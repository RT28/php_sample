<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Country; 
use common\models\Degree;
use common\models\Majors; 
use common\components\Status;
use common\components\Roles;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel; 
use common\models\StandardTests;
use yii\helpers\ArrayHelper;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
 
$Degree = Degree::findOne($model->degree_id);  
$major = Majors::findOne($model->major_id); 
$DegreeLevel = DegreeLevel::findOne($model->degree_level_id); 

$languageModel = Others::find()->where(['=', 'name', 'languages'])->one();
$temp = array();
if($languageModel->value!=''){
	trim($languageModel->value);	
	$temp = explode(',', $languageModel->value);
}
$language = explode(',', $model->language);   
$languages =  array_intersect_key($temp,$language);					 
$lang = implode(',', $languages);


$courseModel = Others::find()->where(['=', 'name', 'course_type'])->one();
$temp1 = array();
if($courseModel->value!=''){
	trim($courseModel->value);	
	$temp1 = explode(',', $courseModel->value);
}
$type = explode(',', $model->type);   
$types =  array_intersect_key($temp1,$type);					 
$coursetypes = implode(',', $types);

$durationModel = Others::find()->where(['=', 'name', 'duration_type'])->one();
$temp2 = array();
if($durationModel->value!=''){
	trim($durationModel->value);	
	$temp2 = explode(',', $durationModel->value);
}
$duration_type = explode(',', $model->duration_type);   
$duration_types =  array_intersect_key($temp2,$duration_type);					 
$durationTypes = implode(',', $duration_types);

 
 
  
/******* updated multiple select functionality *****/
/*$standard_test_list= explode(",",$model->standard_test_list);
foreach($standardTests as $key => $getres): 
 if(in_array($key, $standard_test_list)){ echo $getres.","; } 
endforeach;*/
			 
			 
?>
<div class="university-course-list-view">

<div class="row">
<div class="col-sm-11">
<h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="col-sm-1 pull-right">
<?= Html::a('', ['update', 'id' => $model->id], ['class' => 'glyphicon glyphicon-pencil', 'title'=>'Update']) ?>
<?= Html::a('', ['delete', 'id' => $model->id], [
	'class' => 'glyphicon glyphicon-trash ',
	 'title'=>'Delete',
	'data' => [
		'confirm' => 'Are you sure you want to delete this item?',	'method' => 'post',
	],
]) ?>

</div>
</div>
	<div class="row">
<div class="col-sm-6" >
 
  
	<p><strong>Program:</strong> <?=  $model->name ?></p>
	<p><strong>Program Code:</strong> <?= $model->program_code ?></p>
	<p><strong>Discipline:</strong> <?= $Degree->name ?> </p>
	<p><strong>Degree Level:</strong> <?= $DegreeLevel->name ?> </p>
	<p><strong>Sub Discipline:</strong> <?=  $major->name ?></p>
	<p><strong>Language:</strong> <?= $lang ?></p>
	<p><strong>Course Type:</strong> <?=  $coursetypes ?></p>	
	<p><strong>Standard Test List:</strong> <?php foreach($standardTestsData as $test){
		echo $test['name'].",";
		
	} ?></p>	
  
	
	</div>
<div class="col-sm-6">
	
	<p><strong>Intake:</strong> <?=  $model->intake ?> </p>
    <p><strong>Duration:</strong> <?=  $model->duration ?></p>
	<p><strong>Duration Type:</strong> <?=  $durationTypes ?></p>
	<p><strong>Fees :</strong> <?=  $Currency->symbol.$model->fees ?></p> 
	<p><strong>Fees for International Students:</strong> <?= $Currency->symbol.$model->fees_international_students ?></p> 
	<p><strong>Application Fee:</strong> <?=  $Currency->symbol.$model->application_fees ?></p>
	<p><strong>Application Fees International:</strong> <?= $Currency->symbol. $model->application_fees_international ?></p>
	
</div>
<div class="col-sm-12">
<p><strong>Program Website:</strong> <br/><?=  $model->program_website ?></p>
	<p><strong>Careers:</strong> <br/><?=  $model->careers ?></p>
	<p><strong>Eligibility Criteria:</strong> <br/><?=  $model->eligibility_criteria ?></p>
	<p><strong>Description:</strong> <br/><?=  $model->description ?></p>
	<br><br><br><br>
</div>
</div>
</div>
