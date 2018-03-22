<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Agency */

$this->title = 'Create Agency';
$this->params['breadcrumbs'][] = ['label' => 'Agencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="agency-create">
  <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'countries' => $countries,
			'degrees' => $degrees,
            'message' => $message,
    ]) ?>

</div>
</div>
</div>
</div>

