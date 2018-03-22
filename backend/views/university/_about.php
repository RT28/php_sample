<?php
    use yii\helpers\Html;                
    use dosamigos\ckeditor\CKEditor;
?>

<div class="row">
    <div class="col-xs-12">
        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
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
        <?= $form->field($model, 'bachelor_requirement')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Bachelor Requirements') ?>
    </div>
    <div class="col-xs-12">
        <?= $form->field($model, 'master_requirement')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Master Requirements') ?>
    </div>
    <div class="col-xs-12">
        <?= $form->field($model, 'foundation_requirement')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Foundation Requirements') ?>
    </div>
    <div class="col-xs-12">
        <?= $form->field($model, 'doctoral_requirement')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Doctoral Requirements') ?>
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
	 <div class="col-xs-12">
        <?= $form->field($model, 'success_stories')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ])->label('Success Stories')  ?>
    </div>
    <div class="col-xs-12">
    <?= $form->field($model, 'info_for_consultant')->textArea(['info_for_consultant' => true,'rows' => 20 ])->label('Information for consultant') ?>
        
    </div>
	<div class="col-xs-12">
	 <?= $form->field($model, 'application_web_link')->textInput(['maxlength' => true]) ?> 
    </div>
</div>