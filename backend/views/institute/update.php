<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Institute */

$this->title = 'Update Institute: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Institutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="institute-update">
  <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			    	'id'=>$id,
			    	'currentTab' => $currentTab,
			    	'tabs' => $tabs,
			        'model' => $model,
			        'countries' => $countries,
			    ]) ?>
			 </div>
        </div>
    </div>
</div>
