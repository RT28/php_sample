<?php
    use yii\helpers\Html;                
    use dosamigos\ckeditor\CKEditor;
?>

<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic', 
        ])->label('About Us'); ?>
    </div>
    <div class="col-xs-12">
        <?= $form->field($model, 'achievements')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
    </div>
	 <div class="col-xs-12">
        <?= $form->field($model, 'application_requirement')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Application Requirements') ?>
    </div>
	 <div class="col-xs-12">
        <?= $form->field($model, 'fees')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
    </div>
	 <div class="col-xs-12">
        <?= $form->field($model, 'deadlines')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
    </div>
	
	 <div class="col-xs-12">
        <?= $form->field($model, 'cost_of_living_text')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Cost of Living')  ?>
    </div>
	
	 <div class="col-xs-12">
        <?= $form->field($model, 'accommodation')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Accommodation')  ?>
    </div>
</div>