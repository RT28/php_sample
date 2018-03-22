<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ConsultantEnquiry;
$status  = ConsultantEnquiry::status();  

 
use yii\helpers\ArrayHelper;  

/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */

$this->title = $model->first_name.' '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Consultants Enquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name.' '.$model->last_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';

 
?>
<div class="general-enquiry-update">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-5">
<h1><?= Html::encode($this->title) ?></h1> 

<?php $form = ActiveForm::begin(); ?>
<?= Html::hiddenInput('id' ,$model->id); ?>

<?= $form->field($model, "status")->dropDownList($status,['prompt' => 'Select Status','onchange'=>'status(this.value)']) ?> 
<?= $form->field($model, 'comment')->textarea(['rows' => 6]);?> 


<div class="optionDiv" id="replyDiv" <?php if($model->status!=2){ ?>style="display: none;" <?php } ?>>

<?= $form->field($model, 'reply')->textarea(['rows' => 6]);?> 

</div>


<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>

</div>
</div>
</div>


<script type="text/javascript">
function status(val){
$('.optionDiv').hide();
if (val == 2) {
$('#replyDiv').show();

} else {
$('#replyDiv').hide();
}
} 
</script>