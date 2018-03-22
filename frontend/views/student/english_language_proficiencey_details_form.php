<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
if (isset($layout)) {
    $this->context->layout = $layout;
}

/**
 * var @englishProficiency array of english proficiency exams taken by student
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'english-prof-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-blue float-right']) ?>
        </div>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_student_proficiency', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.proficiency-container-items', // required: css class selector
                'widgetItem' => '.proficiency-item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-detail', // css class
                'deleteButton' => '.remove-detail', // css class
                'model' => $englishProficiency[0],
                'formId' => 'english-prof-details-form',
                'formFields' => [
                    'test_name',
                    'reading_score',
                    'writing_score',
                    'listening_score',
                    'speaking_score',
                ],
            ]);
        ?>
            <div class="row proficiency-container-items"><!-- widgetContainer -->
                <?php foreach ($englishProficiency as $i => $englishProficiency): ?>
                    <div class="proficiency-item col-xs-12"><!-- widgetBody -->
                        <button type="button" class="remove-detail btn btn-danger btn-xs col-xs-1"><i class="glyphicon glyphicon-minus"></i></button>
                        <?php
                            // necessary for update action.
                            if (! $englishProficiency->isNewRecord) {
                                echo Html::activeHiddenInput($englishProficiency, "[{$i}]id");
                            }
                        ?>
                        <div class="col-xs-11">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= $form->field($englishProficiency, "[{$i}]test_name")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($englishProficiency, "[{$i}]reading_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($englishProficiency, "[{$i}]writing_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($englishProficiency, "[{$i}]listening_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($englishProficiency, "[{$i}]speaking_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <?php if($i < sizeof($englishProficiency)): ?>
                            <hr style="clear: both;"/>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="add-detail btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>
