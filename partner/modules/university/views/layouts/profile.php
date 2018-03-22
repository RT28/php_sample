<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use partner\assets\AppAsset;
use common\widgets\Alert;
use common\components\ConnectionSettings;
use frontend\assets\FullCalendarAsset;
use frontend\assets\MomentAsset;
use kartik\datetime\DateTimePicker;
use common\components\Roles;
use kartik\sidenav\SideNav;
use common\models\University;
use yii\helpers\FileHelper;
use common\models\Consultant;
use common\models\StudentConsultantRelation;
use common\models\Student;
use backend\models\Notifications;


AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);

$uid = Yii::$app->user->identity->partner_id;

$university = University::find()->where(['id'=> $uid])->one();
$cover_photo_path = [];
$src = './noprofile.gif';
if(is_dir('./../../backend/web/uploads/'.$university->id.'/logo')) {
$cover_photo_path = FileHelper::findFiles('./../../backend/web/uploads/'.$university->id.'/logo', [
'caseSensitive' => true,
'recursive' => false,
'only' => ['logo.*']
]);
}
if (count($cover_photo_path) > 0) {
//$src = $cover_photo_path[0];
$src = './../../backend/web/uploads/'.$university->id.'/logo/logo.png';
}

 
$consultants = Consultant::find()->where(['=', 'parent_partner_login_id', $uid])->all();

$students = '';

foreach($consultants as $consultant):
$students[] = StudentConsultantRelation::find()->where(['=', 'consultant_id', $consultant->id])->all();
endforeach;
 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="font/main/stylesheet.css" rel="stylesheet">
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
<script src="libs/js-cookie/js.cookie.js"></script> 
<?php $this->head() ?>
</head>



<body class="dash-body menu-active">
<?php $this->beginBody() ?>

<?php include 'header.php';?>


<div class="container-fluid">

<div class="row">
<div class="sidebar">
<div class="side-box red">
<h3 class="side-box-title">University Representative</h3>
<div class="box-content">
<p class="rps-name"><i class="fa fa-user-o" aria-hidden="true"></i> <?php if(!empty($university->contact_person)){echo $university->contact_person; }?></p>
<p class="rps-mail"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php if(!empty($university->contact_email)){echo $university->contact_email; }?></p>
<p class="rps-phone"><i class="fa fa-phone" aria-hidden="true"></i><?php if(!empty($university->contact_mobile)){echo $university->contact_mobile; }?></p>
</div>
</div>

  <div class="side-box green">
<h3 class="side-box-title">Why Advertise With GTU?</h3>
<ol class="why-ad">
<li>Get featured in search results.</li>
                  <li>Penetration in emerging countries.</li>
                  <li>Direct access to prospective students.</li>
</ol>
<div class="text-center">
<a href="#" class="ad-btn">Know More</a>
</div>
</div>
  
<!-- Chats-->

<div id="chatpopup" class="side-box blue" style="display:none;">
<h3 class="side-box-title">Chat</h3>
<i class="fa fa-times" id="close-chat" aria-hidden="true"></i>
<div class="chat-group">
<?php foreach($consultants as $consultant): ?>
<div class="chat-unit" data-to="<?= $consultant->consultant_id . '-' . Roles::ROLE_CONSULTANT; ?>">
<?php
$consultant_name = $consultant->first_name.''.$consultant->last_name ;
?>
<div class="chat-img">
<img src="images/user.jpg" alt="<?= $consultant_name; ?>"/>
</div>
<div class="chat-name"><?= $consultant_name; ?></div>
<div class="chat-status">
<span class="offline"></span>
</div>
</div>
<?php endforeach;?>

<?php
if(isset($students[0])){
	if(count($students[0])>0){
$appointment_options = $students[0];

 foreach($students[0] as $student):
 ?>
<div class="chat-unit" data-to="<?= $student->id . '-' . Roles::ROLE_STUDENT; ?>">
<?php
$student_name = $student->student->first_name . ' ' . $student->student->last_name;
?>
<div class="chat-img">
<img src="images/user.jpg" alt="<?= $student_name; ?>"/>
</div>
<div class="chat-name"><?= $student_name; ?></div>
<div class="chat-status">
<span class="offline"></span>
</div>
</div>
<?php endforeach;
	}
}
?>
</div>
</div>
<div class="chat-parent"></div>

<?php  if (!Yii::$app->user->isGuest) {?>
<div id="chaticon" class="chat-block">
<div class="chat-tab"><i class="fa fa-commenting" aria-hidden="true"></i></div>

</div>
<?php } ?>


</div>


<section class="wrapper-dashboard">

<div class="wrapper-inner">
<input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
<input type="hidden" id="from_role" value="<?= Roles::ROLE_UNIVERSITY; ?>">
<?php /* Breadcrumbs::widget([
'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) */?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
<?php
  $activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
<li role="presentation" class="<?php if($activeTab == 'dashboard') { echo 'active'; }?>"><a href="?r=university/dashboard"  role="tab">Dashboard</a></li>
<li role="presentation" class="<?php if($activeTab == 'profile') { echo 'active'; }?>"><a href="?r=university/university/view" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Update <span class="caret"></span></a>
<ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
<li> <a href="#dropdown1" target="_blank">Info</a></li>
<li class=""><a href="?r=university/program" target="_blank">Programs</a></li>
<li class=""><a href="?r=university/notifications" target="_blank">Notifications</a></li>
</ul>
</li>
<li role="presentation" class="<?php if($activeTab == 'applications') { echo 'active'; }?>"><a href="?r=university/applications" >Applications</a></li>
<li role="presentation" class="<?php if($activeTab == 'admission') { echo 'active'; }?>"><a href="?r=university/admission" >Admission</a></li>
<li role="presentation"><a href="?r=university/dashboard/analytics"   class="<?php if($activeTab == 'analytics') { echo 'active'; }?>" >Advanced Analytics</a></li>

</ul>

<!-- Tab panes -->
<div class="tab-content">
<?= Alert::widget() ?>
<?= $content ?>
</div>

</div>
</section>

</div>
</div>

<?php $this->endBody() ?>

<!-- JAVASCRIPT LIBS-->
<script src="libs/jquery/jquery-ui.js"></script>
<script src="libs/smooth-scroll/jquery-smoothscroll.js"></script>
<script src="libs/owl-carousel-2.0/owl.carousel.min.js"></script>
<script src="libs/appear/jquery.appear.js"></script>
<script src="libs/count-to/jquery.countTo.js"></script>
<script src="libs/wow-js/wow.min.js"></script>
<script src="libs/selectbox/js/jquery.selectbox-0.2.min.js"></script>
<script src="libs/fancybox/js/jquery.fancybox.js"></script>
<script src="libs/fancybox/js/jquery.fancybox-buttons.js"></script>
<script src="libs/tokeninput/js/jquery.tokeninput.js"></script>
<script src="libs/bootstrap-typeahead.min.js"></script>
<!-- MAIN JS-->
<script src="js/main.js"></script>

<script>
  $(document).ready(function(){
	     $('#chaticon').click(function(e){
			 $('#chaticon').hide();
			 $('#chatpopup').show();
		 });
 });
 </script>
 <script>
   $(document).ready(function(){
 	     $('#close-chat').click(function(e){
 			 $('#chaticon').show();
 			 $('#chatpopup').hide();
 		 });
  });
  </script>
</html>
<?php $this->endPage() ?>
