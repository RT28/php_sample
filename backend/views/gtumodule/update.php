<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GtuModule */

$this->title = 'Update Gtu Module: ' . $model->gt_id;
$this->params['breadcrumbs'][] = ['label' => 'Gtu Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gt_id, 'url' => ['view', 'id' => $model->gt_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="gtu-module-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
