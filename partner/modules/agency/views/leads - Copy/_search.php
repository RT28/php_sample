<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\components\Commondata;
use common\models\Degree;
use common\models\Majors;
use common\models\Country;
use yii\helpers\ArrayHelper;
use common\models\PackageType;


$degree = Degree::getAllDegrees();
$majors = Majors::getAllMajors();
$countries = Country::getAllCountries();
$countries = ArrayHelper::map($countries, 'id', 'name');

$packages = PackageType::getPackageType();


/* @var $this yii\web\View */
/* @var $model backend\models\StudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.select2-search__field{
	width:auto !important;
}
</style>
<div class="student-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
 
    
  
 <div class="row">
		<div class="col-sm-4">
	<?= $form->field($model, 'first_name')->textInput(['placeHolder'=>'Student Name'])->label(false); ?>
	</div>	
		<div class="col-sm-4">
			<?= $form->field($model, 'degree_preference')->dropDownList($degree, ['id' => 'degrees', 'prompt' => 'Degree Preference'])->label(false); ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($model, 'majors_preference')->widget(Select2::classname(), [
			'name' => 'majors_preference',
			'data' => $majors,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Discipline Preference', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
		</div>
	</div>

		<div class="row">
		<div class="col-sm-4">
			<?= $form->field($model, 'country_preference')->widget(Select2::classname(), [
			'name' => 'countries',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Country Preference', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($model, 'begin')->dropDownList(Commondata::wanttobegin(), [ 'prompt' => 'Enrollment Year *'])->label(false); ?>
		</div>
		<div class="col-sm-4">
			<?= $form->field($model, 'package_type')->widget(Select2::classname(), [
			'name' => 'packages',
			'data' => $packages,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Preferred Package', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
		</div>
	</div>

	
		
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
