<?php
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Consultant;
use common\models\StudentConsultantRelation; 
$status = Consultant::Status();  
?>
 
<div>
    

    <table class="table table-bordered">
        <th>Associate Consultant</th> 
        <th>Experience (Yrs)</th>
		<th>Work Status</th>
		<th>Assign By</th>
		<th>Start Date </th>
		<th>End Date </th>
        <th>Actions</th> 
	    <th>Connect/Disconnect</th>
        <?php   
		foreach($associates as $associate): 
		 
		$consultant = Consultant::find()->where(['=', 'consultant_id', $associate->consultant_id])->one();
		$AssignBy = Consultant::find()->where(['=', 'consultant_id', $associate->parent_consultant_id])->one();
 ?>
	<tr>

	<td><?= $consultant->first_name . " ". $consultant->last_name; ?></td>
	<td><?= $consultant->experience_years; ?> Years <?= $consultant->experience_months; ?> Months</td>
	<td><?= $status[$associate->assigned_work_status]; ?></td>
	<td><?= $AssignBy->first_name . " ". $AssignBy->last_name; ?></td> 
	<td><?php echo Yii::$app->formatter->asDate($associate->start_date, 'dd-MM-yyyy'); ?></td>
 	<td><?php echo Yii::$app->formatter->asDate($associate->end_date, 'dd-MM-yyyy'); ?></td>
 	
	<td><a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
	data-target="#subconsultantUpdateModal" onclick="loadSubConUpdate(<?= $associate->id; ?>)" ></a>
	</td>
	 <td>
	 <?php if($associate->status ==1){  
		
		$class = ' btn-success ';
		$textstatus = 'Connected';
	  }  
	  if($associate->status ==0){  
	    $class = ' btn-danger ';
		$textstatus = 'Disconnected';
	   }
	   ?>
		<button  id="status" class="btn  btn-associate-status <?php echo  $class;?> " onclick="connectDisconnectAssociate(<?= $associate->consultant_id; ?>,<?= $associate->student_id; ?>);" value="<?= $associate->status; ?>">
		<?php echo $textstatus;?>
		</button> 
	  
	  
	</td> 
	</tr>
        <?php endforeach;?>
    </table>
</div>
 
<?php
    $this->registerJsFile('js/associates.js');
?>
<div id="subconsultantUpdateModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="subconsultantUpdate" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div> 