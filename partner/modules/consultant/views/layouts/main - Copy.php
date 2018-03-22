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
use yii\helpers\FileHelper;
use common\models\StudentAssociateConsultants;
use frontend\models\UserLogin;
use yii\db\Expression;

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);

$meetingtype = CalendarEvents::getMeetingType();
$mode = CalendarEvents::getMode();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>
<!-- LIBRARY FONT-->
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">
<link type="text/css" rel="stylesheet" href="font/font-icon/font-awesome-4.4.0/css/font-awesome.css">
<link type="text/css" rel="stylesheet" href="font/font-icon/font-svg/css/Glyphter.css">
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
<script src="libs/js-cookie/js.cookie.js"></script>
 
<!-- LIBRARY CSS-->
 <style>
#ppForm { display: block; margin: 20px auto; 
background: #eee; border-radius: 10px; 
padding: 15px;   text-align:center; }

.btn_hidden{
    display: none;
} 
.myButton {
	background-color:#44c767;
	-moz-border-radius:14px;
	-webkit-border-radius:14px;
	border-radius:14px;
	border:1px solid #18ab29;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:16px;
	padding:11px 14px;
	text-decoration:none;
	text-shadow:0px 1px 0px #2f6627;
}
.myButton:hover {
	background-color:#5cbf2a;
}
.myButton:active {
	position:relative;
	top:1px;
}
</style>
<?php $this->head() ?>
</head>
<body>
<!-- LOADING-->
<div class="body-2 loading">
<div class="dots-loader"></div>
</div>
<?php $this->beginBody() ?>
<?php
if(Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
    $userId= Yii::$app->user->identity->id;
	$Consultant = Consultant::find()->where(['consultant_id'=>$userId])->one();
	$students = StudentConsultantRelation::find()->where(['consultant_id'=>$Consultant->consultant_id])->all();
}  
 
?>
<?php include 'header.php';?>
<input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
<input type="hidden" id="from_role" value="<?= Roles::ROLE_CONSULTANT; ?>">
<!-- WRAPPER-->
<div id="wrapper-content" class="student-profile"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content">
<div class="container-fluid">
<div class="dashboard-block">
<div class="row">
<div class="col-sm-2">
<div class="dashboard-right" style="margin-top: 20px;">

<div class="student-info">
<?php
 $src = ""; 
    $cover_photo_path = [];
    $src = './noprofile.gif'; 
   $is_profile = 0;
	if(is_dir('./uploads/consultant/' . $userId . '/profile_photo')) {
        $cover_photo_path = "./uploads/consultant/".$userId."/profile_photo/consultant_image_228X228";
        if(glob($cover_photo_path.'.jpg')){
          $src = $cover_photo_path.'.jpg';
		   $is_profile = 1;
        } else if(glob($cover_photo_path.'.png')){
          $src = $cover_photo_path.'.png';
		   $is_profile = 1;
        } else if(glob($cover_photo_path.'.gif')){
          $src = $cover_photo_path.'.gif';
		   $is_profile = 1;
        } 
    }
	
?>

<div class="profile-pic"> <img id="target_logo" class="student-profile-photo" src="<?= $src; ?>" alt="<?= $Consultant->first_name;?>"/> 
</div>

<form id="ppForm" name="myForm1" method="post" action="?r=consultant/consultant/saveprofileajax" enctype="multipart/form-data">
<a style="cursor: pointer;" id="uploadlink">Upload</a>
<?php if($is_profile==1){ ?>
<a style="cursor: pointer;" id="remove_pro_pic">&nbsp;/&nbsp;Remove</a>
<?php } ?>
<br>
     <input type="file" size="60" name="profile_photo" class="btn_profile" id="imgInp" style="display: none;">
     <input type="hidden" name="consultant_id" value="<?php echo $userId; ?>">
     <input type="submit" size="60" id="img_upload" value="Upload" class="btn_hidden">
	  <div id="del_propic" style="display: none;">
     <div>Are you sure , doyou want to remove profile picture?</div>
     <div><a href="#" class="myButton" id='remove_approve'>Yes</a>&nbsp;&nbsp;<a href="#" class="myButton" id='remove_denied'>No</a></div>
     </div>
<div id="message"></div>
 </form>
 </div>
 
<div class="panel panel-default panel-custom panel-noti">
<div class="panel-heading"> <span class="noti-count"></span>Notifications </div>
<div class="panel-body" id="notifications-panel"></div>
</div>
<div id="calendar">
</div>
<div class="panel panel-default panel-custom panel-chat">
<div class="panel-heading">
Chat
</div>
<div class="panel-body">
<?php
$subscribed = 0;
 foreach($students as $student):
  if($student->student->status==UserLogin::STATUS_SUBSCRIBED){ 
	?>
<div class="chat-unit" data-to="<?= $student->student_id . '-' . Roles::ROLE_STUDENT; ?>">
<div class="chat-img">
<?php
$src = '';
$name = $student->student->email;
if(isset($student->student->student)) {
$name = $student->student->student->first_name . ' ' .$student->student->student->last_name;
}
$src = './noprofile.gif';
$user = $student->student_id;

if (is_dir("./web/uploads/$user")) {
$cover_photo_path = FileHelper::findFiles("./web/uploads/$user", [
'caseSensitive' => true,
'recursive' => false,
'only' => ['profile_photo.*']
]);

if (count($cover_photo_path) > 0) {
$src = $cover_photo_path[0];
}
}

 
    
	
?>
<img src="<?= $src; ?>" alt="<?= $name; ?>"/>
</div>
<div class="chat-name"><?= $name; ?></div>
<div class="chat-status">
<span class="offline"></span>
</div>
</div>
<?php $subscribed++;
 }
endforeach;?>
</div>
</div>
<div class="chat-parent"></div>
</div>
</div>
<div class="col-sm-10">
<ul class="dashboard-left-menu">
<?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
 
 <li><a href="?r=consultant/students/status" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Dashboard</a></li> 
<li><a href="?r=consultant/consultant/index" class="<?= ($activeTab == 'profile') ? 'active' : '';?>">My Profile</a></li> 
<li><a href="?r=consultant/students/index" class="<?= ($activeTab == 'students') ? 'active' : '';?>">My Students </a></li> 
<li><a href="?r=consultant/tasks/index" class="<?= ($activeTab == 'tasks') ? 'active' : '';?>">Tasks</a></li> 
<li><a href="?r=consultant/leads/index&status=0" class="<?= ($activeTab == 'leads') ? 'active' : '';?>">Leads</a></li>
<li><a href="?r=consultant/raiseinvoice/index" class="<?= ($activeTab == 'invoice') ? 'active' : '';?>">Invoice</a></li>
<li><a href="?r=consultant/university/index" class="<?= ($activeTab == 'university') ? 'active' : '';?>">University Faq</a></li>
<li><a href="?r=consultant/emailenquiry/index" class="<?= ($activeTab == 'emailenquiry') ? 'active' : '';?>">Email</a></li>


   
</ul>

<?= $content ?>
</div>
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
<img src="images/login-header-bg.png" alt=""/>
<button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="alert alert-danger alert-dismissible" role="alert" id="modal-error-container" style="display: none;">
<strong id="modal-error"></strong>
</div>
<div class="modal-body" id="modal-container">
</div>                
</div>
</div>
</div>

<div class="modal fade" id="calendar-modal" tabindex="-1" role="dialog" aria-labelledby="calendar">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="myModalLabel">Calendar</h4>
<button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<div class="alert alert-danger hidden calendar-alert alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<span class="calendar-alert-text"></span>
</div>
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
<!--<div class="form-group">
<label for="input-event-url">Url</label>
<input type="text" class="form-control" id="input-event-url" placeholder="Url">
</div>-->
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
<option value="<?= $key; ?>"><?= $type; ?></option>
<?php endforeach; ?> 

</select> 
</div>

<div class="form-group " id="mode-container">
<label for="input-event-mode">Mode of Meeting</label>
<select class="form-control" id="input-event-mode" placeholder="Mode of Meeting "> 
<?php foreach($mode as $key=>$type): ?> 
<option value="<?= $key; ?>"><?= $type; ?></option>
<?php endforeach; ?> 
</select> 
</div>

<div class="form-group">
<label for="input-event-event_type">Inivites</label>
<select class="form-control" id="input-event-event_type" placeholder="Event Type"></select>
</div>
<div class="form-group hidden" id="appointment-container">
<label for="input-event-appointment-with">Appointment With</label>
<select class="form-control" id="input-event-appointment-with" placeholder="Appointment with">
<?php foreach($students as $student): ?>
<?php
$name = $student->student->email;
if(isset($student->student->student)) {
$name = $student->student->student->first_name . ' ' .$student->student->student->last_name;
}
?>
<option value="<?= $student->student_id ?>" role="<?= $student->student->role_id ?>"><?= $name; ?></option>
<?php endforeach; ?>
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
<!--<div class="form-group">
<label for="event-url">Url</label>
<p><a id="event-url"></a></p>
</div>-->
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
</div>


<script>
 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#img_upload').trigger('click');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
$(document).ready(function()
{
 $('#uploadlink').on('click',function(evt){
         evt.preventDefault();
         $('#imgInp').trigger('click');
     });
    var options = { 
    beforeSend: function() 
    {
        /////
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
      //// 
    },
    success: function() 
    {
        
    location.reload();
    },
    complete: function(response) 
    { 
         ////       
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#ppForm").ajaxForm(options);
 
});


 $('#remove_pro_pic').on('click',function(evt){
         $("#del_propic").show();
     });
  $('#remove_denied').on('click',function(evt){
         $("#del_propic").hide();
     });
  $('#remove_approve').on('click',function(evt){
          $.ajax({
            url: '?r=consultant/consultant/removeprofileajax',
            method: 'POST',
            success: function(response) { 
                $("#del_propic").html("<font color='green'>Profile Picture Removed Successfully!!</font>");
                $('#target_logo').attr('src','./noprofile.gif');
                $('#my_propic').attr('src','./noprofile.gif');
                $('#remove_pro_pic').hide();
            },
            error: function(error) {
                console.log(error);
            }
     });
 });
 
</script>
<?php $this->registerJsFile('js/ajaxupload.js'); ?>

<?php $this->endBody() ?>
<?php include 'footer.php';?>
</body>
<!-- JAVASCRIPT LIBS-->
<script src="js/calendar.js"></script>
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
<script src="libs/bootstrap-typeahead.min.js"></script>
<!-- MAIN JS--> 
<script src="js/consultant.js"></script> 
<script src="js/main.js"></script> 
<!-- LOADING SCRIPTS FOR PAGE--> 
<script src="libs/isotope/isotope.pkgd.min.js"></script> 
<script src="libs/isotope/fit-columns.js"></script> 
<script src="js/pages/homepage.js"></script>
</html>
<?php $this->endPage() ?>
