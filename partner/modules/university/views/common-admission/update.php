<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityCommonAdmission */

$this->title = 'Update Common Admission: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Common Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'profile';
?>
<div class="university-common-admission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'standardTests' =>$standardTests,
		'degreeLevels' => $degreeLevels,
    ]) ?>

</div>
