<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Full Calendar frontend application asset bundle.
 */
class FullCalendarAsset extends AssetBundle
{
    public $sourcePath = '@bower/fullcalendar/dist';    
    public $css = [
        'fullcalendar.min.css'
    ];
    public $js = [        
        'fullcalendar.min.js'        
    ];
    public $depends = [
        'frontend\assets\MomentAsset',
    ];
}
