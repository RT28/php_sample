<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SRM */

$this->title = 'Update Consultant: ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Consultant', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="srm-update">
	<div class="container">
		<div class="row">
			<div class="col-xs- col-md-10">  
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model, 
            'countries' => $countries,
			'degrees' => $degrees,
			'agencies' => $agencies,
			'languages' => $languages,
			    ]) ?>
			</div>
		</div>
	</div>
</div>
