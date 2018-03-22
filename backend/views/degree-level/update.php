<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DegreeLevel */

$this->title = 'Update Degree Level: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Degree Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="degree-level-update">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">

			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			</div>
		</div>
	</div>
</div>
