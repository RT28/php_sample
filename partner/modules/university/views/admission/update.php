<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityAdmission */

$this->title = 'Update University Admission: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'University Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'profile';
?>
<div class="university-admission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model, 
		'degreeLevels' => $degreeLevels,
		'intake' => $intake,
		'programs' => $programs,
		
    ]) ?>

</div>
