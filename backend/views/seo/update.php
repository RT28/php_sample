<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GtSeofields */

$this->title = 'Update Gt Seofields: ' . ' ' . $model->gt_id;
$this->params['breadcrumbs'][] = ['label' => 'Gt Seofields', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gt_id, 'url' => ['view', 'id' => $model->gt_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gt-seofields-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
