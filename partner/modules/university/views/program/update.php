<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityCourseList */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Update Program', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$this->context->layout = 'profile';
?>
<div class="university-course-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

   
	 <?= $this->render('_form', [
        'model' => $model, 
        'degree' => $degree, 
        'majors' => $majors,          
        'courseType' => $courseType, 
        'degreeLevels' => $degreeLevels,
        'languages' => $languages,
        'intake' => $intake, 
        'durationType' =>$durationType,
        'standardTests' => $standardTests,
		'Currency' => $Currency
    ]) ?>

</div>
