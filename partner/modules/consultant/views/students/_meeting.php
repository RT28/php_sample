<?php
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\components\CalendarEvents;
$Status = CalendarEvents::getEventStatus();
$MeetingType = CalendarEvents::getMeetingType(); 
?>
 
<div>
    
   <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connect-associates">
        Connect Associates
    </button> -->
    <table class="table table-bordered">
        <th>Event Type</th> 
        <th>Appointment Status</th>
		<th>Title</th>
		<th>Remarks</th>
		<th>Start Date </th>
		<th>End Date </th>
       <th>Time</th> 
	<?php   
	foreach($meetings as $meeting): 

	?>
	<tr>

	<td><?= $MeetingType[$meeting->meetingtype] ?></td>  
	<td><?= $Status[$meeting->appointment_status]; ?></td>  
	<td><?= $meeting->title; ?></td> 
	<td><?= $meeting->remarks; ?></td>
	<td><?php echo Yii::$app->formatter->asDate($meeting->start, 'dd-MM-yyyy'); ?></td>
	<td><?php echo Yii::$app->formatter->asDate($meeting->end, 'dd-MM-yyyy'); ?></td>
	<td><?php echo Yii::$app->formatter->asTime($meeting->time_stamp); ?></td>
    
	</tr>
        <?php endforeach;?>
    </table>
</div>
 
 