<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\FeaturedUniversities */

$this->title = 'Create Featured Universities';
$this->params['breadcrumbs'][] = ['label' => 'Featured Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="featured-universities-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'universities' => $universities
    ]) ?>

</div>
