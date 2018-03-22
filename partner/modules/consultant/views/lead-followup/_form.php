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
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker; 
use yii\widgets\Pjax;
use common\models\Student;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */
//$this->title = 'Assigning Consultant';
$this->params['breadcrumbs'][] = $this->title; 
$mode = array(1=>'Telephone',2=>'Email',3=>'Face to face');
$status = array(1=>'FollowUp Again',2=>'Not Interested',3=>'Send Dashboard Access',5=>'Other',6=>'Close Lead');
$reason_code = array(1=>'Not Interested',2=>'Price Not Reasonable',3=>'Not Now');
$studentProfile = Student::find()->where(['=', 'id', $student_id])->one();
$studentname = $studentProfile->first_name." ".$studentProfile->last_name;
?>
 


<div class="leadfollowup-form">


           
<?php Pjax::begin([
    // Pjax options
]);//echo $students[$student_id]; ?>
    <?php $form = ActiveForm::begin(['id'=>'leadfollowup-active-form',
      'validateOnSubmit' => true,
     'enableAjaxValidation' => true,
     'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="row">
                <div class="col-sm-5"> 
                <label class="control-label" for="task_category_id">Student Name</label><br/>
                <?php    
                echo  $studentname;
                ?>
                </div>
        </div>
        <div class="row">
            
            <div class="col-sm-5"> 

            <?= $form->field($model, 'comment_date')->widget(kartik\date\DatePicker::classname(),['pluginOptions'=>[ 'autoclose' => true,'format' => 'yyyy-mm-dd','todayHighlight' => true]
            ])->label('Comment Date');?>
            </div>
            <div class="col-sm-5"> 
                <?= $form->field($model, 'comment')->textInput(['maxlength' => true])->label('Followup Comment'); ?> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5"> 
                <?= $form->field($model, "mode")->dropDownList($mode, ['prompt' => 'Select Mode'])->label('Mode of Contacting') ?> 
            </div>
            <div class="col-sm-5"> 
                <?= $form->field($model, "status")->dropDownList($status, ['prompt' => 'Select Followup Action','onchange'=>'fn_followstatus(this.value)'])->label('Followup Action') ?>
            </div>
        </div>
        <div class="row optionDiv" id="followDiv" style="display: none;">
            <div class="col-sm-5"> 
            <?php echo $form->field($model, 'next_followup')->widget(DateTimePicker::classname(),[
                'name' => 'next_followup',
                'id' =>'next_followup',
                'options' => ['placeholder' => 'Select date and time ...'],
                //'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh:ii',
                    //'startDate' => '01-Mar-2014 12:00 AM',
                    'autoclose'=>true,
                    'todayHighlight' => true
                ]
            ])->label('Next Followup Date'); ?>
            </div>
            <div class="col-sm-5"> 
                <?= $form->field($model, 'next_follow_comment')->textInput() ?> 
            </div>
        </div> 
        <div class="row optionDiv" id="reasonDiv" style="display: none;">
            <div class="col-sm-5"> 
                <?= $form->field($model, "reason_code")->dropDownList($reason_code, ['prompt' => 'Select Reason','id' =>'reason_code'])->label('Reason') ?>
            </div>
        </div>
        <div class="row optionDiv" id="otherDiv" style="display: none;">
            <div class="col-sm-5"> 
                <?= $form->field($model, 'other_follow')->textArea(['maxlength' => true])->label('Follow up for'); ?>
            </div>
        </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Update' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end();
Pjax::end(); ?>
</div>
<script type="text/javascript">
    function fn_followstatus(val){
        $('.optionDiv').hide()
        if (val == 1) {
            $('#followDiv').show();
            $('#reason_code').val('0');
        } else if (val == 2 || val == 6) {
            $('#reasonDiv').show();
            $('#next_followup').val("0000-00-00 00:00:00");
        } else if (val == 5) {
            $('#otherDiv').show();
            $('#next_followup').val("0000-00-00 00:00:00");
            $('#reason_code').val('0');
        }
    } 
</script>

