<?php 
use yii\helpers\Html; 
$this->title = 'Message  '; 
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
?>
<div class="container">
<div class="row">
<div class="group-title-index">
<h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="col-xs-12">
<div class="message">
 

<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?> 

</div>
</div>
</div>
</div>