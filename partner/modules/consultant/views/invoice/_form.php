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
use yii\widgets\Pjax;
use common\models\Student;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Currency;
use common\models\Consultant;
use common\models\Agency;


/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
$universitylist = University::find()->orderBy('name')->all();
$universitylist = ArrayHelper::map($universitylist, 'id', 'name');
$intake = array('1'=>'Month','2'=>'Year');
$status = array('0'=>'Incomplete','1'=>'Completed',);
$currencylist = Currency::find()->orderBy('iso_code')->all();
$currencylist = ArrayHelper::map($currencylist, 'id', 'iso_code');
?>
<?php   
if(!$model->isNewRecord){
$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

$consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
$consultantname = $consultantProfile->first_name." ".$consultantProfile->last_name;

$agencyProfile = Agency::find()->where(['=', 'partner_login_id', $model->agency_id])->one();
$agencyname = $agencyProfile->name;

$currency = Currency::find()->where(['=', 'id', $model->currency])->one();
$gross_amount = $model->gross_tution_fee." ".$currency->iso_code;

$university = University::find()->where(['=', 'id', $model->university])->one();
$university_name = $university->name;

if($model->programme == 0){
$programme_name = $model->custom_programme;     
} else {
$programme = UniversityCourseList::find()->where(['=', 'id', $model->programme])->one();
$programme_name = $programme->name;
}
}
$timestamp = strtotime($model->created_at); 
$createddate = date('d-M-Y', $timestamp);  ?>
<div class="invoice-form">
<?php Pjax::begin([
    // Pjax options
]);//echo $students[$student_id]; ?>
    <?php $form = ActiveForm::begin(['id'=>'invoice-active-form',
      'validateOnSubmit' => true,
 'enableAjaxValidation' => true,
 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <!-- for ajax student basic details -->
    <div id="std_detail"></div>     
    <!-- end ajax student details -->
     <?php    if(!$model->isNewRecord){ ?>
 <div class="row">
<div class="col-sm-6" > 
<p><strong>Date Created:</strong> 
<?= $createddate;?>
</p>
<p><strong>Student Name:</strong> <?= $studentname; ?></p>
<p><strong>Consultant name:</strong> <?= $consultantname; ?></p>
<p><strong>Agency name:</strong> <?= $agencyname; ?></p>
<p><strong>University:</strong> <?=  $university_name?></p>
<p><strong>Program:</strong> <?=  $programme_name?></p>

</div>

</div>
  <?= $form->field($model, "id")->hiddenInput()->label(false);?>
          <?php }  ?>
<?php if($model->isNewRecord){ ?>
<input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
<?php } ?>          
          
       
    <div class="row">
    <?php if($model->isNewRecord){ ?>
        <div class="col-sm-5"> 
                <?php if(!empty($student_id)){?>
        <label class="control-label" for="task_category_id">Student Name</label><br/>
        <?php    
        echo  $students[$student_id];
        $model->student_id = $student_id;
        ?>
        <?= $form->field($model, "student_id")->hiddenInput()->label(false); ?>

        <?php }else{ ?>
        
           <?= $form->field($model, "student_id")->dropDownList($students, ['prompt' => 'Select Students','onchange'=>'getStude_details(this.value)','disabled' => !$model->isNewRecord ? true : false])->label('Student Name') ?>
           <?php }?>
        </div>
        <?php } ?>
        <div class="col-sm-5"> 
        <?= $form->field($model, 'payment_date')->widget(DatePicker::classname(),[
        'name' => 'payment_date',
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd',
            'value' =>null,
             'todayHighlight' => true, 
               
        ]
        ]);?>
        </div>
        
    </div>
          
    <?php if($model->isNewRecord){ ?>
    <div class="row">
        <div class="col-sm-5"> 
        <?= $form->field($model, "university")->dropDownList($universitylist, ['prompt' => 'Select University','id'=>'university_id'])->label('University') ?>
        </div>
        <div class="col-sm-5"> 
            <?= $form->field($model, 'programme')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>[  'id' => 'programme', 'placeholder'=>'------Select Program-----'], 
                'pluginOptions'=>[ 
                'depends'=>['university_id'], // the id for cat attribute
                'placeholder'=>'------Select Program-----',
                'url'=>  \yii\helpers\Url::to(['program'])
                ]
            ]); ?>
        </div>
    </div>
    <div id="custom_programme" class="row" style="display: none;">
        <div class="col-sm-5"> 
        </div>
        <div class="col-sm-5"> 
            <?= $form->field($model, 'custom_programme')->textInput() ?> 
        </div>
    </div>
    <?php } ?>

    <div class="row">
        <!-- <div class="col-sm-5"> 
            <?= $form->field($model, "intake")->dropDownList($intake, ['prompt' => 'Select Intake']) ?>
        </div> -->
        
        <div class="col-sm-3"> 
            <?= $form->field($model, 'gross_tution_fee')->textInput() ?> 
        </div>
        <div class="col-sm-2"> 
            <?= $form->field($model, "currency")->dropDownList($currencylist, ['prompt' => 'Select Currency','id'=>'currency_id'])->label('Currency') ?>
        </div>
        <div class="col-sm-5"> 
            <?= $form->field($model, 'scholarship')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>

    <div class="row">
        
        <div class="col-sm-5"> 
            <?= $form->field($model, 'intake')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'Starting Date')],
                    //'attribute2'=>'intake2',
                    //'type' => DatePicker::TYPE_RANGE,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'startView'=>'year',
                        'minViewMode'=>'months',
                        'format' => 'MM-yyyy'
                    ]
                ])->label('Intake') ?>
        </div>
        <?php if($model->isNewRecord){ ?>
        <div class="col-sm-5"> 
            <?= $form->field($upload, 'attachment')->widget(FileInput::classname(), [
                
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => false,
                    'intialPreviewAsData' => false,                
                    'resizeImages' => true,
                    'minImageWidth' => 150,
                    //'initialPreview' => $initialPreview,
                    'minImageHeight' => 200,
                ]
            ])->label('Evidence Of Fee Payment'); 
            ?>
        </div>
        <?php } ?>
    </div>

    <div class="row">
        
        <div class="col-sm-5"> 
            <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?> 
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); 
    Pjax::end();
    ?>

</div>
<script language="javascript">

    function getStude_details(id) { 
    if(id!=""){  
        $.ajax({
                url: '?r=consultant/invoice/getstudentdetail&id='+id,
                method: 'GET', 
                success: function(response, data) {
                    response = JSON.parse(response);                
                    $('#std_detail').html(response.result); 
                },
                error: function(error) {
                    console.log(error);
                }
            });  
    } else {
        $('#std_detail').html("");
    }        
    }
    
</script>
<?php 
$this->registerJs("
$(function(){
   $('#programme').change(function(){
        var id = this.value; 
        if(id!= '' && id == 0){ 
            $('#custom_programme').show();
        } else {
            $('#custom_programme').hide();
        }
    });

  });
");