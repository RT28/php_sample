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
$category = array('1'=>'Admission','2'=>'Placement','3'=>'Programs','0'=>'Other');
$universitylist = University::find()->where(['=', 'is_partner', 1])->orderBy('name')->all();
$universitylist = ArrayHelper::map($universitylist, 'id', 'name');
?>

<div class="universityinfo-form">
<?php Pjax::begin([
    // Pjax options
]);//echo $students[$student_id]; ?>
    <?php $form = ActiveForm::begin(['id'=>'universityinfo-active-form',
      'validateOnSubmit' => true,
 'enableAjaxValidation' => true,
 'options' => ['enctype' => 'multipart/form-data']]); ?>
   
    <?= $form->field($model, "category")->dropDownList($category, ['prompt' => 'Select Category' , 'id' => 'category'])->label('Inquiry Related to') ?>
    <div id="custom_category" style="display: none;">
            <?= $form->field($model, 'custom_category')->textInput() ?> 
    </div>
    <?= $form->field($model, "university_id")->dropDownList($universitylist, ['prompt' => 'Select University','id'=>'university_id'])->label('University') ?>
    <?= $form->field($model, 'question')->textArea(['maxlength' => true])->label('Your Question') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); 
    Pjax::end();
    ?>

</div>
<?php 
$this->registerJs("
$(function(){
   $('#category').change(function(){
        var id = this.value; 
        if(id!= '' && id == 0){ 
            $('#custom_category').show();
        } else {
            $('#custom_category').hide();
        }
    });

  });
");