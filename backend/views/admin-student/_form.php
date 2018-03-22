<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker; 
use kartik\select2\Select2;   
use common\components\Commondata; 
use common\models\Country;



/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */

$state_data = [];
if(isset($model->state) && $model->state!=0) {
    $state_data = [$model->state => $model->state0->name];
}
$proficiency = Commondata::getProficiency();
$codelist = Country::getAllCountriesPhoneCode(); 
$gender = Commondata::getGender();
?>

<?php
    $initialPreview = [];
    $initialPreviewConfig =[];
    $user = $model->student->id;    
    if (is_dir("./../web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);       
        if (count($cover_photo_path) > 0) {
            $initialPreview = [Html::img($cover_photo_path[0], ['title' => $model->first_name . ' ' . $model->last_name, 'class' => 'photo-thumbnail'])];            
        }
    }
?>
<?php $form = ActiveForm::begin(['id' => 'school-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>    
    <div class="student-form">
	
	
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <?= $form->field($upload, 'profilePhoto')->widget(FileInput::classname(), [
                    'options' => [
                        'accept' => 'image/*'
                    ],
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showPreview' => true,
                        'intialPreviewAsData' => true,                
                        'resizeImages' => true,
                        'minImageWidth' => 150,
                        'initialPreview' => $initialPreview,
                        'minImageHeight' => 200,
                    ]
                ]); 
                ?>
            </div>
        </div>   

		
		<div class="student-form text-left">
	   

<div class="row">

<div class="col-sm-6">

<div class="row">
<div class="col-sm-6 col-xs-6">
<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
 
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?> 
<?= $form->field($model, 'code')->widget(Select2::classname(), [
	'name' => 'code',
	'data' => $codelist,
	'maintainOrder' => true,
	'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
	'pluginOptions' => [
		'tags' => true,
	]
]); ?>
		
<?php  
if($model->date_of_birth=='0000-00-00'){
$model->date_of_birth = '';
}else{
$dob =strtotime($model->date_of_birth);
$model->date_of_birth = date('d-M-Y',$dob);
} 

?>
<?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(),[
'name' => 'date_of_birth',
'type' => DatePicker::TYPE_INPUT,
'pluginOptions' => [
'autoclose' => true,
'format' => 'dd-M-yyyy',  
'todayHighlight' => true,
'todayBtn' => true,  ], 
]);?>

<?= $form->field($model, 'language_proficiency')->dropDownList($proficiency, [  'prompt' => 'Proficiency Level']); ?>
 
<?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'pincode')->textInput(['maxlength' => true]) ?>



</div>

<div class="col-sm-6 col-xs-6"> 

<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nationality')->dropDownList($countries, ['id' => 'nationality', 'prompt'=>'Select Country']); ?>

<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'gender')->dropDownList($gender, ['prompt' => 'Select Gender']); ?>



<?= $form->field($model, 'country')->dropDownList($countries, ['id' => 'country', 'prompt'=>'Select Country']); ?>
<?= $form->field($model, 'city')->textInput() ?> 

<?= $form->field($model, 'state')->widget(DepDrop::classname(), [
'options' => ['id' => 'state'],
'data' => $state_data,
'type' => DepDrop::TYPE_SELECT2,
'pluginOptions' => [
'depends' => ['country'],
'placeholder' => 'Select State',
'url' => Url::to(['/admin-student/dependent-states'])
]
]); ?> 
</div>
</div>
 
 

</div> 
<div class="col-sm-6">

<div class="row">
<div class="col-sm-6 col-xs-6">

<?= $form->field($model, 'father_name')->textInput(['maxlength' => true]) ?> 
<?= $form->field($model, 'father_phonecode')->widget(Select2::classname(), [
	'name' => 'father_phonecode',
	'data' => $codelist,
	'maintainOrder' => true,
	'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
	'pluginOptions' => [
		'tags' => true,
	]
])?>
<?= $form->field($model, 'mother_name')->textInput(['maxlength' => true]) ?>
 
<?= $form->field($model, 'mother_phonecode')->widget(Select2::classname(), [
	'name' => 'mother_phonecode',
	'data' => $codelist,
	'maintainOrder' => true,
	'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
	'pluginOptions' => [
		'tags' => true,
	]
]) ?>
</div>
<div class="col-sm-6 col-xs-6">

<?= $form->field($model, 'father_email')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'father_phone')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'mother_email')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'mother_phone')->textInput(['maxlength' => true]) ?>


</div>
</div> 


</div> 


<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
 
</div>
