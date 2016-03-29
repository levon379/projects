<?php
namespace frontend\assets;

use yii\web\AssetBundle as AssetBundle;

class CalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://arshaw.com/js/fullcalendar-2.0.2/fullcalendar.css',
        'http://arshaw.com/js/fullcalendar-2.0.2/fullcalendar.print.css',
    ];
    public $js = [
        'http://arshaw.com/js/fullcalendar-2.0.2/lib/moment.min.js',
        'http://arshaw.com/js/fullcalendar-2.0.2/lib/jquery-ui.custom.min.js',
        'http://arshaw.com/js/fullcalendar-2.0.2/fullcalendar.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}