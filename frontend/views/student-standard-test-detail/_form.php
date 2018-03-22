<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\StandardTests;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentStandardTestDetail */
/* @var $form yii\widgets\ActiveForm */
//$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
?>

<div class="student-standard-test-detail-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php if($model->isNewRecord){ 
        $test_names=ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
        $test_names[0]='Other';
    ?>
    <?= $form->field($model, 'test_name')->dropdownlist($test_names,['prompt'=>'Select Test Name',
    'onchange' => 
    'var url = "/student-standard-test-detail/getsubjects?test_id="+$(this).val()+"&marks='.$model->test_marks.'";
            $.ajax({
                type:"POST",
                url: url,
                success: function(data){
                    data = data.trim();
                    if(data == 1){
                        $("#other-test-parameter").show();
                        $("#student_test_detail").html("");
                        $("#other").show();
                    }else{
                        $("#student_test_detail").html(data);
                        $("#other-test-parameter").hide();
                        $("#other").hide();
                    }
                }
            });'
    ]); ?>
    <?php }else{ ?>
    <?= $form->field($model, 'test_name')->textInput(['readOnly'=>true]);?>
    <?php } ?>

    <div class="col-md-12" id="other-test-parameter" style="padding:0px;">
    <?php if($model->isNewRecord && $model->test_id == 0){ ?>
    <?= $form->field($model, 'other_test')->textInput(['maxlength' => true , 'placeholder' => 'Other Test']) ?>
    <?php $other_test_error = isset($error1)?$error1:''; echo $other_test_error; ?>
    <?php } ?>

    <?php if($model->test_id == 0){ ?>
    <?= $form->field($model, 'test_authority')->textInput(['maxlength' => true , 'placeholder' => 'Test Authority']) ?>
    <?php $test_authority_error = isset($error2)?$error2:''; echo $test_authority_error; ?>
    <?php } ?>
    </div>

    <?= $form->field($model, 'test_date')->widget(kartik\date\DatePicker::classname(),['pluginOptions'=>[ 'autoclose' => true,'format' => 'yyyy-mm-dd','todayHighlight' => true]]); ?>

    
    <div class="col-md-12" id="test-marks" style="padding-left:0px;">
        <table class="table table-bordered" id="student_test_detail">
            <?php if($model->isNewRecord && $model->test_id == 0){ ?>
            <input type="text" id="other" name="other" class="form-control" placeholder="Test Marks"/>
            <?php }elseif(isset($subjects)){
                print_r($subjects);
            }else{
                $subjects = '';
                $marks = Json::decode($model->test_marks);
                foreach($marks as $key => $value){
                    $subjects .= '<tr><td>'.$key.'</td><td><input name="'.$key.'" value="'.$value.'" class="form-control"/></td></tr>';
                }
                print_r($subjects);
            } ?>
            <?php if(isset($marks_error) && $marks_error != ''){ echo $marks_error; } ?>
        </table>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-blue' : 'btn btn-primary','id'=>'score']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
    $(document).ready(function(){
       //$('#other-test-parameter').hide();
       //$('#other').hide();
    });

    //$('#score').click(function (){
    //    $('#login-modal').modal('show').find('form').load('/student-standard-test-detail/create');
    //});

JS;
$this->registerJs($script);
?>