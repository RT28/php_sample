<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Employee */

$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="employee-create">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
	    	<h1><?= Html::encode($this->title) ?></h1>
		    <?= $this->render('_form', [
		        'model' => $model,
		        'countries'=> $countries,
		        'loginmodel'=>$loginmodel,
		    ]) ?>
		    </div>
		</div>
	</div>
</div>
