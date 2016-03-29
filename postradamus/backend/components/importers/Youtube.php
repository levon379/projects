<?php

namespace backend\components\importers;

use Yii;
use common\models\cListPost;

class Youtube extends Import {

    const YOUTUBE_API_KEY = 'AIzaSyAMvOQnekOA-PrLdIsekRHvM_5UddXEZUA';
    protected $origin_type = cListPost::ORIGIN_YOUTUBE;

    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function getCategories()
    {
        $url = 'https://www.googleapis.com/youtube/v3/videoCategories?part=id%2Csnippet&regionCode=US&key=' . self::YOUTUBE_API_KEY;
        $search_results = file_get_contents($url);
        $search_results = json_decode($search_results);

        if(isset($search_results->items) && is_array($search_results->items))
        {
            $items = $search_results->items;
        }
        else
        {
            Yii::$app->session->setFlash('danger', 'Looks like YouTube is having issues. Please try again later.');
            $items = [];
            $categories = [];
        }

        foreach($items as $item)
        {
            if($item->id != 34)
            $categories[$item->id] = $item->snippet->title;
        }

        asort($categories);

        return $categories;
    }

    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        //get search results
        $url = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=50&videoDuration=' . $search_params['search_duration'] . '&videoDefinition=' . $search_params['search_definition'] .  '&order=' . $search_params['search_order'] . '&videoCategoryId='. $search_params['search_category'] .'&safeSearch='. $search_params['search_safe_search'] .'&q=' . urlencode($search_params['search_keywords']) . '&type=video&key=' . self::YOUTUBE_API_KEY;

        $search_results = file_get_contents($url);

        $search_results = json_decode($search_results);

        $ids = [];

        if(is_array($search_results->items))
        {
            //get statistics on the search results
            foreach($search_results->items as $item)
            {
                $ids[] = $this->get_post_id($item);
            }
            $url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id=' . implode(',', $ids) . '&key=' . self::YOUTUBE_API_KEY;
            $statistic_results = file_get_contents($url);
            $statistic_results = json_decode($statistic_results);

            //combine statistics with search results
            foreach($statistic_results->items as $stat)
            {
                $newstat_array[$stat->id] = $stat;
            }

            foreach($search_results->items as $item)
            {
                $item->stats = $newstat_array[$this->get_post_id($item)];
            }

            if($search_results->pageInfo->totalResults == 0)
            {
                Yii::$app->session->setFlash('danger', 'No results found. Please try different keywords.');
                return array();
            }

            //print("<pre>");
            //print_r($search_results->items);
            //die();

            foreach($search_results->items as $item)
            {
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($this->get_post_id($item), Yii::$app->user->id))
                    {
                        continue;
                    }
                }
                $items[] = [
                    'id' => $this->get_post_id($item),
                    'title' => $this->get_post_title($item),
                    'message' => $this->get_post_message($item),
                    'image_url' => $this->get_post_image_src($item),
                    'image_link' => $this->get_post_image_link($item),
                    'views' => $this->get_view_count($item),
                    'likes' => $this->get_like_count($item),
                    'comments' => $this->get_comment_count($item),
                ];
            }
        }
        else
        {
            Yii::$app->session->setFlash('danger', 'YouTube is having issues right now. Please try again later.');
            $items = [];
        }
        return $items;
    }

    /* Helpers */
    public function get_post_id($v)
    {
        return $v->id->videoId;
    }

    public function get_view_count($v)
    {
        return $v->stats->statistics->viewCount;
    }

    public function get_like_count($v)
    {
        return $v->stats->statistics->likeCount;
    }

    public function get_comment_count($v)
    {
        return $v->stats->statistics->commentCount;
    }

    public function get_post_message($v)
    {
        return $v->snippet->description;
    }

    public function get_post_image_src($v)
    {
        return $v->snippet->thumbnails->high->url;
    }

    public function get_post_title($v)
    {
        return $v->snippet->title;
    }

    public function get_post_image_link($v)
    {
        return 'http://www.youtube.com/watch?v=' . $v->id->videoId;
    }

}