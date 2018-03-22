<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
if (isset($layout)) {
    $this->context->layout = $layout;
}

/**
 * var @schools array of students school details
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'school-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-blue float-right']) ?>
        </div>
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
            ]); 
        ?>

            <div class="row school-container-items"><!-- widgetContainer -->
                <?php foreach ($schools as $i => $schools): ?>
                    <div class="school-item col-xs-12"><!-- widgetBody -->
                        <button type="button" class="remove-school btn btn-danger btn-xs col-xs-1"><i class="glyphicon glyphicon-minus"></i></button>
                        <?php
                            // necessary for update action.
                            if (! $schools->isNewRecord) {
                                echo Html::activeHiddenInput($schools, "[{$i}]id");
                            }
                        ?>
                        <div class="col-xs-11">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <?= $form->field($schools, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <?= $form->field($schools, "[{$i}]from_date")->widget(DatePicker::classname(),[
                                        'name' => 'from_date_picker',
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoClose' => true,
                                            'format' => 'yyyy'
                                            ]
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-4">
                                    <?= $form->field($schools, "[{$i}]to_date")->widget(DatePicker::classname(),[
                                        'name' => 'from_date_picker',
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoClose' => true,
                                            'format' => 'yyyy'
                                            ]
                                        ]);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <?= $form->field($schools, "[{$i}]curriculum")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <?php if($i < sizeof($schools)): ?>
                            <hr style="clear: both;"/>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="add-school btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>