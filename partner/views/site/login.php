<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-5">
<h1><?= Html::encode($this->title) ?></h1>


<?php if(Yii::$app->session->getFlash('Error')): ?>
    <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>

<p>Please fill out the following fields to login:</p>



<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Username *') ?>

<?= $form->field($model, 'password')->passwordInput()->label('Password *') ?>

<?= $form->field($model, 'rememberMe')->checkbox() ?>
<div class="form-group">
<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
