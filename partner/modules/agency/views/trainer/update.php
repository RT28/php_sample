<?php

use yii\helpers\Html;
 
$this->title = 'Update ' . $model->first_name. ' '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Trainer', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update'; 
    $this->context->layout = 'main';
?>
<div class="consultant-update">
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
			'countries' => $countries,
			'degrees' => $degrees, 
			'languages' => $languages,
			]) ?>
			</div>
		</div>
	</div>
</div>
