<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
$this->context->layout = 'profile';
/**
 * var @subjects array of subjects taken by student
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'subject-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::a('View', ['subject-details'], ['class' => 'btn btn-primary']) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Subject Details</h4>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_student_subject', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.subject-container-items', // required: css class selector
                    'widgetItem' => '.subject-item', // required: css class
                    'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-subject', // css class
                    'deleteButton' => '.remove-subject', // css class
                    'model' => $subjects[0],
                    'formId' => 'subject-details-form',
                    'formFields' => [
                        'name',
                        'from_date',
                        'to_date',
                        'curriculum',
                    ],
                ]);
            ?>
            <table class="table table-bordered subject-container-items"><!-- widgetContainer -->
                <?php foreach ($subjects as $i => $subjects): ?>
                    <tr class="subject-item panel panel-default"><!-- widgetBody -->
                        <td>
                            <button type="button" class="remove-subject btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                        <?php
                            // necessary for update action.
                            if (! $subjects->isNewRecord) {
                                echo Html::activeHiddenInput($subjects, "[{$i}]id");
                            }
                        ?>
                        <td>
                            <?= $form->field($subjects, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                        </td>
                        <td>
                            <?= $form->field($subjects, "[{$i}]maximum_marks")->textInput(['maxlength' => true]) ?>
                        </td>
                        <td>
                            <?= $form->field($subjects, "[{$i}]marks_obtained")->textInput(['maxlength' => true]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
           </table>
           <button type="button" class="add-subject btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>