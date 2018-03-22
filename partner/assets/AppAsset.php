<?php

namespace partner\assets;

use yii\web\AssetBundle;

/**
 * Main partner application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [ 
        'css/chat.css',
        'css/calendar.css',
        'css/color-1.css',
        'css/style.css',
        'css/university.css', 
		'css/dashboard.css', 		
    ];
    public $js = [
        'js/socket.io.js',
        'js/chat.js?var=123.45',
        'js/applications.js',
    ];
	public $jsOptions = array(
    'position' => \yii\web\View::POS_HEAD
   );
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
