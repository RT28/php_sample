<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
$this->context->layout = 'profile';

/**
 * var @standardTests array of students school details
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'standard-test-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::a('View', ['standard-tests'], ['class' => 'btn btn-primary']) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Standard Test Details</h4>
        </div>
        <div class="panel-body">
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
            ]); ?>

                <table class="table table-bordered tests-container-items"><!-- widgetContainer -->
                    <?php foreach ($standardTests as $i => $standardTests): ?>
                        <tr class="test-item panel panel-default"><!-- widgetBody -->
                            <td>
                                <button type="button" class="remove-test btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </td>
                            <?php
                                // necessary for update action.
                                if (! $standardTests->isNewRecord) {
                                    echo Html::activeHiddenInput($standardTests, "[{$i}]id");
                                }
                            ?>
                            <td>
                                <?= $form->field($standardTests, "[{$i}]test_name")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($standardTests, "[{$i}]verbal_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($standardTests, "[{$i}]quantitative_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($standardTests, "[{$i}]integrated_reasoning_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($standardTests, "[{$i}]data_interpretation_score")->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
            <button type="button" class="add-test btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>