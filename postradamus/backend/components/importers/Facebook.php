<?php

namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;

class Facebook extends Import
{
    public $_fh; //facebook reference
    public $_limit = 1000;
    protected $origin_type = cListPost::ORIGIN_FACEBOOK;

    public function __construct($fh)
    {
        $this->_fh = $fh;
    }

    public function get_last_scheduled_post($page_id)
    {
        $last_scheduled_post = Yii::$app->cache->get(md5('last_scheduled_post' . $page_id));
        if ($last_scheduled_post === false) {
            $last_scheduled_post = $this->_fh->api_call('/' . $page_id . '/promotable_posts?fields=id,created_time,scheduled_publish_time&limit=1&is_published=false', 'GET', ['access_token' => $_SESSION['fb_token']]);
            Yii::$app->cache->set(md5('last_scheduled_post' . $page_id), $last_scheduled_post, 10 * 60);
        }
        return $last_scheduled_post;
    }

    public function get_pages($term)
    {
        $pages = Yii::$app->cache->get(md5('pages' . $term));
        if ($pages === false) {
            $url = '/search?type=page&q=' . urlencode(strtolower($term)) . '&fields=name,likes,picture,talking_about_count';
            $pages = $this->_fh->api_call($url, 'GET', ['access_token' => $_SESSION['fb_token']]);
            if(!empty($pages))
                Yii::$app->cache->set(md5('pages' . $term), $pages, 6 * 60 * 60);
        }
        return $pages;
    }

    public function get_page_or_group($id)
    {
        $page_or_group = Yii::$app->cache->get(md5('page_or_group' . $id));
        if ($page_or_group === false) {
            $page_or_group = $this->_fh->api_call('/' . $id, 'GET', ['access_token' => $_SESSION['fb_token']]);
            if(!empty($page_or_group))
                Yii::$app->cache->set(md5('page_or_group' . $id), $page_or_group, 6 * 60 * 60);
        }
        return $page_or_group;
    }

    public function get_groups($term)
    {
        $groups = Yii::$app->cache->get(md5('groups' . $term));
        if ($groups === false) {
            $groups = $this->_fh->api_call('/search?type=group&q=' . urlencode(strtolower($term)) . '&fields=name,likes,picture,cover', 'GET', ['access_token' => $_SESSION['fb_token']]);
            if(!empty($groups))
                Yii::$app->cache->set(md5('groups' . $term), $groups, 6 * 60 * 60);
        }
        return $groups;
    }

    private function format_query($sql)
    {
        $sql = preg_replace('!\s+!', ' ', str_replace(array("\n", "\r", "\r\n"), " ", $sql));
        return $sql;
    }

    public function delete($page_id)
    {
        $posts = $this->_fh->api_call('/' . $page_id . '/promotable_posts?fields=id,created_time,scheduled_publish_time&limit=100&is_published=false', 'GET', ['access_token' => $_SESSION['fb_token']]);

        $i = 0;
        if (is_array($posts['data']) && !empty($posts['data'])) {
            foreach ($posts['data'] as $k => $v) {
                //echo $v->id;
                //die();
                $this->_fh->api_call("/" . $v->id, "DELETE");
                $i++;
            }
        }

        return $i;

    }

    public function getImageInObject($object_id)
    {
        $search = '/' . $object_id . '?fields=attachment';
        $image = $this->_fh->api_call($search);
        //print("<pre>");
        //print_r($image);
        return (!empty($image['attachment']) ? $image['attachment']->media->image->src : false);
    }

    public function searchComments($search_params)
    {
        //user has fb app setup? then pull in more photos
        $fb = Yii::$app->postradamus->get_facebook_details();
        if($fb['app_secret'])
        {
            $search_params['search_min_like_count'] = 0;
            $limit = 200;
        }
        else
        {
            $limit = 100;
        }
        $search = "";
        if(stristr($search_params['search_from_post_id'], 'www.facebook.com') != FALSE) {
            $search_url = file_get_contents("http://api.beachinsoft.com/?api_key=ZTI3YzRmNGZhZjYzZDY3NjNkOGRjMTZlMDlmYzAwOGFiNDQ3NWVkNTQzZmRiZGQxZTYyNDYzZTg3YTIyMmNjZg&r=facebook/get-post-id&url=".$search_params['search_from_post_id']) ;
            $search_id_from_url = json_decode($search_url);
            $search = '/' . $search_id_from_url->response . "/comments?limit=$limit&filter=" . $search_params['filter'] . "&summary=true&fields=comment_count,id,can_remove,created_time,like_count,message,user_likes,from{id,name,picture,link}";
        }else{
            $search = '/' . $search_params['search_from_post_id'] . "/comments?limit=$limit&filter=" . $search_params['filter'] . "&summary=true&fields=comment_count,id,can_remove,created_time,like_count,message,user_likes,from{id,name,picture,link}";
        }


        $comments = $this->_fh->api_call($search);

        if(!empty($comments) && !empty($comments['data']))
        {
            foreach ($comments['data'] as $k => $comment) {
                $i++;

                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($comment->id, Yii::$app->user->id))
                    {
                        continue;
                    }
                }

                if($comment->like_count >= $search_params['search_min_like_count'])
                {
                    //lookup image
                    $picture = $this->getImageInObject($comment->id);
                }

                $myposts[] = [
                    'id' => $comment->id,
                    'author_id' => $comment->from->id,
                    'author_name' => $comment->from->name,
                    'author_pic' => $comment->from->picture->data->url,
                    'author_url' => $comment->from->link,
                    'image_url' => $picture,
                    'comments' => $comment->comment_count,
                    'shares' => 0,
                    //'large_image_id' => $comment->object_id,
                    'post_url' => 'http://fb.com/' . $comment->id,
                    //'object_id' => $comment->object_id,
                    'text' => $this->get_post_message($comment->message),
                    'likes' => (int)$comment->like_count,
                    'created' => strtotime($comment->created_time),
                ];

                unset($picture);

            }
        }
        \Yii::endProfile('Facebook Manipulate Results');

        if (empty($myposts)) {
            Yii::$app->session->setFlash('warning', 'No results found. Please try a different post.');
            return array();
        }
        return $myposts;
    }

    /* Searches facebook API for posts from a page or group */
    public function search($search_params)
    {

        if ($search_params['search_from_page_id'] != '' || $search_params['search_from_group_id'] != '') {
            $myposts = [];

            if ($search_params['search_from_page_id']) {
                $page = true;
                $search_from_id = $search_params['search_from_page_id'];
            } else {
                $group = true;
                $search_from_id = $search_params['search_from_group_id'];
            }

            //user has fb app setup? then pull in more photos
            $fb = Yii::$app->postradamus->get_facebook_details();
            if($fb['app_secret'])
            {
                $limit = 100;
            }
            else
            {
                $limit = 100;
            }

            $search = '/' . $search_from_id . "/feed/?fields=id,object_id,created_time,type,link,from{id,name,picture,link},message,picture,shares,likes.limit(1).summary(true),comments.limit(1).summary(true)&limit=$limit";

            if ($search_params['cache'] == 0) {
                Yii::$app->cache->delete(md5('facebook' . $search . $search_params['large_results']));
            }

            $posts = Yii::$app->cache->get(md5('facebook' . $search . $search_params['large_results']));
            if ($posts === false) {
                $pre_posts1 = $this->_fh->api_call($search);
                foreach($pre_posts1['data'] as $post)
                {
                    $posts[] = $post;
                }
                if(isset($pre_posts1['paging']->next))
                {
                    $pre_posts2 = json_decode(file_get_contents($pre_posts1['paging']->next));
                    foreach($pre_posts2->data as $post)
                    {
                        $posts[] = $post;
                    }
                }
                if($search_params['large_results'] == 1)
                {
                    if(isset($pre_posts2->paging->next)) {
                        $pre_posts3 = json_decode(file_get_contents($pre_posts2->paging->next));
                        foreach ($pre_posts3->data as $post) {
                            $posts[] = $post;
                        }
                    }
                    if(isset($pre_posts3->paging->next)) {
                        usleep(300);
                        $pre_posts4 = json_decode(file_get_contents($pre_posts3->paging->next));
                        foreach ($pre_posts4->data as $post) {
                            $posts[] = $post;
                        }
                    }
                    if(isset($pre_posts4->paging->next)) {
                        usleep(300);
                        $pre_posts5 = json_decode(file_get_contents($pre_posts4->paging->next));
                        foreach($pre_posts5->data as $post)
                        {
                            $posts[] = $post;
                        }
                    }
                }
                Yii::$app->cache->set(md5('facebook' . $search . $search_params['large_results']), $posts, 12 * 60 * 60);
            }

            set_time_limit(100);
            $i = 0;

            \Yii::beginProfile('Facebook Manipulate Results');
            if (empty($posts)) {
                $posts = [];
            }
            foreach ($posts as $k => $post) {
                $i++;
                if (isset($post->message) && $post->message == '' && !isset($post->picture)) {
                    unset($posts[$k]);
                }
                /*if($this->get_post_image_src($post->picture) == '' && $post->message == '')
                {
                    continue;
                }
                if(strstr($this->get_post_image_src($post->picture), 'fbstaging'))
                {
                    continue;
                }*/
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($post->id, Yii::$app->user->id))
                    {
                        continue;
                    }
                }
                if ($group != true) {
                    //post type is photo and type is not photo
                    if ($search_params['search_post_type'] == 1 && $post->type != 'photo') {
                        continue;
                    }

                    //post type is text and type is not text
                    if ($search_params['search_post_type'] == 2 && $post->type != 'status') {
                        continue;
                    }

                    //post type is photo and type is not link
                    if ($search_params['search_post_type'] == 4 && !strstr($post->link, 'video.php')) {
                        continue;
                    }

                    //post type is photo and type is not link
                    if ($search_params['search_post_type'] == 3 && $post->type != 'link') {
                        continue;
                    }

                    //posted by fans and from id == page id
                    if ($search_params['search_posted_by'] == 1 && $post->from->id == $search_from_id) {
                        continue;
                    }

                    //posted by page owner and from id != page id
                    if ($search_params['search_posted_by'] == 2 && $post->from->id != $search_from_id) {
                        continue;
                    }
                }

                $myposts[] = [
                    'id' => $post->id,
                    'page_id' => $search_from_id,
                    'author_id' => $post->from->id,
                    'author_name' => $post->from->name,
                    'author_pic' => $post->from->picture->data->url,
                    'author_url' => $post->from->link,
                    'image_url' => $this->getImageUrl($post->picture),
                    'large_image_id' => $post->object_id,
                    'link' => $post->link,
                    'post_url' => $this->get_link($post->id),
                    'object_id' => $post->object_id,
                    'text' => $this->get_post_message($post->message),
                    'likes' => (int)$post->likes->summary->total_count,
                    'comments' => (int)$post->comments->summary->total_count,
                    'shares' => (int)$post->shares->count,
                    'engagement' => ($page ? $this->calculate_engagement($search_from_id, $post) : 0),
                    'created' => strtotime($post->created_time),
                ];

            }
            \Yii::endProfile('Facebook Manipulate Results');

            if (empty($myposts)) {
                Yii::$app->session->setFlash('warning', 'No results found. Please try a different page or group.');
                return array();
            }
            return $myposts;
        } else {
            Yii::$app->session->setFlash('danger', 'Oops. You didn\'t select a page or group to search in.');
            return array();
        }
    }

    public function getImageUrl($url)
    {
        if(strstr($url, 'url='))
        {
            $url_parsed = parse_url($url);
            $url_test = $url_parsed['query'];
            parse_str($url_test, $params);
            if($params['url'])
                return $params['url'];
        }
        return $url;
    }

    public function get_link($post_id)
    {
        $post_id_info = explode("_", $post_id);
        $page = $post_id_info[0];
        $post_id = $post_id_info[1];
        return ('http://fb.com/' . $page . '/posts/' . $post_id);
    }

    public function calculate_engagement($page_id, $post)
    {
        if ($page_id) {
            //get total page likes

            $page_likes = Yii::$app->cache->get(md5('page_likes_' . $page_id));
            if ($page_likes === false) {
                $page_likes = $this->_fh->get_page_likes($page_id);
                Yii::$app->cache->set(md5('page_likes_' . $page_id), $page_likes, 10 * 60);
            }

            //add up all the actions (likes, comments, shares)
            $total_actions = (int)$post->comments->summary->total_count;
            $total_actions += (int)$post->shares->count;
            $total_actions += (int)$post->likes->summary->total_count;

            if ($page_likes > 0 && $total_actions > 0)
                return round($total_actions / $page_likes, 2) * 100;
            else
                return 0;
        } else {
            return 0;
        }
    }

    /* Helpers */
    public function get_post_message($message)
    {
        return iconv(mb_detect_encoding($message), "UTF-8", $message);
    }

    public function get_post_image_src($page_id, $object_id)
    {
        if ($object_id) {
            $photo_info = $this->_fh->get_photo_info($page_id, $object_id);
            if(isset($photo_info->data[0]->media->image->src))
            {
                return $photo_info->data[0]->media->image->src;
            }
            elseif(isset($photo_info->data[0]->subattachments->data[0]->media->image->src))
            {
                return $photo_info->data[0]->subattachments->data[0]->media->image->src;
            }
        }
        return $photo_info;
    }

}