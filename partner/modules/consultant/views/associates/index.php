<?php
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Consultant;
use common\models\StudentConsultantRelation; 
$status = Consultant::Status(); 

$this->context->layout = 'main'; 
?>
 
<div>
    
   <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connect-associates">
        Connect Associates
    </button> -->
    <table class="table table-bordered">
        <th>Associate Consultant</th> 
        <th>Experience (Yrs)</th>  
        <?php   
		foreach($associates as $associate): 
		 
		$consultant = Consultant::find()->where(['=', 'consultant_id', $associate->consultant_id])->one();
		$AssignBy = Consultant::find()->where(['=', 'consultant_id', $associate->parent_consultant_id])->one();
 ?>
	<tr>

	<td><?= $consultant->first_name . " ". $consultant->last_name; ?></td>
	<td><?= $consultant->experience_years; ?> Years <?= $consultant->experience_months; ?> Months</td> 
	 
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