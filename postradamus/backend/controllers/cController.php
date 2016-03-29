<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii;

class cController extends Controller
{
    public $panel_heading_controls;
    public $before_panel;

    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'git-pull', 'cancel-accounts', 'signup', 'cron-send', 'test-api-call', 'download-images', 'choose-list-macro', 'scheduling-stats'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        //see if user has FB app setup
        if(Yii::$app->postradamus->get_facebook_details()['app_id'] == Yii::$app->params['facebook']['app_id'])
        {
            Yii::$app->session->setFlash('danger', '<h4>Attention</h4>Please see this post regarding posting problems. <a target="_blank" href="https://www.facebook.com/groups/postradamus/permalink/1687215704859734/">See here</a> for details.');
        }

        return true; // or false to not run the action
    }
}

?>