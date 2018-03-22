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
use common\components\CalendarEvents;
use frontend\assets\FullCalendarAsset;
use frontend\assets\MomentAsset;
use kartik\datetime\DateTimePicker;
use common\models\StudentConsultantRelation; 
use common\models\Consultant;
use common\components\Roles;
use common\models\StudentAssociateConsultants;
use common\models\StudentPackageDetails;
use frontend\models\UserLogin;
use frontend\assets\NotifyAsset;

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);
NotifyAsset::register($this);
$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);

$meetingtype = CalendarEvents::getMeetingType();
$mode = CalendarEvents::getMode();
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
<!-- LIBRARY FONT -->
 
<title>
<?= Html::encode($this->title) ?>
</title>
<!-- LIBRARY FONT
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">-->
 <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
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
<!--<script src="libs/js-cookie/js.cookie.js"></script> -->
<!-- Global site tag (gtag.js) - Google Analytics --> 
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111788034-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-111788034-1');
    </script>
<!--<script src="https://static.opentok.com/v2/js/opentok.js" charset="utf-8"></script>-->
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
$consultant = Consultant::find()
->leftJoin('student_consultant_relation','consultant.consultant_id=student_consultant_relation.consultant_id')
->select(['consultant.first_name','consultant.last_name','consultant.consultant_id'])
->where(['student_id'=>$student_id])->all();
 
?>
<?php include 'header.php';?>
<input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
<input type="hidden" id="from_role" value="<?= Roles::ROLE_STUDENT; ?>">
<!-- WRAPPER-->
<div id="wrapper-content" class="student-profile"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content">
        <div class="container">
          <div class="dashboard-block">
            <div class="row">
              <div class="col-sm-12">
                <?= $content ?>
              </div>
              <div id="calendar"> </div>
              <!--<div class="col-sm-2">
                <?php if($userLogin->status==4){ ?>
                <div class="dashboard-right">
                  <div class="panel panel-default panel-custom panel-noti">
                    <div class="panel-heading"> Notifications <span class="noti-count">9</span> </div>
                    <div class="panel-body" id="notifications-panel"></div>
                  </div>
                  <div id="calendar"> </div>
                  <div id="chatpopup" class="panel panel-default panel-custom panel-chat" style="display:none;">
                    <div class="panel-heading"> Chat </div>
                    <div class="panel-body">
                      <?php if($consultant>0){
foreach($consultant as $conslt): ?>
                      <div class="chat-unit" data-to="<?= $conslt->consultant_id . '-' . Roles::ROLE_CONSULTANT; ?>">
                        <div class="chat-img"> <img src="/images/user-1.jpg" alt=""/> </div>
                        <div class="chat-name">
                          <?= $conslt->first_name.''.$conslt->last_name; ?>
                        </div>
                        <div class="chat-status"> <span class="offline"></span> </div>
                      </div>
                      <?php endforeach;
}
?>
                    </div>
                  </div>
                  <div class="chat-parent"></div>
                </div>
                <?php }?>
              </div>-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-title">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="alert alert-danger alert-dismissible" role="alert" id="modal-error-container" style="display: none;"> <strong id="modal-error"></strong> </div>
      <div class="modal-body" id="modal-container"> </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="calendar-modal" tabindex="-1" role="dialog" aria-labelledby="calendar">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Calendar</h4>
        <button type="button" class="close custom-modal-close-1" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger hidden calendar-alert alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <span class="calendar-alert-text"></span> </div>
        <div class="row">
          <div class="col-sm-8">
            <div id="calendar-detailed"></div>
          </div>
          <div class="col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">Events</div>
              <div class="panel-body">
                <div id="calendar-form">
                  <form id="event-form">
                    <input type="hidden" id="input-event-id" placeholder=""/>
                    <div class="form-group">
                      <label for="input-event-title">Title</label>
                      <input type="text" class="form-control" id="input-event-title" placeholder="Title">
                    </div>
                    <div class="form-group">
                      <label for="input-event-start">Start</label>
                      <?= DateTimePicker::widget([
'name' => 'input-event-start',
'type' => DateTimePicker::TYPE_INPUT,
'options' => ['placeholder' => 'Start Time', 'class' => 'form-control', 'id' => 'input-event-start'],
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd hh:ii',
'todayHighlight' => true
]
]);
?>
                    </div>
                    <div class="form-group">
                      <label for="input-event-end">End</label>
                      <?= DateTimePicker::widget([
'name' => 'input-event-end',
'type' => DateTimePicker::TYPE_INPUT,
'options' => ['placeholder' => 'Start Time', 'class' => 'form-control', 'id' => 'input-event-end'],
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd hh:ii',
'todayHighlight' => true
]
]);
?>
                    </div>
                    <div class="form-group " id="meetingtype-container">
                      <label for="input-event-meetingtype">Type</label>
                      <select class="form-control" id="input-event-meetingtype" placeholder="Meeting Type">
                        <?php foreach($meetingtype as $key=>$type): ?>
                        <option value="<?= $key; ?>">
                        <?= $type; ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group " id="mode-container">
                      <label for="input-event-mode">Mode of Meeting</label>
                      <select class="form-control" id="input-event-mode" placeholder="Mode of Meeting ">
                        <?php foreach($mode as $key=>$type): ?>
                        <option value="<?= $key; ?>">
                        <?= $type; ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="input-event-event_type">Inivites</label>
                      <select class="form-control" id="input-event-event_type" placeholder="Event Type">
                      </select>
                    </div>
                    <div class="form-group hidden" id="appointment-container">
                      <label for="input-event-appointment-with">Appointment With</label>
                      <select class="form-control" id="input-event-appointment-with" placeholder="Appointment with">
                        <?php if($consultant>0){
foreach($consultant as $conslt): ?>
                        <option value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                        <?= $conslt->first_name.''.$conslt->last_name; ?>
                        </option>
                        <?php endforeach; 
}?>
                      </select>
                      <div id="input-event-status-container" class="hidden">
                        <label for="input-event-remarks">Status</label>
                        <p id="input-event-appointment-status"></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="input-event-remarks">Remarks</label>
                      <textarea type="text" class="form-control" id="input-event-remarks" placeholder="Remarks" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                      <button type="button" class="btn btn-success btn-event-add">Add</button>
                      <button type="button" class="btn btn-success btn-event-form-update hidden">Update</button>
                    </div>
                  </form>
                </div>
                <div id="calendar-event-detail" class="hidden">
                  <p id="event-id" class="hidden"></p>
                  <p id="event-appointment-with" class="hidden" role=""></p>
                  <div class="form-group">
                    <label for="input-event-title">Title</label>
                    <p id="event-title"></p>
                  </div>
                  <div class="form-group">
<label for="event-url">Url</label>
<p><a id="event-url"></a></p>
</div>
                  <div class="form-group">
                    <label for="event-start">Start</label>
                    <p id="event-start"></p>
                  </div>
                  <div class="form-group">
                    <label for="event-end">End</label>
                    <p id="event-end"></p>
                  </div>
                  <div class="form-group">
                    <label for="event-meetingtype">Type</label>
                    <p id="event-meetingtype"></p>
                  </div>
                  <div id="event-mode-container" class="form-group">
                    <label for="event-mode">Mode of Meeting</label>
                    <p id="event-mode"></p>
                  </div>
                  <div class="form-group">
                    <label for="event-type">Invities</label>
                    <p id="event-type"></p>
                  </div>
                  <div id="event-status-container" class="form-group hidden">
                    <label for="event-status">Status</label>
                    <p id="event-status"></p>
                  </div>
                  <div class="form-group">
                    <label for="event-remarks">Remarks</label>
                    <p id="event-remarks"></p>
                  </div>
                  <button type="button" class="btn btn-primary btn-event-update">Update</button>
                  <button type="button" class="btn btn-danger btn-event-delete">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->
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
