<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use wbraganca\dynamicform\DynamicFormWidget;
    use yii\helpers\ArrayHelper;
    $this->registerJsFile('@web/js/programs.js');
?>
<div class="bulk-upload">

    <?php $form = ActiveForm::begin(['id' => 'bulk-upload-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
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
                        'model' => $models[0],
                        'formId' => 'bulk-upload-form',
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
                            <?php foreach ($models as $i => $courses): ?>                                        
                                <tr class="course-item"><!-- widgetBody -->                    
                                    <td>
                                        <button type="button" class="remove-course btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                    </td>
                                    <?php
                                        // necessary for update action.
                                        if (! $courses->isNewRecord) {
                                            echo Html::activeHiddenInput($courses, "[{$i}]id");                                            
                                        }
                                        echo Html::activeHiddenInput($courses, "[{$i}]university_id");
                                    ?>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]name")->textInput([]) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]degree_id")->dropDownList($degree, ['prompt' => 'Select Discipline...', 'onchange' => 'updateCourses(this)']) ?>
                                    </td>
                                    <td>
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
                                        <?= $form->field($courses, "[{$i}]degree_level_id")->dropDownList($degreeLevels) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]intake")->textInput(['type' => 'number']) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]language")->dropDownList($languages) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]fees")->textInput(['type' => 'number']) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]duration")->textInput(['type' => 'number']) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]type")->dropDownList($courseType) ?>
                                    </td>
                                    <td>
                                        <?= $form->field($courses, "[{$i}]description")->textArea(['rows' => 6]) ?>
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
        <div class="form-group text-center">        
            <?= Html::submitInput('Save', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>