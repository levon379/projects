<?php

namespace backend\controllers;

use Yii;
use backend\components\importers\Pinterest;
use common\models\cList;
use common\models\cListPost;
use common\models\cPostTemplate;
use common\models\cPostTemplateImage;
use backend\models\PinterestSearchForm;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use backend\components\Common;
use common\models\cSavedSearch;

class ImportController extends cController
{
    public $enableCsrfValidation = false;

    public function actionYoutube()
    {
        return $this->handleAction(cListPost::ORIGIN_YOUTUBE);
    }

    public function actionList()
    {
        return $this->handleAction(cListPost::ORIGIN_LIST);
    }

    public function actionWebpage()
    {
        return $this->handleAction(cListPost::ORIGIN_WEBPAGE);
    }

    public function actionImgur()
    {
        return $this->handleAction(cListPost::ORIGIN_IMGUR);
    }

    public function actionFeed()
    {
        return $this->handleAction(cListPost::ORIGIN_FEED);
    }

    public function actionAmazon()
    {
        return $this->handleAction(cListPost::ORIGIN_AMAZON);
    }

    public function actionTumblr()
    {
        return $this->handleAction(cListPost::ORIGIN_TUMBLR);
    }

    function sanitize($string, $force_lowercase = true, $anal = false) {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    public function handleAction($origin)
    {
        $counted = 0;
        if (Yii::$app->request->post('list') == 1) {
            $list_id = Yii::$app->request->post('list_id');
        } else {
            //create new list
            $new_list = new cList;
            $new_list->user_id = Yii::$app->user->id;
            $new_list->campaign_id = (int)Yii::$app->session->get('campaign_id');
            $new_list->name = Yii::$app->request->post('new_list_name');
            $new_list->save();
            $list_id = $new_list->id;
        }
        Yii::$app->session->set('last_used_list_id', $list_id);
		
		$default_images=null;
		$templateId=null;
		if($origin!=cListPost::ORIGIN_YOUTUBE&&$origin!=cListPost::ORIGIN_UPLOAD&&$origin!=cListPost::ORIGIN_CSV&&Yii::$app->request->post('post_template_id')&&is_array(Yii::$app->request->post('post_template_id'))){
			$templateId=Yii::$app->request->post('post_template_id')[0];
			$default_images=cPostTemplateImage::findListByPostTemplateId(Yii::$app->request->post('post_template_id')[0]);
		}
		$i = 0;
        $image = new \backend\components\Image;
        foreach (Yii::$app->request->post('post') as $post) {
            if (isset($post['selected']) && $post['selected'] == 1) //is checked?
            $counted += 1;
        }
        foreach (Yii::$app->request->post('post') as $post) {
			unset($image_url);
            if (isset($post['selected']) && $post['selected'] == 1) //is checked?
            {
                if (!$list_id) {
                    Yii::$app->session->setFlash('danger', 'Oops! Something bad happened.');
                }
                set_time_limit(10);
                $newPost = new cListPost;

                if($origin == cListPost::ORIGIN_FACEBOOK)
                {
                    Yii::$app->session->open();
                    $params = [];
                    if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason'] == 'user_denied')
                    {
                        die("You must accept the Facebook permissions. Try again.");
                    }
                    $e = '';

                    $fb = Yii::$app->postradamus->get_facebook_details();
                    \Facebook\FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

                    $helper = new \Facebook\FacebookRedirectLoginHelper( Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook') );
                    // login helper with redirect_uri
                    $fh = new \backend\components\FacebookHelper;
                    try {
                        $session = $fh->create_session($helper);
                    } catch ( \Facebook\FacebookAuthorizationException $ex ) {
                        // catch any exceptions
                        $session = null;
                        $e = $ex->getMessage();
                    } catch( \Facebook\FacebookRequestException $ex ) {
                        // When Facebook returns an error
                        // handle this better in production code
                        $e = $ex->getMessage();
                    } catch(\Exception $ex) {
                        $e = $ex->message();
                    }

                    // see if we have a session
                    if ( isset( $session ) ) {
                        // graph api request for user data
                        if(!$fh->has_permissions(['manage_pages', 'user_managed_groups']))
                        {
                            if($_GET['code'])
                            {
                                //Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                                unset($_SESSION['fb_token']);
                                $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook'), ['manage_pages', 'user_managed_groups'], true, true);
                            }
                            else
                            {
                                unset($_SESSION['fb_token']);
                                $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook'), ['manage_pages', 'user_managed_groups']);
                            }
                        }
                    } else { //not logged in, do so now!
                        unset($_SESSION['fb_token']);
                        $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook'), ['manage_pages', 'user_managed_groups']);
                    }
					
					if(isset($post['id'])&&!empty($post['large_image_id'])){
                        $fb = new \backend\components\importers\Facebook($fh);
                        $ids = explode("_", $post['id']);
                        $image_url = $fb->get_post_image_src($ids[0], $ids[1]);
					}
                    
					if(!$image_url && isset($post['image_url'])&&!empty($post['image_url'])){
                        $image_url = $post['image_url'];
                    }
                }
                elseif (isset($post['image_url']))
                {
                    $image_url = $post['image_url'];
                }

				if((trim($image_url)=='')&&!empty($default_images)){
					$image_url=$default_images[array_rand($default_images)];
					$image_url=Yii::$app->params['imagePath'] . 'post-templates/' . Yii::$app->user->id . '/' . $templateId . '/' . $image_url ;
				}
				
				if (isset($image_url)&&trim($image_url)!=''&& Yii::$app->request->post('include_photos') == 1) {
					$image_parts = pathinfo($image_url);
                    $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $list_id . '/';
                    $filename = $image->download_image($image_url, $imagepath, false);
                    $filename_parts = pathinfo($filename);
                    //$image->createThumbnail($imagepath, $filename_parts['basename']);
                    $newPost->image_filename0 = $filename_parts['basename'];
                }
				/*
				if((trim($image_url)=='')&&!empty($default_images)){
					$image_url=$default_images[array_rand($default_images)];
					
					$srcpath=Yii::$app->params['imagePath'] . 'post-templates/' . Yii::$app->user->id . '/' . $templateId . '/' . $image_url ;
					
					if(is_file($srcpath)){
						$destpath=Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $list_id  ;
						if(!is_dir($destpath)){
							mkdir($destpath);
						}
						$destpath .= '/' . $image_url;
						if(copy($srcpath,$destpath)){
							$newPost->image_filename0=$image_url;
						}	
					}
				}
				*/
                $newPost->user_id = Yii::$app->user->id;
                $newPost->list_id = $list_id;
                $newPost->name = "Source: " . $post['meta']['author_name'] . " (" . cListPost::getOriginNameFromId($origin) . ")";

                if($origin == cListPost::ORIGIN_PINTEREST) //pinterest
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'name' => $newPost->name,
                        'keyword' => ucwords(Yii::$app->request->post('keyword')),
                        'image_url' => $post['image_url'],
                        'post_url' => $post['image_link'],
                        'like_count' => Common::human_number($post['meta']['like_count']),
                        'repin_count' => Common::human_number($post['meta']['repin_count']),
                        'comment_count' => Common::human_number($post['meta']['comment_count']),
                        'author_name' => $post['meta']['author_name'],
                        'author_profile_url' => $post['meta']['author_profile_url'],
                        'author_image_url' => $post['meta']['author_image_url']
                    ];
                }

                if($origin == cListPost::ORIGIN_YOUTUBE) //youtube
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'url' => $post['url'],
                        'embed_code' => '<iframe width="560" height="315" src="//www.youtube.com/embed/' . $post['id'] . '" frameborder="0" allowfullscreen></iframe>',
                        'name' => $newPost->name,
                        'title' => $post['title'],
                        'image_url' => $post['image_url'],
                        'likes' => Common::human_number($post['meta']['likes']),
                        'views' => Common::human_number($post['meta']['views']),
                        'comments' => Common::human_number($post['meta']['comments']),
                    ];
                    $newPost->link = $post['url'];
                }

                if($origin == cListPost::ORIGIN_LIST)
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'name' => $post['name'],
                        'link' => $post['link'],
                        'image_url' => $post['image_url'],
                        'scheduled_time' => $post['scheduled_time']
                    ];
                }

                if($origin == cListPost::ORIGIN_FACEBOOK)
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'name' => $newPost->name,
                        'page_url' => 'http://fb.com/' . $post['meta']['page_id'],
                        'image_url' => $image_url,
                        'like_count' => Common::human_number($post['meta']['like_count']),
                        'share_count' => Common::human_number($post['meta']['share_count']),
                        'comment_count' => Common::human_number($post['meta']['comment_count']),
                        'author_name' => $post['meta']['author_name'],
                        'author_profile_url' => $post['meta']['author_profile_url'],
                        'post_url' => $post['meta']['post_url'],
                        'link' => $post['meta']['link'],
                        'author_image_url' => $post['meta']['author_image_url']
                    ];
                    if(strstr($variables['link'], 'video.php') || strstr($variables['link'], 'vimeo.com'))
                    {
                        $newPost->link = $variables['link']; //video link
                    }
                }

                if($origin == cListPost::ORIGIN_TUMBLR)
                {
                    $variables = [
                        'id' => $post['id'],
                        'type' => $post['meta']['type'],
                        'text' => $post['text'],
                        'image_url' => $post['image_url'],
                        'note_count' => Common::human_number($post['meta']['note_count']),
                        'created' => $post['meta']['created'],
                        'post_url' => $post['meta']['post_url'],
                        'blog_name' => $post['meta']['blog_name'],
                        'blog_url' => $post['meta']['blog_url'],
                        'author_name' => $post['meta']['author_name']
                    ];
                }

                if($origin == cListPost::ORIGIN_AMAZON)
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'url' => $post['meta']['url'],
                        'name' => $newPost->name,
                        'title' => $post['meta']['title'],
                        'image_url' => $post['image_url'],
                        'sales_rank' => Common::human_number($post['meta']['sales_rank']),
                        'author_name' => $post['meta']['author_name'],
                    ];
                    $newPost->link = $post['meta']['url'];
                }

                if($origin == cListPost::ORIGIN_INSTAGRAM)
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'name' => $newPost->name,
                        'image_url' => $post['image_url'],
                        'like_count' => Common::human_number($post['meta']['like_count']),
                        'comment_count' => Common::human_number($post['meta']['comment_count']),
                        'author_name' => $post['meta']['author_name'],
                        'author_profile_url' => $post['meta']['author_profile_url'],
                        'author_image_url' => $post['meta']['author_image_url']
                    ];
                }

                if($origin == cListPost::ORIGIN_TWITTER)
                {
                    $variables = [
                        'id' => $post['id'],
                        'text' => $post['text'],
                        'name' => $newPost->name,
                        'image_url' => $post['image_url'],
                        'like_count' => Common::human_number($post['meta']['like_count']),
                        'comment_count' => Common::human_number($post['meta']['comment_count']),
                        'author_name' => $post['meta']['author_name'],
                        'retweet_count' => $post['meta']['retweet_count'],
                        'favorite_count' => $post['meta']['favorite_count'],
                        'author_profile_url' => $post['meta']['author_profile_url'],
                        'author_image_url' => $post['meta']['author_image_url']
                    ];
                }

                if(Yii::$app->request->post('save_links') == 1 && isset($variables['link']) && $variables['link'] != '')
                {
                    $newPost->link = $variables['link']; //video link
                }

                if($origin == cListPost::ORIGIN_REDDIT)
                {
                    if(!strstr($post['url'], '.png') && !strstr($post['url'], '.jpg') && !strstr($post['url'], '.gif'))
                        $newPost->link = $post['url'];
                }

                if(!$variables)
                {
                    $variables = $post;
                }

                if (Yii::$app->request->post('include_text') == 1) {
                    $text = $this->createText($origin, Yii::$app->request->post('post_template_id'), $variables);
                    $newPost->text = $text[0];
                    $image_template = $text[1];
                }

                $newPost->origin_type = $origin;
                $newPost->origin_id = $post['id'];
                $newPost->post_type_id = Yii::$app->request->post('post_type_id');
                if ($newPost->save()) {
                    $postTemplate = cPostTemplate::find()->where(['id' => Yii::$app->request->post('post_template_id')])->one();
                    $image_test = $this->apply_image_template($newPost->id, $newPost->image_url, $image_template, $counted, Yii::$app->request->referrer, $variables);
                    if(count($image_test) > 1)
                    {
                        $images[] = $image_test;
                        $applied = 1;
                    }
                    $i++;
                }
                unset($variables);
            }
        }

        Yii::$app->session->setFlash('success', $counted . ' posts have been added to ' . Html::a('your list', ['list/view', 'id' => $list_id]) . '.');

        if($applied == 1) //user applied image template
        {
            $result = array();
            foreach ($images as $image) {
                $result = array_merge($result, $image);
            }
            $result = array_unique($result);
            $this->view->registerJsFile('@web' . '/js/fabric.js');
            $this->view->registerJsFile('@web' . '/js/image-editing.js');
            return $this->render('image-template', ['images' => $result]);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPinterest()
    {
        return $this->handleAction(cListPost::ORIGIN_PINTEREST);
    }

    public function actionReddit()
    {
        return $this->handleAction(cListPost::ORIGIN_REDDIT);
    }

    public function actionFacebook()
    {
        return $this->handleAction(cListPost::ORIGIN_FACEBOOK);
    }

    public function actionTest()
    {
        $variables = [
            'author_name' => 'test'
        ];
        $json_array = json_decode('{"objects":[{"type":"image","originX":"left","originY":"top","left":0,"top":0,"width":625,"height":567,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","src":"http://localhost/fbpostbot3/backend/web/images/posts/1/43/83a610a8eae91bf8453e10ca6ce82e0c.jpg","filters":[],"crossOrigin":"","name":"master"},{"type":"i-text","originX":"left","originY":"top","left":87.33,"top":495.5,"width":537.67,"height":71.5,"fill":"#ffffff","stroke":"black","strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","text":"My {author_name}","fontSize":55,"fontWeight":"bold","fontFamily":"tahoma","fontStyle":"","lineHeight":1.3,"textDecoration":"","textAlign":"left","path":null,"textBackgroundColor":"","useNative":true,"styles":{},"position_x":"3","position_y":"3"}],"background":"","width":625,"height":567}');
        if(!is_object($json_array)) { $objects = []; } else { $objects = $json_array->objects; }
        foreach($objects as $object)
        {
            if($object->type == 'i-text')
            {
                $image_text = $object->text;
                $image_text = Yii::$app->postradamus->spin($image_text, false, '[[', ']]', '|');
                $image_text = Yii::$app->postradamus->replace_vars($image_text, $variables);
                $object->text = $image_text;
                unset($image_text);
            }
        }
        $image_template = json_encode($json_array);
        echo "<pre>";
        print_r($json_array);
    }

    public function createText($origin_type, $post_template_ids, $variables)
    {
        //handle facebook
        $rand = rand(0, count($post_template_ids) - 1);
        $post_template_id = $post_template_ids[$rand];
        $template_text = cPostTemplate::find()->andWhere(['origin_type' => $origin_type, 'id' => $post_template_id])->one();
        //handle spin text
        if (!empty($template_text)) {
            //handle the post text
            \Yii::info('Template ID ' . $post_template_id . ' used.');
            $text = $template_text->template;
            $text = Yii::$app->postradamus->spin($text, false, '[[', ']]', '|');
            $text = Yii::$app->postradamus->replace_vars($text, $variables);
            //handle the image text
            $json_array = json_decode($template_text->image_template);
            if(!is_object($json_array)) { $objects = []; } else { $objects = $json_array->objects; }
            foreach($objects as $object)
            {
                if($object->type == 'i-text')
                {
                    $image_text = $object->text;
                    $image_text = Yii::$app->postradamus->spin($image_text, false, '[[', ']]', '|');
                    $image_text = Yii::$app->postradamus->replace_vars($image_text, $variables);
                    $object->text = $image_text;
                    unset($image_text);
                }
            }
            $image_template = json_encode($json_array);
        } else {
            \Yii::info('No template used. ' . $post_template_id);
            if($origin_type != cListPost::ORIGIN_REDDIT)
            {
                $text = $variables['text'];
            }
            else
            {
                $text = $variables['title'];
            }
        }
        return [(string)$text, (string)$image_template];
    }

    public function apply_image_template($post_id, $image_url, $image_json, $post_count, $redirect)
    {
        $post_count = (int)$post_count;
        $id = $post_id;

        $additional_javascript = '';

        $cid = md5($image_url . $image_json);

        $images[] = $image_url;

        //load html images and resize objects and move objects
        $json_array = json_decode($image_json);
        $json_objects = $json_array->objects;
        if(!is_array($json_objects)) { $json_objects = []; }
        foreach($json_objects as $object)
        {
            if($object->type == 'image')
            {
                $images[] = $object->src;
            }
        }

        //replace master image with new image
        $additional_javascript .= "
            //remove fruit image
            canvas_$cid.getItemByName('master').remove();
            //add user image
            img = new fabric.Image($(\"img[src='$image_url']\")[0]);
            createImageFromUrl(img, canvas_$cid);
            img.sendToBack();
            //go through each object and reposition
            var objs = canvas_$cid.getObjects().map(function(o) {
                //lock movement
                scale(o, canvas_$cid);
                moveObject(o, o.position_x, o.position_y, canvas_$cid);
                return o;
            });
        ";

        //save the image
        $additional_javascript .= "
            saveImage($id, '" . Yii::$app->urlManager->createUrl('post/save-custom-image') . "', '$redirect', '$post_count', canvas_$cid);
        ";

        Yii::$app->view->registerJs(Yii::$app->postradamus->create_canvas_from_image($image_url, $image_json, $additional_javascript, 'canvas_' . $cid), yii\web\View::POS_LOAD);
        return ($images ? $images : true);

        return false;
    }

    public function actionInstagram()
    {
        return $this->handleAction(cListPost::ORIGIN_INSTAGRAM);
    }

    public function actionTwitter()
    {
        return $this->handleAction(cListPost::ORIGIN_TWITTER);
    }
    
    public function actionImageUpload()
    {
        //handle the file upload
        $image = new \backend\components\Image;
        $text = '';

        if (Yii::$app->request->post('list') == 1) {
            $list_id = Yii::$app->request->post('content_list_id');
        } elseif (Yii::$app->request->post('list') == 2) {
            $list_id = Yii::$app->session->get('content_list_id');
            if (!$list_id) {
                //create new list
                $new_list = new cList;
                $new_list->user_id = Yii::$app->user->id;
                $new_list->campaign_id = (int)Yii::$app->session->get('campaign_id');
                $new_list->name = Yii::$app->request->post('new_list_name');
                $new_list->save(false);
                $list_id = $new_list->id;
                Yii::$app->session->set('content_list_id', $list_id);
            }
        }
        Yii::$app->session->set('last_used_list_id', $list_id);

        $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $list_id . '/';
        if ($new_file_name = $image->move_uploaded_file($_FILES["file"], $imagepath)) {
            /*
            $exif = @exif_read_data($imagepath . $new_file_name, 0, true);
            if(isset($exif) && is_array($exif))
            {
                foreach ($exif as $key => $section) {
                    foreach ($section as $name => $val) {
                        //$text .= "$key.$name: $val<br />\n";
                    }
                }
            }
            */
            //add it as a post
            $newPost = new cListPost;
            $newPost->list_id = $list_id;
            Yii::$app->session->set('last_used_list_id', $list_id);
            $newPost->user_id = \Yii::$app->user->id;
            $newPost->name = $_FILES['file']['name'];

            if (Yii::$app->request->post('include_text') == 1) {
                $text = $this->createText(cListPost::ORIGIN_UPLOAD, Yii::$app->request->post('post_template_id'), [
                    'name' => $newPost->name,
                ]);
                $newPost->text = $text[0];
                $image_template = $text[1];
            }

            if (!$newPost->text) {
                $newPost->text = '';
            }

            $variables = [
                'name' => $newPost->name,
            ];

            $newPost->image_filename0 = $new_file_name;
            $newPost->origin_type = $newPost::ORIGIN_UPLOAD;
            if (!$newPost->save()) {
                header("HTTP/1.0 404 Not Found");
                print_r($newPost->errors);
                die();
            }

            $newPost->origin_id = $newPost->id;
            $newPost->post_type_id = (int)Yii::$app->request->post('post_type_id');
            if($newPost->save())
            {
                $postTemplate = cPostTemplate::find()->where(['id' => Yii::$app->request->post('post_template_id')])->one();
                $image_test = $this->apply_image_template($newPost->id, $newPost->image_url, $image_template, $counted, Yii::$app->request->referrer, $variables);
                if(count($image_test) > 1)
                {
                    $images[] = $image_test;
                    $applied = 1;
                }
                $i++;
            }
            else
            {

                header("HTTP/1.0 404 Not Found");
                print_r($newPost->errors);
                die();
            }

            if($applied == 1) //user applied image template
            {
                $result = array();
                foreach ($images as $image) {
                    $result = array_merge($result, $image);
                }
                $result = array_unique($result);
                $this->view->registerJsFile('@web' . '/js/fabric.js');
                $this->view->registerJsFile('@web' . '/js/image-editing.js');
                return $this->render('image-template', ['images' => $result]);
            }

        } else {
            header("HTTP/1.0 404 Not Found");
            die("Could not upload image. Too large or wrong type?");
        }
    }

    public function actionCsv()
    {
        $counted = 0;
        if (Yii::$app->request->post('list') == 1) {
            $list_id = Yii::$app->request->post('list_id');
        } else {
            //create new list
            $new_list = new cList;
            $new_list->user_id = Yii::$app->user->id;
            $new_list->campaign_id = (int)Yii::$app->session->get('campaign_id');
            $new_list->name = Yii::$app->request->post('new_list_name');
            $new_list->save();
            $list_id = $new_list->id;
        }
        Yii::$app->session->set('last_used_list_id', $list_id);

        $i = 0;
        $image = new \backend\components\Image;
        foreach (Yii::$app->request->post('post') as $post) {
            if (isset($post['selected']) && $post['selected'] == 1) //is checked?
            {
                if (!$list_id) {
                    Yii::$app->session->setFlash('danger', 'Oops! Something bad happened.');
                }
                set_time_limit(20);
                $newPost = new cListPost;
                $image_url = $post['image_url'];
				if (isset($image_url)) {
                    $imagepath = Yii::$app->params['imagePath'] . 'posts/' . Yii::$app->user->id . '/' . $list_id . '/';
                    $filename = $image->download_image($image_url, $imagepath, false);
                    if (!$filename || $filename == '') { continue; }
                    $filename_parts = pathinfo($filename);
                    //$image->createThumbnail($imagepath, $filename_parts['basename']);
                    $newPost->image_filename0 = $filename_parts['basename'];
                }
                else { continue; }
                $newPost->user_id = Yii::$app->user->id;
                $newPost->list_id = (int)$list_id;
				if(!empty($post['scheduled_time'])&&strtolower($post['scheduled_time']!='not scheduled')){
                    if((bool)strtotime($post['scheduled_time'])){
                        $newPost->scheduled_time = strtotime($post['scheduled_time']);
                    }else{
                        $newPost->scheduled_time = NULL;
                    }
				}
			    $newPost->name = $post['name'];
				$newPost->link = $post['link'];
                $text = $this->createText(cListPost::ORIGIN_CSV, Yii::$app->request->post('post_template_id'), $post);
                $newPost->text = $text[0];
                $image_template = $text[1];
                $newPost->origin_type = cListPost::ORIGIN_CSV;
                $newPost->post_type_id = (int)Yii::$app->request->post('post_type_id');
                if ($newPost->save()) {
                    $newPost->origin_id = (string)$newPost->id;
                    $newPost->post_type_id = (int)Yii::$app->request->post('post_type_id');
                    if ($newPost->save()) {
                        $postTemplate = cPostTemplate::find()->where(['id' => Yii::$app->request->post('post_template_id')])->one();
                        $image_test = $this->apply_image_template($newPost->id, $newPost->image_url, $image_template, $counted, Yii::$app->request->referrer, $post);
                        if(count($image_test) > 1)
                        {
                            $images[] = $image_test;
                            $applied = 1;
                        }
                        $i++;
                        $counted += 1;
                    }
                }
                
            }
        }
        Yii::$app->session->setFlash($counted > 0 ? 'success' : 'error', $counted . ' post' . ($counted > 1 ? 's have' : ' has') . ' been added to ' . Html::a('your list', ['list/view', 'id' => $list_id]) . '.' . ($counted == 0 ? ' Please make sure that your source CSV file contains rows and data that are in the correct format.' : ''));

        if($applied == 1) //user applied image template
        {
            $result = array();
            foreach ($images as $image) {
                $result = array_merge($result, $image);
            }
            $result = array_unique($result);
            $this->view->registerJsFile('@web' . '/js/fabric.js');
            $this->view->registerJsFile('@web' . '/js/image-editing.js');
            return $this->render('image-template', ['images' => $result]);
        }

        return $this->redirect(Yii::$app->request->referrer);
        
    }
}