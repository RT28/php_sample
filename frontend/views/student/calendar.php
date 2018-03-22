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
use common\models\PartnerEmployee;
use frontend\models\StudentCalendar; 

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);
$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);

$meetingtype = CalendarEvents::getMeetingType();
$mode = CalendarEvents::getMode();
$student_id = Yii::$app->user->identity->id;
$consultant = Consultant::find()
->leftJoin('student_consultant_relation','consultant.consultant_id=student_consultant_relation.consultant_id')
->select(['consultant.first_name','consultant.last_name','consultant.consultant_id'])
->where(['student_id'=>$student_id])->all();

$trainees = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$student_id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_TRAINER)
        ->all();

$employees = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$student_id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_EMPLOYEE)
        ->all(); 
$e_count = StudentCalendar::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_STUDENT)
        ->andWhere('created_by_role != '.Roles::ROLE_STUDENT)
        ->andWhere('status = 0')
        ->all();
        $e_count =  count($e_count);              
$this->context->layout = 'profile';
?>
<?php
    $defaultClass = 'dashboard-checklist-item';
    $completeClass = 'dashboard-checklist-item dashboard-checklist-item-done';
?>

<div class="col-sm-12">
  <h1>
    <?= Html::encode($this->title) ?>
  </h1>
  <?= $this->render('_student_common_details', []); ?>
  <div class="form-group" style="float: right;">
  	<div class="all-meet-modal">
    <button type="button" class="btn btn-blue fc-widget-content" onclick="getAllmeetings();" >All Meetings </button>
    <span id="e_count"><?php if($e_count > 0) { echo $e_count; } ?></span>
  	</div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div id="calendar-detailed"></div>
    </div>
  </div>
</div>


<div class="cal-popup">
      <div class="panel panel-default">
        <div class="panel-heading">Events <button type="button" id="cl_close" class="close" data-dismiss="modal">&times;</button></div>
        <div class="panel-body">
          <div id="calendar-form">
            <form id="event-form">
              <input type="hidden" id="input-event-id" placeholder=""/>
              <div id="err_msg" style="display: none;">Fields marked * are mandatory!</div>
              <div class="row">
    			<div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-title">Title *</label>
                <input type="text" class="form-control" id="input-event-title" placeholder="Title">
              </div>
              <div class="form-group">
                <label for="input-event-location">Location</label>
                <input type="text" class="form-control" id="input-event-location" placeholder="Location">
              </div>
              </div>
    		  <div class="col-sm-6">
              <div class="form-group">
                <label for="input-event-start">Start *</label>

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
              </div>
    		  <div class="col-sm-6">
              <div class="form-group">
                <label for="input-event-end">End *</label>
                <?= DateTimePicker::widget([
                'name' => 'input-event-end',
                'type' => DateTimePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'End Time', 'class' => 'form-control', 'id' => 'input-event-end'],
                'pluginOptions' => [
                'autoClose' => true,
                'format' => 'yyyy-mm-dd hh:ii',
                'todayHighlight' => true
                ]
                ]);
                ?>
              </div>
              </div>
    		  <!-- <div class="col-sm-4">
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
              </div> -->
    		  
    		  <!-- <div class="col-sm-4">
              <div class="form-group">
                <label for="input-event-appointment-with">Invities</label>
                <select class="form-control" id="input-event-appointment-with" placeholder="Appointment with">
                <option value="0">--Select--</option>
                  <?php if($consultant>0){
                  foreach($consultant as $conslt): ?>
                                    <option value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                                    <?= $conslt->first_name.' '.$conslt->last_name; ?>
                                    </option>
                                    <?php endforeach; 
                  }?>
                  <?php if($trainees>0){
                  foreach($trainees as $traine): ?>
                                    <option value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                                    <?= $traine->first_name.' '.$traine->last_name; ?>
                                    </option>
                                    <?php endforeach; 
                  }?>
                  <?php if($editors>0){
                  foreach($editors as $editor): ?>
                                    <option value="<?= $editor->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                                    <?= $editor->first_name.' '.$editor->last_name; ?>
                                    </option>
                                    <?php endforeach; 
                  }?>
                  <?php if($employees>0){
                  foreach($employees as $employee): ?>
                                    <option value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                                    <?= $employee->first_name.' '.$employee->last_name; ?>
                                    </option>
                                    <?php endforeach; 
                  }?>
                </select>
              </div>
              </div> -->

              <div class="col-sm-6">
              <div class="form-group">
                <label for="input-event-appointment-with">Invitees</label>
                <select class="form-control" id="app_with" placeholder="Appointment with">
                <option>--Select Invitees--</option></select>
                  <div class="form-group other-chat" id="invities_list" style="height: 100px!important; display: none;">

                  <?php if($consultant>0){
                  foreach($consultant as $conslt): ?>
                                    <input type="checkbox" class="ids_consultant" name="consultant_id[]" value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                                    <?= $conslt->first_name.' '.$conslt->last_name; ?><br>
                                    <?php endforeach; 
                  }?>
                  <?php if($trainees>0){
                  foreach($trainees as $traine): ?>
                                    <input type="checkbox" class="ids_trainer" name="trainer_id[]" value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                                    <?= $traine->first_name.' '.$traine->last_name; ?><br>
                                    <?php endforeach; 
                  }?>
                  <?php if($employees>0){
                  foreach($employees as $employee): ?>
                                    <input type="checkbox" class="ids_employee" name="employee_id[]" value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                                    <?= $employee->first_name.' '.$employee->last_name; ?><br>
                                    <?php endforeach; 
                  }?>
                  </div>
              </div>
              </div>



            <div class="col-sm-4">
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
              </div>  

    		  <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-remarks">Remarks</label>
                <textarea type="text" class="form-control" id="input-event-remarks" placeholder="Remarks" rows="4"></textarea>
              </div>
              </div>
          <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-alerts">Alerts</label>
                <select class="form-control" id="input-event-alerts" placeholder="Mode of Meeting ">
                  <option value="0">--Select--</option>
                  <option value="1">15 Minutes before</option>
                  <option value="2">30 Minutes before</option>
                  <option value="3">1 Hour before</option>
                  <option value="4">1 Day before</option>
                  <option value="5">2 Days before</option>
                </select>
              </div>
              </div>    
    		  <div class="col-sm-12">
              <div class="form-group">
                <button type="button" class="btn btn-success btn-event-add">Add</button>
                <button type="button" class="btn btn-success btn-event-form-update hidden">Update</button>
              </div>
              </div>
              </div>
            </form>
          </div>
          <div id="calendar-event-detail" class="hidden">
            
          </div>
          <div id="calendar-allmeetings"></div>
        </div>
      </div>
    </div>
    <div class="popup-closer"></div>
 
    <script>
    	$( document ).on( 'click', '.fc-widget-content', function () {  
        	$('.cal-popup').addClass('open');
        	$('body').addClass('open-cal-popup');
        	$('.popup-closer').addClass('active');
			
        	//$('.cal-popup').removeClass('open');
    	});
    </script>
    <script>
    	$(document).ready(function(e) {
		  $(".fc-widget-content").click(function() {
			$(".cal-popup").addClass("open");
			$("body").addClass("open-cal-popup");
        	$(".popup-closer").addClass("active");
		  });
		  
		  $(".popup-closer").click(function() {
			$(".cal-popup").removeClass("open");
			$("body").removeClass("open-cal-popup");
        	$(".popup-closer").removeClass("active");
          $('#calendar-detailed').fullCalendar('refetchEvents');
          $('#calendar').fullCalendar('refetchEvents');
		  });

      $("#cl_close").click(function() {
      $(".cal-popup").removeClass("open");
      $("body").removeClass("open-cal-popup");
          $(".popup-closer").removeClass("active");
          $('#calendar-detailed').fullCalendar('refetchEvents');
          $('#calendar').fullCalendar('refetchEvents');
      });
      $("#app_with").click(function() {
      $("#invities_list").toggle();
      });
		  
		});
    </script>
