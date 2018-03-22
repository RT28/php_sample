<?php 
use common\models\User;
use common\components\Roles;
use kartik\datetime\DateTimePicker;
use common\components\CalendarEvents;

$mode = CalendarEvents::getMode();
if(!empty($events)){ 
$consultant_id = Yii::$app->user->identity->id;
$students = User::find()
        ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.Yii::$app->user->identity->id.'')
        ->all();

$checked_students = explode(',', $events->student_ids); ?>
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

                  <?php if($students>0){
                          foreach($students as $student):
                          if (in_array($student->id, $checked_students)){  ?>
                          <input type="checkbox" checked="checked" class="ids_students" name="student_id[]" value="<?= $student->id ?>" role="<?= Roles::ROLE_STUDENT ?>">
                          <?php } else { ?>
                          <input type="checkbox" class="ids_students" name="student_id[]" value="<?= $student->id ?>" role="<?= Roles::ROLE_STUDENT ?>">
                          <?php } ?>
                                          
                          <?= $student->first_name.' '.$student->last_name; ?><br>
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
<?php } ?>
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