<?php
use yii\helpers\FileHelper;
use common\models\Majors;
use common\models\Degree;
use common\models\Country;
use common\models\StudentPackageDetails; 
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\models\StudentConsultantRelation;
use common\models\StudentPartneremployeeRelation;
use frontend\models\UserLogin;
use frontend\models\StudentNotifications;
use common\components\Roles;
use common\models\ChatHistory;



$user = Yii::$app->user->identity;
$unreadNotifications = StudentNotifications::find()->where(['AND', ['=', 'student_id', $user->id], ['=', 'read', 0]])->all();
$n_count =  count($unreadNotifications);
$model = $user->student;
$userLogin =UserLogin::findOne($user->id);

$cover_photo_path = [];
$src = '../frontend/web/noprofile.gif';
$is_profile = 0;
if(is_dir('../../frontend/web/uploads/' . $user->id . '/profile_photo')) {
	$cover_photo_path = "../../frontend/web/uploads/".$user->id."/profile_photo/logo_170X115";
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
        $arr = Degree::find()->select('name')
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
    $consultants = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $user->id], ['=','status', 0]])->all();
  	$clist = array();
      if(!empty($consultants)) {
  	foreach ($consultants as $consultant){
          $consultant = Consultant::find()->where(['=', 'consultant_id', $consultant->consultant_id])->one();
          if(!empty($consultant)) {
              $clist[] = $consultant->first_name.' '.$consultant->last_name;
          }  
  	}
  	if(isset($clist)){
  		$consultant = implode(',',$clist) ;
  	}
	 	
    }  

    $trainees = '-';
    $trainees = StudentPartneremployeeRelation::find()->where(['=', 'student_id', $user->id])->all();
    $tlist = array();
      if(!empty($trainees)) {
    foreach ($trainees as $trainee){
          $trainee = PartnerEmployee::find()->where(['=', 'partner_login_id', $trainee->parent_employee_id])
          ->andWhere('role_id = '.Roles::ROLE_TRAINER)
          ->andWhere('profile_type = '.Roles::PROFILE_TRAINER)
          ->one();
          if(!empty($trainee)) {
              $tlist[] = $trainee->first_name.' '.$trainee->last_name;
          }  
    }
    if(isset($tlist)){
      $trainee = implode(',',$tlist) ;
    }
    
    }

    $editors = '-';
    $editors = StudentPartneremployeeRelation::find()->where(['=', 'student_id', $user->id])->all();
    $elist = array();
      if(!empty($editors)) {
    foreach ($editors as $editor){
          $editor = PartnerEmployee::find()->where(['=', 'partner_login_id', $editor->parent_employee_id])
          ->andWhere('role_id = '.Roles::ROLE_TRAINER)
          ->andWhere('profile_type = '.Roles::PROFILE_EDITOR)
          ->one();
          if(!empty($editor)) {
              $elist[] = $editor->first_name.' '.$editor->last_name;
          }  
    }
    if(isset($elist)){
      $editor = implode(',',$elist) ;
    }
    
    }


    /*$employees = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_EMPLOYEE)
        ->andWhere('partner_employee.logged_status = 1')
        ->all(); 
        foreach($employees as $employee){
            array_push($online_employees, $employee['id']);
        }*/

    $others = '-';
    $others = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$user->id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_EMPLOYEE)
        ->all(); 
    $olist = array();
      if(!empty($others)) {
    foreach ($others as $other){
          
              $olist[] = $other->first_name.' '.$other->last_name;
    }
    if(isset($olist)){
      $other = implode(',',$olist) ;
    }
    
    }

    $m_count = 0;
    $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);
?>
<div class="row">
<?php if($userLogin->status==4){ ?>
<div class="col-md-3">
  <div class="profile-pic stud-dash-pic">
    <div class="dash-pic-block">
    	<img id="target_logo" class="student-profile-photo" src="<?= $src; ?>" alt="<?= $model->first_name . ' ' , $model->last_name ?>"/> 
        <form id="myForm" class="change-dp" name="myForm1" method="post" action="/student/saveprofileajax" enctype="multipart/form-data">
        <a id="uploadlink">Upload</a>
        <?php if($is_profile==1){ ?>
        &nbsp;/&nbsp;
        <a id="remove_pro_pic">Remove</a>
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
    </div>
    <div class="user-name-loc">
    <h2 class="name">
        <?= $model->first_name . ' ' , $model->last_name ?>
     </h2>
     <p class="user-location">
     	<i class="fa fa-map-marker" aria-hidden="true"></i>
      <?php $student_country = Country::find()->where(['=', 'id', $model['country']])->one(); ?>
      <?= $student_country->name ?>
     </p>
     </div>
  </div>

<?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
<ul class="dashboard-left-menu" id="dashboard-ul">
  <?php if($userLogin->status==4){ ?>
  <li><a href="/student/dashboard" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Dashboard</a></li>
  <li><a href="/student/notification" class="<?= ($activeTab == 'notification') ? 'active' : '';?>">Notifications</a>
  <span id="n_count" style="color: #2ac1f0;"><?php if($n_count!=0){ echo $n_count; } ?></span></li>
  <li><a href="/student/calendar" class="<?= ($activeTab == 'calendar') ? 'active' : '';?>">My Calendar</a></li>
  <li><a href="/student/view" class="<?= ($activeTab == 'profile') ? 'active' : '';?>">My Profile</a></li>
  <li><a href="/student/student-shortlisted-courses" class="<?= ($activeTab == 'programs') ? 'active' : '';?>">Shortlisted Programs</a></li>
  <li><a href="/favourite-universities/index" class="<?= ($activeTab == 'universities') ? 'active' : '';?>">Shortlisted Universities</a></li>
  <li><a href="/student/packages" class="<?= ($activeTab == 'packages') ? 'active' : '';?>">Packages</a></li>
  <li><a href="/application-form/index" class="<?= ($activeTab == 'application') ? 'active' : '';?>">Standard Tests</a></li>
  <li><a href="/student-document/index" class="<?= ($activeTab == 'documents') ? 'active' : '';?>">Documents</a></li>
  <li><a href="/tasks/index" class="<?= ($activeTab == 'tasks') ? 'active' : '';?>">Tasks Management</a></li>
  <li><a href="/emailenquiry/index?status=1" class="<?= ($activeTab == 'enquiry') ? 'active' : '';?>">Email Enquiry</a></li>
  <li><a href="/video/chat" class="<?= ($activeTab == 'chat') ? 'active' : '';?>">Live Chat</a>
  <span id="m_count" style="color: #2ac1f0;"><?php if($m_count!=0){ echo $m_count; } ?></span></li>
  <?php }?>
  <?php if($userLogin->status!=4){ ?>
  <li><a href="/student/student-not-subscribed" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Shortlisted Programs</a></li>
  <li><a href="/favourite-universities/student-not-subscribed" class="<?= ($activeTab == 'universities') ? 'active' : '';?>">Shortlisted Universities</a></li>
  <?php }?>
</ul>
<!-- <form>
 -->  <select id="dashboard-ul-sel" class="form-control visible-xs">
      <option value="0">Dashboard</option>
      <option value="1">Notifications</option>
      <option value="2">My Calendar</option>
      <option value="3">My Profile</option>
      <option value="4">Shortlisted Programs</option>
      <option value="5">Shortlisted Universities</option>
      <option value="6">Packages</option>
      <option value="7">Standard Tests</option>
      <option value="8">Documents</option>
      <option value="9">Tasks Management</option>
      <option value="10">Email Enquiry</option>
      <option value="11">Live Chat</option>
  </select>
<!-- </form>
 --></div>
<?php }?>
<div class="col-md-9">

  
<?php  if(!empty($packages)) { ?>  
<p class="student-info">Wants to Study <strong><?= $majors ?></strong> in <strong><?= $countries ?></strong></br>
    Consulted by <strong><?= $consultant; ?></strong><br>
    <?php if(!empty($tlist)){ ?>
    Trainees : <strong><?= $trainee; ?></strong><br>
    <?php } if(!empty($elist)){ ?>
    Editors : <strong><?= $editor; ?></strong><br>
    <?php } if(!empty($olist)){ ?>
    Others : <strong><?= $other; ?></strong><br>
    <?php } ?>
</p>
<?php } ?>    

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
            url: '/student/removeprofileajax',
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
<?php $this->registerJsFile('../frontend/web/js/easyNotify.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/ajaxupload.js'); ?>
