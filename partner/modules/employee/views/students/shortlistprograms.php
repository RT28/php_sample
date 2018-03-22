<?php
use yii\helpers\Html; 
use yii\widgets\ActiveForm;  
use kartik\select2\Select2; 

?>
<?php $form = ActiveForm::begin( ); ?>
<div class="row">
<div class="col-xs-12">
<div class="panel panel-default"> 

<div class="modal-body">
<div style="color:red" id="message_display"></div> 
<input type="hidden" id="pcurrentrowid" value="0" /> 
<table class="table table-bordered" id="course-form">
	<tbody>
		<tr>
			<th>University</th>
			<th>Degree Level</th> 
			<th>Programs</th> 
		</tr> 
	</tbody> 
</table>
<button type="button" class="btn btn-blue" onclick="onAddCourseClick('course-form')">
<span class="glyphicon glyphicon-plus"></button>
</div>
</div>
</div>
</div>
     <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>