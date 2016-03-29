<?php

namespace backend\controllers;

use Yii;
use backend\components\importers\Webpage;
use backend\components\importers\Pinterest;
use backend\components\importers\Amazon;
use backend\components\importers\Imgur;
use backend\components\importers\Youtube;
use backend\components\importers\Instagram;
use backend\components\importers\Feed;
use backend\components\importers\Twitter;
use backend\components\importers\TwitterSearch;
use backend\components\importers\TwitterList;
use backend\components\importers\TwitterTimeline;
use backend\components\importers\Tumblr;
use backend\components\importers\Reddit;
use backend\components\importers\Csv;
use backend\components\FacebookHelper;
use common\models\cList;
use common\models\cListPost;
use common\models\cListPostSearch;
use backend\models\PinterestSearchForm;
use backend\models\AmazonSearchForm;
use backend\models\WebpageSearchForm;
use backend\models\YoutubeSearchForm;
use backend\models\ImgurSearchForm;
use backend\models\FacebookSearchForm;
use backend\models\FeedSearchForm;
use backend\models\InstagramSearchForm;
use backend\models\TwitterSearchForm;
use backend\models\TwitterListForm;
use backend\models\TwitterTimelineForm;
use backend\models\TumblrSearchForm;
use backend\models\RedditSearchForm;
use backend\models\CsvImportForm;
use yii\data\ArrayDataProvider;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use backend\components\Common;
use common\models\cSavedSearch;

class ContentController extends cController
{
    public $enableCsrfValidation = false;

    public function actionSaveSearch()
    {
        //see if it exists first
        $savedSearch = cSavedSearch::find()->andWhere(['origin_type' => cListPost::getOriginIdFromName(Yii::$app->request->post('source')), 'search_value' => Yii::$app->request->post('search_value')])->count();
        if($savedSearch == 0)
        {
            $savedSearch = new cSavedSearch;
            $savedSearch->user_id = Yii::$app->user->id;
            $savedSearch->campaign_id = (int)Yii::$app->session->get('campaign_id');
            $savedSearch->origin_type = cListPost::getOriginIdFromName(Yii::$app->request->post('source'));
            $savedSearch->fb_type = Yii::$app->request->post('fb_type');
            $savedSearch->search_value = Yii::$app->request->post('search_value');
            $savedSearch->name = Yii::$app->request->post('name');
            $savedSearch->save(false);
            echo "saved";
        }
        else
        {
            echo "origin_type => " . cListPost::getOriginIdFromName(Yii::$app->request->post('source')) . "<br />";
            echo "search_value => " . Yii::$app->request->post('search_value');
        }
        echo "hmm";
    }

    public function actionForgetSearch()
    {
        $search = cSavedSearch::find()->andWhere(['origin_type' => cListPost::getOriginIdFromName(Yii::$app->request->post('source')), 'search_value' => Yii::$app->request->post('search_value')])->one();
        $search->delete();
    }

    public function actionUpload()
    {
        if(Yii::$app->request->get('done') == 1)
        {
            Yii::$app->session->setFlash('success', 'Images uploaded successfully to your <a href="'.Yii::$app->urlManager->createUrl(['list/view', 'id' => Yii::$app->session->get('last_used_list_id')]).'">list</a>.');
            Yii::$app->session->remove('content_list_id');
        }

        return $this->render('upload');
    }

    public function actionWeb()
    {
        return $this->render('web');
    }

    public function actionFacebookSearchPages($term)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook-search-pages')
        ]);
        $fb = new \backend\components\importers\Facebook($fh);
        $pages = $fb->get_pages(strtolower($term));
        $pages['data'] = Common::sort_array_of_objects_by_key($pages['data'], 'talking_about_count', 'desc');
        echo json_encode($pages);
    }

    public function actionFacebookSearchGroups($term)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('list/facebook-search-groups')
        ]);
        $fb = new \backend\components\importers\Facebook($fh);
        echo json_encode($fb->get_groups(strtolower($term)));
    }

    public function actionFacebookLookupPage($id)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('list/facebook-lookup-page')
        ]);
        $fb = new \backend\components\importers\Facebook($fh);
        echo json_encode($fb->get_page_or_group($id));
    }

    public function actionFacebookLookupGroup($id)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('list/facebook-lookup-group')
        ]);
        $fb = new \backend\components\importers\Facebook($fh);
        echo json_encode($fb->get_page_or_group($id));
    }

    public function actionFeedSearch($query)
    {
        $feed = new \backend\components\importers\Feed;
        echo $feed->get_feeds($query);
    }

    public function actionSubRedditSearch($query)
    {
        $feed = new \backend\components\importers\Reddit;
        echo $feed->get_sub_reddits($query);
    }

    public function actionList()
    {
        $fh = '';
        $searchModel = new cListPostSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('web', [
            'source' => 'list',
            'fh' => $fh,
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionYoutube()
    {
        $fh = '';
        $model = new YoutubeSearchForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Youtube();
            $models = $search->search(['search_keywords' => $model->keywords, 'search_type' => $model->type, 'search_duration' => $model->duration, 'search_definition' => $model->definition, 'search_order' => $model->order, 'search_category' => $model->category, 'search_safe_search' => $model->safe_search, 'hide_used_content' => $model->hide_used_content]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'likes' => [
                        'default' => SORT_DESC,
                    ],
                    'views' => [
                        'default' => SORT_DESC,
                    ],
                    'comments' => [
                        'default' => SORT_DESC,
                    ]
                ],
                'defaultOrder' => [
                    'likes' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'youtube', 'fh' => $fh, 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionWebpage()
    {
        $fh = '';
        $model = new WebpageSearchForm;
        $webpage_models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Webpage();
            $webpage_models = $search->search(['webpage_url' => $model->webpage_url, 'hide_used_content' => $model->hide_used_content]);
        }

        $webpageDataProvider = new ArrayDataProvider([
            'sort' => [
                'class' => 'common\components\cSort'
            ],
            'allModels' => $webpage_models,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'webpage', 'fh' => $fh, 'model' => $model, 'dataProvider' => $webpageDataProvider]);
    }

    public function actionInstagram()
    {
        $fh = '';
        $model = new InstagramSearchForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Instagram();
            $models = $search->search(['search_keywords' => $model->keywords, 'search_type' => $model->type, 'search_method' => Yii::$app->request->get('instagram_search_pill')]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'created' => [
                        'default' => SORT_DESC,
                    ],
                    'likes' => [
                        'default' => SORT_DESC,
                    ],
                    'shares' => [
                        'default' => SORT_DESC,
                    ],
                    'comments' => [
                        'default' => SORT_DESC,
                    ]
                ],
                'defaultOrder' => [
                    'likes' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render('web', ['source' => 'instagram', 'fh' => $fh, 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionImgur()
    {
        $fh = '';
        $model = new ImgurSearchForm;
        $imgur_models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Imgur();
            $imgur_models = $search->search(['search_keywords' => $model->keywords]);
        }

        $imgurDataProvider = new ArrayDataProvider([
            'sort' => [
                'class' => 'common\components\cSort'
            ],
            'allModels' => $imgur_models,
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'imgur', 'fh' => $fh, 'model' => $model, 'dataProvider' => $imgurDataProvider]);
    }

    public function actionAmazon()
    {
        $fh = '';
        $model = new AmazonSearchForm;
        $amazon_models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Amazon([
                'aws_api_access_key' => Yii::$app->user->identity->getAmazonConnection('aws_api_access_key', $model->country),
                'aws_api_secret_key' => Yii::$app->user->identity->getAmazonConnection('aws_api_secret_key', $model->country),
                'aws_associate_tag' => Yii::$app->user->identity->getAmazonConnection('aws_associate_tag', $model->country)
            ]);
            $amazon_models = $search->search(['cache' => $model->cache, 'search_keywords' => $model->keywords, 'search_max_price' => $model->max_price, 'search_min_price' => $model->min_price, 'search_category' => $model->category, 'search_country' => $model->country, 'hide_used_content' => $model->hide_used_content]);
        }

        $amazonDataProvider = new ArrayDataProvider([
            'allModels' => $amazon_models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'title' => [
                        'default' => SORT_ASC,
                    ],
                    'sales_rank' => [
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'sales_rank' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'amazon', 'fh' => $fh, 'model' => $model, 'dataProvider' => $amazonDataProvider]);
    }

    public function actionFbGetLargeImage($page_id, $object_id)
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl(['content/fb-get-large-image','page_id' => $page_id, 'object_id' => $object_id])
        ]);
        $fb = new \backend\components\importers\Facebook($fh);
        return json_encode(['img_src' => $fb->get_post_image_src($page_id, $object_id)]);
    }

    public function actionFacebook()
    {

        Yii::$app->session->open();
        $params = [];
        if(isset($_REQUEST['error_reason']) && $_REQUEST['error_reason'] == 'user_denied')
        {
            die("You must accept the Facebook permissions. Try again.");
        }
        $e = '';

        $fb = Yii::$app->postradamus->get_facebook_details();
        FacebookSession::setDefaultApplication($fb['app_id'], $fb['app_secret']);

        $helper = new FacebookRedirectLoginHelper( Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('content/facebook') );
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


        //at this point we should have full facebook authentication through $fh
        $profile_name = Yii::$app->cache->get(md5('profile_name'));
        if($profile_name === false)
        {
            $profile_name = $fh->get_user_profile()['name'];
            Yii::$app->cache->set(md5('profile_name'), $profile_name, 30 * 60);
        }
        Yii::$app->postradamus->updateFBUserName($profile_name);

        if($red = Yii::$app->session->get('redirect'))
        {
            Yii::$app->session->remove('redirect');
            $this->redirect($red);
        }

        $model = new FacebookSearchForm;
        $facebook_models = [];
        $from_post_id = false;
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new \backend\components\importers\Facebook($fh);
            $params['search_posted_by'] = $model->posted_by;
            $params['search_post_type'] = $model->post_type;
            $params['large_results'] = $model->large_results;
            $params['hide_used_content'] = $model->hide_used_content;
            $params['cache'] = $model->cache;
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_my_pages') {
                $params['search_from_page_id'] = $model->from_page1;
                $params['search_from_name'] = $fh->get_page_name($model->from_page1);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_other_pages') {
                $params['search_from_page_id'] = $model->from_page2;
                $params['search_from_name'] = $fh->get_page_name($model->from_page2);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_saved_pages') {
                $params['search_from_page_id'] = $model->from_page3;
                $params['search_from_name'] = $fh->get_page_name($model->from_page3);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_my_groups') {
                $params['search_from_group_id'] = $model->from_group1;
                $params['search_from_name'] = $fh->get_page_name($model->from_group1);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_other_groups') {
                $params['search_from_group_id'] = $model->from_group2;
                $params['search_from_name'] = $fh->get_page_name($model->from_group2);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_saved_groups') {
                $params['search_from_group_id'] = $model->from_group3;
                $params['search_from_name'] = $fh->get_page_name($model->from_group3);
            }
            if(Yii::$app->request->get('facebook_search_pill') == '#pill_comments') {
                $from_post_id = true;
                $params['search_from_post_id'] = $model->from_post_id;
                $params['search_min_like_count'] = 0;
                $facebook_models = $search->searchComments($params);
            }
            if(!$facebook_models)
            $facebook_models = $search->search($params);
        }

        $facebookDataProvider = new ArrayDataProvider([
            'allModels' => $facebook_models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'created' => [
                        'default' => SORT_DESC,
                    ],
                    'engagement' => [
                        'default' => SORT_DESC,
                    ],
                    'likes' => [
                        'default' => SORT_DESC,
                    ],
                    'shares' => [
                        'default' => SORT_DESC,
                    ],
                    'comments' => [
                        'default' => SORT_DESC,
                    ]
                ],
                'defaultOrder' => [
                    'likes' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);
        if($e)
        {
            Yii::$app->session->setFlash('danger', 'Facebook says: ' . $e);
            //return $this->render('facebook_error');
        }

        //facebook
        if($params['search_from_page_id'])
        {
            $search_value = $params['search_from_page_id'];
            $fb_type = 'page';
        } else {
            $search_value = $params['search_from_group_id'];
            $fb_type = 'group';
        }
        $name = $params["search_from_name"];

        return $this->render('web', ['source' => 'facebook','from_post_id'=>$from_post_id, 'fh' => $fh, 'model' => $model, 'dataProvider' => $facebookDataProvider, 'fb_type' => $fb_type, 'save_name' => $name, 'save_search_value' => $search_value]);
    }

    public function actionFeed()
    {
        $fh = '';
        $model = new FeedSearchForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Feed();

            if($model->feed_search_pill == '#pill_feed1')
            {
                $feed_url = $model->feed1;
            } elseif($model->feed_search_pill == '#pill_feed3') {
                $feed_urls = $model->feed3;
            } else {
                $feed_url = $model->feed2;
            }
            if(isset($feed_urls))
            {
                foreach($feed_urls as $feed_url)
                {
                    $mymodels[] = $search->search(['search_url' => $feed_url, 'hide_used_content' => $model->hide_used_content]);
                }
                $models = call_user_func_array('array_merge', $mymodels);
            }
            else
            {
                $models = $search->search(['search_url' => $feed_url, 'hide_used_content' => $model->hide_used_content]);
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'created' => [
                        'label' => 'Date Created',
                        'default' => SORT_DESC,
                    ],
                    'comment_count' => [
                        'label' => 'Comments',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'created' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'feed', 'fh' => $fh, 'model' => $model, 'dataProvider' => $dataProvider, 'save_name' => (isset($search) ? $search->getFeedTitle() . ' (' . $feed_url . ')' : ''), 'save_search_value' => $feed_url]);
    }

    public function actionReddit()
    {
        $fh = '';
        $model = new RedditSearchForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Reddit();
            $models = $search->search(['search_keywords' => $model->keywords, 'search_type' => $model->type, 'search_subreddit' => $model->subreddit, 'search_large_images' => $model->large_images, 'hide_used_content' => $model->hide_used_content]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'created' => [
                        'label' => 'Created',
                        'default' => SORT_DESC,
                    ],
                    'up_count' => [
                        'label' => 'Ups',
                        'default' => SORT_DESC,
                    ],
                    'comment_count' => [
                        'label' => 'Comments',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'like_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'reddit', 'fh' => $fh, 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionTumblr()
    {
        $fh = '';
        $model = new TumblrSearchForm;
        $models = [];
        $i=0;
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Tumblr();
            $models1 = $search->search(['search_keywords' => $model->keywords, 'search_before' => time(), 'hide_used_content' => $model->hide_used_content]);
            usleep(500);
            $models2 = $search->search(['search_keywords' => $model->keywords, 'search_before' => time() - 86400 * 2, 'hide_used_content' => $model->hide_used_content]);
            usleep(500);
            $models3 = $search->search(['search_keywords' => $model->keywords, 'search_before' => time() - 86400 * 4, 'hide_used_content' => $model->hide_used_content]);
            usleep(500);
            $models4 = $search->search(['search_keywords' => $model->keywords, 'search_before' => time() - 86400 * 6, 'hide_used_content' => $model->hide_used_content]);
            $models = array_merge($models1, $models2, $models3, $models4);
            $used_ids = [];
            foreach($models as $key => $mymodel)
            {
                if(in_array($mymodel['id'], $used_ids))
                {
                    unset($models[$key]);
                    //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;unset " . $mymodel->id . "<br />";
                }
                $i++;
                $used_ids[] = $mymodel['id'];
            }
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'created' => [
                        'label' => 'Created',
                        'default' => SORT_DESC,
                    ],
                    'note_count' => [
                        'label' => 'Notes',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'note_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'tumblr', 'fh' => $fh, 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionPinterest()
    {
        $fh = '';
        $model = new PinterestSearchForm;
        $pinterest_models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new Pinterest();
            $pinterest_models = $search->search(['search_keywords' => $model->keywords, 'search_results' => $model->results, 'hide_used_content' => $model->hide_used_content]);
        }

        $pinterestDataProvider = new ArrayDataProvider([
            'allModels' => $pinterest_models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'repin_count' => [
                        'label' => 'Repins',
                        'default' => SORT_DESC,
                    ],
                    'like_count' => [
                        'label' => 'Likes',
                        'default' => SORT_DESC,
                    ],
                    'comment_count' => [
                        'label' => 'Comments',
                        'default' => SORT_DESC,
                    ]
                ],
                'defaultOrder' => [
                    'like_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        return $this->render('web', ['source' => 'pinterest', 'tags' => $search->tags, 'fh' => $fh, 'model' => $model, 'dataProvider' => $pinterestDataProvider]);
    }

    public function actionTwitterSuccess()
    {
        if (!Yii::$app->session->get('access_token') || Yii::$app->session->get('access_token')['oauth_token'] == '' || Yii::$app->session->get('access_token')['oauth_token_secret'] == '') {
            /* Save HTTP status for error dialog on connnect page.*/
            session_start();
            session_destroy();

            /* Redirect to page with the connect to Twitter option. */
            $this->redirect(['content/twitter']);
        }
        /* Get user access tokens out of the session. */
        $access_token = Yii::$app->session->get('access_token');

        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth('vvNAA8Rd0yF4kJqoATFEOyYLo', '2gjX1PMx4K21ZOdritIJd4M8DvKVmfBpTN64CSQ7Qn70w7pavA', $access_token['oauth_token'], $access_token['oauth_token_secret']);

        /* If method is set change API call made. Test is called by default. */
        $content = $connection->get('account/verify_credentials');
        echo $this->render('twitter/connected', ['content' => $content]);
    }

    public function actionTwitterRedirect()
    {
        /* Build TwitterOAuth object with client credentials. */
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth('vvNAA8Rd0yF4kJqoATFEOyYLo', '2gjX1PMx4K21ZOdritIJd4M8DvKVmfBpTN64CSQ7Qn70w7pavA');

        /* Get temporary credentials. */
        $request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => Yii::$app->urlManager->createAbsoluteUrl('content/twitter-callback')));

        /* Save temporary credentials to session. */
        $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

        /* If last connection failed don't display authorization link. */
        switch ($connection->getLastHttpCode()) {
            case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url = $connection->url('oauth/authorize', array('oauth_token' => $token));
                $this->redirect($url);
                break;
            default:
                /* Show notification if something went wrong. */
                echo $connection->getLastHttpCode() . ' - Could not connect to Twitter. Refresh the page or try again later.';
        }
    }

    public function actionTwitterCallback()
    {
        /* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
            /* CLEAR SESSIONS */
            $_SESSION['oauth_status'] = 'oldtoken';
            /* Save HTTP status for error dialog on connect page.*/
            session_start();
            session_destroy();

            $this->redirect(['content/twitter-redirect']);
        }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth('vvNAA8Rd0yF4kJqoATFEOyYLo', '2gjX1PMx4K21ZOdritIJd4M8DvKVmfBpTN64CSQ7Qn70w7pavA', $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        /* Request access tokens from twitter */
        $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => Yii::$app->request->get('oauth_verifier')));

        /* Save the access tokens. Normally these would be saved in a database for future use. */
        Yii::$app->session->set('access_token', $access_token);

        /* Remove no longer needed request tokens */
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->getLastHttpCode()) {
            /* The user has been verified and the access tokens can be saved for future use */
            $_SESSION['status'] = 'verified';

            Yii::$app->session->setFlash('success', 'Now connected to Twitter!');

            $this->redirect(['content/twitter']);
        } else {
            /* CLEAR SESSIONS */
            /* Save HTTP status for error dialog on connnect page.*/
            session_start();
            session_destroy();

            Yii::$app->session->setFlash('danger', 'Did you cancel the Twitter authorization? You must <a href="' . Yii::$app->urlManager->createUrl(['content/twitter-redirect']) . '">connect to twitter</a> to use this feature.');

            /* Redirect to page with the connect to Twitter option. */
            $this->redirect(['content/twitter']);
        }
    }

    public function actionTwitterTimeline()
    {
        $this->beforeTwitter();
        $model = new TwitterTimelineForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new TwitterTimeline();
            $models = $search->search(['hide_used_content' => $model->hide_used_content]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'retweet_count' => [
                        'label' => 'Retweets',
                        'default' => SORT_DESC,
                    ],
                    'favorite_count' => [
                        'label' => 'Favorites',
                        'default' => SORT_DESC,
                    ],
                    'created' => [
                        'label' => 'Created',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'retweet_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        return $this->render('web', ['source' => 'twitter', 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionTwitterSearch()
    {
        $this->beforeTwitter();
        $model = new TwitterSearchForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new TwitterSearch();
            $models = $search->search(['search_keywords' => $model->keywords, 'include_retweets' => $model->include_retweets, 'result_type' => $model->result_type, 'hide_used_content' => $model->hide_used_content]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'retweet_count' => [
                        'label' => 'Retweets',
                        'default' => SORT_DESC,
                    ],
                    'favorite_count' => [
                        'label' => 'Favorites',
                        'default' => SORT_DESC,
                    ],
                    'created' => [
                        'label' => 'Created',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'retweet_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        return $this->render('web', ['source' => 'twitter', 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionTwitterList()
    {
        $this->beforeTwitter();
        $model = new TwitterListForm;
        $models = [];
        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $search = new TwitterList();
            $models = $search->search(['list_id' => $model->list_id, 'include_retweets' => $model->include_retweets, 'hide_used_content' => $model->hide_used_content]);
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'sort' => [
                'class' => 'common\components\cSort',
                'attributes' => [
                    'retweet_count' => [
                        'label' => 'Retweets',
                        'default' => SORT_DESC,
                    ],
                    'favorite_count' => [
                        'label' => 'Favorites',
                        'default' => SORT_DESC,
                    ],
                    'created' => [
                        'label' => 'Created',
                        'default' => SORT_DESC,
                    ],
                ],
                'defaultOrder' => [
                    'retweet_count' => SORT_DESC
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);

        return $this->render('web', ['source' => 'twitter', 'model' => $model, 'dataProvider' => $dataProvider]);
    }

    public function actionTwitter()
    {
        $this->redirect(['content/twitter-search']);

        /*
        $this->beforeTwitter();

        return $this->render('web', ['source' => 'twitter', 'model' => [], 'dataProvider' => []]);
        */
    }

    public function beforeTwitter()
    {
        $access_token = Yii::$app->session->get('access_token');

        if(!$access_token['screen_name'])
        {

            /* Create a TwitterOauth object with consumer/user tokens. */
            $connection = new \Abraham\TwitterOAuth\TwitterOAuth(Twitter::OAUTH_ACCESS_TOKEN, Twitter::OAUTH_ACCESS_TOKEN_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* If method is set change API call made. Test is called by default. */
            $request = $connection->get('account/verify_credentials');

            if(isset($request->errors[0]->code))
            {
                //220 - Your credentials do not allow access to this resource
                //89 - The access token used in the request is incorrect or has expired. Used in API v1.1
                if($request->errors[0]->code == 220 || $request->errors[0]->code == 89 || $request->errors[0]->code == 32)
                {
                    //Yii::$app->session->setFlash('warning', 'This feature requires a connection with Twitter. <a href="' . Yii::$app->urlManager->createUrl('content/twitter-redirect') . '">Connect Now</a>.');
                }
                else
                {
                    Yii::$app->session->setFlash('danger', 'Twitter says: ' . $request->errors[0]->message . '. <a href="' . Yii::$app->urlManager->createUrl('content/twitter-redirect') . '">Try again</a>.');
                }
            }

        }

    }

    public function actionCsv() {
        if (Yii::$app->request->isAjax && count($_FILES) > 0 && isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $dataProvider = Csv::ParseCsv($file['tmp_name']);
            unlink($file['tmp_name']);
            return $this->renderPartial('_search_results_form', [
                      'dataProvider' => $dataProvider,
                      'source' => 'csv',
					  'defaultSourceName'=>"Source: " . cListPost::getOriginNameFromId(cListPost::ORIGIN_CSV)
                  ]);
        }
        
        $model = new CsvImportForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // DO NOTHING
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
}
