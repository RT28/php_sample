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


AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- LIBRARY FONT-->
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link type="text/css" rel="stylesheet" href="font/main/stylesheet.css">

    <!-- LIBRARY CSS-->
    <link type="text/css" rel="stylesheet" href="libs/animate/animate.css">    
    <link type="text/css" rel="stylesheet" href="libs/owl-carousel-2.0/assets/owl.carousel.css">
    <link type="text/css" rel="stylesheet" href="libs/selectbox/css/jquery.selectbox.css">
    <link type="text/css" rel="stylesheet" href="libs/fancybox/css/jquery.fancybox.css">
    <link type="text/css" rel="stylesheet" href="libs/fancybox/css/jquery.fancybox-buttons.css">
    <link type="text/css" rel="stylesheet" href="libs/media-element/build/mediaelementplayer.min.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input-facebook.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input-mac.css">
    <link type="text/css" rel="stylesheet" href="http://davidstutz.github.io/bootstrap-multiselect/dist/css/bootstrap-multiselect.css">
    <script src="libs/js-cookie/js.cookie.js"></script>

    <?php $this->head() ?>
</head>
<body>
<!-- LOADING-->
<div class="body-2 loading">
  <div class="dots-loader"></div>
</div>
<?php $this->beginBody() ?>
    <?php include 'header.php';?>
    <?= $content ?>

    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-title">
        <div class="modal-dialog" role="document">
            <div class="modal-content">			
                <div class="modal-header">
                    <img src="/images/login-header-bg.png" alt=""/>
                    <button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="alert alert-danger alert-dismissible" role="alert" id="modal-error-container" style="display: none;">
                    <strong id="modal-error"></strong>
                </div>
                <div class="modal-body" id="modal-container">
                </div>                
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
<?php include 'footer.php';?>
</body>
<!-- JAVASCRIPT LIBS-->
<script src="libs/jquery/jquery-ui.js"></script>
<script src="libs/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="libs/smooth-scroll/jquery-smoothscroll.js"></script> 
<script src="libs/owl-carousel-2.0/owl.carousel.min.js"></script> 
<script src="libs/appear/jquery.appear.js"></script> 
<script src="libs/count-to/jquery.countTo.js"></script> 
<script src="libs/wow-js/wow.min.js"></script> 
<script src="libs/selectbox/js/jquery.selectbox-0.2.min.js"></script> 
<script src="libs/fancybox/js/jquery.fancybox.js"></script> 
<script src="libs/fancybox/js/jquery.fancybox-buttons.js"></script>
<script src="libs/tokeninput/js/jquery.tokeninput.js"></script>
<script src="js/bootstrap-tokenfield.js"></script>
<script src="js/typeahead.bundle.min.js"></script>
<script src="libs/bootstrap-typeahead.min.js"></script>
<script src="js/slick.js" type="text/javascript"></script> 
<script src="http://davidstutz.github.io/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<!-- MAIN JS--> 
<!-- LOADING SCRIPTS FOR PAGE--> 
<script src="libs/isotope/isotope.pkgd.min.js"></script> 
<script src="libs/isotope/fit-columns.js"></script> 
<script src="js/pages/homepage.js"></script>

<script src="js/main.js"></script> 
</html>
<?php $this->endPage() ?>
