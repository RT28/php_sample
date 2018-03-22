<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;
use common\models\UniversityCourseList;

/**
 * var @univerityAdmisssions array of students school details
 * var @form is active form.
*/
?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Admissions</h4>
        </div>
        <div class="panel-body">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_university_admissions', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.university_admission-container-items', // required: css class selector
                'widgetItem' => '.admission-item', // required: css class
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $univerityAdmisssions[0],
                'formId' => 'university-active-form',
                'formFields' => [
                    'start_date',
                    'end_date',
                    'course_id',
                    'department_id',
                    'major_id',
                    'admission_link',
                    'admission_fees',
                    'admission_fees_international',
                ],
            ]); ?>

            <table class="university_admission-container-items table table-bordered"><!-- widgetContainer -->
                <?php foreach ($univerityAdmisssions as $i => $univerityAdmisssions): ?>
                    <tr class="admission-item"><!-- widgetBody -->
                        <td>
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                        <?php
                            // necessary for update action.
                            if (! $univerityAdmisssions->isNewRecord) {
                                echo Html::activeHiddenInput($univerityAdmisssions, "[{$i}]id");                                
                            }
                        ?>
                        <td>
                            <?= $form->field($univerityAdmisssions, "[{$i}]degree_level_id")->dropDownList($degreeLevels, ['prompt' => 'Select Degree Level...', 'onchange' => 'updateAdmission(this)']) ?>
                        </td>
                        <td>
                            <?php
                                $admissionCourses = [];
                                if($univerityAdmisssions->course_id != 0) {
                                    $course = UniversityCourseList::find()->where(['AND', ['=', 'university_id', $univerityAdmisssions->university_id], ['=', 'id', $univerityAdmisssions->course_id]])->one();
                                    if(!empty($course))
                                        $admissionCourses = [$course->id => $course->name];
                                } else {
                                    $admissionCourses = [ 0 => 'All'];
                                }
                            ?>
                            <?= $form->field($univerityAdmisssions, "[{$i}]course_id")->dropDownList($admissionCourses, ['prompt' => 'Select Programmes']) ?>   
                        </td>
                        <td>
                            <?= $form->field($univerityAdmisssions, "[{$i}]start_date")->widget(DatePicker::classname(),[
                                'name' => "date_picker_2[{$i}]",
                                'options'=> ['class'=>'start'],
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoClose' => true,
                                    'format' => 'yyyy-mm-dd'
                            ]]); ?>
                        </td>
                        <td>
                            <?= $form->field($univerityAdmisssions, "[{$i}]end_date")->widget(DatePicker::classname(),[
                                'name' => "date_picker_3[{$i}]",
                                'options'=> ['class'=>'end'],
                                'type' => DatePicker::TYPE_INPUT,
                                'pluginOptions' => [
                                    'autoClose' => true,
                                    'format' => 'yyyy-mm-dd'
                                    ]
                            ]);?>
                        </td>
                        <td>
                            <?= $form->field($univerityAdmisssions, "[{$i}]intake")->dropDownList($intake) ?>
                        </td>
                        <td>
                            <?= $form->field($univerityAdmisssions, "[{$i}]admission_link")->textInput(['maxlength' => true]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>

<script>
    function updateAdmission(element) {
        console.log(element);
        var degree = element.value;
        if (degree !== null && degree !== undefined && degree !== "") {
            $.ajax({
                url: '/backend/web/index.php?r=university/dependent-courses',
                method: 'POST',
                data: {
                    'degree': degree,
                    'university': "<?= $model->id ?>"
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status == "success") {
                        var row = element.id.split('-')[1];
                        var select = $('#universityadmission-' + row + '-course_id');
                        select.empty();
                        var data = response.result;
                        for(var i = 0; i < data.length; i++) {
                            select.append( '<option value="' + data[i].id + '">'
                                        + data[i].name
                                        + '</option>' ); 
                        }
                    }
                },
                error: function(){
                    console.log('error', arguments);
                }
            });
        }
    }
</script>
