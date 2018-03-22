<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 

$this->title = 'Agency Signup';
$this->params['breadcrumbs'][] = ['label' => 'Agency Signup', 'url' =>['create']];
$this->params['breadcrumbs'][] = $this->title;
 
?>
 
<div class="create-consultant col-xs-12 col-sm-6">
  <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
        <h1><?= Html::encode($this->title) ?> </h1>

<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>

<?php $form = ActiveForm::begin() ?>
 
<div class="site-login">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-5">
<div class="panel panel-default">
 <div class="panel-heading">Create Your Credentials</div>
 <div class="panel-body">
<?= $form->field($partnerSignup, 'username')->textInput(['maxlength' => true, 'id' => 'username' ]) ?>

<?= $form->field($partnerSignup, 'password')->textInput(['type' => 'password', 'id' => 'password']) ?>

<?= $form->field($partnerSignup, 'confirm_password')->textInput(['type' => 'password', 'id' => 'confirm_password']) ?>
		
 <?= $form->field($partnerSignup, 'agree')->checkbox(['label'=>'I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Use and Policy</a>'], true)->label(''); ?>
 
 </div>
</div>
<div class="form-group">
<?= Html::submitButton('Signup', ['class' =>  'btn btn-primary', 'id' => 'btn-create' ]) ?>
</div>
</div>


</div>
</div>
 </div>
    
<?php ActiveForm::end(); ?>

 
 
</div>   
</div>
</div>
</div>


<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> 
  </div>
</div>