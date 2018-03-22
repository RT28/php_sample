<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css?ver=1.2345',
        'css/chat.css',
        'css/calendar.css?1.234',
        'css/color-1.css',
        'css/style.css?ver=1.234'
    ];
    public $js = [
        'js/socket.io.js',
        'js/chat.js?var=123.45',
        'js/applications.js',
        'js/calendar.js?ver=1.234',
        'js/jquery-ias.min.js',
    ];
	public $jsOptions = array(
    'position' => \yii\web\View::POS_HEAD
   );
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
