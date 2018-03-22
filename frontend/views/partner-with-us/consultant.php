<?php

use yii\helpers\Html; 

$this->title = 'Consultant Enquiry';
$this->context->layout = 'index';

?>

<div class="create-consultant section-padding">
  <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-10">
        <h1><?= Html::encode($this->title) ?> </h1>

			<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>


        <?= $this->render('_formconsultant', [
            'model' => $model, 
            'countries' => $countries,
			'degrees' => $degrees, 
			
        ]); ?>
    </div>   </div>
</div>
</div>
 