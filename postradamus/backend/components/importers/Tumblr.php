<?php
namespace backend\components\importers;

use common\models\cListPost;
use backend\components\UnicodeHelper;
use Yii;
use yii\web\HttpException;

class Tumblr extends Import
{

    protected $origin_type = cListPost::ORIGIN_TUMBLR;

    const API_KEY = 'fuiKNFp9vQFvjLNvx4sUwti4Yb5yGutBN4Xh10LXZhhRKjWlV4';

    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        $posts = [];

        if($search_params['cache'] == 0)
        {
            Yii::$app->cache->delete('tumblr' . md5(serialize($search_params)));
        }

        try {

            $url = 'http://api.tumblr.com/v2/tagged?tag=' . urlencode($search_params['search_keywords']) . '&api_key=' . self::API_KEY . '&filter=text&limit=20&before=' . ($search_params['search_before']);
            $json = file_get_contents($url);
            $response = json_decode($json);

            //print("<pre>");
            //print_r($response);
            //die();

            Yii::$app->cache->set('tumblr' . md5(serialize($search_params)), $response, 60 * 60);

            if (empty($response->response)) {
                Yii::$app->session->setFlash('success', 'No results found. Please try different keywords.');
                return [];
            }

            $i = 0;
            foreach ($response->response as $item)
            {
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($item->id, Yii::$app->user->id))
                    {
                        continue;
                    }
                }

                if($item->type != 'text' && $item->type != 'link' && $item->type != 'photo')
                    continue;

                if($item->caption == '' && $item->photos[0]->original_size->url == '')
                {
                    continue;
                }

                $posts[$i]['id'] = $item->id;
                $posts[$i]['type'] = $item->type;
                $posts[$i]['text'] = UnicodeHelper::CleanupText($item->caption);
                $posts[$i]['image_url'] = $item->photos[0]->original_size->url;
                $posts[$i]['note_count'] = $item->note_count;
                $posts[$i]['created'] = $item->timestamp;
                $posts[$i]['post_url'] = $item->post_url;
                $posts[$i]['author_name'] = $item->blog_name;
                $posts[$i]['blog_name'] = ucwords(str_replace("-", " ", $item->blog_name));
                $posts[$i]['blog_url'] = 'http://' . $item->blog_name . '.tumblr.com';
                $i++;
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', 'Tumblr says: ' . $e->getMessage());
        }

        return $posts;
    }

}