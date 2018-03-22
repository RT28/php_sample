<?php
namespace frontend\components;

use backend\models\Seofields;

class Seo {

    /**
     * @inheritdoc
     */
    public static function get_metatags()
    {
        $source = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //print_r($source);
        $seofield = Seofields::find()->where(['gt_linkurl'=>[$source,'http://'.$source,'https://'.$source]])->asArray()->one();
        if($seofield){
            $metatags = '<title>'.$seofield['gt_title'].'</title>';
            $metatags .= '<meta name="keywords" content="'.$seofield['gt_keycontent'].'" >';
            $metatags .= '<meta name="description" content="'.$seofield['gt_desccontent'].'" >';
            //print_r($seofield);
            return $metatags;
        }
        return false;
    }
}

?>