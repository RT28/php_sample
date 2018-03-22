<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TestCategory;
use common\models\TestSubject;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\StandardTests */
/* @var $form yii\widgets\ActiveForm */
$tests = ArrayHelper::map(TestCategory::find()->asArray()->all(),'id','name');
$subjects = ArrayHelper::map(TestSubject::find()->asArray()->all(),'id','name');
?>

<div class="standard-tests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'test_category_id')->dropdownlist($tests,['prompt'=>'Select an category'])?>

	<?= $form->field($model, 'test_subject_id')->widget(Select2::classname(), [
            'data' => $subjects,
            'value' => '',
            'options' => ['multiple' => true, 'placeholder' => 'Select Subjects ...']
            ]);
    ?>
	  
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
