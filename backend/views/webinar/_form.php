<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker; 
use kartik\select2\Select2;
use common\models\Country;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use common\models\StandardTests;



/* @var $this yii\web\View */
/* @var $model common\models\WebinarCreateRequest */
/* @var $form yii\widgets\ActiveForm */
$codelist = Country::getAllCountriesPhoneCode();
$testpreperation = StandardTests::getAllStandardTests();
/*$testpreperation = array('1'=>'TOEFL','2'=>'IELTS','3'=>'SAT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT','1'=>'SAT','2'=>'GMAT','3'=>'ACT',);
*/
?>
<?php
if(!$model->isNewRecord){
    $initialPreview = [];
    $initialPreviewConfig =[];
    if (is_dir("./../../frontend/web/uploads/webinar/$model->id/")) {
        $cover_photo_path = FileHelper::findFiles("./../../frontend/web/uploads/webinar/$model->id/", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => [$model->logo_image]
        ]);       
    
        if (count($cover_photo_path) > 0) {
            $initialPreview = [Html::img($cover_photo_path[0], ['title' => $model->topic, 'class' => 'photo-thumbnail'])];            
        }
    }
} else { $initialPreview = ''; }    
?>
<div class="webinar-create-request-form">
    <?php $form = ActiveForm::begin(['id'=>'webinar-active-form',
      //'validateOnSubmit' => true,
 //'enableAjaxValidation' => true,
 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?> 
        </div>
        <div class="col-sm-6"> 
            <?= $form->field($model, 'author_name')->textInput(['maxlength' => true])->label('Speaker Name') ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'webinar_description')->textArea(['maxlength' => true])->label('Description about topic') ?> 
        </div>
        <div class="col-sm-6"> 
            <?= $form->field($model, 'speaker_description')->textArea(['maxlength' => true])->label('Description about speaker') ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true])->label('University/Institution') ?> 
        </div>
        <div class="col-sm-6"> 
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'date_time')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Select date and time ...'],
                    //'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd hh:ii',
                        //'startDate' => '01-Mar-2014 12:00 AM',
                        'autoclose'=>true,
                        'todayHighlight' => true
                        ]
            ]) ?> 
        </div>

        <div class="col-sm-3 col-xs-6">
                <?= $form->field($model, 'code')->widget(Select2::classname(), [
                    'name' => 'codelist',
                    'data' => $codelist,
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
                    'pluginOptions' => [
                        'tags' => true,
                    ]
                ])?>
        </div>
        <div class="col-sm-3"> 
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <label>Category</label>
<div class="category" style="border-style: dotted;">
    <div class="row">
        
        <div class="col-sm-6"> 
        <?php if($model->country){
                    $model->country = explode(',',$model->country); 
                }
            ?>
        <?= $form->field($model, 'country')->widget(Select2::classname(), [
                'name' => 'country',
                'data' => $countries,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Select Country', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                ]
            ]) ?>
        </div>
        <div class="col-sm-6"> 
        <?php 
				if($model->disciplines){
					$model->disciplines = explode(',',$model->disciplines); 
				}
			?>
        <?= $form->field($model, 'disciplines')->widget(Select2::classname(), [
            'name' => 'disciplines',
            'data' => $majors,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Discipline Preference', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
            ]
        ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6"> 
        <?php if($model->degreelevels){
                    $model->degreelevels = explode(',',$model->degreelevels); 
                }
            ?>
            <?= $form->field($model, 'degreelevels')->widget(Select2::classname(), [
                'name' => 'degreelevels',
                'data' => $degree,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Degree Levels', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                ]
            ]) ?>
        </div>
        <div class="col-sm-6"> 
            <!-- <?= $form->field($model, 'university_admission')->textInput(['maxlength' => true]) ?> --> 
            <?php if($model->test_preperation){
                    $model->test_preperation = explode(',',$model->test_preperation); 
                }
            ?>
            <?= $form->field($model, 'test_preperation')->widget(Select2::classname(), [
                'name' => 'test_preperation',
                'data' => $testpreperation,
                'maintainOrder' => true,
                'options' => ['placeholder' => 'Test Peration', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                ]
            ]) ?>
        </div>
        
    </div>
</div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($upload, 'logoFile')->widget(FileInput::classname(), [
				/*'options' => [
					'accept' => 'image/*'
				],*/
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
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
