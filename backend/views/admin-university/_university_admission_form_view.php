<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\JsExpression;

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
                    'eligibility_criteria',
                    'admission_fees',
                ],
            ]); ?>

            <table class="university_admission-container-items table table-bordered"><!-- widgetContainer -->
                <?php foreach ($univerityAdmisssions as $i => $univerityAdmisssions): ?>
                    <tr class="admission-item"><!-- widgetBody -->                       
                        <?php
                            // necessary for update action.
                            if (! $univerityAdmisssions->isNewRecord) {
                                echo Html::activeHiddenInput($univerityAdmisssions, "[{$i}]id");                                
                            }
                        ?>
                        <td>
                             <div class="form-group">
                                <?= Html::activeLabel($univerityAdmisssions, "[{$i}]degree_level_id"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($univerityAdmisssions->degreeLevel->name)?print_r($univerityAdmisssions->degreeLevel->name):'-';
                                 ?>
                                
                            </div>         
                           
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::activeLabel($univerityAdmisssions, "[{$i}]course_id"); ?>
                                   <?= '<br>' ?>
                                <?php 
                                isset($univerityAdmisssions->course->name)?print_r($univerityAdmisssions->course->name):'-';
                                 ?>
                                
                            </div>  
                            <?php
                                $admissionCourses = [];
                                if(!empty($univerityAdmisssions->course_id)) {
                                    $course = $univerityAdmisssions->course;
                                    $admissionCourses = [$course->id => $course->name];
                                }
                            ?>                           
                        </td>
                        <td>
                             <div class="form-group">
                                <?= Html::activeLabel($univerityAdmisssions, "[{$i}]start_date"); ?>
                                   <?= '<br>' ?>
                                <?php 
                                isset($univerityAdmisssions->start_date)?print_r($univerityAdmisssions->start_date):'-';
                                 ?>
                                
                            </div>  
                          
                        </td>
                        <td>
                         <div class="form-group">
                                <?= Html::activeLabel($univerityAdmisssions, "[{$i}]end_date"); ?>
                                   <?= '<br>' ?>
                                <?php 
                                isset($univerityAdmisssions->end_date)?print_r($univerityAdmisssions->end_date):'-';
                                 ?>
                                
                            </div>  
                        </td>
                        <td>
                             
                            <?= $form->field($univerityAdmisssions, "[{$i}]intake")->dropDownList($intake,['disabled'=>'true']) ?>
                        </td>                                                
                        <td>
                            <div class="form-group">
                            <?= Html::activeLabel($univerityAdmisssions, "[{$i}]admission_link"); ?>
                              <?= '<br>' ?>
                            <?php 
                            isset($univerityAdmisssions->intake)?print_r($univerityAdmisssions->admission_link):'-';
                            ?>
                                
                            </div>
                        
                        </td>
                        <td>
                         <div class="form-group">
                            <?= Html::activeLabel($univerityAdmisssions, "[{$i}]eligibility_criteria"); ?>
                              <?= '<br>' ?>
                            <?php 
                            isset($univerityAdmisssions->eligibility_criteria)?print_r($univerityAdmisssions->eligibility_criteria):'-';
                            ?>
                        </div>
                           
                        </td>
                        <td>
                         <div class="form-group">
                            <?= Html::activeLabel($univerityAdmisssions, "[{$i}]admission_fees"); ?>
                              <?= '<br>' ?>
                        <?php 
                        isset($univerityAdmisssions->admission_fees)?print_r($univerityAdmisssions->admission_fees):'-';
                         ?>
                        </div>
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
                url: '/gotouniversity/backend/web/index.php?r=university/dependent-courses',
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