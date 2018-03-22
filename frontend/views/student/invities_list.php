<?php 
use common\models\Consultant;
use common\components\Roles;
use common\models\PartnerEmployee;
use kartik\datetime\DateTimePicker;
use common\components\CalendarEvents;

$mode = CalendarEvents::getMode();
if(!empty($events)){ 
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

$checked_consultant = explode(',', $events->consultant_ids);
$checked_trainer = explode(',', $events->trainer_ids);
$checked_employee = explode(',', $events->employee_ids); ?>
<form id="event-form">
              <input type="hidden" id="input-event-id" value="<?= $events->id; ?>" placeholder=""/>
              <div id="err_msg" style="display: none;">Fields marked * are mandatory!</div>
              <div class="row">
          <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-title">Title *</label>
                <input type="text" class="form-control" id="input-event-title" placeholder="Title" value="<?= $events->title; ?>">
              </div>
              <div class="form-group">
                <label for="input-event-location">Location</label>
                <input type="text" class="form-control" id="input-event-location" placeholder="Location" value="<?= $events->location; ?>">
              </div>
              </div>
          <div class="col-sm-6">
              <div class="form-group">
                <label for="input-event-start">Start *</label>
                <?php $startTime = $events['start'];
                $startTime = date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($startTime))); ?>
                <?= DateTimePicker::widget([
                'name' => 'input-event-start',
                'type' => DateTimePicker::TYPE_INPUT,
                'value' => $startTime,
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
                <?php $endTime = $events['end'];
                $endTime = date('Y-m-d H:i:s',strtotime('+4 hour',strtotime($endTime))); ?>
                <?= DateTimePicker::widget([
                'name' => 'input-event-end',
                'type' => DateTimePicker::TYPE_INPUT,
                'value' => $endTime,
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

                  <?php if($consultant>0){
                          foreach($consultant as $conslt):
                          if (in_array($conslt->consultant_id, $checked_consultant)){ ?>
                          <input type="checkbox" checked="checked" class="ids_consultant" name="consultant_id[]" value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_consultant" name="consultant_id[]" value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                          <?php } ?>
                                          
                          <?= $conslt->first_name.' '.$conslt->last_name; ?><br>
                          <?php endforeach; 
                        } if($trainees>0){
                          foreach($trainees as $traine):
                          if (in_array($traine->partner_login_id, $checked_trainer)){ ?>  
                          <input type="checkbox" checked="checked" class="ids_trainer" name="trainer_id[]" value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_trainer" name="trainer_id[]" value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                          <?php } ?>
                          <?= $traine->first_name.' '.$traine->last_name; ?><br>
                          <?php endforeach; 
                        } if($employees>0){
                          foreach($employees as $employee):
                          if (in_array($employee->partner_login_id, $checked_employee)){ ?>
                          <input type="checkbox" checked="checked" class="ids_employee" name="employee_id[]" value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_employee" name="employee_id[]" value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                          <?php } ?>
                          <?= $employee->first_name.' '.$employee->last_name; ?><br>
                          <?php endforeach; 
                  } ?>
                  </div>
              </div>
              </div>



            <div class="col-sm-4">
              <div class="form-group " id="mode-container">
                <label for="input-event-mode">Mode of Meeting</label>
                <select class="form-control" id="input-event-mode" placeholder="Mode of Meeting ">
                  <?php foreach($mode as $key=>$type): ?>
                  <option value="<?= $key; ?>" <?php if($key == $events->mode){ ?> selected="selected" <?php } ?> >
                  <?= $type; ?>
                  </option>
                  <?php endforeach; ?>
                </select>
              </div>
              </div>  

          <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-remarks">Remarks</label>
                <textarea type="text" class="form-control" id="input-event-remarks" placeholder="Remarks" rows="4"><?= $events->remarks; ?></textarea>
              </div>
              </div>
          <div class="col-sm-12">
              <div class="form-group">
                <label for="input-event-alerts">Alerts</label>
                <select class="form-control" id="input-event-alerts" placeholder="Mode of Meeting ">
                  <option value="0" <?php if($events->alert == 1){ ?> selected="selected" <?php } ?>>--Select--</option>
                  <option value="1" <?php if($events->alert == 1){ ?> selected="selected" <?php } ?>>15 Minutes before</option>
                  <option value="2" <?php if($events->alert == 2){ ?> selected="selected" <?php } ?>>30 Minutes before</option>
                  <option value="3" <?php if($events->alert == 3){ ?> selected="selected" <?php } ?>>1 Hour before</option>
                  <option value="4" <?php if($events->alert == 4){ ?> selected="selected" <?php } ?>>1 Day before</option>
                  <option value="5" <?php if($events->alert == 5){ ?> selected="selected" <?php } ?>>2 Days before</option>
                </select>
              </div>
              </div>    
          <div class="col-sm-12">
              <div class="form-group">
                <button type="button" class="btn btn-success btn-event-add hidden" onclick="onBtnEventAddClick();">Add</button>
                <button type="button" class="btn btn-success btn-event-form-update" onclick="onBtnEventFormUpdateClick();">Update</button>
              </div>
              </div>
              </div>
            </form>
<?php }/*if($consultant>0){
                          foreach($consultant as $conslt):
                          if (in_array($conslt->consultant_id, $checked_consultant)){ ?>
                          <input type="checkbox" checked="checked" class="ids_consultant" name="consultant_id[]" value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_consultant" name="consultant_id[]" value="<?= $conslt->consultant_id ?>" role="<?= Roles::ROLE_CONSULTANT ?>">
                          <?php } ?>
                                          
                          <?= $conslt->first_name.' '.$conslt->last_name; ?><br>
                          <?php endforeach; 
} if($trainees>0){
                          foreach($trainees as $traine):
                          if (in_array($traine->partner_login_id, $checked_trainer)){ ?>  
                          <input type="checkbox" checked="checked" class="ids_trainer" name="trainer_id[]" value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_trainer" name="trainer_id[]" value="<?= $traine->partner_login_id ?>" role="<?= Roles::ROLE_TRAINER ?>">
                          <?php } ?>
                          <?= $traine->first_name.' '.$traine->last_name; ?><br>
                          <?php endforeach; 
} if($employees>0){
                          foreach($employees as $employee):
                          if (in_array($employee->partner_login_id, $checked_employee)){ ?>
                          <input type="checkbox" checked="checked" class="ids_employee" name="employee_id[]" value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_employee" name="employee_id[]" value="<?= $employee->partner_login_id ?>" role="<?= Roles::ROLE_EMPLOYEE ?>">
                          <?php } ?>
                          <?= $employee->first_name.' '.$employee->last_name; ?><br>
                          <?php endforeach; 
                  }
}*/ ?>
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

      $("#cl_close").click(function() {
      $(".cal-popup").removeClass("open");
      $("body").removeClass("open-cal-popup");
          $(".popup-closer").removeClass("active");
      });
      $("#app_with").click(function() {
      $("#invities_list").toggle();
      });
      
    });
    </script>