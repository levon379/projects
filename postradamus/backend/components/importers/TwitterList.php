<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use yii\web\HttpException;
use Abraham\TwitterOAuth;

class TwitterList extends Twitter
{

    public function getLists()
    {
        $lists = [];
        if(Yii::$app->session->get('twitter_lists'))
        {
            return Yii::$app->session->get('twitter_lists');
        }

        $access_token = Yii::$app->session->get('access_token');

        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth(parent::CONSUMER_KEY, parent::CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        $params = [
            'count' => 100,
            'screen_name' => Yii::$app->session->get('access_token')['screen_name'],
        ];

        /* If method is set change API call made. Test is called by default. */
        $request = $connection->get('lists/list', $params);

        if(!empty($request))
        {
            foreach($request as $list)
            {
                if(isset($list->name) && trim($list->name) != '')
                $lists[$list->id] = $list->name;
            }

            if(!empty($lists))
            {
                asort($lists);
                Yii::$app->session->get('twitter_lists', $lists);
            }
        }

        return $lists;
    }

    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        $posts = [];

        try {

            $access_token = Yii::$app->session->get('access_token');

            /* Create a TwitterOauth object with consumer/user tokens. */
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(parent::CONSUMER_KEY, parent::CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            $params = [
                'count' => 100,
                'list_id' => urlencode($search_params['list_id']),
            ];

            if($search_params['include_retweets'] == 1)
            {
                $params['include_rts'] = 1;
            }

            /* If method is set change API call made. Test is called by default. */
            $request = $connection->get('lists/statuses', $params);

            if(isset($request->errors[0]->code))
            {
                if($request->errors[0]->code == 89)
                {
                    Yii::$app->session->setFlash('danger', 'This feature requires authorization from Twitter. <a href="' . Yii::$app->urlManager->createUrl('content/twitter-redirect') . '">Try again</a>.');
                }
                else
                {
                    Yii::$app->session->setFlash('danger', 'Twitter says: ' . $request->errors[0]->message);
                }
            }

            if (empty($request)) {
                Yii::$app->session->setFlash('warning', 'No results found. Please try a different list.');
                //return array();
            }

            $i = 0;
            foreach ($request as $status)
            {
                $posts[$i]['id'] = $status->id_str;
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($posts[$i]['id'], Yii::$app->user->id))
                    {
                        unset($posts[$i]['id']);
                        continue;
                    }
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