<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PackageOfferings */

$this->title = 'Create Package Offerings';
$this->params['breadcrumbs'][] = ['label' => 'Package Offerings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-offerings-create">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model,
					'status' => $status
			    ]) ?>
			</div>
		</div>
	</div>
</div>
