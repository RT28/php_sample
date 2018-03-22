<?php
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\PartnerEmployee;
use common\models\StudentPartneremployeeRelation; 
$status = PartnerEmployee::Status();   
?> 
<div>
   
<!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connect-employees">
Connect Associates
</button> -->

    <table class="table table-bordered">
        <th>Trainer/Employee Name</th> 
        <th>Experience (Yrs)</th>
		<th>Work Status</th>
		<th>Assign By</th>
		<th>Start Date </th>
		<th>End Date </th>
       <th>Actions</th> 
        <?php foreach($employees as $employee): 
		 
		$trainer = PartnerEmployee::find()->where(['=', 'partner_login_id', $employee->parent_employee_id])->one();
		$AssignBy = PartnerEmployee::find()->where(['=', 'partner_login_id', $employee->parent_employee_id])->one();
 ?>
	<tr>

	<td><?= $trainer->first_name . " ". $trainer->last_name; ?></td>
	<td><?= $trainer->experience_years; ?> Years <?= $trainer->experience_months; ?> Months</td>
	<td><?= $status[$employee->assigned_work_status]; ?></td>
	<td><?php echo Yii::$app->formatter->asDate($employee->start_date, 'dd-MM-yyyy'); ?></td>
 	<td><?php echo Yii::$app->formatter->asDate($employee->end_date, 'dd-MM-yyyy'); ?></td>
 	<td><?= $AssignBy->first_name . " ". $AssignBy->last_name; ?></td> 
	<td><a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
	data-target="#employeeUpdateModal" onclick="loadEmployeeUpdate(<?= $employee->id; ?>)" ></a>
	</td>
 
	</tr>
        <?php endforeach;?>
    </table>
</div>
 
<?php
    $this->registerJsFile('js/employees.js');
?>
<div id="employeeUpdateModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="employeeUpdate" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div> 