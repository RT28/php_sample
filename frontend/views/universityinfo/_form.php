<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\University;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\Universityinfo */
/* @var $form yii\widgets\ActiveForm */
$category = array('1'=>'Admission','2'=>'Placement','3'=>'Programs');
$university = University::find()->where(['=', 'id', $model->university_id])->one();
$university_name = $university->name;
?>

<div class="universityinfo-form">
<?php Pjax::begin([
    // Pjax options
]);//echo $students[$student_id]; ?>
    <?php $form = ActiveForm::begin(['id'=>'universityinfo-active-form',
      'validateOnSubmit' => true,
 'enableAjaxValidation' => true,
 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php if($model->category == 0){
        $category_name = '<b>Inquiry Related to : </b>'.$model->custom_category.'<br><br>'; 
        echo $category_name;
    } else { ?>
    <?= $form->field($model, "category")->dropDownList($category, ['prompt' => 'Select Category','disabled' => !$model->isNewRecord ? true : false])->label('Inquiry Related to') ?>
    <?php } ?>
    <?= $form->field($model, 'question')->textArea(['maxlength' => true , 'disabled' => !$model->isNewRecord ? true : false])->label('Question') ?>
    <?= $form->field($model, 'answer')->textArea(['maxlength' => true])->label('Your Answer') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); 
    Pjax::end();
    ?>

</div>