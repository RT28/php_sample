<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\StudentConsultantRelation;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */
/* @var $form yii\widgets\ActiveForm */
        $id = Yii::$app->user->identity->id;
        $consultants = StudentConsultantRelation::find()
        ->leftJoin('consultant', 'consultant.consultant_id = student_consultant_relation.consultant_id') 
        ->where('student_consultant_relation.student_id = '.$id.'')
        ->all();
     
        
        $consultantData = array();     
        $i = 0;              
        foreach($consultants as $consultant){
        echo $consultant['consultant_id'].',';
        $consultantProfile = $consultant->consultant->consultant;   
        $consultantData[$i]['consultant_id'] = $consultantProfile->id;   
        //$consultantData[$i]['name'] =  $consultantProfile->first_name." ".$consultantProfile->last_name;

        
        $i++;
        }
         
        $consultants = ArrayHelper::map($consultantData, 'consultant_id', 'consultant_id');
       // $model->is_to_student = true;  
?>

<div class="emailenquiry-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-5"> 
        <?= $form->field($model, "consultant_id")->dropDownList($consultants, ['prompt' => 'Select Consultant','disabled' => !$model->isNewRecord ? true : false])->label('Consultant Name') ?>
        </div>
    </div> 

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
  
    <?= $form->field($model, 'student_message')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
