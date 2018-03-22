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
    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Invoice Requisition</div>
                    <div class="panel-body">
                        <p><strong>Date Created :</strong> <?= $createddate;?></p>
                        <p><strong>Student Name:</strong> <?= $studentname; ?></p>
                        <p><strong>Consultant name:</strong> <?= $consultantname; ?></p>
                        <p><strong>Agency name:</strong> <?= $agencyname; ?></p>
                        <p><strong>University:</strong> <?=  $university_name?></p>
                        <p><strong>Program:</strong> <?=  $programme_name?></p>
                        <p><strong>Refference No#:</strong> <?=  $model->refer_number?></p>
                         
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
                        </div>
                        <div class="row">
                            <div class="col-sm-6"> 
                                <?= $form->field($model, 'comment')->textArea(['maxlength' => true]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"> 
                                <?= $form->field($model, 'gross_tution_fee')->textInput() ?> 
                            </div>
                            <div class="col-sm-3"> 
                                <?= $form->field($model, 'scholarship')->textInput(['maxlength' => true]) ?> 
                            </div>
                            <div class="col-sm-3"> 
                                <?= $form->field($model, 'net_fee_paid')->textInput(['maxlength' => true])->label('Net Tution Fee') ?> 
                            </div>
                            <div class="col-sm-3"> 
                                <?= $form->field($model, "currency")->dropDownList($currencylist, ['prompt' => 'Select Currency','id'=>'currency_id'])->label('Currency') ?> 
                            </div>
                        </div>

                    <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
