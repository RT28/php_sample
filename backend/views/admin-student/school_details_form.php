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
<?php $form = ActiveForm::begin(['id' => 'school-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= Html::a('View', ['school-details'], ['class' => 'btn btn-primary']) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>School Details</h4>
        </div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_student_school', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.school-container-items', // required: css class selector
                'widgetItem' => '.school-item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-school', // css class
                'deleteButton' => '.remove-school', // css class
                'model' => $schools[0],
                'formId' => 'school-details-form',
                'formFields' => [
                    'name',
                    'from_date',
                    'to_date',
                    'curriculum',
                ],
            ]); ?>

                <table class="table table-bordered school-container-items"><!-- widgetContainer -->
                    <?php foreach ($schools as $i => $schools): ?>
                        <tr class="school-item panel panel-default"><!-- widgetBody -->
                            <td>                        
                                <button type="button" class="remove-school btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </td>
                            <?php
                                // necessary for update action.
                                if (! $schools->isNewRecord) {
                                    echo Html::activeHiddenInput($schools, "[{$i}]id");
                                }
                            ?>
                            <td>
                                <?= $form->field($schools, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <?= $form->field($schools, "[{$i}]from_date")->widget(DatePicker::classname(),[
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
                                <?= $form->field($schools, "[{$i}]to_date")->widget(DatePicker::classname(),[
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
                                <?= $form->field($schools, "[{$i}]curriculum")->textInput(['maxlength' => true]) ?>
                            </td>                    
                        </tr>
                    <?php endforeach; ?>
            </table>
            <button type="button" class="add-school btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
