<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Currency */

$this->title = 'Create Currency';
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="currency-create">
<div class="container">
		<div class="row">
			<div class="col-xs- col-md-12">
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model,
			        'countries' => $countries
			    ]) ?>
			</div>
		</div>
</div>

</div>
