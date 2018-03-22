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
  <div class="row">
    <div class="col-sm-12">
      <div id="calendar-detailed"></div>
    </div>
  </div>
</div>


<div class="cal-popup">
      <div class="panel panel-default">
        <div class="panel-heading">Events</div>
        <div class="panel-body">
          <div id="calendar-form">
            <form id="event-form">
              <input type="hidden" id="input-event-id" placeholder=""/>
              <div class="row">
    			<div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-title">Title</label>
                <input type="text" class="form-control" id="input-event-title" placeholder="Title">
              </div>
              <div class="form-group">
                <label for="input-event-title">Location</label>
                <input type="text" class="form-control" id="input-event-loaction" placeholder="Location">
              </div>
              </div>
    		  <div class="col-sm-6">
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
              </div>
    		  <div class="col-sm-6">
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
              </div>
    		  <div class="col-sm-4">
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
    		  <div class="col-sm-4">
              <div class="form-group">
                <label for="input-event-event_type">Inivites</label>
                <select class="form-control" id="input-event-event_type" placeholder="Event Type">
                </select>
              </div>
              </div>
    		  <div class="col-sm-12">
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
              </div>
    		  <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-remarks">Remarks</label>
                <textarea type="text" class="form-control" id="input-event-remarks" placeholder="Remarks" rows="4"></textarea>
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
              <label for="input-event-title">Title</label>
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
    		  <div class="col-sm-6">
            <div class="form-group">
              <label for="event-meetingtype">Type</label>
              <p id="event-meetingtype"></p>
            </div>
            </div>
    		  <div class="col-sm-6">
            <div id="event-mode-container" class="form-group">
              <label for="event-mode">Mode of Meeting</label>
              <p id="event-mode"></p>
            </div>
            </div>
    		  <div class="col-sm-6">
            <div class="form-group">
              <label for="event-type">Invities</label>
              <p id="event-type"></p>
            </div>
            </div>
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
            <button type="button" class="btn btn-primary btn-event-update">Update</button>
            <button type="button" class="btn btn-danger btn-event-delete">Delete</button>
            </div>
    		  </div>
          </div>
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
		  });
		  
		});
    </script>