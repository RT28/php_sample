<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PackageOfferings */

$this->title = 'Update Package Offerings: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Package Offerings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-offerings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status
    ]) ?>

</div>