<?php
namespace backend\components\importers;

use common\models\cListPost;
use backend\components\Common;
use Yii;

class Pinterest extends Import {

    protected $origin_type = cListPost::ORIGIN_PINTEREST;
    protected $max_results = 125;

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        try {
            // START ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $results = array();
            // BUILD SEARCH URL
            $search_url = 'http://infinigag.eu01.aws.af.cm/hot/0';

            // FETCH MAIN SEARCH RESULT PAGE
            $html = $this->get_html($search_url);

            $results = array_merge($results, $this->parse_html_result($html));

            while (sizeof($results) < $this->max_results)
            {
                // PARSE JSON REQUEST STRING
                if (preg_match('/"name": "SearchResource", "options": {(.*?)}},/', $html, $match))
                {
                    // BUILD JSON REQUEST URL
                    $json_request = '{"options":{' . trim($match[1]) . '},"context":{},"module":{"name":"GridItems","options":{"scrollable":true,"show_grid_footer":true,"centered":true,"reflow_all":true,"virtualize":true,"item_options":{"show_pinner":true,"show_pinned_from":false,"show_board":true},"layout":"variable_height","track_item_impressions":true}},"render_type":3,"error_strategy":1}';
                    $json_url = 'http://www.pinterest.com/resource/SearchResource/get/?source_url=' . urlencode('search/pins/?q=' . $search_params['search_keywords']) . '&data=' . urlencode($json_request);

                    // FETCH NEXT RESULT
                    $json_string = $this->get_json($json_url);
                    $json_obj = json_decode($json_string);
                    // SET NEW HTML VALUE
                    $html = $json_string;

                    // PARSE RESULTS
                    $results = array_merge($results, $this->parse_json_result($json_obj));
                }
                else
                {
                    break;
                }
            }

            if (sizeof($results) > $this->max_results)
            {
                $results = array_slice($results, 0, $this->max_results);
            }

            $i=0;
            foreach($results as $result)
            {
                if(isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($result['id'], Yii::$app->user->id))
                    {
                        unset($results[$i]);
                    }
                }
                $i++;
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            //$this->message->set_message("Could not load the Pinterest search page. Please try again later." . "\n\n". $e->getMessage(), Message::MSG_TYPE_ERROR);
        }

        /*
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $x = new \DOMXPath($dom);
        $i=0;

        foreach($x->query("//div[contains(@class,'pinWrapper')]") as $node)
        {
            //id
            $idNode = $x->query(".//a[contains(@class,'pinImageWrapper')]", $node);
            foreach($idNode as $myIdNode)
            {
                $url = $myIdNode->getAttribute('href');
                preg_match('~/pin/([0-9]+)/~', $url, $matches);
                $id = $matches[1];
            }
            if($search_params['hide_used_content'] == 1)
            {
                if($this->is_used($id, Yii::$app->user->id))
                {
                    continue;
                }
            }
            $posts[$i]['id'] = $id;
            //image
            $imgNode = $x->query(".//img[contains(@src,'236x/')]", $node);
            foreach($imgNode as $myImgNode)
            {
                $posts[$i]['img'] = str_replace('236x', '736x', $this->rel2abs($myImgNode->getAttribute("src"), $url));
            }
            //text
            $descriptionNode = $x->query(".//p[contains(@class,'pinDescription')]", $node);
            foreach($descriptionNode as $myDescriptionNode)
            {
                $posts[$i]['message'] = $myDescriptionNode->nodeValue;
            }
            //repins
            $repinNode = $x->query(".//a[contains(@class,'socialItem') and contains(@href, '/repins/')]", $node);
            foreach($repinNode as $myRepinNode)
            {
                $posts[$i]['repins'] = (trim(str_replace('repin', '', str_replace('repins', '', $myRepinNode->nodeValue))));
            }
            //likes
            $likesNode = $x->query(".//a[contains(@class,'socialItem likes')]", $node);
            foreach($likesNode as $myLikesNode)
            {
                $posts[$i]['likes'] = (trim(str_replace('like', '', str_replace('likes', '', $myLikesNode->nodeValue))));
            }
            //likes
            $commentsNode = $x->query(".//a[contains(@class,'socialItem comments')]", $node);
            foreach($commentsNode as $myCommentsNode)
            {
                $posts[$i]['comments'] = (trim(str_replace('comment', '', str_replace('comments', '', $myCommentsNode->nodeValue))));
            }
            //author name
            $authorNameNode = $x->query(".//div[@class='creditName'][1]", $node);
            foreach($authorNameNode as $myAuthorNameNode)
            {
                $posts[$i]['author_name'] = $myAuthorNameNode->nodeValue;
            }
            //author link
            $authorLinkNode = $x->query(".//div[contains(@class,'pinCredits')]//a[contains(@class,'creditItem')][1]", $node);
            //\fbpostbot\Common::print_p($authorLinkNode);
            foreach($authorLinkNode as $myAuthorLinkNode)
            {
                $posts[$i]['author_link'] = $myAuthorLinkNode->getAttribute("href");
            }
            //author img
            $authorImgNode = $x->query(".//div[contains(@class,'pinCredits')]//img[contains(@class,'creditImg')][1]", $node);
            //\fbpostbot\Common::print_p($authorLinkNode);
            foreach($authorImgNode as $myAuthorImgNode)
            {
                $posts[$i]['author_img_src'] = $myAuthorImgNode->getAttribute("src");
            }

            $i++;
        }
        */

        if(empty($results))
        {
            \Yii::$app->session->setFlash("error", "No results found. Please try different keywords.");
            return array();
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
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1)".
            " Gecko/20061204 Firefox/2.0.0.1";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
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
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1)".
            " Gecko/20061204 Firefox/2.0.0.1";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        $json_string = curl_exec( $ch ); # run!
        curl_close($ch);

        return $json_string;
    }

    function get_inner_html( $node )
    {
        $innerHTML= '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveXML( $child );
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

        foreach ($items as $item)
        {
            $nodes = $xpath->query('div/div[@class="pinHolder"]/a', $item);
            if ($nodes->length > 0)
            {
                if (preg_match("/\/pin\/(\d+)/", $nodes->item(0)->getAttribute("href"), $match))
                {
                    $id = $match[1];
                    $nodes = $xpath->query('div/div[@class="pinHolder"]/a/div[@class="fadeContainer"]/img', $item);
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
            , 'description' => $description
            , 'image_link' => 'http://www.pinterest.com/pin/' . $id
            , 'image_url' => $image_url
            , 'like_count' => $like_count
            , 'repin_count' => $repin_count
            , 'comment_count' => $comment_count
            , 'author_name' => $author_name
            , 'author_image_url' => $author_image_url
            , 'author_link' => $author_link);
        }

        return $result;
    }

    function parse_json_result($json_obj)
    {
        $result = array();
        foreach ($json_obj->module->tree->data as $obj)
        {
            $result[] = array('id' => $obj->id
            , 'title' => $obj->title
            , 'description' => $obj->description
            , 'image_link' => 'http://www.pinterest.com/pin/' . $obj->id
            , 'image_url' => $obj->images->orig->url
            , 'like_count' => $obj->like_count
            , 'repin_count' => $obj->repin_count
            , 'comment_count' => $obj->comment_count
            , 'author_name' => $obj->pinner->full_name
            , 'author_image_url' => $obj->pinner->image_large_url
            , 'author_link' => 'http://www.pinterest.com/' . $obj->pinner->username);
        }

        return $result;
    }

    /*
    function rel2abs($url, $host)
    {
        if (substr($url, 0, 4) == 'http') {
            return $url;
        } else {
            $hparts = explode('/', $host);

            if ($url[0] == '/') {
                return implode('/', array_slice($hparts, 0, 3)) . $url;
            } else if ($url[0] != '.') {
                array_pop($hparts);
                return implode('/', $hparts) . '/' . $url;
            }
        }
        return false;
    }
    */

    /*
    public function get_post_id($v)
    {
        return $v['post_id'];
    }
    public function get_post_message($v)
    {
        return iconv("UTF-8", "ISO-8859-1//IGNORE", $v['message']);
    }
    public function get_post_image_src($v)
    {
        return $v['img'];
    }
    public function get_post_image_link($v)
    {
        return 'http://www.pinterest.com/pin/' . $v['post_id'];
    }
    public function get_post_like_count($v)
    {
        return (INT)$v['likes'];
    }
    public function get_post_repin_count($v)
    {
        return (INT)$v['repins'];
    }
    public function get_post_comment_count($v)
    {
        return (INT)$v['comments'];
    }
    public function get_post_created_time($v)
    {
        return $v['created_time'];
    }

    public function get_author_name($v)
    {
        return $v['author_name'];
    }
    public function get_author_image_src($v)
    {
        return $v['author_img_src'];
    }
    public function get_author_link($v)
    {
        return 'http://www.pinterest.com' . $v['author_link'];
    }
    */

}