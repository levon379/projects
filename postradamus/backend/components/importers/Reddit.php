<?php
namespace backend\components\importers;

use backend\components\FacebookHelper;
use common\models\cListPost;
use Yii;

class Reddit extends Import {

    protected $origin_type = cListPost::ORIGIN_REDDIT;

    public function get_sub_reddits($query)
    {
        $c = file_get_contents('http://www.reddit.com/api/subreddits_by_topic.json?query=' . urlencode($query));
        return $c;
    }

    /* Searches reddit (screen scrape) for news and stuff */
    public function search($search_params)
    {
        $i = 0;
        $json = '';
        $search_keywords = urlencode(str_replace("\"", "", $search_params['search_keywords']));
        try {
            if($search_keywords != '')
            {
                $url = 'http://www.reddit.com/search.json?limit=100&q=' . $search_keywords;
            }
            else
            {
                $url = 'http://www.reddit.com/' . $search_params['search_type'] . '.json?limit=100';
            }

            if($search_params['search_subreddit'])
            {
                $url = 'http://www.reddit.com/r/' . $search_params['search_subreddit'] . '/';
                if($search_params['search_keywords'] != '')
                {
                    $url .= 'search.json?q=' . $search_keywords .  '&restrict_sr=on&sort=popular&t=all';
                }
                else
                {
                    $url .=  $search_params['search_type'] . '.json?limit=100';
                }
            }

            $json = file_get_contents($url);
        } catch (\Exception $e) {
            try {
                $url = 'http://www.reddit.com/' . ($search_params['search_subreddit'] ? 'r/' . $search_params['search_subreddit'] . '/' : '') . 'search.json?limit=100&q=' . urlencode(str_replace("\"", "", $search_params['search_keywords']));
                $json = file_get_contents($url);
            } catch(\Exception $e) {
                Yii::$app->session->setFlash('danger', "Could not load Reddit. Please try again later.");
                mail("natesanden@gmail.com", "Reddit error", "\n\n". $e->getMessage());
            }
        }

        $results = json_decode($json);
        $results = (isset($results->data->children) ? $results->data->children : []);

        //print("<pre>");
        //print_r($results);
        //die();

        foreach($results as $result)
        {
            $id = $result->data->id;
            if(isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1)
            {
                if($this->is_used($id, Yii::$app->user->id))
                {
                    continue;
                }
            }
            $posts[$i]['id'] = $id;
            $posts[$i]['author_name'] = $result->data->author;
            $posts[$i]['author_url'] = 'http://www.reddit.com/user/' . $result->data->author;
            $posts[$i]['created'] = $result->data->created;
            $posts[$i]['up_count'] = $result->data->ups;
            $posts[$i]['comment_count'] = $result->data->num_comments;
            $posts[$i]['image_url'] = $this->getImageUrl($result, $search_params['search_large_images']);
            $posts[$i]['title'] = $result->data->title;
            $posts[$i]['text'] = trim(isset($result->data->selftext) && trim($result->data->selftext) != '' ? $result->data->selftext : '');
            $posts[$i]['post_url'] = $result->data->url;
            $i++;
        }

        //print("<pre>");
        //print_r($posts);
        //die();

        if(empty($posts))
        {
            Yii::$app->session->setFlash("error", "No results found. Please try different keywords.");
            return array();
        }

        return $posts;
    }

    function getImageUrl($result, $large_images = false)
    {
        //get full size image if we can
        if(stristr($result->data->url, '.jpg'))
        {
            return $result->data->url;
        }
        if(stristr($result->data->url, '.gif'))
        {
            return str_replace('.gifv', '.gif', $result->data->url);
        }
        if(stristr($result->data->url, '.png'))
        {
            return $result->data->url;
        }

        if($large_images == true)
        {
            $url_info = explode("#", $result->data->url);
            $url_info = Yii::$app->cache->get(md5($url_info[0]));
            if($url_info == false) {
                \Yii::beginProfile('Not cached ' . $result->data->url);
                //search the imgur site for the rel=image_src tag
                if(strstr($result->data->url, 'imgur'))
                {
                    $html = @file_get_contents($url_info);
                    if ($html) {
                        set_time_limit(15);
                        $encoding = mb_detect_encoding($html);
                        if ($encoding != 'UTF-8') {
                            @iconv($encoding, 'UTF-8', $html);
                        }
                        $document = new \DOMDocument('4.01', 'UTF-8');
                        $dom = @$document->loadHTML($html);
                        $document->encoding = 'UTF-8';
                        $xpath = new \DOMXPath($document);

                        $items = $xpath->query('//link[@rel="image_src"]');

                        if ($items->length > 0) {
                            $image_url = ($items->item(0)->getAttribute('href'));
                            if($url_info != '' && $url_info != 'nsfw') {
                                Yii::$app->cache->set(md5($url_info), $image_url, 60 * 60 * 24 * 10);
                                return $url_info;
                            }
                        }
                        else
                        {
                            //echo $html;
                            echo $result->data->url;
                            die();
                        }
                    }
                }
                \Yii::endProfile('Not cached ' . $result->data->url);
                Yii::$app->cache->set(md5($result->data->url), '1', 60 * 60 * 24);
            } else {
                if($url_info != '' && $url_info != 1 && $url_info != 'nsfw') { return $url_info; }
            }
        }

        //final fallback (thumbnail)
        return ($result->data->thumbnail != 'self' && $result->data->thumbnail != 'default' && $result->data->thumbnail != 'nsfw' ? $result->data->thumbnail : '');
    }

}