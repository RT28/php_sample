<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\components\ConnectionSettings;
use frontend\assets\FullCalendarAsset;
use frontend\assets\MomentAsset;
use kartik\datetime\DateTimePicker;
use common\models\StudentConsultantRelation;  
use common\models\Consultant;
use common\components\Roles;
use common\models\StudentAssociateConsultants;
use common\models\StudentPackageDetails;
use frontend\models\UserLogin;

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);
$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<?php include('metatag.php'); ?>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<!-- LIBRARY FONT-->
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">
<link type="text/css" rel="stylesheet" href="/font/font-icon/font-awesome-4.4.0/css/font-awesome.css"> 
<link type="text/css" rel="stylesheet" href="/font/main/stylesheet.css">
<!-- LIBRARY CSS-->
<link type="text/css" rel="stylesheet" href="/libs/animate/animate.css">    
<link type="text/css" rel="stylesheet" href="/libs/owl-carousel-2.0/assets/owl.carousel.css">
<link type="text/css" rel="stylesheet" href="/libs/selectbox/css/jquery.selectbox.css">
<link type="text/css" rel="stylesheet" href="/libs/fancybox/css/jquery.fancybox.css">
<link type="text/css" rel="stylesheet" href="/libs/fancybox/css/jquery.fancybox-buttons.css">
<link type="text/css" rel="stylesheet" href="/libs/media-element/build/mediaelementplayer.min.css">
<link type="text/css" rel="stylesheet" href="/libs/tokeninput/css/token-input.css">
<link type="text/css" rel="stylesheet" href="/libs/tokeninput/css/token-input-facebook.css">
<link type="text/css" rel="stylesheet" href="/libs/tokeninput/css/token-input-mac.css">
<script src="/libs/js-cookie/js.cookie.js"></script>
<script src="https://static.opentok.com/v2/js/opentok.js" charset="utf-8"></script>
<!-- Global site tag (gtag.js) - Google Analytics --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111788034-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-111788034-1');
    </script>
<?php $this->head() ?>
</head>
<body>
<!-- LOADING-->
<div class="body-2 loading">
<div class="dots-loader"></div>
</div>
<?php $this->beginBody() ?>

<?php
$student_id = Yii::$app->user->identity->id;
$consultant = StudentConsultantRelation::find()->where(['=', 'student_id', $student_id])->one();
$consultant = StudentConsultantRelation::find()->where(['=', 'student_id', $student_id])->one();

if(!empty($consultant)) {
$consultant = Consultant::find()->where(['=', 'consultant_id', $consultant->consultant_id])->one();
}

if(!empty($consultant)) {
$consultant = Consultant::find()->where(['=', 'id', $consultant->consultant_id])->all();
}

 
?>
<?php include 'header.php';?>
<input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
<input type="hidden" id="from_role" value="<?= Roles::ROLE_STUDENT; ?>">
<!-- WRAPPER-->

<?= $content ?>

 

 

<?php $this->endBody() ?>
<?php include 'footer.php';?>
</body>
<!-- JAVASCRIPT LIBS-->
<script src="/libs/jquery/jquery-ui.js"></script>
<script src="/libs/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="/libs/smooth-scroll/jquery-smoothscroll.js"></script> 
<script src="/libs/owl-carousel-2.0/owl.carousel.min.js"></script> 
<script src="/libs/appear/jquery.appear.js"></script> 
<script src="/libs/count-to/jquery.countTo.js"></script> 
<script src="/libs/wow-js/wow.min.js"></script> 
<script src="/libs/selectbox/js/jquery.selectbox-0.2.min.js"></script> 
<script src="/libs/fancybox/js/jquery.fancybox.js"></script> 
<script src="/libs/fancybox/js/jquery.fancybox-buttons.js"></script>
<script src="/libs/tokeninput/js/jquery.tokeninput.js"></script>
<script src="/js/bootstrap-tokenfield.js"></script>
<script src="/js/typeahead.bundle.min.js"></script>
<script src="/libs/bootstrap-typeahead.min.js"></script>
<script src="/js/slick.js" type="text/javascript"></script> 
<!-- MAIN JS--> 
<script src="/js/main.js"></script> 
<!-- LOADING SCRIPTS FOR PAGE--> 
<script src="/libs/isotope/isotope.pkgd.min.js"></script> 
<script src="/libs/isotope/fit-columns.js"></script> 
<script src="/js/pages/homepage.js"></script>
</html>
<?php $this->endPage() ?>
