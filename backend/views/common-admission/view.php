<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\StandardTests;
use common\models\DegreeLevel;
use common\models\University;

$standardTestsList = $model->test_id;
$standardTests = StandardTests::find()->where(['=', 'id',$model->test_id])->one();
$University = University::find()->where(['=', 'id',$model->university_id])->one();

$degree_level_id = DegreeLevel::find()->where(['=', 'id',$model->degree_level_id])->one();

/* @var $this yii\web\View */
/* @var $model common\models\UniversityCommonAdmission */

$this->title = "Common Admissions";
$this->params['breadcrumbs'][] = ['label' => 'Common Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';



?>
<div class="university-common-admission-view">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
<h1><?= Html::encode($this->title) ?></h1>
 
<div class="row">
<div class="col-sm-6" >
 
	<p><strong>University Name:</strong> <?=  $University->name ?></p>
	<p><strong>Degree Level:</strong> <?=  $degree_level_id->name ?></p>
	<p><strong>Standard Test Name:</strong> <?=  $standardTests->name ?></p>
	<p><strong>Score:</strong> <?= $model->score ?></p> 	
  
	
	</div>
	</div>
	
 
</div>
</div>
</div>
</div>
