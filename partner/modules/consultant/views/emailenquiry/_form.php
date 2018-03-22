<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\StudentConsultantRelation;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */
/* @var $form yii\widgets\ActiveForm */
        $id = Yii::$app->user->identity->id;
        $students = StudentConsultantRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.$id.'')
        ->all();
     
        
        $studentData = array();     
        $i = 0;              
        foreach($students as $student){
    
        $studentProfile = $student->student->student;   
        $studentData[$i]['id'] = $studentProfile->student_id;   
        $studentData[$i]['name'] =  $studentProfile->first_name." ".$studentProfile->last_name;

        
        $i++;
        }
         
        $students = ArrayHelper::map($studentData, 'id', 'name');
        $model->is_to_student = true;  
?>

<div class="emailenquiry-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-5"> 
        <?= $form->field($model, "student_id")->dropDownList($students, ['prompt' => 'Select Students','onchange'=>'getStude_details(this.value)','disabled' => !$model->isNewRecord ? true : false])->label('Student Name') ?>
        </div>
    </div> 
    <label>Selct Recepients</label>
    <div class="row">
        <div class="col-sm-2"> 

        <?= $form->field($model, 'is_to_student')->checkbox() ?>
        </div>
        <div class="col-sm-2"> 
        <?= $form->field($model, 'is_to_father')->checkbox() ?>
        </div>
        <div class="col-sm-2"> 
        <?= $form->field($model, 'is_to_mother')->checkbox() ?>
        </div>
    </div> 

    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
  
    <?= $form->field($model, 'consultant_message')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
