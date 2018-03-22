<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Faq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-form">
    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Faqs</div>
                    <div class="panel-body">

                        <?= $form->field($model, 'category_id')->dropDownList($faqCategory, ['prompt' => 'Select Faq Type...']) ?>

    					<?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    					
                        <?= $form->field($model, 'answer')->widget(CKEditor::className(), [
                            'options' => ['rows' => 10],
                            'preset' => 'basic'
                        ]) ?>

                    <div class="form-group">
				        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
