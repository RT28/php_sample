<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;

$this->registerJsFile('@web/js/programs.js');
$this->registerJsFile('@web/libs/select2/select2.full.min.js');
$this->registerCssFile('@web/libs/select2/select2.min.css');
?>
<?php /*
<div class="row">
</div>

<div class="panel panel-default">
    <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Programmes</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.course-items', // required: css class selector
                'widgetItem' => '.course-item', // required: css class
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-course', // css class
                'deleteButton' => '.remove-course', // css class
                'model' => $courses[0],
                'formId' => 'university-active-form',
                'formFields' => [
                    'name',
                    'degree_id',
                    'major_id',
                    'degree_level_id',
                    'intake',
                    'language',
                    'fees',
                    'fees_international_students',
                    'duration',
                    'duration_type',
                    'type',
                    'careers',
                    'eligibility_criteria'
                ],
            ]); ?>
            
            <table class="table table-bordered"><!-- widgetContainer -->
                <tbody class="course-items">
                <?php foreach ($courses as $i => $courses): ?>
                    <tr class="course-item"><!-- widgetBody -->
                        <td>
                            <button type="button" class="remove-course btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                        <?php
                            // necessary for update action.
                            if (! $courses->isNewRecord) {
                                echo Html::activeHiddenInput($courses, "[{$i}]id");
                            }
                        ?>
                        <td>
                            <?= $form->field($courses, "[{$i}]name")->textInput([]) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]degree_level_id")->dropDownList($degreeLevels) ?>
                            <?= $form->field($courses, "[{$i}]degree_id")->dropDownList($degree, ['prompt' => 'Select Discipline...', 'onchange' => 'updateCourses(this)']) ?>
                            <?php
                                $major = [];
                                if(!empty($courses->degree_id)) {
                                    $temp = $courses->degree->majors;
                                    if(!empty($temp)) {
                                        $major = ArrayHelper::map($temp, 'id', 'name');
                                    }
                                }
                            ?>
                            <?= $form->field($courses, "[{$i}]major_id")->dropDownList($major, ['prompt' => 'Select Discipline...']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]intake")->textInput(['type' => 'number']) ?>
                            <?= $form->field($courses, "[{$i}]language")->dropDownList($languages) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]fees")->textInput(['type' => 'number']) ?>
                            <?= $form->field($courses, "[{$i}]fees_international_students")->textInput(['type' => 'number']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]duration")->textInput(['type' => 'number']) ?>
                            <?= $form->field($courses, "[{$i}]duration_type")->dropDownList($durationType, ['prompt' => 'Select...']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]type")->dropDownList($courseType) ?>
                        </td>
                        <td>
                            <?php
                                if(isset($courses->standard_test_list)) {
                                    $courses->standard_test_list = explode(',', $courses->standard_test_list);
                                }
                            ?>
                            <?= $form->field($courses, "[{$i}]standard_test_list")->dropDownList($standardTests, ['multiple' => 'multiple', 'class' => 'course-standard-tests']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]application_fees")->textInput() ?>
                            <?= $form->field($courses, "[{$i}]application_fees_international")->textInput() ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]description")->textArea(['rows' => 6]) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]careers")->textArea(['rows' => 6]) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$i}]eligibility_criteria")->textArea(['rows' => 6]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <td>
                        <button type="button" class="add-course btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                    </td>
                </tfoot>
            </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>

<?php */ ?>