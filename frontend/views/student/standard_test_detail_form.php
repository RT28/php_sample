<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;
use yii\helpers\FileHelper;
	$this->context->layout = 'profile';

/**
 * var @standardTests array of students school details
 * var @form is active form.
*/
?>

 <?php

    $cover_photo_path = [];
    $src = './noprofile.gif';
    $user = $model->student->id;
    if(is_dir("./../web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);
    }
    if (count($cover_photo_path) > 0) {
        $src = $cover_photo_path[0];
    }
?>
<div class="student-profile-main">
    <?= $this->render('_student_common_details');
    ?>
<?php $form = ActiveForm::begin(['id' => 'standard-test-details-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-blue float-right']) ?>
        </div>
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
                    <div class="col-sm-12">
            <div class="row tests-container-items"><!-- widgetContainer -->
                <?php foreach ($standardTests as $i => $standardTests): ?>
                    <div class="test-item"><!-- widgetBody -->
                    <div class="row">
                        <button type="button" class="remove-test"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <?php
                            // necessary for update action.
                            if (! $standardTests->isNewRecord) {
                                echo Html::activeHiddenInput($standardTests, "[{$i}]id");
                            }
                        ?>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= $form->field($standardTests, "[{$i}]test_name")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <?= $form->field($standardTests, "[{$i}]test_authority")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                <?= $form->field($standardTests, "[{$i}]test_date")->widget(DatePicker::classname(),[
                                            'name' => "[{$i}]test_date",
                                                'type' => DatePicker::TYPE_INPUT,
                                                'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',
                                                'value' =>null,
                                                 'todayHighlight' => true, 
                                                   
                                            ]
                                            ]);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <?= $form->field($standardTests, "[{$i}]verbal_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <?= $form->field($standardTests, "[{$i}]quantitative_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <?= $form->field($standardTests, "[{$i}]integrated_reasoning_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <?= $form->field($standardTests, "[{$i}]data_interpretation_score")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        <?php if($i < sizeof($standardTests)): ?>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <button type="button" class="add-test btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
        <?php DynamicFormWidget::end(); ?>
    <div class="form-group text-right mtop-10">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>