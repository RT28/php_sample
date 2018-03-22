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
</div>