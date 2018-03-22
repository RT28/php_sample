<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
 
/**
 * var @standardTests array of students school details
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'standard-test-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-xs-12">
      
 

        <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_student_tests', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.tests-container-items', // required: css class selector
                'widgetItem' => '.test-item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-test', // css class
                'deleteButton' => '.remove-test', // css class
                'model' => $standardTests[0],
                'formId' => 'standard-test-details-form',
                'formFields' => [
                    'name',
                    'from_date',
                    'to_date',
                    'curriculum',
                ],
            ]); 
        ?>
            <div class="row tests-container-items"><!-- widgetContainer -->
                <?php foreach ($standardTests as $i => $standardTests): ?>
                    <div class="test-item col-xs-12"><!-- widgetBody -->
                        <button type="button" class="remove-test btn btn-danger btn-xs col-xs-1"><i class="glyphicon glyphicon-minus"></i></button>
                        <?php
                            // necessary for update action.
                            if (! $standardTests->isNewRecord) {
                                echo Html::activeHiddenInput($standardTests, "[{$i}]id");
                            }
                        ?>
                        <div class="col-xs-11">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= $form->field($standardTests, "[{$i}]test_name")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($standardTests, "[{$i}]verbal_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($standardTests, "[{$i}]quantitative_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($standardTests, "[{$i}]integrated_reasoning_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?= $form->field($standardTests, "[{$i}]data_interpretation_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <?php if($i < sizeof($standardTests)): ?>
                            <hr style="clear: both;"/>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="add-test btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>