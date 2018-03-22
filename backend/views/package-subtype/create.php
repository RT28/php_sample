<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PackageSubtype */

$this->title = 'Create Package Subtype';
$this->params['breadcrumbs'][] = ['label' => 'Package Subtypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-subtype-create">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model,
			        'packageType' => $packageType,
			        'currency' => $currency,
			        'limitType' => $limitType,
			        'packageOfferings' => $packageOfferings
			    ]) ?>
			 </div>
		</div>
	</div>
</div>
