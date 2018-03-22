<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
?>

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
                    'fees',
                    'duration',
                    'type',
                ],
            ]); ?>
            
            <table class="table table-bordered"><!-- widgetContainer -->
                <tbody class="course-items">
                <?php foreach ($courses as $i => $courses): ?>                                        
                    <tr class="course-item"><!-- widgetBody -->                    
                      
                        <?php
                            // necessary for update action.
                            if (! $courses->isNewRecord) {
                                echo Html::activeHiddenInput($courses, "[{$i}]id");
                            }
                        ?>
                        <td>
                             <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]name"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->name)?print_r($courses->name):'-';
                                 ?>
                                
                            </div>    
                      
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]degree_id"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->degree->name)?print_r($courses->degree->name):'-';
                                 ?>
                            </div> 
                          
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]major_id"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->major->name)?print_r($courses->major->name):'-';
                                 ?>
                            </div> 
                                                     
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]degree_level_id"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->degreeLevel->name)?print_r($courses->degreeLevel->name):'-';
                                 ?>
                            </div> 
                            
                        </td>
                        <td>
                            <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]intake"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->intake)?print_r($courses->intake):'-';
                                 ?>
                            </div> 
                           
                        </td>
                        <td>
                        <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]language"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->language)?print_r($courses->language):'-';
                                 ?>
                        </div> 
                            
                        </td>
                        <td>
                        <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]fees"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->fees)?print_r($courses->fees):'-';
                                 ?>
                        </div> 
                            
                        </td>
                        <td>
                        <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]duration"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->duration)?print_r($courses->duration):'-';
                                 ?>
                        </div> 
                            
                        </td>
                        <td>
                        <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]type"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->type)?print_r($courses->type):'-';
                                 ?>
                        </div> 
                          
                        </td>
                        <td>
                        <div class="form-group">
                                <?= Html::activeLabel($courses, "[{$i}]description"); ?>
                                <?= '<br>' ?>
                                <?php 
                                isset($courses->description)?print_r($courses->description):'-';
                                 ?>
                        </div> 
                          
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    
                </tfoot>
            </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>

<script>
    function updateCourses(element) {
        console.log(element);
        var degree = element.value;
        if (degree !== null && degree !== undefined && degree !== "") {
            $.ajax({
                url: '/gotouniversity/backend/web/index.php?r=university/dependent-majors',
                method: 'POST',
                data: {
                    'degree': degree,
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status == "success") {
                        var row = element.id.split('-')[1];
                        var select = $('#universitycourselist-' + row + '-major_id');
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