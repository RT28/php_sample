<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\FeaturedUniversities */

$this->title = 'Update Featured Universities: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Featured Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="featured-universities-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'universities' => $universities
    ]) ?>

</div>
