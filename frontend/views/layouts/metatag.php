<?php

use yii\helpers\Html;
use common\models\City;
use frontend\components\Seo;

    $controller = Yii::$app->controller;
    $default_controller = Yii::$app->defaultRoute;
    $request = Yii::$app->request->getQueryParams();
    
?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta property="og:title" content="<?= Html::encode($this->title) ?>" />
    <meta property="og:type" content="Education.admission" />
    <meta property="og:url" content="https://www.gotouniversity.com/" />
    <meta property="og:image" content="" />
    <meta name="author" content="Harshit Sethy">  
    
    <?php if(Seo::get_metatags()){ echo Seo::get_metatags(); }else { ?>

			<meta name="description" content="Do you want to Study Abroad in USA, UK, Europe, Canada, Australia, UAE; GoToUniversity education consultants waiting to help you get admissions in top universities. Compare universities and program, courses and study costs, check university rankings, admission criteria and much more.">
			<meta name="keywords" content="GoToUniversity, Go To University, Study Abroad, Education Consultancy, Abroad Universities, Foreign Education Consultant, Foreign University, Study in the USA, Study in Canada, Study in the UK">
    <?php } ?>
    