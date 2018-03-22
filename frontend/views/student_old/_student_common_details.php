<?php
use yii\helpers\FileHelper;
use common\models\Majors;
use common\models\Country;
use common\models\StudentPackageDetails; 
use common\models\Consultant;
use common\models\StudentConsultantRelation;
use frontend\models\UserLogin;
use frontend\models\StudentNotifications;





$user = Yii::$app->user->identity;
$StudentNotifications = StudentNotifications::find()->where(['=', 'student_id', $user->id])->orderBy(['id'=>'DESC'])->all();

$model = $user->student;
$userLogin =UserLogin::findOne($user->id);

$cover_photo_path = [];
$src = './noprofile.gif';
$is_profile = 0;
if(is_dir('./../web/uploads/' . $user->id . '/profile_photo')) {
	$cover_photo_path = "./../web/uploads/".$user->id."/profile_photo/logo_170X115";
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
	/*$cover_photo_path = FileHelper::findFiles('./../web/uploads/' . $user->id . '/profile_photo/', [
		'caseSensitive' => true,
		'recursive' => false,
		//'only' => ['profile_photo.*']
	]);*/
} 

    /*if (count($cover_photo_path) > 0) {
        //$src = $cover_photo_path[0];
        $src = './uploads/' . $user->id . '/profile_photo/profile_photo.jpg';
    }*/
	
$majors = "";

    if(!empty($model->student->majors_preference))
    {
        $temp = $model->student->majors_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
        $arr = Majors::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $major) {
            $majors .= $major['name'] . ', ';
        }
    }

    $countries = "";
    if(!empty($model->student->country_preference))
    {          
        $temp = $model->student->country_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
        $arr = Country::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $country) {
            $countries .= $country['name'] . ', ';
        }
    }
    $packages = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', $user->id]])->count();
  
     
    $consultant = '-';
    $consultants = StudentConsultantRelation::find()->where(['=', 'student_id', $user->id])->all();
	$clist = array();
    if(!empty($consultants)) {
	foreach ($consultants as $consultant){
        $consultant = Consultant::find()->where(['=', 'consultant_id', $consultant->consultant_id])->one();
        if(!empty($consultant)) {
            $clist[] = $consultant->first_name.' '.$consultant->last_name;
        }  
	}
	if(isset($clist)){
		$consultant = implode('<br/>',$clist) ;
	}
	 	
    }  
?>
<style>
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
<div class="row">
<?php if($userLogin->status==4){ ?>
<div class="col-md-3">
<div class="profile-pic stud-dash-pic"> 
<div class="dash-pic-block">
<img id="target_logo" class="student-profile-photo" src="<?= $src; ?>" alt="<?= $model->first_name . ' ' , $model->last_name ?>"/> 
</div>
<a data-toggle="modal" data-target="#notiModal" class="student-noti"><i class="fa fa-bell-o" aria-hidden="true"></i></a>

<div class="modal fade" id="notiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notifications</h4>
      </div>
      <div class="modal-body">
	  <div style='padding:10px;'>
       <?php foreach($StudentNotifications as $Notification) {
             echo "<li>".$Notification['message'] . '</li>';
        }
		?>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>
</div>

<h2 class="name"><?= $model->first_name . ' ' , $model->last_name ?></h2>
<form id="myForm" name="myForm1" method="post" action="?r=student/saveprofileajax" enctype="multipart/form-data">
<a style="cursor: pointer;" id="uploadlink">Upload</a>
<?php if($is_profile==1){ ?>
<a style="cursor: pointer;" id="remove_pro_pic">&nbsp;/&nbsp;Remove</a>
<?php } ?>
<br>
     <input type="file" size="60" name="profile_photo" class="btn_profile" id="imgInp" style="display: none;">
     <input type="hidden" name="student_id" value="<?php echo $user->id; ?>">
     <input type="submit" size="60" id="img_upload" value="Upload" class="btn_hidden">
     <div id="del_propic" style="display: none;">
     <div>Are you sure , doyou want to remove profile picture?</div>
     <div><a href="#" class="myButton" id='remove_approve'>Yes</a>&nbsp;&nbsp;<a href="#" class="myButton" id='remove_denied'>No</a></div>
     </div>

<div id="message"></div>
 </form>
<?php  if(!empty($packages)) { ?>
<div class="student-info">

	<div class="student-info-unit">
		<label>Wants to study:</label>
		<p><?= $majors ?></p>
	</div>
	<div class="student-info-unit">
		<label>In:</label>
		<p><?= $countries ?></p>
	</div>
	<div class="student-info-unit">
		<label>Packages:</label>
<p><?php 
	echo $packages;?><a href="?r=student/packages" class="">View</a><?php
 ?></p>
	</div>
	 
	<div class="student-info-unit">
		<label>Consultant:</label>
		<p><?= $consultant ?></p>
	</div>
</div>
<?php } ?>
</div>
     <?php }?>
	 <div class="col-md-9">
<ul class="dashboard-left-menu">
<?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
<?php if($userLogin->status==4){ ?>
<li><a href="?r=student/dashboard" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Dashboard</a></li> 
<li><a href="?r=student/view" class="<?= ($activeTab == 'profile') ? 'active' : '';?>">My Profile</a></li> 
<li><a href="?r=student/student-shortlisted-courses" class="<?= ($activeTab == 'programs') ? 'active' : '';?>">Shortlisted Programs</a></li>
<li><a href="?r=favourite-universities/index" class="<?= ($activeTab == 'universities') ? 'active' : '';?>">Shortlisted Universities</a></li>
<li><a href="?r=student/packages" class="<?= ($activeTab == 'packages') ? 'active' : '';?>">My Packages</a></li>
<li><a href="?r=application-form/index" class="<?= ($activeTab == 'application') ? 'active' : '';?>">Standard Tests</a></li>
<li><a href="?r=student-document/index" class="<?= ($activeTab == 'documents') ? 'active' : '';?>">My Documents</a></li>
<li><a href="?r=tasks/index" class="<?= ($activeTab == 'tasks') ? 'active' : '';?>">My Tasks</a></li> 
 
<?php }?>

<?php if($userLogin->status!=4){ ?>
<li><a href="?r=student/student-not-subscribed" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Shortlisted Programs</a></li>
<li><a href="?r=favourite-universities/student-not-subscribed" class="<?= ($activeTab == 'universities') ? 'active' : '';?>">Shortlisted Universities</a></li>

<?php }?>
</ul>
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
       $('#target_logo').attr('src','./images/loading.gif');  
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
       /*dataString=$('form[name=myForm1]').serialize();
        $.ajax({
            url: '?r=student/saveprofileajax',
            method: 'POST',
            data: dataString,
            success: function(response, data) {
                
            },
            error: function(error) {
                console.log(error);
            }
        });*/
 
    },
    success: function() 
    {
        
    location.reload();
    },
    complete: function(response) 
    { 
        //$("#message").html("<font color='green'>Profile Picture Updated Successfully!!</font>");
        //reloadPic();
        
    },
    error: function()
    {

        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#myForm").ajaxForm(options);
 
});

 $('#remove_pro_pic').on('click',function(evt){
         $("#del_propic").show();
     });
  $('#remove_denied').on('click',function(evt){
         $("#del_propic").hide();
     });
  $('#remove_approve').on('click',function(evt){
          $.ajax({
            url: '?r=student/removeprofileajax',
            //method: 'POST',
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
