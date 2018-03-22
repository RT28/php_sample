<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Articles */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $initialPreview = [];
    $preview = [];
    $path = '';
    if (is_dir("./../web/articles-uploads/$model->id")) {
        $path = FileHelper::findFiles("./../web/articles-uploads/$model->id", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['icon.*']
        ]);
    
        if (count($path) > 0) {
            array_push($preview, Html::img($path[0]));
            array_push($initialPreview, [
                'caption' => basename($path[0]),
                'url' => Url::to(['/articles/delete-photo']),
                'key'=> basename($path[0])
            ]);
        }
    }
?>

<div class="services-form col-xs-6">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 50,'column' => 50],
        'preset' => 'full'
    ]) ?>
    
    <?= $form->field($model, 'view_duration')->textInput(['maxlength' => true])->label('Reading Duration in Minutes') ?>  

    <?= $form->field($model, 'active')->dropdownList($statusList, ['prompt' => 'Select Status...']) ?>

    <?= FileInput::widget([
        'name' => 'icon',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::to(['/articles/delete-photo']),
            'intialPreviewAsData' => true,
            'deleteExtraData' => [
                'service_id' => $model->id
            ],
            'initialPreviewConfig' => $initialPreview,
            'initialPreview' => $preview
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
