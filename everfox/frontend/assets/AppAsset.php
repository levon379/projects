<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'js/tageditor/bootstrap-tagsinput.css',
        'css/custom.css',
    ];
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
    public $js = [
        'js/jquery-ui.min.js',
        'js/intercooler-0.9.2.min.js',
        'js/ajax-modal-popup.js',
        'js/bootstrap3-typeahead.min.js',
        'js/tageditor/bootstrap-tagsinput.min.js',
        'js/app/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'raoul2000\bootswatch\BootswatchAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
