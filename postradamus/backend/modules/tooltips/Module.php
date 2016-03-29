<?php

namespace app\modules\tooltips;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\web\View;
use yii\web\ForbiddenHttpException;
use backend\modules\tooltips\models\TooltipDisplay;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'app\modules\tooltips\controllers';

    public function init(){
        parent::init();
		// custom initialization code goes here
    }
	
	public function bootstrap($app){	
		if(TooltipDisplay::isTooltipsOnForUser(Yii::$app->user->id)==true){
			$app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
				$app->getView()->on(View::EVENT_END_BODY, [$this, 'renderTooltipsBlock']);
			});	
		}
    }
	
	public function renderTooltipsBlock($event){
		$view = $event->sender;
		echo '<div id="tooltips-module">'.$view->renderPhpFile(__DIR__ .'/views/_tooltips.php') .'</div>';
	}
}
