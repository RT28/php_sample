<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PackageType */

$this->title = 'Create Package Type';
$this->params['breadcrumbs'][] = ['label' => 'Package Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-type-create">
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
