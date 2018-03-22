<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/button.css',
        'css/datepicker.css',
        'css/form.css',
        'css/login.css',
        'css/university.css',
        'css/chat.css',  
        'css/calendar.css',  
    ];
    public $js = [
        'js/applications.js',
        'js/socket.io.js',           
        'js/departments.js',
        'js/courses.js',
        'js/common.js',
        'js/bootstrap-datepicker.js',
        'js/chat.js',
        'js/calendar.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
