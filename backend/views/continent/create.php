<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\Models\Continent */

$this->title = 'Create Continent';
$this->params['breadcrumbs'][] = ['label' => 'Continents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar'; 
?>
<div class="continent-create">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'countriesList' => $countriesList,
    ]) ?>

</div>
</div>
</div>
</div>