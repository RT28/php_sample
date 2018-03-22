<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper; 
use common\components\AdmissionWorkflow;
/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Change Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'profile';


$status = AdmissionWorkflow::getStates();
?>
<div class="university-enquiry-update">  

		<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
     
	
	    <?php $form = ActiveForm::begin(); ?>
 <?= Html::hiddenInput('id' ,$model->id); ?>
   
	  <?= $form->field($model, "status")->dropDownList($status) ?> 
	<?= $form->field($model, 'remarks')->textarea(['rows' => 6]);?> 
	
 
     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
 