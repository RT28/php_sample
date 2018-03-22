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
use common\models\Agency;
use common\components\Roles;
use yii\helpers\FileHelper; 
use common\models\User;

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);
/*$l_count = Agency::find()->where(['=', 'partner_login_id', Yii::$app->user->identity->id])->one();
$l_count = $l_count->leads_count;*/
$students_new = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 0 AND `student_consultant_relation`.`agency_id` = "'.Yii::$app->user->identity->id.'" ' )->all();
$l_count =  count($students_new);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title>
<?= Html::encode($this->title) ?>
</title>
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

<?php $this->head() ?>
</head>
<body>
<!-- LOADING-->
<div class="body-2 loading">
  <div class="dots-loader"></div>
</div>
<?php $this->beginBody() ?>
<?php
if(Yii::$app->user->identity->role_id == Roles::ROLE_AGENCY) {
    $userId= Yii::$app->user->identity->id;
	$Agency = Agency::find()->where(['AND',  ['=', 'partner_login_id', $userId]])->one();
	 
 

}  
 
?>
<?php include 'header.php';?>
<input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
<input type="hidden" id="from_role" value="<?= Roles::ROLE_AGENCY; ?>">
<!-- WRAPPER-->
<div id="wrapper-content" class="student-profile"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content">
        <div class="container">
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
	if(is_dir('./uploads/agency/' . $userId . '/profile_photo')) {
        $cover_photo_path = "./uploads/agency/".$userId."/profile_photo/consultant_image_228X228";
        if(glob($cover_photo_path.'.jpg')){
          $src = $cover_photo_path.'.jpg';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.png')){
          $src = $cover_photo_path.'.png';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.gif')){
          $src = $cover_photo_path.'.gif';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.jpeg')){
          $src = $cover_photo_path.'.jpeg';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.JPG')){
          $src = $cover_photo_path.'.JPG';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.PNG')){
          $src = $cover_photo_path.'.PNG';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.GIF')){
          $src = $cover_photo_path.'.GIF';
           $is_profile = 1;
        } else if(glob($cover_photo_path.'.JPEG')){
          $src = $cover_photo_path.'.JPEG';
           $is_profile = 1;
        }
    }
	
?>
                    <div class="profile-pic"> <img id="target_logo" class="student-profile-photo" src="<?= $src; ?>" alt="<?= $Agency->name;?>"/> </div>
                    <form id="ppForm" name="myForm1" method="post" action="?r=agency/agency/saveprofileajax" enctype="multipart/form-data">
                      <a style="cursor: pointer;" id="uploadlink">Change Logo</a>
                      <?php if($is_profile==1){ ?>
                      /
                      <a style="cursor: pointer;" id="remove_pro_pic">&nbsp;/&nbsp;Remove</a>
                      <?php } ?>
                      <br>
                      <input type="file" size="60" name="profile_photo" class="btn_profile" id="imgInp" style="display: none;">
                      <input type="hidden" name="agency_id" value="<?php echo $userId; ?>">
                      <input type="submit" size="60" id="img_upload" value="Upload" class="btn_hidden">
                      <div id="del_propic" style="display: none;">
                        <div>Are you sure , doyou want to remove profile picture?</div>
                        <div><a href="#" class="myButton" id='remove_approve'>Yes</a>&nbsp;&nbsp;<a href="#" class="myButton" id='remove_denied'>No</a></div>
                      </div>
                      <div id="message"></div>
                    </form>
                  </div>
                  <!--<div class="panel panel-default panel-custom panel-noti">
<div class="panel-heading"> <span class="noti-count"></span>Notifications </div>
<div class="panel-body" id="notifications-panel" style="color:white;">Coming sooon</div>
</div>-->
                  <ul class="dashboard-left-menu">
                    <?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
                    <li><a href="?r=agency/agency/index" class="<?= ($activeTab == 'profile') ? 'active' : '';?>">My Profile</a></li>
                    <li><a href="?r=agency/students/index" class="<?= ($activeTab == 'students') ? 'active' : '';?>">My Students</a></li>
                    <li><a href="?r=agency/consultant/index" class="<?= ($activeTab == 'consultant') ? 'active' : '';?>">Consultants</a></li>
                    <li><a href="?r=agency/employee/index" class="<?= ($activeTab == 'employee') ? 'active' : '';?>">Employees</a></li>
                    <li><a href="?r=agency/trainer/index" class="<?= ($activeTab == 'trainer') ? 'active' : '';?>">Trainers</a></li>
                    <li><a href="?r=agency/leads/index&status=0" class="<?= ($activeTab == 'leads') ? 'active' : '';?>">Leads&nbsp;<span id="l_count" style="color: #2ac1f0;">
                      <?php if($l_count!=0){ echo '('.$l_count.')'; } ?>
                      </span></a></li>
                  </ul>
                </div>
              </div>
              <div class="col-sm-10">
                <?= $content ?>
              </div>
            </div>
          </div>
        </div>
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
            url: '?r=agency/agency/removeprofileajax',
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
<script src="js/main.js"></script>
<!-- LOADING SCRIPTS FOR PAGE-->
<script src="libs/isotope/isotope.pkgd.min.js"></script>
<script src="libs/isotope/fit-columns.js"></script>
<script src="js/pages/homepage.js"></script>
</html>
<?php $this->endPage() ?>
