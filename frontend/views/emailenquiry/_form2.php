<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\StudentConsultantRelation;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */
/* @var $form yii\widgets\ActiveForm */
        /*$id = Yii::$app->user->identity->id;
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
         
        $consultants = ArrayHelper::map($consultantData, 'consultant_id', 'consultant_id');*/
       // $model->is_to_student = true;  
?>

<div class="emailenquiry-form">

<?php  if(!empty($status)) {
        if ($status === 'success') {
            echo '<div class="alert alert-success" role="alert">';
                echo 'Your response has been sent successfully!!. Thank you for your interest.';
            echo '</div>';
        }
        elseif($status === 'error') {
            echo '<div class="alert alert-danger" role="alert">';
                echo 'Something went wrong! Please try later.';
            echo '</div>';
        }

    } else {
    $form = ActiveForm::begin(); ?>

            <label>Subject</label>
            <p><?= $model->subject; ?></p>

            <?php if(!empty($model->consultant_message)){ ?>
            
            <label>Message by consultant</label>
            <p><?= $model->consultant_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->student_message)){ ?>
            <label>Message by Student</label>
            <p><?= $model->student_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->father_message)){ ?>
            <label>Message by Student Father</label>
            <p><?= $model->father_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->mother_message)){ ?>
            <label>Message by Student Mother</label>
            <p><?= $model->mother_message; ?></p>
            <?php } ?>
  
    <?php if($tag=="st"){
          echo $form->field($model, 'student_message')->textarea(['rows' => 6])->label('Your Message');  
    } else if($tag=="pr1"){
           echo $form->field($model, 'father_message')->textarea(['rows' => 6])->label('Your Message'); 
    } else if($tag=="pr2"){
            echo $form->field($model, 'mother_message')->textarea(['rows' => 6])->label('Your Message');
    } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php } ?>
</div>
