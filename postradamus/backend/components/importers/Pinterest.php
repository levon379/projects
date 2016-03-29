<?php
namespace backend\components\importers;

use common\models\cListPost;
use backend\components\Common;
use Yii;

class Pinterest extends Import {

    protected $origin_type = cListPost::ORIGIN_PINTEREST;
    public $tags;

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        $results = Yii::$app->cache->get('pinterest' . md5(serialize($search_params)));
        $this->tags = Yii::$app->cache->get('pinterest' . md5(serialize($search_params)) . 'tags');
        if($results === false) {
            try {
                // START ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $results = array();
                // BUILD SEARCH URL
                $search_url = 'http://www.pinterest.com/search/pins/?q=' . urlencode(trim($search_params['search_keywords']));

                $user_agents = [
                    'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
                    'Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10',
                    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
                ];

                // Create a stream
                $opts = array(
                    'http'=>array(
                        'timeout' => 15,
                        'method'=>"GET",
                        'request_fulluri' => true,
                        'follow_location' => 1,
                        'max_redirects' => 20,
                        'header'=>"Accept-language: en\r\n" .
                            "User-Agent: " . $user_agents[rand(0,count($user_agents)-1)],
                    ),
                    'ssl' => array(
                        'SNI_enabled' => false,
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    )
                );

                $proxy = '172.245.131.214:8800
192.3.18.194:8800
104.194.75.212:8800
172.245.131.201:8800
155.254.48.55:8800
155.254.48.184:8800
104.194.88.55:8800
68.71.156.56:8800
68.71.156.22:8800
23.89.196.16:8800
23.95.29.115:8800
23.89.196.101:8800
192.3.32.32:8800
192.227.236.174:8800
172.245.131.194:8800
23.89.196.203:8800
23.89.196.171:8800
172.245.131.220:8800
192.227.236.164:8800
23.89.196.132:8800';
                $proxy = explode("\n", $proxy);
                $proxy = $proxy[rand(0, count($proxy))];
                if(YII_ENV == 'prod')
                {
                    $opts['http']['proxy'] = "tcp://" . $proxy;
                }
                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                $html = @file_get_contents($search_url, false, $context);
                $this->tags = $this->parse_recommended_tags($html);
                Yii::$app->cache->set('pinterest' . md5(serialize($search_params)) . 'tags', $this->tags);

                $results = array_merge($results, $this->parse_html_result($html));

                while (sizeof($results) < $search_params['search_results']) {
                    // PARSE JSON REQUEST STRING
                    if (preg_match('/"name": "SearchResource", "options": {(.*?)}/', $html, $match)) {
                        // BUILD JSON REQUEST URL
                        $json_request = '{"options":{' . trim($match[1]) . '},"context":{},"module":{"name":"GridItems","options":{"scrollable":true,"show_grid_footer":true,"centered":true,"reflow_all":true,"virtualize":true,"item_options":{"show_pinner":true,"show_pinned_from":false,"show_board":true},"layout":"variable_height","track_item_impressions":true}},"render_type":3,"error_strategy":1}';
                        $json_url = 'http://www.pinterest.com/resource/SearchResource/get/?source_url=' . urlencode('search/pins/?q=' . $search_params['search_keywords']) . '&data=' . urlencode($json_request);

                        // FETCH NEXT RESULT
                        $json_string = $this->get_json($json_url);
                        usleep(50);
                        $json_obj = json_decode($json_string);
                        // SET NEW HTML VALUE
                        $html = $json_string;

                        // PARSE RESULTS
                        $results = array_merge($results, $this->parse_json_result($json_obj));
                    } else {
                        break;
                    }
                }

                if (sizeof($results) > $search_params['search_results']) {
                    $results = array_slice($results, 0, $search_params['search_results']);
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
                //$this->message->set_message("Could not load the Pinterest search page. Please try again later." . "\n\n". $e->getMessage(), Message::MSG_TYPE_ERROR);
            }

            if (empty($results)) {
                mail("natesanden@gmail.com", "no results", $proxy);
                \Yii::$app->session->setFlash("error", "No results found. Please try different keywords.");
                return array();
            }
        }
        Yii::$app->cache->set('pinterest' . md5(serialize($search_params)), $results, 60 * 60 * 6); //6 hour

        $i = 0;
        if(is_array($results))
        {
            foreach ($results as $result) {
                if (isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1) {
                    if ($this->is_used($result['id'], Yii::$app->user->id)) {
                        unset($results[$i]);
                    }
                }
                $i++;
            }
        }

        return $results;
    }

    function get_html($url)
    {
        $ch = curl_init();
        $header = array('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', 'Accept-Language: en-US,en;q=0.8,fil;q=0.6');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }

    function get_json($url)
    {
        $ch = curl_init();
        $header = array('Accept: application/json, text/javascript, */*; q=0.01', 'X-NEW-APP: 1', 'X-APP-VERSION: 6757f6e', 'X-Requested-With: XMLHttpRequest');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $json_string = curl_exec( $ch ); # run!
        curl_close($ch);

        return $json_string;
    }

    function get_inner_html( $node )
    {
        $innerHTML= '';
        $children = $node->childNodes;
        if(!empty($children))
        {
            foreach ($children as $child) {
                $innerHTML .= $child->ownerDocument->saveXML( $child );
            }
        }
        return $innerHTML;
    }

    function parse_html_result($html)
    {
        $result = array();
        $encoding = mb_detect_encoding($html);
        if( $encoding != 'UTF-8' ){ @iconv($encoding, 'UTF-8', $html); }
        $document = new \DOMDocument('4.01', 'UTF-8');
        $dom = @$document->loadHTML($html);
        $document->encoding = 'UTF-8';
        $xpath = new \DOMXPath($document);

        $items = $xpath->query("//*[contains(@class, 'pinWrapper')]");

        $id = '';
        $image_url = '';
        $description = '';
        $repin_count = 0;
        $like_count = 0;
        $comment_count = 0;
        $author_name = '';
        $author_image_url = '';
        $author_link = '';
        $title = '';

        if(!empty($items))
        {
            foreach ($items as $item)
            {
                $nodes = $xpath->query('div/div[@class="pinHolder"]/a', $item);
                if ($nodes->length > 0)
                {
                    if (preg_match("/\/pin\/(\d+)/", $nodes->item(0)->getAttribute("href"), $match))
                    {
                        $id = $match[1];
                        $nodes = $xpath->query('div/div[@class="pinHolder"]/a/div[@class="fadeContainer"]/div/div/img', $item);
                        if ($nodes->length > 0)
                        {
                            $image_url = $nodes->item(0)->getAttribute("src");
                            $image_url = str_replace("/236x/", "/originals/", $image_url);
                        }
                    }
                }
                // TITLE
                $nodes = $xpath->query('div/a/h3[@class="richPinGridTitle"]', $item);
                if ($nodes->length > 0)
                {
                    $title = $this->get_inner_html($nodes->item(0));
                }
                // DESCRIPTION
                $nodes = $xpath->query('div/p[@class="pinDescription"]', $item);
                if ($nodes->length > 0)
                {
                    $description = $this->get_inner_html($nodes->item(0));
                }
                // REPINS
                $nodes = $xpath->query('div/div[@class="pinSocialMeta"]/a/em[@class="socialMetaCount repinCountSmall"]', $item);
                if ($nodes->length > 0)
                {
                    $repin_count = (int)$this->get_inner_html($nodes->item(0));
                }
                // LIKES
                $nodes = $xpath->query('div/div[@class="pinSocialMeta"]/a/em[@class="socialMetaCount likeCountSmall"]', $item);
                if ($nodes->length > 0)
                {
                    $like_count = (int)$this->get_inner_html($nodes->item(0));
                }
                // COMMENTS
                $nodes = $xpath->query('div/div[@class="pinSocialMeta"]/a/em[@class="socialMetaCount commentCountSmall"]', $item);
                if ($nodes->length > 0)
                {
                    $comment_count = (int)$this->get_inner_html($nodes->item(0));
                }
                // AUTHOR NAME
                $nodes = $xpath->query('div[@class="pinCredits"]/div/a/div[@class="creditName"]', $item);
                if ($nodes->length > 0)
                {
                    $author_name = trim($this->get_inner_html($nodes->item(0)));
                }
                // AUTHOR IMAGE URL
                $nodes = $xpath->query('div[@class="pinCredits"]/div/a/img', $item);
                if ($nodes->length > 0)
                {
                    $author_image_url = $nodes->item(0)->getAttribute("src");
                }
                // AUTHOR LINK
                $nodes = $xpath->query('div[@class="pinCredits"]/div/a', $item);
                if ($nodes->length > 0)
                {
                    $author_link = $nodes->item(0)->getAttribute("href");
                    if (preg_match("/\/(.*?)\//", $author_link, $match))
                    {
                        $author_link = 'http://www.pinterest.com/' . $match[1];
                    }
                }

                $result[] = array('id' => $id
                , 'title' => $title
                , 'description' => trim(strip_tags($description))
                , 'image_link' => 'http://www.pinterest.com/pin/' . $id
                , 'image_url' => $image_url
                , 'like_count' => $like_count
                , 'repin_count' => $repin_count
                , 'comment_count' => $comment_count
                , 'author_name' => $author_name
                , 'author_image_url' => $author_image_url
                , 'author_link' => $author_link);
            }
        }

        return $result;
    }

    function parse_json_result($json_obj)
    {
        $result = array();
        if(!empty($json_obj))
        {
            foreach ($json_obj->module->tree->data as $obj)
            {
                $result[] = array('id' => $obj->id
                , 'title' => $obj->title
                , 'description' => trim(strip_tags($obj->description))
                , 'image_link' => 'http://www.pinterest.com/pin/' . $obj->id
                , 'image_url' => $obj->images->orig->url
                , 'like_count' => $obj->like_count
                , 'repin_count' => $obj->repin_count
                , 'comment_count' => $obj->comment_count
                , 'author_name' => $obj->pinner->full_name
                , 'author_image_url' => $obj->pinner->image_large_url
                , 'author_link' => 'http://www.pinterest.com/' . $obj->pinner->username);
            }
        }
        return $result;
    }

    function parse_recommended_tags($html) {
        $tags = array();
        $encoding = mb_detect_encoding($html);
        if( $encoding != 'UTF-8' ){ @iconv($encoding, 'UTF-8', $html); }
        $document = new \DOMDocument('4.01', 'UTF-8');
        $dom = @$document->loadHTML($html);
        $document->encoding = 'UTF-8';
        $xpath = new \DOMXPath($document);

        $items = $xpath->query("//ul[@class='guidesContainer']/li/a");

        foreach ($items as $item)
        {
            if (preg_match("/Search for '(.*)'/i", $item->getAttribute('title'), $match)) {
                $tags[] = trim($match[1]);
            }
        }
        return $tags;
    }

}