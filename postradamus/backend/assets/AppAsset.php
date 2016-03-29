<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        '//vjs.zencdn.net/4.12/video-js.css',
    ];
    public $js = [
        'js/garlic.js',
        'js/readmore.min.js',
        'themes/pixeladmin/assets/javascripts/pixel-admin.min.js',
        'js/lazy.min.js',
        'js/masonry.pkgd.min.js',
        'js/imagesloaded.pkgd.min.js',
        '//vjs.zencdn.net/4.12/video.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
