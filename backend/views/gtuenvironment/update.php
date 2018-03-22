<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GtuEnvironment */

$this->title = 'Update Gtu Environment: ' . $model->gt_id;
$this->params['breadcrumbs'][] = ['label' => 'Gtu Environments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gt_id, 'url' => ['view', 'id' => $model->gt_id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="gtu-environment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
