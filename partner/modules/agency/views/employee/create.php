<?php

use yii\helpers\Html;
 
$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employee', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
    $this->context->layout = 'main';
?>
<div class="consultant-create">
	<div class="container">
		<div class="row">
			<div class="col-xs- col-md-10">  
			    <h1><?= Html::encode($this->title) ?></h1>
<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
			  <?= $this->render('_form', [
            'model' => $model, 
			'partnerLogin' => $partnerLogin,
            'countries' => $countries,
			'degrees' => $degrees,
            'message' => $message,
			
        ]); ?>
			</div>
		</div>
	</div>
</div>
