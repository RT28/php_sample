<?php
use common\models\Consultant;
use common\components\Roles;
use common\models\PartnerEmployee; 
use common\models\User;

if(!empty($events)){
$consultant_id = Yii::$app->user->identity->id;


 ?>
<div id="all_mtg">
<style>
#all_mtg table, th, td {
    border: 1px solid black;
}
</style>
<table style="width:100%">
  <tr>
    <th>Title</th>
    <th>Start Time</th> 
    <th>End Time</th>
    <th>Created by</th> 
    <th>Location</th>
    <th style="width: 18%;">Invities</th>
    <th>Actions</th>
  </tr>
  <?php
  foreach ($events as $key => $event) {
  $students = User::find()
        ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.Yii::$app->user->identity->id.'')
        ->all();
$consultant = Consultant::find()->all();

$trainees = PartnerEmployee::find()->all();

$employees = PartnerEmployee::find()->all();

$checked_consultant = explode(',', $event->consultant_ids);
$checked_trainer = explode(',', $event->trainer_ids);
$checked_employee = explode(',', $event->employee_ids);
$checked_students = explode(',', $event->student_ids); ?>
  <tr id="meeting_row<?php echo $event['id']; ?>">
    <td><?php echo $event['title']; ?></td>
    <td>
    <?php $startTime = $event['start'];
    $startTime = date('d-M-Y H:i:a',strtotime('+4 hour',strtotime($startTime))); echo $startTime; ?>
    </td>
    <td>
    <?php $endTime = $event['end'];
    $endTime = date('d-M-Y H:i:a',strtotime('+4 hour',strtotime($endTime))); echo $endTime; ?>
    </td>
    <td>
    <?php
      $role = $event['created_by_role'];
      $created_by = $event['created_by'];
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
    </td>
    <td><?php echo $event['location']; ?></td>
    <td>
      <?php
       $invities = array();

       if($consultant>0){ 
                                    foreach($consultant as $conslt):
                                    if (in_array($conslt->consultant_id, $checked_consultant)){ 
                                    array_push($invities, $conslt->first_name.' '.$conslt->last_name);
                                    } endforeach; 
                  } if($trainees>0){
                                    foreach($trainees as $traine):
                                    if (in_array($traine->partner_login_id, $checked_trainer)){
                                    array_push($invities, $traine->first_name.' '.$traine->last_name);  
                                    } endforeach; 
                  } if($employees>0){
                                    foreach($employees as $employee):
                                    if (in_array($employee->partner_login_id, $checked_employee)){
                                    array_push($invities, $employee->first_name.' '.$employee->last_name);
                                    } endforeach; 
                  }

       if($students>0){ 
                                    foreach($students as $student): 
                                    if (in_array($student->id, $checked_students)){
                                    array_push($invities, $student->first_name.' '.$student->last_name);
                                    } endforeach; 
          }
          $i = 0;
          $totalCount = count($invities);
          $someCounted = 1;

          for($i = 0; $i <= $someCounted; $i++){
           echo $invities[$i].'<br>';
          } ?>
          <?php if($totalCount > 2){ $moreCount = $totalCount - 2;
            echo 'and +'.$moreCount.' more';
          } ?>
    </td>
    <td>
    <a style="cursor: pointer;" onclick="editMeeting('<?php echo $event['id']; ?>');">View</a>
    <?php if($event['created_by']!==$consultant_id AND $event['created_by_role']!==Roles::ROLE_CONSULTANT){ ?>
        <div>
        <?php if($event->status==0){ $evclass_acc= ''; $evclass_rej= ''; ?>
        <?php } else if($event->status==1){ $evclass_acc= 'hidden'; $evclass_rej= ''; ?>
        <?php } else if($event->status==2){ $evclass_acc= ''; $evclass_rej= 'hidden'; ?>
        <?php } ?>
        <button class="<?php echo $evclass_acc; ?>" onclick="changeEventStatus(1,'<?php echo $event['id']; ?>')" id="btn_e_accept<?php echo $event['id']; ?>">Accept</button><br><br>
        <button class="<?php echo $evclass_rej; ?>" id="btn_e_reject<?php echo $event['id']; ?>" onclick="changeEventStatus(2,'<?php echo $event['id']; ?>')">Reject</button>
        </div>
    <?php } ?>
    </td>
  </tr>
  <?php } ?>
</table>
</div>

<?php } else { echo "No events created"; } ?>