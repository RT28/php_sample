<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile';
$this->context->layout = 'profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 
?>

 <div class="student-profile-main">
    <?= $this->render('_student_common_details');
    ?>
    <div class="dashboard-detail">
	
	<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'school-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>    
   
    <?= $form->field($userLogin, 'password_hash')->passwordInput(['value'=>'']) ?>
	<?= $form->field($userLogin, 'confirm_password')->passwordInput(['value'=>'']) ?>
	 	
    <div class="form-group">
        <?= Html::submitButton('Update Password', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
</div> 
</div>
</div>