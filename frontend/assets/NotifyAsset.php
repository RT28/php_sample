<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Full Calendar frontend application asset bundle.
 */
class NotifyAsset extends AssetBundle
{
    public $sourcePath = '@bower/remarkable-bootstrap-notify/dist';
    public $css = [];    
    public $js = [        
        'bootstrap-notify.min.js'        
    ];
}
