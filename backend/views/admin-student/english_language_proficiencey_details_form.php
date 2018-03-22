<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
$this->context->layout = 'profile';

/**
 * var @englishProficiency array of english proficiency exams taken by student
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'english-prof-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::a('View', ['english-proficiency'], ['class' => 'btn btn-primary']) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>English Proficiency Details</h4>
        </div>
        <div class="panel-body">
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
                <table class="table table-bordered proficiency-container-items"><!-- widgetContainer -->
                    <?php foreach ($englishProficiency as $i => $englishProficiency): ?>
                        <tr class="proficiency-item panel panel-default"><!-- widgetBody -->
                            <td>
                                <button type="button" class="remove-detail btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </td>
                            <?php
                                // necessary for update action.
                                if (! $englishProficiency->isNewRecord) {
                                    echo Html::activeHiddenInput($englishProficiency, "[{$i}]id");
                                }
                            ?>
                            <td>
                                <?= $form->field($englishProficiency, "[{$i}]test_name")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($englishProficiency, "[{$i}]reading_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($englishProficiency, "[{$i}]writing_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($englishProficiency, "[{$i}]listening_score")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($englishProficiency, "[{$i}]speaking_score")->textInput(['maxlength' => true]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <button type="button" class="add-detail btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
