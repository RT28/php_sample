<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UniversityAdmission */

$this->title = 'Create University Admission';
$this->params['breadcrumbs'][] = ['label' => 'University Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-admission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,		
		'degreeLevels' => $degreeLevels,
		'intake' => $intake,
		'programs' => $programs,
    ]) ?>

</div>
