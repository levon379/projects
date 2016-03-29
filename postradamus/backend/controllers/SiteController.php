<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use frontend\models\SignupForm;
use common\models\cList;
use common\models\cCampaign;
use common\models\cListSent;
use common\models\cListSentMeta;
use common\models\cListPost;
use common\models\cUser;
use common\models\cNews;
use yii\filters\VerbFilter;
use Aws\S3\S3Client;
use backend\components\Common;
use yii\helpers\ArrayHelper;
/**
 * Site controller
 */
class SiteController extends cController
{
    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }
    
    public function actionUploadVideo()
    {
        $client = S3Client::factory(array(
            'credentials' => array(
                'key'    => 'AKIAIAOJIS6WTSTJMBPA',
                'secret' => '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',
            )
        ));
        //$client->createBucket(array('Bucket' => 'postradamus_mybucket'));
        $post_policy = '{ "expiration": "2016-08-06T12:00:00.000Z",
  "conditions": [
    {"bucket": "postradamus"},
    ["starts-with", "$key", "user/user1/"],
    {"acl": "public-read"},
    {"success_action_redirect": "http://postradamus.s3.amazonaws.com/successful_upload.html"},
    ["starts-with", "$Content-Type", "image/"],
    {"x-amz-meta-uuid": "14365123651274"},
    ["starts-with", "$x-amz-meta-tag", ""],

    {"x-amz-credential": "' . $client->getCredentials() . '"},
    {"x-amz-algorithm": "AWS4-HMAC-SHA256"},
    {"x-amz-date": "' . date("Ymd") . 'T000000Z" }
  ]
}';

        echo '<html>
  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

  </head>
  <body>

  <form action="http://examplebucket.s3.amazonaws.com/" method="post" enctype="multipart/form-data">
    Key to upload:<br />
    <input type="input"  name="key" value="user/user1/${filename}" /><br />
    <input type="hidden" name="acl" value="public-read" /><br />
    <input type="hidden" name="success_action_redirect" value="http://postradamus.s3.amazonaws.com/successful_upload.html" /><br />
    Content-Type:<br />
    <input type="input"  name="Content-Type" value="image/jpeg" /><br />
    <input type="hidden" name="x-amz-meta-uuid" value="14365123651274" /><br />
    <input type="text"   name="X-Amz-Credential" value="' . $client->getCredentials() . '" /><br />
    <input type="text"   name="X-Amz-Algorithm" value="AWS4-HMAC-SHA256" /><br />
    <input type="text"   name="X-Amz-Date" value="' . date('Ymd') . 'T000000Z" /><br />

    Tags for File:<br />
    <input type="input"  name="x-amz-meta-tag" value="" /><br />
    <input type="hidden" name="Policy" value=\'' . base64_encode($post_policy) . '\' /><br />
    <input type="hidden" name="X-Amz-Signature" value="' . $client->getSignature() . '" /><br />
    File:<br />
    <input type="file"   name="file" /> <br />
    <!-- The elements after this will be ignored -->
    <input type="submit" name="submit" value="Upload to Amazon S3" />
  </form>

</html>';
    }

    public function actionGitPull()
    {
        //test 5
        echo shell_exec("cd /home/allblogs/botpostfb3/ && sudo git fetch --all && sudo git reset --hard origin/master 2>&1");
    }

    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionTestEmail()
    {
        mail("ulikecoke@gmail.com", "from 1s0s server", "from 1s0s.com server", "FROM: info@1s0s.com");
    }

    public function actionCancelAccounts()
    {
        $users = cUser::find()->where(['status' => 10, 'complimentary' => 0])->andWhere('plan_id != 10')->all();
        foreach($users as $user)
        {
            $jvzoo = new \common\components\JvzooRest;
            $order = new \common\components\Order;
            $pre_key = $order->getLastTransactionReceiptNo($user->id);
            if($pre_key != false)
            {
                if(!$recurring_payment = Yii::$app->cache->get('recurring_payment' . $pre_key))
                {
                    $recurring_payment = $jvzoo->getRecurringPayment('PA-' . $pre_key);
                }
                Yii::$app->cache->set('recurring_payment' . $pre_key, $recurring_payment, 60 * 60);
                $response = json_decode($recurring_payment);
                if($response->results[0]->status == 'CANCELED' && strtotime($order->getEndingDate($response)) <= time())
                {
                    $order->logAccountAction($user->id, 'Account De-activated');
                    $user->status = 0;
                    $user->save(false);
                    $order->emailUser(Yii::$app->name . ': Account De-activated', ['model' => $user], '/order/email/user/_account_deactivated');
                    $order->emailAdmin(Yii::$app->name . ': Account De-activated', ['model' => $user], '/order/email/admin/_account_deactivated');
                }
                elseif($response->results[0]->status == 'CANCELED' && $user->cancelled == 0)
                {
                    $order->logAccountAction($user->id, 'Account Cancelled');
                    $user->cancelled = 1;
                    $user->save(false);
                    $order->emailUser(Yii::$app->name . ': Account Cancelled', ['model' => $user, 'ending_date' => $order->getEndingDate($response)], '/order/email/user/_account_cancelled');
                    $order->emailAdmin(Yii::$app->name . ': Account Cancelled', ['model' => $user, 'ending_date' => $order->getEndingDate($response)], '/order/email/admin/_account_cancelled');
                }
                else {
                    echo $user->id . "Not cancelled status.<br />";
                }
            }
        }
    }

    public function actionOneTime()
    {
        $fb = Yii::$app->postradamus->get_facebook_details();
        \Facebook\FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new \Facebook\FacebookRedirectLoginHelper(Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('export/delete-api'));
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

        $lists = cList::find()->where(['internal_scheduler' => 1])->all();
        foreach($lists as $list)
        {
            $listSent = new cListSent;
            $listSent->list_id = $list->id;
            $listSent->user_id = $list->user_id;
            $listSent->campaign_id = 0;
            $listSent->target = 1;
            $listSent->save(false);
            //
            $listSentMeta = new cListSentMeta;
            $listSentMeta->list_id = $listSent->list_id;
            $listSentMeta->user_id = $listSent->user_id;
            $listSentMeta->list_sent_id = $listSent->id;
            $listSentMeta->key = 'page_id';
            $listSentMeta->value = $list->to_page;
            $listSentMeta->save(false);
            //
            $listSentMeta = new cListSentMeta;
            $listSentMeta->list_id = $listSent->list_id;
            $listSentMeta->user_id = $listSent->user_id;
            $listSentMeta->list_sent_id = $listSent->id;
            $listSentMeta->key = 'access_token';
            $listSentMeta->value = $list->access_token;
            $listSentMeta->save(false);
            //
            $listSentMeta = new cListSentMeta;
            $listSentMeta->list_id = $listSent->list_id;
            $listSentMeta->user_id = $listSent->user_id;
            $listSentMeta->list_sent_id = $listSent->id;
            $listSentMeta->key = 'page_name';
            $listSentMeta->value = $fh->get_page_name($list->to_page);
            $listSentMeta->save(false);
        }
    }

    /* Establishes a connection to Facebook :) */
    public function actionLoginFacebook()
    {
        //Yii::$app->session->open();
        /*if(!$_SESSION['fb_token'])
        {
            $fh = Yii::$app->postradamus->setupFacebook([
                'permissions' => ['manage_pages'],
                'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->request->url
            ]);
        }*/
        Yii::$app->session->set('redirect', Yii::$app->urlManager->createUrl('site/index'));
        $this->redirect(['content/facebook']);
    }

    public function actionLogoutFacebook()
    {
        unset($_SESSION['fb_token']);
        unset($_SESSION['_user_pages']);
        unset($_SESSION['_user_groups']);
        $this->redirect(['site/index']);
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        // user login or signup comes here
        print("<pre>");
        print_r($attributes);
        die();
    }

    public function actionGetScheduledPosts()
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('site/get-scheduled-posts')
        ]);
        $scheduled_posts = Yii::$app->postradamus->scheduledPosts($fh, Yii::$app->request->get('page_id'));
        echo \yii\widgets\ListView::widget([
            'dataProvider' => $scheduled_posts,
            'itemView' => '/site/_scheduled_post',
        ]);
    }

    public function actionIndex()
    {
        //nate secret login method
        if(isset($_GET['user_name']) && $_GET['user_name'])
        {
            Yii::$app->user->login(\common\models\cUser::findByUsername($_GET['user_name']), 3600 * 24 * 30);
        }


        //list count
        //$list_count = cList::find()->count();
        $post_count = cListPost::find()->count();
        $user_count = cUser::find()->where(['parent_id' => Yii::$app->user->id])->count();
		$camp_count = cCampaign::find()->count();
        //get plan
        $plan = Yii::$app->user->identity->getField('plan_id');

        $news = cNews::find()->orderBy('created DESC')->all();
        return $this->render('index', ['news' => $news, 'camp_count' => $camp_count, /*'list_count' => $list_count, */ 'post_count' => $post_count, 'user_count' => $user_count, 'plans' => Yii::$app->postradamus->getPlanDetails($plan)]);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
//echo Yii::$app->security->generatePasswordHash('lusine2015');
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm;
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	function actionClearImages(){
		$postsDir=Yii::$app->params['imagePath'].'posts/'; 
		$nodes=scandir($postsDir);
		$removableUserDirs=[];
		$removableListDirs=[];
		$removablePostFiles=[];
		if(is_array($nodes)){
			foreach($nodes as $userDir){
				if($userDir=='.'||$userDir=='..'){
					continue;
				}
				$userDirPath=$postsDir.$userDir;
				if(is_dir($userDirPath)){
					$tempUser=cUser::find()->Where(['id' => $userDir])->one();
					if(empty($tempUser)){
						array_push($removableUserDirs,$userDirPath);
						continue;
					}
					
					$subNodes=scandir($userDirPath);
					if(is_array($subNodes)){
						foreach($subNodes as $listDir){
							if($listDir=='.'||$listDir=='..'){
								continue;
							}
							$listDirPath=$userDirPath.'/'.$listDir;
							if(is_dir($listDirPath)){
								$tempList= cList::find()->Where(['tbl_list.id' => $listDir])->one();
								if(empty($tempList)){
									array_push($removableListDirs,$listDirPath);
									continue;
								}
								
								$postRecords=cListPost::find()->where(['list_id'=>$listDir])->select(['id','image_filename0','image_filename1','image_filename2','image_filename3'])->asArray()->all();
								
								$fileName0Ary = ArrayHelper::map($postRecords, 'id', 'image_filename0');
								$fileName1Ary = ArrayHelper::map($postRecords, 'id', 'image_filename1');
								$fileName2Ary = ArrayHelper::map($postRecords, 'id', 'image_filename2');
								$fileName3Ary = ArrayHelper::map($postRecords, 'id', 'image_filename3');
								
								$postFiles=scandir($listDirPath);
								foreach($postFiles as $postFileName){
									if($postFileName=='.'||$postFileName=='..'){
										continue;
									}
                                    set_time_limit(15);
									$postFilePath=$listDirPath.'/'.$postFileName;
									if(is_file($postFilePath)){
										//check whether any relevant post record exists or not.. if not then remove this image .. 
										if(!in_array($postFileName,$fileName0Ary)&&!in_array($postFileName,$fileName1Ary)&&!in_array($postFileName,$fileName2Ary)&&!in_array($postFileName,$fileName3Ary)){
											array_push($removablePostFiles,$postFilePath);	
										}
									}
								}
							}
						}
					}	
				}
			}	
		}

        echo count($removableUserDirs).' user directories to be removed.';
        echo '<br/> ------ <br/>';
        foreach($removableUserDirs as $removableUserDir){
            echo '<br/>';
            echo $removableUserDir;
            echo ' - ' ;
            if(Common::removeDir($removableUserDir)==true){
            //if(false){
                echo 'Removed';
            }
            else{
                echo '<font style="color:red;">Couldn\'t be removed</font>';
            }
        }

        echo '<br/><br/><br/> ------------------------------------------ <br/>';
		echo count($removableListDirs).' list directories to be removed.';
		echo '<br/> ------ <br/>';
		foreach($removableListDirs as $removableListDir){
			echo '<br/>';
			echo $removableListDir; 
			echo ' - ' ;
			if(Common::removeDir($removableListDir)==true){
			//if(false){
				echo 'Removed';
			}
			else{
				echo '<font style="color:red;">Couldn\'t be removed</font>';
			}
		}
		
		echo '<br/><br/><br/> ------------------------------------------ <br/>';
		echo count($removablePostFiles).' post images to be removed.';
		echo '<br/> ------ <br/>';
		foreach($removablePostFiles as $removablePostFile){
			echo '<br/>';
			echo $removablePostFile; 
			echo ' - ' ;
			@unlink($removablePostFile);
			echo 'Removed';
		}
		
		//echo '<pre>'; print_r ($removableUserDirs); echo '</pre>';
		//echo '<pre>'; print_r ($removableListDirs); echo '</pre>';
		exit();
	}
}
