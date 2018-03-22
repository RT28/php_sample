<?php
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
 
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

	<td><?= $meeting->event_type; ?></td>  
	<td><?= $meeting->appointment_status; ?></td>  
	<td><?= $meeting->title; ?></td> 
	<td><?= $meeting->remarks; ?></td>
	<td><?php echo Yii::$app->formatter->asDate($meeting->start, 'dd-MM-yyyy'); ?></td>
	<td><?php echo Yii::$app->formatter->asDate($meeting->end, 'dd-MM-yyyy'); ?></td>
	<td><?php echo Yii::$app->formatter->asTime($meeting->time_stamp); ?></td>
    
	</tr>
        <?php endforeach;?>
    </table>
</div>
 
 