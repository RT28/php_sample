<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $initialPreview = [];
    $preview = [];
    $path = '';
    if (is_dir("./../web/services-uploads/$model->id")) {
        $path = FileHelper::findFiles("./../web/services-uploads/$model->id", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['icon.*']
        ]);
    
        if (count($path) > 0) {
            array_push($preview, Html::img($path[0]));
            array_push($initialPreview, [
                'caption' => basename($path[0]),
                'url' => Url::to(['/services/delete-photo']),
                'key'=> basename($path[0])
            ]);
        }
    }
?>

<div class="services-form col-xs-12">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 50,'column' => 50],
        'preset' => 'full'
    ]) ?>

    <?= $form->field($model, 'name_fa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description_fa')->widget(CKEditor::className(), [
        'options' => ['rows' => 50,'column' => 50],
        'preset' => 'full'
    ]) ?>

    <?= $form->field($model, 'rank')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'active')->dropdownList($statusList, ['prompt' => 'Select Status...']) ?>

    <?= FileInput::widget([
        'name' => 'icon',
        'options'=>[
            'multiple'=>true
        ],
        'pluginOptions' => [
            'deleteUrl' => Url::to(['/services/delete-photo']),
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
