<?php

namespace backend\controllers;

use Yii;
use yii\base\ErrorException;
use yii\web\Controller;
use backend\components\exporters\FacebookMacroBasic;
use backend\components\exporters\FacebookApi;
use backend\components\exporters\FacebookMacroEnhanced;
use backend\components\exporters\Csv;
use backend\components\Zip;
use backend\models\FacebookDirectExportForm;
use backend\models\FacebookMacroExportForm;;
use backend\models\WordpressExportForm;;
use backend\models\FacebookExportDeleteForm;
use backend\models\CsvExportForm;
use backend\models\PinterestExportForm;
use common\models\cListPost;
use common\models\cList;
use common\models\cUser;
use yii\db\Expression;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use backend\components\FacebookHelper;
use common\models\cListSent;
use common\models\cListSentPost;
use common\models\cListSentMeta;

/**
 * Export controller
 */
class ExportController extends cController
{

    public function actionRss()
    {
        return $this->render('rss');
    }

    public function actionPinterest()
    {
        $model = new PinterestExportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $list = cList::find()->where(['tbl_list.id' => $model->list_id])->one();
            $list->sent_at = 0;
            $list->save(false);
            //get list posts
            $list = new cListSent;
            $list->list_id = $model->list_id;
            $list->user_id = Yii::$app->user->id;
            $list->campaign_id = (int)Yii::$app->session->get('campaign_id');
            $list->target = cListSent::TARGET_PINTEREST;
            $list->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $list->id;
            $meta->key = 'username';
            $meta->value = Yii::$app->user->identity->getPinterestConnection('username', (int)Yii::$app->session->get('campaign_id'));
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $list->id;
            $meta->key = 'password';
            $meta->value = Yii::$app->user->identity->getPinterestConnection('password', (int)Yii::$app->session->get('campaign_id'));
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $list->id;
            $meta->key = 'board_id';
            $meta->value = $model->board_id;
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $list->id;
            $meta->key = 'board_name';
            $meta->value = $model->board_name;
            $meta->save(false);

            Yii::$app->session->setFlash('success', 'Done! Your posts will be sent to Pinterest when they are ready.');
        }

        $lists['Ready'] = \yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sending'] = \yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sent'] = \yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        //TODO
        $email = Yii::$app->user->identity->getPinterestConnection('username', Yii::$app->session->get('campaign_id'));
        $pass = Yii::$app->user->identity->getPinterestConnection('password', Yii::$app->session->get('campaign_id'));

        $p = new \backend\components\PinterestHelper($email, $pass);
        //$p->debug = true;

        return $this->render('pinterest_scrape', [
            'model' => $model,
            'pinterest' => $p,
            'lists' => $lists,
        ]);
    }

    public function actionWordpress()
    {
        $model = new WordpressExportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $list = cList::find()->where(['tbl_list.id' => $model->list_id])->one();
            $list->sent_at = 0;
            $list->save(false);
            //get list posts
            $listSent = new cListSent;
            $listSent->list_id = $model->list_id;
            $listSent->user_id = Yii::$app->user->id;
            $listSent->campaign_id = (int)Yii::$app->session->get('campaign_id');
            $listSent->target = cListSent::TARGET_WORDPRESS;
            $listSent->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $listSent->id;
            $meta->key = 'username';
            $meta->value = Yii::$app->user->identity->getWordpressConnection('username', (int)Yii::$app->session->get('campaign_id'));
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $listSent->id;
            $meta->key = 'password';
            $meta->value = Yii::$app->user->identity->getWordpressConnection('password', (int)Yii::$app->session->get('campaign_id'));
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $listSent->id;
            $meta->key = 'xml_rpc_url';
            $meta->value = Yii::$app->user->identity->getWordpressConnection('xml_rpc_url', (int)Yii::$app->session->get('campaign_id'));
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $listSent->id;
            $meta->key = 'blog_name';
            $meta->value = $model->blog_name;
            $meta->save(false);
            //create meta fields
            $meta = new cListSentMeta;
            $meta->user_id = Yii::$app->user->id;
            $meta->list_id = $model->list_id;
            $meta->list_sent_id = $listSent->id;
            $meta->key = 'blog_category_id';
            $meta->value = $model->category_id;
            $meta->save(false);

            Yii::$app->session->setFlash('success', 'Done! Your posts will be sent to Wordpress when they are ready.');
        }

        $lists['Ready'] = \yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sending'] = \yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sent'] = \yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        return $this->render('wordpress', [
            'model' => $model,
            'lists' => $lists,
        ]);
    }

    public function actionSchedulingStats()
    {
        header("Content-Type: text/json");
        $sent_in_last_hour = cListSentPost::find()->where('sent > UNIX_TIMESTAMP() - 60 * 60 * 1')->count();
        $sent_in_last_12_hours = cListSentPost::find()->where('sent > UNIX_TIMESTAMP() - 60 * 60 * 12')->count();
        $sent_in_last_24_hours = cListSentPost::find()->where('sent > UNIX_TIMESTAMP() - 60 * 60 * 24')->count();
        return json_encode([
            'last_1_hour_sent' => $sent_in_last_hour,
            'last_12_hours_sent' => $sent_in_last_12_hours,
            'last_24_hours_sent' => $sent_in_last_24_hours,
        ]);
    }

    public function actionCronSend()
    {
        ob_start();
        $lists = cList::findCronSending()->all();
        foreach($lists as $list)
        {
            foreach($list->listSent as $listSent)
            {
                //bingo
                //echo 'Target ' . $listSent->target_name;
                $user = cUser::find()->where(['tbl_user.id' => $list->user_id])->one();

                if(!$userTimezone = $user->getSetting('timezone'))
                {
                    $userTimezone = 'America/Los_Angeles';
                }

                //find posts that have a scheduled date up to 10 minutes before NOW that HAVEN'T been sent yet
                $posts = cListPost::find()
                    ->where(['list_id' => $list->id])
                    ->andWhere('scheduled_time IS NOT NULL')
                    ->andWhere('(scheduled_time + ' . Yii::$app->postradamus->get_timezone_offset($userTimezone) . ') BETWEEN (UNIX_TIMESTAMP() - 10 * 60) AND UNIX_TIMESTAMP()')
                    ->orderBy('scheduled_time ASC')->all();

                $nextpost = cListPost::find()
                    ->where(['list_id' => $list->id])
                    ->andWhere('scheduled_time IS NOT NULL')
                    ->andWhere('(scheduled_time + ' . Yii::$app->postradamus->get_timezone_offset($userTimezone) . ') >= (UNIX_TIMESTAMP() - 10 * 60)')
                    ->orderBy('scheduled_time ASC')->one();

                if(!isset($nextpost))
                {
                    $list->sent_at = time();
                    $list->save(false);
                }

                echo 'list ' . $list->id . ' (' . $listSent->id . ') ' . ': ' . $list->name . ' -> ';
                $sch_time = $nextpost->scheduled_time + Yii::$app->postradamus->get_timezone_offset($userTimezone);
                echo $nextpost->id . " Next post in: scheduled_time (".date("Y-m-d H:i:s", $sch_time).") - time (" . date("Y-m-d H:i:s", time()) . "): " . round(($sch_time - time()) / 60) . " minutes ->";
                echo "Posts to send out right now: " . count($posts) . "\n";
$i=0;

                foreach($posts as $post)
                {
                    $error_message = '';
                    if(\common\models\cListSentPost::isSent($listSent->id, $post->id) == true)
                    {
                        echo "Sent already";
                        continue;
                    }

                    if($listSent->target == $listSent::TARGET_FACEBOOK)
                    {
                        $page_id = cListSentMeta::find()->where([
                            'list_id' => $list->id,
                            'list_sent_id' => $listSent->id
                        ])->andWhere("`key` = 'page_id' OR `key` = 'group_id' OR `key` = 'my_feed_id'")->one();

                        $access_token = cListSentMeta::find()->where([
                            'list_id' => $list->id,
                            'list_sent_id' => $listSent->id,
                            'key' => 'access_token'
                        ])->one();

                        $params = [
                            'access_token' => $access_token->value,
                            'post_message' => $post->text,
                            'to_page' => $page_id->value
                        ];
                        //runs when the post type is link and there is a link
                        if(isset($post->link) && $post->link != '')
                        {
                            $params['post_link'] = $post->link;
                            $params['post_image_url'] = $post->image_url;
                        }
                        elseif(isset($post->image_filename0) && $post->image_filename0 != '')
                        {
                            $params['post_image_filename'] = $post->image_filename_with_path;
                        }

                        $fb = Yii::$app->postradamus->get_facebook_details($list->user_id);
                        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

                        // login helper with redirect_uri
                        $fh = new FacebookHelper;

                        $fh->_session = new FacebookSession($access_token->value);

                        $export = new FacebookApi($fh);

                        $responses = $export->post_to_api($params);
                        if(is_array($responses))
                        {
                            $response['post_id'] = (isset($responses['post']['id']) ? $responses['post']['id'] : 0);
                            $response['success'] = (isset($responses['errors']['id']) == 0 ? 1 : 0);
                            $response['error'] = (isset($responses['errors']) ? $responses['errors'] : '');
                        }
                        elseif(is_string($responses))
                        {
                            $response['post_id'] = 0;
                            $response['success'] = 0;
                            $response['error'] = $responses;
                        }
                    }

                    if($listSent->target == $listSent::TARGET_PINTEREST)
                    {
                        $export = new \backend\components\exporters\PinterestScrape;

                        $board_id = cListSentMeta::find()->where([
                            'user_id' => $list->user_id,
                            'list_id' => $list->id,
                            'list_sent_id' => $listSent->id,
                            'key' => 'board_id'
                        ])->one();

                        if(count($board_id) == 1)
                        {
                            $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'username'])->one();
                            $username = $listSentMeta->value;
                            $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'password'])->one();
                            $password = $listSentMeta->value;

                            //support old lists
                            if($username == '')
                            {
                                $username = $user->getPinterestConnection('username', $listSent->campaign_id);
                                $password = $user->getPinterestConnection('password', $listSent->campaign_id);
                            }

                            $p = new \backend\components\PinterestHelper($username, $password);
                            $p->debug = true;
                            $connection = $p->connect();
                            if($connection == '')
                            {
                                sleep(rand(1,3));
                                $response = $p->post($post->text, $post->image_url, $post->link, $board_id->value);
                            }
                            else
                            {
                                $response['post_id'] = '';
                                $response['success'] = 0;
                                $response['error'] = $connection;
                            }
                        }
                    }

                    if($listSent->target == $listSent::TARGET_WORDPRESS)
                    {
                        $export = new \backend\components\exporters\Wordpress;

                        $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'blog_username'])->one();
                        $username = $listSentMeta->value;
                        $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'blog_password'])->one();
                        $password = $listSentMeta->value;
                        $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'blog_xml_rpc_url'])->one();
                        $xml_rpc_url = $listSentMeta->value . 'xmlrpc.php';

                        //support old lists
                        if($username == '')
                        {
                            $username = $user->getWordpressConnection('username', $listSent->campaign_id);
                            $password = $user->getWordpressConnection('password', $listSent->campaign_id);
                            $xml_rpc_url = $user->getWordpressConnection('xml_rpc_url', $listSent->campaign_id) . 'xmlrpc.php';
                        }

                        $wp = new \backend\components\WordpressHelper($username, $password, $xml_rpc_url);
                        if($post->link != '')
                        {
                            $custom_fields = [['key' => 'pdms_link', 'value' => $post->link]];
                        }

                        $listSentMeta = cListSentMeta::find()->where(['list_id' => $post->list_id, 'list_sent_id' => $listSent->id, 'key' => 'blog_category_id'])->one();
                        $category_name = $listSentMeta->value;

                        $response = $wp->post($post->text, $post->image_url, $post->name, $category_name, $custom_fields);
                    }

                    set_time_limit(10);
                    $i++;

                    $export->postSent([
                        'list_sent_id' => $listSent->id,
                        'list_post_id' => $post->id,
                        'list_id' => $list->id,
                        'user_id' => $list->user_id,
                        'post_id' => (int)$response['post_id'],
                        'success' => $response['success'],
                        'error' => $response['error'],
                        'sent' => time()
                    ]);
                }
            }
        }
        $c = ob_get_clean();
        echo nl2br($c);
    }

    public function actionDeleteApi()
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/delete-api'));
        // login helper with redirect_uri
        $fh = new FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        } catch ( FacebookAuthorizationException $ex ) {
            // catch any exceptions
            $session = null;
            $e = $ex->getMessage();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
            // handle this better in production code
            $e = $ex->getMessage();
        } catch(Exception $ex) {
            $e = $ex->message();
        }

        // see if we have a session
        if ( isset( $session ) ) {

            // graph api request for user data
            if(!$fh->has_permissions(['manage_pages', 'publish_actions']))
            {
                if(isset($_GET['code']))
                {
                    Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                    //return $this->render('/content/facebook_error');
                }
                else
                {
                    $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/delete-api'), ['manage_pages', 'publish_actions']);
                }
            }

        } else { //not logged in, do so now!

            unset($_SESSION['fb_token']);
            $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/delete-api'), ['manage_pages', 'publish_actions']);
            //exit;
        }

        $model = new FacebookExportDeleteForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $importer = new \backend\components\importers\Facebook($fh);
            $deleted = $importer->delete($model->fb_page_id);
            Yii::$app->session->setFlash('success', 'Deleted ' . $deleted . ' posts from your Facebook Scheduler');
        }

        return $this->render('facebook_delete', [
            'model' => $model,
            'fh' => $fh
        ]);
    }

    public function actionFacebookApi()
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-api'));
		// login helper with redirect_uri
        $fh = new FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        } catch ( FacebookAuthorizationException $ex ) {
            // catch any exceptions
            $session = null;
            $e = $ex->getMessage();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
            // handle this better in production code
            $e = $ex->getMessage();
        } catch(Exception $ex) {
            $e = $ex->message();
        }
	
		$fbPermissions=['manage_pages', 'publish_actions', 'publish_pages', 'user_managed_groups'];
        // see if we have a session
        if ( isset( $session ) ) {
		    // graph api request for user data
            if(!$fh->has_permissions($fbPermissions))
            {
                if(isset($_GET['code']))
                {
                    if(!$fh->has_permissions(['manage_pages', 'publish_actions', 'publish_pages', 'user_managed_groups']))
                    {
                        Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                    }
                    //return $this->render('/content/facebook_error');
                }
                else
                {
                    $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-api'), $fbPermissions);
                }
            }

        } else { //not logged in, do so now!

            unset($_SESSION['fb_token']);
            $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-api'),$fbPermissions);
            //exit;
        }
        //at this point we should have full facebook authentication through $fh
        Yii::$app->postradamus->updateFBUserName($fh->get_user_profile()['name']);

        $model = new FacebookDirectExportForm();
        $model->scenario = 'publish';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			//server offset = -7;
            if(!$userTimezone = Yii::$app->user->identity->getSetting('timezone'))
            {
                $userTimezone = 'America/Los_Angeles';
            }
            // This will return 10800 (3 hours) ...
            $offset = Yii::$app->postradamus->get_timezone_offset($userTimezone);

            //get list posts
            $posts = cListPost::find()
                ->where(['list_id' => $model->list_id])
                ->andWhere('scheduled_time IS NOT NULL')
                ->andWhere('scheduled_time + '.$offset.' > (UNIX_TIMESTAMP() + 700)')
                ->orderBy('scheduled_time ASC')->all();

            $i=0;
            $export=new FacebookApi($fh);
            if($model->fb_target_type=='My Feed'){
                $exportAccessToken=$_SESSION['fb_token'];
                $metaIdKey='my_feed_id';
                $metaNameKey='my_feed_name';
            } elseif($model->fb_target_type=='Pages'){
				$exportAccessToken=$fh->get_page_access_token($model->fb_page_id);
				$metaIdKey='page_id';
				$metaNameKey='page_name';
			} else if($model->fb_target_type=='Groups'){
				$exportAccessToken=$_SESSION['fb_token'];
				$metaIdKey='group_id';
				$metaNameKey='group_name';
			}
			else{
				Yii::$app->session->setFlash('danger', 'It seems some required data is missing.');
				return $this->redirect(['facebook-api']);
			}
			
            foreach($posts as $post)
            {
                //      entered time as los angeles - subtract los angeles offset - subtract users offset
                $time = $post->scheduled_time + $offset;
                //die('with offset: ' . date("Y-m-d H:i:s", $time) . "\n<br />" . 'without offset: ' . date("Y-m-d H:i:s", $post->scheduled_time));

                $params = [
                    'access_token' => $exportAccessToken ,
                    'post_message' => $post->text,
                    'post_schedule_time' => $time,
                    'to_page' => $model->fb_page_id,
                ];
                //runs when the post type is link and there is a link
                if(isset($post->link) && $post->link != '')
                {
                    $params['post_link'] = $post->link;
                    $params['post_image_url'] = $post->image_url;
                }
                elseif(isset($post->image_filename0) && $post->image_filename0 != '')
                {
                    $params['post_image_filename'] = $post->image_filename_with_path;
                }
                if($model->internal_scheduler == 0) {
                    $res=$export->post_to_api($params);
                    $post->sent_at = time();
                    $post->save(false);
                }
                set_time_limit(10);
                $i++;
            }

            $list = cList::find()->where(['tbl_list.id' => $model->list_id])->one();

            if($model->internal_scheduler == 1) {
                //mark it as not sent
                $list->sent_at = 0;
                $list->save(false);

                Yii::$app->session->setFlash('success', "Done! Your posts will be sent to Facebook when they are ready.");
                //get list posts
                $list = new cListSent;
                $list->list_id = $model->list_id;
                $list->user_id = Yii::$app->user->id;
                $list->target = cListSent::TARGET_FACEBOOK;
                $list->save(false);
                //create meta fields
                $meta = new cListSentMeta;
                $meta->user_id = Yii::$app->user->id;
                $meta->list_id = $model->list_id;
                $meta->list_sent_id = $list->id;
                $meta->key = $metaIdKey;
                $meta->value = $model->fb_page_id;
                $meta->save(false);
                //create meta fields
                $meta = new cListSentMeta;
                $meta->user_id = Yii::$app->user->id;
                $meta->list_id = $model->list_id;
                $meta->list_sent_id = $list->id;
                $meta->key = $metaNameKey;
                $meta->value = $model->fb_page_name;
                $meta->save(false);
                //create meta fields
                $meta = new cListSentMeta;
                $meta->user_id = Yii::$app->user->id;
                $meta->list_id = $model->list_id;
                $meta->list_sent_id = $list->id;
                $meta->key = 'access_token';
                $meta->value = $exportAccessToken;
                $meta->save(false);
            }
            else
            {
                Yii::$app->session->setFlash('success', "Sent $i posts to Facebook's Scheduler.");
                //update list
                $list->sent_at = time();
            }
            $list->save(false);
        }

        $lists['Ready'] = \yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sending'] = \yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sent'] = \yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        return $this->render('facebook_api', [
            'model' => $model,
            'lists' => $lists,
            'fh' => $fh
        ]);
    }

    public function actionFacebookMacro()
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-macro'));
        // login helper with redirect_uri
        $fh = new FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        } catch ( FacebookAuthorizationException $ex ) {
            // catch any exceptions
            $session = null;
            $e = $ex->getMessage();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
            // handle this better in production code
            $e = $ex->getMessage();
        } catch(Exception $ex) {
            $e = $ex->message();
        }

        // see if we have a session
        if ( isset( $session ) ) {

            // graph api request for user data
            if(!$fh->has_permissions(['manage_pages', 'publish_actions']))
            {
                if(isset($_GET['code']))
                {
                    Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                    //return $this->render('/content/facebook_error');
                }
                else
                {
                    $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-macro'), ['manage_pages', 'publish_actions']);
                }
            }

        } elseif(!isset($e) || $e == '') { //not logged in, do so now!
            unset($_SESSION['fb_token']);
            $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/facebook-macro'), ['manage_pages', 'publish_actions']);
        }
        //at this point we should have full facebook authentication through $fh
        Yii::$app->postradamus->updateFBUserName($fh->get_user_profile()['name']);

        $macro_text = '';
        $model = new FacebookMacroExportForm();
        $model->scenario = 'publish';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //get list posts
            $posts = cListPost::find()
                ->where(['list_id' => $model->list_id])
                ->andWhere('scheduled_time IS NOT NULL')
                ->andWhere('scheduled_time  > (UNIX_TIMESTAMP() + 700)')
                ->orderBy('scheduled_time ASC')->all();

            $export = new FacebookMacroBasic();
            $export->list_id = $model->list_id;
            $export->page_id = $model->fb_page_id;
            foreach($posts as $post)
            {
                $export->add_post($post);
            }
            //add the images
            $macro_text = $export->merge_images();
            $macro_text .= $export->merge_posts();
        }

        $lists['Ready'] = yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sending'] = yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sent'] = yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        return $this->render('facebook_macro', [
            'model' => $model,
            'lists' => $lists,
            'macro_text' => $macro_text,
            'fh' => $fh
        ]);
    }

    public function actionCsv()
    {
        $model = new CsvExportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			//get list posts
            $posts = cListPost::find()
                ->where(['list_id' => $model->list_id])
                ->orderBy('scheduled_time ASC')->all();
			
			$exportImages = (array_key_exists('include_images',$_POST) && $_POST['include_images'] == 1 ) ? true : false ;
			if( $exportImages ){

				if(YII_ENV == 'dev')
                {
                    $exportCsvDir = 'export-files/csv/';
                }
                else
                {
                    $exportCsvDir = '/home/onezero/public_html/app/export-files/csv/';
                }

                $listDir      = $model->list_id .'/';
				$dateTimeDir  = date('d-M-y-H-i-s').'/';
				$workingDir   = $exportCsvDir.$listDir.$dateTimeDir;
               // print_r($workingDir);die;
				if(Zip::assureDir($workingDir)){
					//$imagesZipFileName = $workingDir.'Post-Images.zip';
					$filePaths = [] ;
					foreach($posts as $post){
						$filePath = $post->image_filename_with_path ; 
						if(file_exists($filePath) && is_file($filePath) ){
							array_push($filePaths, [ 'filePath' => $filePath , 'localName' => 'Images/'.basename($filePath) ] );
						}
					}
					/*
					$finalPckgsFilePaths = [] ; 
					if(!empty($filePaths) && Zip::makeZipFileFromPaths($filePaths,$imagesZipFileName) === TRUE ){
						array_push($finalPckgsFilePaths,$imagesZipFileName);
					}
					*/
					
					// create csv file here & push its path 
					$csvFileName = $workingDir.'Posts.csv';
					if($csvFile = fopen($csvFileName, "w")){
						$csvObj = new Csv();
						$rows = $csvObj->createCsv($posts,true,true);	
						if( is_array($rows) && !empty($rows) ){
							fputcsv($csvFile, array_keys($rows[0]));
							foreach ($rows as $row) {
								fputcsv($csvFile, $row);
							}
							if(fclose($csvFile) === TRUE){
								array_push($filePaths,$csvFileName);
							}	
						}
					}
					// created csv file here 
					$finalPackageFileName = $workingDir.'Posts-Data.zip';
					if(!empty($filePaths) && Zip::makeZipFileFromPaths($filePaths,$finalPackageFileName) === TRUE ){
						header('Content-type: application/zip');
						header('Content-Disposition: attachment; filename="Posts-Data.zip"');
						readfile($finalPackageFileName);
						exit;
					}					
				}
				else{
					Yii::$app->session->setFlash('danger', 'Error! System couldn\'t access export directory.');
				}
			}
            else{
				$csvObj = new Csv();
				$csvObj->createCsv($posts);	
			}
		}

        $lists['Not Ready'] = yii\helpers\ArrayHelper::map(cList::findNotReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Ready'] = yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sending'] = yii\helpers\ArrayHelper::map(cList::findSending()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists['Sent'] = yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        return $this->render('csv', [
            'model' => $model,
            'lists' => $lists,
        ]);
    }

    public function actionGetMacroCode($query)
    {
        parse_str(parse_url(urldecode($query), PHP_URL_QUERY));
        $posts = cListPost::find()
            ->where(['list_id' => $list_id])
            ->andWhere('scheduled_time IS NOT NULL')
            ->andWhere('scheduled_time > (UNIX_TIMESTAMP() + 700)')
            ->orderBy('scheduled_time ASC')->all();
        $export = new FacebookMacroEnhanced();
        $export->page_id = $page_id;
        $export->list_id = $list_id;
        foreach($posts as $post)
        {
            $export->add_post($post);
        }
        //add the images
        $macro_text = $export->merge_images();
        $macro_text .= $export->merge_posts();
        echo $macro_text;
    }

    public function actionChooseListMacro()
    {
        $url1 = Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/choose-list');
        $url1 = str_replace('/postradamus/postradamus/', '/postradamus/', $url1);
        $url2 = urldecode(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl(['export/download-images', 'list_id' => '{{!VAR1}}', 'page_id' => '{{!VAR2}}']));
        $url2 = str_replace('/postradamus/postradamus/', '/postradamus/', $url2);
        $macro = <<<EOF
SET !TIMEOUT_PAGE 5000
URL GOTO=$url1

'PAUSE IT SO WE CAN LET USER CHOOSE A LIST AND PAGE TO SEND THE MACRO TO
SET !SINGLESTEP YES
SET !SINGLESTEP NO

'In case this is in loop
SET !EXTRACT NULL
TAG POS=1 TYPE=INPUT:HIDDEN ATTR=NAME:list_id_hidden EXTRACT=TXT
SET !VAR1 {{!EXTRACT}}
SET !EXTRACT NULL
TAG POS=1 TYPE=INPUT:HIDDEN ATTR=NAME:page_id_hidden EXTRACT=TXT
SET !VAR2 {{!EXTRACT}}
SET !EXTRACT NULL

URL GOTO=$url2
WAIT SECONDS=3
EOF;
        return $macro;
    }

    public function actionChooseList()
    {
        $lists = cList::find()->having("COUNT(tbl_list_post.id) > 0")->orderBy('name')->all();

        $e = '';

        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/choose-list'));
        // login helper with redirect_uri
        $fh = new FacebookHelper;
        try {
            $session = $fh->create_session($helper);
        } catch ( FacebookAuthorizationException $ex ) {
            // catch any exceptions
            $session = null;
            $e = $ex->getMessage();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
            // handle this better in production code
            $e = $ex->getMessage();
        } catch(Exception $ex) {
            $e = $ex->message();
        }

        // see if we have a session
        if ( isset( $session ) ) {

            // graph api request for user data
            if(!$fh->has_permissions(['manage_pages']))
            {
                if(isset($_GET['code']))
                {
                    Yii::$app->session->setFlash('danger', 'You must accept the Facebook permissions.');
                    //return $this->render('/content/facebook_error');
                }
                else
                {
                    $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/choose-list'), ['manage_pages']);
                }
            }

        } elseif(!isset($e) || $e == '') { //not logged in, do so now!
            unset($_SESSION['fb_token']);
            $fh->login(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/choose-list'), ['manage_pages']);

        }

        $lists1['Ready'] = yii\helpers\ArrayHelper::map(cList::findReady()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');
        $lists1['Sent'] = yii\helpers\ArrayHelper::map(cList::findSent()->orderBy('name')->all(), 'id', 'name_with_count_and_dates');

        return $this->render('choose_list', ['lists' => $lists1, 'fh' => $fh]);
    }

    public function actionDownloadImages($list_id)
    {
        //get list posts
        //TODO dont show posts with no image filename
        $posts = cListPost::find()->where(['list_id' => $list_id])->all();

        return $this->renderPartial('download_images', [
            'posts' => $posts
        ]);
    }

}
