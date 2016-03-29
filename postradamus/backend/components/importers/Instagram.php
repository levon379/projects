<?php
namespace backend\components\importers;

use common\models\cListPost;
use backend\components\UnicodeHelper;
use Yii;

class Instagram extends Import {

    const INSTAGRAM_CLIENT_ID = 'f8a1dfee2e0d4847b840c7bb76276d4e';

    protected $origin_type = cListPost::ORIGIN_INSTAGRAM;

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        $i = 0;
        $json = '';
        try {
            if($search_params['search_method'] == '#pill_tag')
            {
                if($search_params['search_type'] == 2)
                {
                    $limit = 'count=40&';
                }
                else
                {
                    $limit = '';
                }
                $url = 'https://api.instagram.com/v1/tags/' . urlencode(str_replace(' ', '', $search_params['search_keywords'])) . '/media/recent?'.$limit.'client_id=' . self::INSTAGRAM_CLIENT_ID;
            }
            else
            {
                $url = 'https://api.instagram.com/v1/media/popular?client_id=' . self::INSTAGRAM_CLIENT_ID;
            }
            $json = file_get_contents($url);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', "Could not load Instragram. Please try again later.");
            mail("natesanden@gmail.com", "postradamus error", "\n\n". $e->getMessage());
        }

        $results = json_decode($json);

        if(isset($results->pagination->next_url))
        {
            //get more results
            $next_results = json_decode(file_get_contents($results->pagination->next_url));
            $next_results2 = [];
            if(isset($next_results->pagination->next_url))
            {
                sleep(1);
                $next_results2 = json_decode(file_get_contents($next_results->pagination->next_url));
            }
            $results = (object)array_merge((array)$results->data, (array)$next_results->data, (array)$next_results2->data);
        }
        else
        {
            $results = (isset($results->data) ? $results->data : []);
        }

        //print("<pre>");
        //print_r($results);
        //die();

        foreach($results as $result)
        {
            $id = $result->id;
            if(isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1)
            {
                if($this->is_used($id, Yii::$app->user->id))
                {
                    continue;
                }
            }
            //type is photo and type is not photo
            if($search_params['search_type'] == 1 && $result->type != 'image')
            {
                continue;
            }
            if($search_params['search_type'] == 2 && $result->type != 'video')
            {
                continue;
            }
            $posts[$i]['id'] = $id;
            $posts[$i]['image_url'] = $result->images->standard_resolution->url;
            $posts[$i]['text'] = (isset($result->caption->text) ? UnicodeHelper::CleanupText($result->caption->text) : '');
            $posts[$i]['likes'] = $result->likes->count;
            $posts[$i]['comments'] = $result->comments->count;
            $posts[$i]['post_link'] = $result->link;
            $posts[$i]['video_url'] = $result->videos->standard_resolution->url;
            $posts[$i]['type'] = $result->type;
            $posts[$i]['author_id'] = (isset($result->caption->from->id) ? $result->caption->from->id : '');
            $posts[$i]['author_name'] = (isset($result->caption->from->full_name) ? UnicodeHelper::CleanupText($result->caption->from->full_name) : '');
            if($posts[$i]['author_name'] == '') { $posts[$i]['author_name'] = (isset($result->caption->from->username) ? $result->caption->from->username : ''); }
            $posts[$i]['author_pic'] = (isset($result->caption->from->profile_picture) ? $result->caption->from->profile_picture : '');
            $posts[$i]['author_url'] = 'http://instagram.com/' . (isset($result->caption->from->username) ? $result->caption->from->username : '');
            $posts[$i]['created'] = $result->created_time;
            $i++;
        }

        if(empty($posts))
        {
            Yii::$app->session->setFlash("error", "No results found. Please try different keywords.");
            return array();
        }

        return $posts;
    }
}