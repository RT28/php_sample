<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker; 
use kartik\select2\Select2;
use common\models\Country;




/* @var $this yii\web\View */
/* @var $model common\models\WebinarCreateRequest */
/* @var $form yii\widgets\ActiveForm */
$codelist = Country::getAllCountriesPhoneCode();
?>

<div class="webinar-create-request-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'author_name')->textInput(['maxlength' => true])->label('Speaker Name') ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'institution_name')->textInput(['maxlength' => true])->label('University/Institution') ?> 
        </div>
    </div>
    <div class="row">
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
    </div>
    <div class="row">
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
<?php if(!$model->isNewRecord){   ?>

    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'logo_image')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'country')->dropDownList($countries, [ 'prompt' => 'Country']) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
        <?= $form->field($model, 'disciplines')->widget(Select2::classname(), [
            'name' => 'disciplines',
            'data' => $majors,
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Discipline Preference', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
            ]
        ])?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'degreelevels')->dropDownList($degree, ['id' => 'degrees', 'prompt' => 'Degree Preference'])->label('Degree Preferences') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'university_admission')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6"> 
            <?= $form->field($model, 'test_preperation')->textInput(['maxlength' => true]) ?> 
        </div>
    </div>
  
  <?php } ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
