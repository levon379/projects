<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use yii\web\HttpException;

class TwitterTimeline extends Twitter
{
    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        $i = 0;
        $posts = [];

        try {
            $access_token = Yii::$app->session->get('access_token');

            /* Create a TwitterOauth object with consumer/user tokens. */
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(parent::CONSUMER_KEY, parent::CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* If method is set change API call made. Test is called by default. */
            $request = $connection->get('statuses/home_timeline');

            if(isset($request->errors[0]->code))
            {
                if($request->errors[0]->code == 89 || $request->errors[0]->code == 220)
                {
                    Yii::$app->session->setFlash('danger', 'This feature requires authorization from Twitter. <a href="' . Yii::$app->urlManager->createUrl('content/twitter-redirect') . '">Connect Now</a>.');
                }
                else
                {
                    Yii::$app->session->setFlash('danger', 'Twitter says: ' . $request->errors[0]->message);
                }
            }

            foreach($request as $status)
            {
                $posts[$i]['id'] = $status->id_str;
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($posts[$i]['id'], Yii::$app->user->id))
                    {
                        unset($posts[$i]);
                        continue;
                    }
                }
                if(trim($status->text) == '')
                {
                    unset($posts[$i]);
                    continue;
                }
                $posts[$i]['text'] = $status->text;
                $posts[$i]['author_name'] = $status->user->screen_name;
                $posts[$i]['author_url'] = $status->user->url;
                $posts[$i]['created'] = strtotime($status->created_at);
                $posts[$i]['retweet_count'] = $status->retweet_count;
                $posts[$i]['favorite_count'] = $status->favorite_count;
                $posts[$i]['author_image_url'] = $status->user->profile_image_url;
                $posts[$i]['image_url'] = (isset($status->entities->media[0]) && isset($status->entities->media[0]->media_url) ? $status->entities->media[0]->media_url : '');
                $posts[$i]['image_link'] = 'http://twitter.com/' . $posts[$i]['author_name'] . '/status/' . $posts[$i]['id'];
                $posts[$i]['json'] = $status;
                $i++;
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', 'Twitter says: ' . $e->getMessage());
        }

        return $posts;
    }

}