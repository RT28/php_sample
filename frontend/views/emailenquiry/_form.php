<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Consultant;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */
/* @var $form yii\widgets\ActiveForm */
        $id = Yii::$app->user->identity->id; 

        
        $consultants = Consultant::find()
        ->leftJoin('student_consultant_relation', 'student_consultant_relation.consultant_id = consultant.consultant_id') 
        ->where('student_consultant_relation.student_id = '.$id)
        ->all(); 
     
        $consultantData = array();     
        $i = 0;              
        foreach($consultants as $consultant){   

         $consultantData[$i]['id'] =  $consultant['consultant_id'];   
         $consultantData[$i]['name'] =  $consultant['first_name'].' '.$consultant['last_name'];

        
        $i++;
        } 

        $consultants = ArrayHelper::map($consultantData, 'id', 'name');
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
    <?= $form->field($model, 'is_draft')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
