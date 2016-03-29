<?php

namespace app\modules\tooltips\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\tooltips\models\TooltipDisplay;

class DefaultController extends Controller
{	
	/*
    public function actionIndex(){
        return $this->render('index');
    }
	*/
	
	public function actionDisableTooltip(){
		$response=[];
		$response['success']=0;
		$user_id=Yii::$app->user->id;
		$keyword=$_POST['keyword'];
		if(TooltipDisplay::disableTooltipForUser($user_id,$keyword)==true){
			$response['success']=1;	
		}
		exit(json_encode($response));
	}
	
	public function actionOnOffTooltips(){
		$response=[];
		$response['success']=0;
		$user_id=Yii::$app->user->id;
		$status=$_POST['status'];
		if(TooltipDisplay::onOffTooltipsForUser($user_id,$status)==true){
			$response['success']=1;	
		}
		exit(json_encode($response));
	}
}
