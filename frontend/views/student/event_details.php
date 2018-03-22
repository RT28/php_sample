<?php
use frontend\models\UserLogin;
use common\models\Consultant;
use common\components\Roles;
use common\models\PartnerEmployee;
use common\models\User;
use common\models\ConsultantCalendar;
use frontend\models\StudentCalendar; 

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

$student_id = Yii::$app->user->identity->id;
$students = User::find()->all();
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
                                $e_status = ConsultantCalendar::find()
                                ->where('consultant_id = '.$conslt->consultant_id)
                                ->andWhere('student_appointment_id = '.$events['id'])
                                ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
                                ->one();
                                $status_text = '';
                                if($e_status->status==0){
                                $status_text = 'Pending'; 
                                } else if($e_status->status==1){
                                $status_text = 'Accepted';   
                                } else if($e_status->status==2){
                                $status_text = 'Declined';   
                                }  
                        echo $conslt->first_name.' '.$conslt->last_name.'-<b>'.$status_text.'</b><br>';
                          } endforeach; 
                  } if($trainees>0){
                                foreach($trainees as $traine):
                                if (in_array($traine->partner_login_id, $checked_trainer)){ 
                                $e_status = ConsultantCalendar::find()
                                ->where('consultant_id = '.$traine->partner_login_id)
                                ->andWhere('student_appointment_id = '.$events['id'])
                                ->andWhere('role_id = '.Roles::ROLE_TRAINER)
                                ->one();
                                $status_text = '';
                                if($e_status->status==0){
                                $status_text = 'Pending'; 
                                } else if($e_status->status==1){
                                $status_text = 'Accepted';   
                                } else if($e_status->status==2){
                                $status_text = 'Declined';   
                                }   
                      echo $traine->first_name.' '.$traine->last_name.'-<b>'.$status_text.'</b><br>';
                      } endforeach; 
                  } if($employees>0){
                                foreach($employees as $employee):
                                if (in_array($employee->partner_login_id, $checked_employee)){
                                $e_status = ConsultantCalendar::find()
                                ->where('consultant_id = '.$employee->partner_login_id)
                                ->andWhere('student_appointment_id = '.$events['id'])
                                ->andWhere('role_id = '.Roles::ROLE_EMPLOYEE)
                                ->one();
                                $status_text = '';
                                if($e_status->status==0){
                                $status_text = 'Pending'; 
                                } else if($e_status->status==1){
                                $status_text = 'Accepted';   
                                } else if($e_status->status==2){
                                $status_text = 'Declined';   
                                }   
                      echo $employee->first_name.' '.$employee->last_name.'-<b>'.$status_text.'</b><br>';
                      } endforeach; 
                  } if($students>0){ 
                                foreach($students as $student):
                                if (in_array($student->id, $checked_students)){
                                $e_status = StudentCalendar::find()
                                ->where('student_id = '.$student->id)
                                ->andWhere('consultant_appointment_id = '.$events['consultant_appointment_id'])
                                ->andWhere('role_id = '.Roles::ROLE_STUDENT)
                                ->one();
                                $status_text = '';
                                if($e_status->status==0){
                                $status_text = 'Pending'; 
                                } else if($e_status->status==1){
                                $status_text = 'Accepted';   
                                } else if($e_status->status==2){
                                $status_text = 'Declined';   
                                }   
                      echo $student->first_name.' '.$student->last_name.'-<b>'.$status_text.'</b><br>';  
                      } endforeach; 
                  }
                ?>
              </p>
            </div>
            </div>
          <!-- <div class="col-sm-6">
            <div id="event-status-container" class="form-group hidden">
              <label for="event-status">Status</label>
              <p id="event-status"></p>
            </div>
            </div> -->
        <?php if($events['created_by']==$student_id AND $events['created_by_role']==Roles::ROLE_STUDENT){ ?>
          <div class="col-sm-12">
            <button type="button" class="btn btn-primary btn-event-update btn-upd" onclick="onBtnEventUpdateClick('<?= $events->id; ?>');">Update</button>
            <button type="button" class="btn btn-danger btn-event-delete btn-upd" onclick="onBtnEventDeleteClick('<?= $events->id; ?>');">Delete</button>
            </div>
          <?php } else if($event['created_by']!==$student_id AND $event['created_by_role']!==Roles::ROLE_STUDENT){ ?>
            <div>
            <?php if($events->status==0){ $evclass_acc= ''; $evclass_rej= ''; ?>
            <?php } else if($events->status==1){ $evclass_acc= 'hidden'; $evclass_rej= ''; ?>
            <?php } else if($events->status==2){ $evclass_acc= ''; $evclass_rej= 'hidden'; ?>
            <?php } ?>
            <button class="<?php echo $evclass_acc; ?> btn btn-success" onclick="changeEventStatus(1,'<?php echo $events['id']; ?>')" id="btn_e_accept<?php echo $events['id']; ?>">Accept</button>
            <button class="<?php echo $evclass_rej; ?> btn btn-success" id="btn_e_reject<?php echo $events['id']; ?>" onclick="changeEventStatus(2,'<?php echo $events['id']; ?>')">Reject</button>
           </div>
          <?php } ?>

          </div>