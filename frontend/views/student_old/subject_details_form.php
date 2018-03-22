<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
if (isset($layout)) {
    $this->context->layout = $layout;
}
/**
 * var @subjects array of subjects taken by student
 * var @form is active form.
*/
?>
<?php $form = ActiveForm::begin(['id' => 'subject-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-blue float-right']) ?>
        </div>
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
            <div class="row subject-container-items"><!-- widgetContainer -->
                <?php foreach ($subjects as $i => $subjects): ?>
                    <div class="subject-item col-xs-12"><!-- widgetBody -->
                        <button type="button" class="remove-subject btn btn-danger btn-xs col-xs-1"><i class="glyphicon glyphicon-minus"></i></button>
                        <?php
                            // necessary for update action.
                            if (! $subjects->isNewRecord) {
                                echo Html::activeHiddenInput($subjects, "[{$i}]id");
                            }
                        ?>
                        <div class="col-xs-11">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <?= $form->field($subjects, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <?= $form->field($subjects, "[{$i}]maximum_marks")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-5">
                                    <?= $form->field($subjects, "[{$i}]marks_obtained")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                        <?php if($i < sizeof($subjects)): ?>
                            <hr style="clear: both;"/>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
           </div>
           <button type="button" class="add-subject btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>