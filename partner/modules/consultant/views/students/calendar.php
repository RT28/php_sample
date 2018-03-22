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
use common\models\User;
use common\components\Roles;
use common\models\StudentAssociateConsultants;
use common\models\StudentPackageDetails;
use frontend\models\UserLogin;
use common\models\ConsultantCalendar;

AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);

$meetingtype = CalendarEvents::getMeetingType();
$mode = CalendarEvents::getMode();

$students = User::find()
        ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.Yii::$app->user->identity->id.'')
        ->all();
$e_count = ConsultantCalendar::find()
        ->where('consultant_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
        ->andWhere('created_by_role != '.Roles::ROLE_CONSULTANT)
        ->andWhere('status = 0')
        ->all();
        $e_count =  count($e_count);   
$parentConsultantId = Yii::$app->user->identity->id; 

$this->context->layout = 'main';
?>

<div class="col-sm-12">
  <h1>
    <?= Html::encode($this->title) ?>
  </h1>
  <div class="form-group" style="float: right;">
    <span id="e_count"><?php if($e_count > 0) { echo $e_count; } ?></span>
    <button type="button" class="btn btn-success fc-widget-content" onclick="getAllmeetings();" >All Meetings </button>
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
          

              <div class="col-sm-6">
              <div class="form-group">
                <label for="input-event-appointment-with">Invitees</label>
                <select class="form-control" id="app_with" placeholder="Appointment with">
                <option>--Select Invitees--</option></select>
                  <div class="form-group other-chat" id="invities_list" style="height: 100px!important; display: none;">
                  <?php if($students>0){
                  foreach($students as $student): ?>
                                    <input type="checkbox" class="ids_students" name="student_id[]" value="<?= $student->id ?>" role="<?= Roles::ROLE_STUDENT ?>">
                                    <?= $student->first_name.' '.$student->last_name; ?><br>
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
            <p id="event-id" class="hidden"></p>
            <p id="event-appointment-with" class="hidden" role=""></p>
            <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-title">Title</label>
              <p id="event-title"></p>
            </div>
            </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-start">Start</label>
              <p id="event-start"></p>
            </div>
            </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-end">End</label>
              <p id="event-end"></p>
            </div>
            </div>
          <!-- <div class="col-sm-6">
            <div class="form-group">
              <label for="event-meetingtype">Type</label>
              <p id="event-meetingtype"></p>
            </div>
            </div> -->
          <div class="col-sm-6">
            <div id="event-mode-container" class="form-group">
              <label for="event-mode">Mode of Meeting</label>
              <p id="event-mode"></p>
            </div>
            </div>
          <!-- <div class="col-sm-6">
            <div class="form-group">
              <label for="event-type">Invities</label>
              <p id="event-type"></p>
            </div>
            </div> -->
          <div class="col-sm-6">
            <div id="event-status-container" class="form-group hidden">
              <label for="event-status">Status</label>
              <p id="event-status"></p>
            </div>
            </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-remarks">Remarks</label>
              <p id="event-remarks"></p>
            </div>
            </div>
          <div class="col-sm-12">
            <button type="button" class="btn btn-primary btn-event-update btn-upd">Update</button>
            <button type="button" class="btn btn-danger btn-event-delete btn-upd">Delete</button>
            </div>
          </div>
          </div>
          <div id="calendar-allmeetings" style="overflow: scroll;"></div>
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

