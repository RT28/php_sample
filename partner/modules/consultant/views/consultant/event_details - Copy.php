<?php
use frontend\models\UserLogin;
use common\components\Roles;
use common\models\PartnerEmployee;
use common\models\User;
use common\models\Consultant;
if(!empty($events->location)){
  $location = $events->location;
} else { $location = '--'; }
if($events->mode ==0 ){
  $mode = '--';
} else if($events->mode ==1 ){
  $mode = 'Telephone';
} else if($events->mode ==2 ){
  $mode = 'Face to face';
} else if($events->mode ==3 ){
  $mode = 'Videocall';
} else if($events->mode ==4 ){
  $mode = 'Others';
}
if(!empty($events->remarks)){
  $remarks = $events->remarks;
} else { $remarks = '--'; }

$consultant_id = Yii::$app->user->identity->id;
$students = User::find()
        ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.Yii::$app->user->identity->id.'')
        ->all();
$consultant = Consultant::find()->all();

$trainees = PartnerEmployee::find()->all();

$employees = PartnerEmployee::find()->all();

$checked_consultant = explode(',', $events->consultant_ids);
$checked_trainer = explode(',', $events->trainer_ids);
$checked_employee = explode(',', $events->employee_ids);
$checked_students = explode(',', $events->student_ids);
?>
<p id="event-id" class="hidden" value="<?= $events->id; ?>"></p>
            <p id="event-appointment-with" class="hidden" role=""></p>
            <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-title">Title</label>
              <p id="event-title"><?= $events->title; ?></p>
            </div>
            </div>

        <div class="col-sm-6">
            <div class="form-group">
              <label for="event-location">Location</label>
              <p id="event-location"><?= $location; ?></p>
            </div>
            </div>    

          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-start">Start</label>
              <p id="event-start"><?php $startTime = $events['start'];
              $startTime = date('d-M-Y H:i:a',strtotime('+4 hour',strtotime($startTime))); echo $startTime; ?></p>
            </div>
            </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-end">End</label>
              <p id="event-end"><?php $endTime = $events['end'];
              $endTime = date('d-M-Y H:i:a',strtotime('+4 hour',strtotime($endTime))); echo $endTime; ?></p>
            </div>
            </div>

          <div class="col-sm-6">
            <div id="event-mode-container" class="form-group">
              <label for="event-mode">Mode of Meeting</label>
              <p id="event-mode"><?= $mode; ?></p>
            </div>
            </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-remarks">Remarks</label>
              <p id="event-remarks"><?= $remarks; ?></p>
            </div>
            </div> 
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-createdby">Created By</label>
              <p id="event-createdby">
                <?php
                  $role = $events['created_by_role'];
                  $created_by = $events['created_by'];
                  $owner = '';
                    if($role == Roles::ROLE_STUDENT){
                    $owner = User::find()->where(['=', 'id', $created_by])->one();
                    $owner =  $owner->first_name. " " .$owner->last_name;
                    } else if($role == Roles::ROLE_CONSULTANT){
                    $owner = Consultant::find()->where(['=', 'partner_login_id', $created_by])->one();
                    $owner =  $owner->first_name. " " .$owner->last_name;
                    } else {
                    $owner = PartnerEmployee::find()->where(['=', 'partner_login_id', $created_by])->one();
                    $owner =  $owner->first_name. " " .$owner->last_name;
                    } ?>
                <?php echo $owner; ?>
              </p>
            </div>
            </div>    
          <div class="col-sm-6">
            <div class="form-group">
              <label for="event-type">Invities</label>
              <p id="event-type">
                <?php
                if($consultant>0){ 
                                    foreach($consultant as $conslt):
                                    if (in_array($conslt->consultant_id, $checked_consultant)){ 
                                    echo $conslt->first_name.' '.$conslt->last_name.',';
                                    } endforeach; 
                  } if($trainees>0){
                                    foreach($trainees as $traine):
                                    if (in_array($traine->partner_login_id, $checked_trainer)){  
                                    echo $traine->first_name.' '.$traine->last_name.',';
                                    } endforeach; 
                  } if($employees>0){
                                    foreach($employees as $employee):
                                    if (in_array($employee->partner_login_id, $checked_employee)){
                                    echo $employee->first_name.' '.$employee->last_name.',';
                                    } endforeach; 
                  }
                  if($students>0){ 
                                    foreach($students as $student):
                                    if (in_array($student->id, $checked_students)){ 
                                    echo $student->first_name.' '.$student->last_name.',';
                                    } endforeach; 
                  }
                ?>
              </p>
            </div>
            </div>
          <?php if($events['created_by']==$consultant_id AND $events['created_by_role']==Roles::ROLE_CONSULTANT){ ?>
            <div class="col-sm-12">
            <button type="button" class="btn btn-primary btn-event-update btn-upd" onclick="onBtnEventUpdateClick('<?= $events->id; ?>');">Update</button>
            <button type="button" class="btn btn-danger btn-event-delete btn-upd" onclick="onBtnEventDeleteClick('<?= $events->id; ?>');">Delete</button>
            </div>
          <?php } ?>  
          </div>