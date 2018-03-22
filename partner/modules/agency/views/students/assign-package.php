<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
$this->context->layout = 'main';
$this->title = 'Assign Package to Student';
?>
 
 <div class="consultant-dashboard-index col-sm-6">
 
 <?php 
	if(isset($status)) {
		if ($status === 'success') {
			echo '<div class="alert alert-success" role="alert">';
				echo 'Dashboard access has been sent.';
			echo '</div>';
		}
		elseif($status === 'error') {
			echo '<div class="alert alert-danger" role="alert">';
				echo $error;
			echo '</div>';
		}
		if(isset($id) && isset($email)) {
			echo Html::a('Resend Activation Link', ['resend-activation-link', 'id' => $id, 'email' => $email], ['class' => 'btn btn-primary']);
		}
	}
?>

<?php $form = ActiveForm::begin() ?> 
 
	<?= $form->field($StudentAssignPackages, 'packagestype')->dropDownList($packages, ['prompt' => 'Select...']); ?>

	<?= $form->field($model, 'comment')->textArea(['rows' => 4]) ?>
	<div class="form-group">
	<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'id' => 'btn-submit']) ?>
	</div>
<?php ActiveForm::end(); ?>
</div>