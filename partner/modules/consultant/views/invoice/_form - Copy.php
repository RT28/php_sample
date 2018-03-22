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
use common\models\TaskList;
use yii\widgets\Pjax;
use common\models\Tasks;
use common\models\TaskCategory; 
use common\models\Student;
use common\models\University;
use common\models\UniversityCourseList;


/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
$universitylist = University::find()->orderBy('name')->all();
$universitylist = ArrayHelper::map($universitylist, 'id', 'name');
$intake = array('1'=>'Month','2'=>'Year');
$status = array('0'=>'Incomplete','1'=>'Completed',);

?>

<div class="invoice-form">
<?php Pjax::begin([
    // Pjax options
]);//echo $students[$student_id]; ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6"> 
           <?= $form->field($model, "student_id")->dropDownList($students, ['prompt' => 'Select Students','onchange'=>'getStude_details(this.value)'])->label('Student Name') ?>
        </div>
    </div>
    <!-- for ajax student basic details -->
    <div id="std_detail"></div>     
    <!-- end ajax student details -->      
    <div class="row">
        <div class="col-sm-6"> 
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

    <div class="row">
        <div class="col-sm-6"> 
        <?= $form->field($model, "university")->dropDownList($universitylist, ['prompt' => 'Select University','id'=>'university_id'])->label('University') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
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

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, "intake")->dropDownList($intake) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'gross_tution_fee')->textInput() ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'discount')->textInput() ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'scholarship')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'net_fee_paid')->textInput() ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'invoice_attachment')->textInput(['maxlength' => true]) ?> 
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