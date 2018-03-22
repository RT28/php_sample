<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SRM */

$this->title = 'Create Consultant';
$this->params['breadcrumbs'][] = ['label' => 'Consultant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="srm-create">
	<div class="container">
		<div class="row">
			<div class="col-xs- col-md-11">  
			    <h1><?= Html::encode($this->title) ?></h1>

			  <?= $this->render('_form', [
            'model' => $model, 
            'countries' => $countries,
			'degrees' => $degrees,
			'agencies' => $agencies,
			'languages' => $languages,
            'message' => $message,
			
        ]); ?>
			</div>
		</div>
	</div>
</div>
