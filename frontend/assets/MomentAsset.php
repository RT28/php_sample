<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Full Calendar frontend application asset bundle.
 */
class MomentAsset extends AssetBundle
{
    public $sourcePath = '@bower/moment/min';    
    public $css = [];
    public $js = [        
        'moment.min.js'        
    ];    
}
