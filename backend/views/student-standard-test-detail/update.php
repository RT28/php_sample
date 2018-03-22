<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentStandardTestDetail */

$this->title = 'Update Student Standard Test Detail: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Standard Test Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-standard-test-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'subjects'=>$subjects,
    ]) ?>

</div>
