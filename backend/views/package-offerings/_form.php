<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\PackageOfferings */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
    $initialPreview = [];
    $preview = [];
    $path = '';
    if (is_dir("./../web/package-offerings-uploads/$model->id")) {
        $path = FileHelper::findFiles("./../web/package-offerings-uploads/$model->id", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['icon.*']
        ]);
    
        if (count($path) > 0) {
            array_push($preview, Html::img($path[0]));
            array_push($initialPreview, [
                'caption' => basename($path[0]),
                'url' => Url::to(['/package-offerings/delete-photo']),
                'key'=> basename($path[0])
            ]);
        }
    }
?>

<!--<div class="package-offerings-form col-xs-12 col-sm-6">-->
<div class="package-offerings-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Package Offerings</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                            'options' => ['rows' => 10],
                            'preset' => 'basic'
                        ]) ?>
                        <?= $form->field($model, 'time')->textInput(['type' => 'number']) ?>
                        <?= $form->field($model, 'status')->dropdownList($status, ['prompt' => 'Select...']) ?>
                        <?= FileInput::widget([
                            'name' => 'icon',
                            'pluginOptions' => [
                                'deleteUrl' => Url::to(['/package-offerings/delete-photo']),
                                'intialPreviewAsData' => true,
                                'deleteExtraData' => [
                                    'service_id' => $model->id
                                ],
                                'initialPreviewConfig' => $initialPreview,
                                'initialPreview' => $preview
                            ]
                        ]);?>
                    </div>
                </div>
            </div>            
        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
