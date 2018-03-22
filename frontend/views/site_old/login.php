<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="site-login">
    <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#login" aria-controls="home" role="tab" data-toggle="tab">Login</a></li>
                <li role="presentation">
                    <a href="?r=site/signup">Sign Up</a>
                </li>
            </ul>
            <?php $form = ActiveForm::begin(['id' => 'login-form', 'validationUrl' => ['site/validate-login'],
            'validateOnSubmit' => true,
            'enableAjaxValidation' => true,]); ?>
                <div class="alert alert-danger hidden">
                </div>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control login-fields'])->label('Email') ?>

                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control login-fields']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <input type="hidden" value="" name="url" id="login-redirect-url"/>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-blue', 'name' => 'login-button']) ?>
                        <?= Html::a('Forgot Password', ['site/request-password-reset']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
