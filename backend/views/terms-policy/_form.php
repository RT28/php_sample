<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\TermsPolicy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terms-policy-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'terms')->widget(CKEditor::className(), [
        'options' => ['rows' => 50,'column' => 50],
        'preset' => 'full'
    ]) ?>
    <?= $form->field($model, 'policy')->widget(CKEditor::className(), [
        'options' => ['rows' => 50,'column' => 50],
        'preset' => 'full'
    ]) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
