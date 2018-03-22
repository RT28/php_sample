<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
$this->context->layout = 'profile';

/**
 * var @schools array of students school details
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'college-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::a('View', ['college-details'], ['class' => 'btn btn-primary']) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>College Details</h4>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_student_college', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.college-container-items', // required: css class selector
                'widgetItem' => '.college-item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-college', // css class
                'deleteButton' => '.remove-college', // css class
                'model' => $colleges[0],
                'formId' => 'college-details-form',
                'formFields' => [
                    'name',
                    'from_date',
                    'to_date',
                    'curriculum',
                ],
            ]); ?>

            <table class="table table-bordered college-container-items"><!-- widgetContainer -->
                <?php foreach ($colleges as $i => $colleges): ?>
                    <tr class="college-item panel panel-default"><!-- widgetBody -->
                        <td class="panel-heading">
                            <button type="button" class="remove-college btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>                        
                        <?php
                            // necessary for update action.
                            if (! $colleges->isNewRecord) {
                                echo Html::activeHiddenInput($colleges, "[{$i}]id");
                            }
                        ?>
                        <td>
                            <?= $form->field($colleges, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                        </td>
                        <td>
                            <?= $form->field($colleges, "[{$i}]from_date")->widget(DatePicker::classname(),[
                                    'name' => 'from_date_picker',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'autoClose' => true,
                                        'format' => 'yyyy'
                                    ]
                                ]);
                            ?>
                        </td>
                        <td>
                            <?= $form->field($colleges, "[{$i}]to_date")->widget(DatePicker::classname(),[
                                    'name' => 'from_date_picker',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'autoClose' => true,
                                        'format' => 'yyyy'
                                    ]
                                ]);
                            ?>
                        </td>
                        <td>
                            <?= $form->field($colleges, "[{$i}]curriculum")->textInput(['maxlength' => true]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
           </table>
           <button type="button" class="add-college btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>