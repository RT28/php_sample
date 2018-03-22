<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
$this->context->layout = 'admin-dashboard-sidebar';

?>

<div class="panel panel-default">
    <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Programmes</h4></div>
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_inner', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.course-items', // required: css class selector
                'widgetItem' => '.course-item', // required: css class                
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-course'.$department, // css class
                'deleteButton' => '.remove-course'.$department, // css class
                'model' => $courses[0],
                'formId' => 'university-active-form',
                'formFields' => [
                    'name',
                    'degree_id',
                    'major_id',
                    'intake',
                    'fees',
                    'duration',
                    'type',
                    'department_id',
                ],
            ]); ?>
            
            <table class="table table-bordered"><!-- widgetContainer -->
                <tbody class="course-items">
                <?php foreach ($courses as $i => $courses): ?>                                        
                    <tr class="course-item"><!-- widgetBody -->                    
                        <td>
                            <button type="button" class="remove-course<?= $department ?> btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                        <?php
                            // necessary for update action.
                            if (! $courses->isNewRecord) {
                                echo Html::activeHiddenInput($courses, "[{$department}][{$i}]id");
                            }
                        ?>                        
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]degree_id")->dropDownList($degree) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]major_id")->dropDownList($majors) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]intake")->textInput(['type' => 'number']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]language")->dropDownList($languages) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]fees")->textInput(['type' => 'number']) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]duration")->textInput(['type' => 'number']) ?>
                        </td>                        
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]type")->dropDownList($courseType) ?>
                        </td>
                        <td>
                            <?= $form->field($courses, "[{$department}][{$i}]description")->textArea(['rows' => 6]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <td>
                        <button type="button" class="add-course<?= $department ?> btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                    </td>
                </tfoot>
            </table>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>