<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor; 
use yii\helpers\ArrayHelper;
use common\models\TaskCategory;

/* @var $this yii\web\View */
/* @var $model common\models\TaskList */
/* @var $form yii\widgets\ActiveForm */
$tests = ArrayHelper::map(TaskCategory::find()->asArray()->all(),'id','name');
?>

<div class="task-list-form">

    <?php $form = ActiveForm::begin(); ?>

	
<div class="row">
<div class="col-sm-6" > 
<?= $form->field($model, 'task_category_id')->dropdownlist($tests,['prompt'=>'Select an category'])?>
</div>
<div class="col-sm-6"><br/>
<?= $form->field($model, 'auto_assign')->checkbox() ?>
</div>
</div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
 

 	<?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 5],
            'preset' => 'basic'
        ]) ?>
		
			<?= $form->field($model, 'how_to_complete')->widget(CKEditor::className(), [
            'options' => ['rows' => 5],
            'preset' => 'basic'
        ]) ?>
		
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
