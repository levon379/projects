<?php

class BloggerAPI
{
    private $instance = false;
    private $client_id = false;
    private $client_secret = false;
    private $redirect_uri = false;
    private $client = false;
    private $service = false;

    private $current_user = false;

    public function __construct()
    {
        require_once 'Google/autoload.php';
        $this->instance = Controller::get_instance();
        $this->keys = get_config('blogger');
        $this->client_id = $this->keys['client_id'];
        $this->client_secret = $this->keys['client_secret'];
        $this->redirect_uri = base_url('blogger/login');
    }

    private function connect()
    {
        $this->client = new Google_Client();;
        $this->client->setClientId($this->client_id);
        $this->client->setClientSecret($this->client_secret);
        $this->client->setRedirectUri($this->redirect_uri);
        // scopes
        $this->client->addScope(Google_Service_Blogger::BLOGGER);
        $this->client->addScope(Google_Service_Plus::PLUS_ME);
        $this->client->addScope(Google_Service_Plus::USERINFO_EMAIL);
        $this->client->addScope(Google_Service_Plus::USERINFO_PROFILE);
        $this->current_user = Users_Model::get_current_user();
        if(!$this->current_user && $this->current_user_id) {
            $this->current_user = Users_Model::find($this->current_user_id);
        }

        if ($this->current_user->get_blogger_token()) {
            if ($this->client->isAccessTokenExpired()) {
                $this->client->refreshToken($this->current_user->get_blogger_token());
            }
        }

        $this->service = new Google_Service_Blogger($this->client);
    }

    public function login()
    {
        $this->connect();
        if (isset($_GET['code'])) {

            $this->client->authenticate($_GET['code']);
            $token = json_decode($this->client->getAccessToken());
            $oauth = new Google_Service_Oauth2($this->client);
            $userinfo = $oauth->userinfo->get();

            if (!$google_screen_name = Usermetum::first(array('meta_key' => 'google_user_id', 'user_id' => $this->current_user->user_id))) {
                $google_screen_name = new Usermetum(array(
                    'user_id' => $this->current_user->user_id,
                    'meta_key' => 'google_user_id'
                ));
                if ($userinfo->id) {
                    $google_screen_name->meta_value = $userinfo->id;
                    $google_screen_name->save();

                    /**
                     * Update blogger role
                     */
                    if($newroles = $this->current_user->get_roles()) {
                        if(!in_array(Roles_Model::TYPE_LEVEL_HAVE_BLOGGER, $newroles)) {
                            $newroles[] = Roles_Model::TYPE_LEVEL_HAVE_BLOGGER;
                            $this->current_user->update_roles($newroles);
                        }
                    }
                }
            }

            if (!$meta = Usermetum::first(array('meta_key' => 'blogger_access_token', 'user_id' => $this->current_user->user_id))) {
                $meta = new Usermetum();
            }
            $meta->set_attributes(array(
                'user_id'       => $this->current_user->user_id,
                'meta_key'      => 'blogger_access_token',
                'meta_value'    => $token->refresh_token,
            ));
            $meta->save();
            redirect(filter_var(base_url('blogger/login'), FILTER_SANITIZE_URL));
        }

        if (!$this->current_user->get_blogger_token()) {
            $this->client->setApprovalPrompt('force');
            $this->client->setAccessType('offline');
            $authUrl = $this->client->createAuthUrl();
            redirect($authUrl);
            exit;
        } else {
            return true;
        }
        return false;
    }

    function delete_blogger_account()
    {
        $response = array(
            'status' => false,
        );

        $current_user = Users_Model::get_current_user();
        if (!$current_user) return false;

        /**clear roles*/
        $newroles = $current_user->get_roles();
        if(in_array(Roles_Model::TYPE_LEVEL_HAVE_BLOGGER, $newroles)){
            foreach($newroles as $rolekey => $rolevalue){
                if($rolevalue === Roles_Model::TYPE_LEVEL_HAVE_BLOGGER){
                    unset($newroles[$rolekey]);
                }
            }
            $current_user->update_roles($newroles);
        }

            /**delete social blogger posts*/
            $bl_posts = Posts_Model::all(array('conditions' => array('user_id = ? AND social_type = ?', $current_user->id, get_config('social_types')->type_blogger)));
            foreach($bl_posts as $bl_post){
                $atch_id = $bl_post->attachment_id;
                if(!empty($atch_id) && is_numeric($atch_id)){
                    try{
                        $attachments = Media_Model::find($atch_id);
                        //delete attachment from filesystem
                        $deletepath = ABSPATH . $attachments->uri;
                        if(file_exists($deletepath)){
                            @unlink($deletepath);
                        }
                        //delete attachment from database
                        $attachments->delete();
                    } catch (Exception $ex){
                        //run script further if do not find attachment
                    }
                }
                if(!empty($_POST['del-messages']) && $_POST['del-messages'] === "on"){
                    $bl_post->remove_blogger_post();
                }
                $bl_post->delete();
            }


            /**clear coupons*/
            $coupons = Coupon_Model::all(array('conditions' => array('user_id = ?', $current_user->id)));
            foreach($coupons as $coupon){
                //clear coupons attachment for blogger
                if(!empty($coupon->attach_id_blogger)){
                    $coupon->attach_id_facebook = NULL;
                }

                if(!empty($coupon->attach_id_twitter) ||
                    !empty($coupon->attach_id_facebook) ||
                    !empty($coupon->attach_id_instagram)){
                    $coupon->save();
                }else{
                    /**delete if only bloggers coupons*/
                    $coupon->delete();
                }
            }

            /**remove blogger token and clear user meta*/
            $bloggerMeta = array("blogger_access_token", "google_user_id");
            Usermetum::table()->delete(array('user_id' => $current_user->id, 'meta_key' => $bloggerMeta));

        if($current_user->save()){
            $response = array(
                'status'    => 'success',
                'url'       => base_url('Posts/index'),
            );
        }

        return $response;
    }

    public function get_blogs()
    {
        $this->connect();
        if ($this->client) {
            return $this->service->blogs->listByUser('self');
        }
        return false;
    }

    public function get_comments_by_date($from, $to)
    {
        $return = array();
        $this->connect();
        if ($this->client) {
            $blogs = $this->get_blogs();
            foreach ($blogs->items as $blog) {
                $posts = $this->service->posts->listPosts($blog->id);
                foreach ($posts->items as $post) {
                    $comments = $this->service->comments->listComments($blog->id, $post->id);
                    foreach ($comments->items as $comment){
                        if (strtotime($comment->published) >= $from && strtotime($comment->published) <= $to) {
                            $return[] = $comment;
                        }
                    }
                }
            }
        }
        return $return;
    }

    public function create_post($blog_id = false, $title = '', $content = '', $user_id = false)
    {
        if($user_id){
            $this->current_user_id = $user_id;
        }
        if (!$blog_id) return false;
        $this->connect();
        if ($this->client) {
            $new_post = new Google_Service_Blogger_Post();
            $new_post->setTitle($title);
            $new_post->setContent($content);
            return $this->service->posts->insert($blog_id, $new_post, array());
        }
        return false;
    }

    public function create_comment($blog_id, $postId, $replyToId, $content = '', $user_id = false)
    {
        if($user_id){
            $this->current_user_id = $user_id;
        }
        if (!$blog_id) return false;
        $this->connect();
        if ($this->client) {
            $new_comment = new Google_Service_Blogger_Comment();

            $replyTo = new Google_Service_Blogger_CommentInReplyTo();
            $replyTo->setId($replyToId);

            $blog = new Google_Service_Blogger_CommentBlog();
            $blog->setId($blog_id);

            $post = new Google_Service_Blogger_CommentPost();
            $post->setId($postId);

            $new_comment->setBlog($blog);
            $new_comment->setPost($post);
            $new_comment->setInReplyTo($replyTo);
            $new_comment->setContent($content);

            return $this->service->comments->insert($blog_id, $new_comment, array());
        }
        return false;
    }

    public function delete_post($blog_id = false, $post_id = false)
    {
        if (!$post_id || !$blog_id) return false;
        $this->connect();
        if ($this->client) {
            try {
                $this->service->posts->delete($blog_id, $post_id);
            } catch (Exception $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function  get_all_comments(){
        $return = array();
        $this->connect();
        if ($this->client) {
            $blogs = $this->get_blogs();
            foreach ($blogs->items as $blog) {
                $comments = $this->service->comments->listByBLog($blog->id, array("maxResults" => 100));
                $return = array_merge($comments->items, $return);
            }
        }
        return $return;
    }

    public  function remove_comment($blog_id, $post_id,$comment_id)
    {
        $return = array();
        $this->connect();
        if ($this->client) {
            $return = $this->service->comments->delete($blog_id, $post_id,$comment_id);
        }
        return $return;
    }

    public  function mark_spam_comment($blog_id, $post_id,$comment_id)
    {
        $return = array();
        $this->connect();
        if ($this->client) {
            $return = $this->service->comments->markAsSpam($blog_id, $post_id,$comment_id);
        }
        return $return;
    }
}