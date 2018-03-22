<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\StandardTests;
use common\models\DegreeLevel;

$standardTestsList = $model->test_id;
$standardTests = StandardTests::find()->where(['=', 'id',$model->test_id])->one();

$degree_level_id = DegreeLevel::find()->where(['=', 'id',$model->degree_level_id])->one();

/* @var $this yii\web\View */
/* @var $model common\models\UniversityCommonAdmission */

$this->title = "Common Admissions";
$this->params['breadcrumbs'][] = ['label' => 'Common Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';



?>
<div class="university-common-admission-view">

<h1><?= Html::encode($this->title) ?></h1>
 
<div class="row">
<div class="col-sm-6" >
 
	<p><strong>Degree Level:</strong> <?=  $degree_level_id->name ?></p>
	<p><strong>Standard Test Name:</strong> <?=  $standardTests->name ?></p>
	<p><strong>Score:</strong> <?= $model->score ?></p> 	
  
	
	</div>
	</div>
	
 
</div>
