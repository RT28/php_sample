<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Access Token';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'index';
?>
<div class="site-reset-password container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please Enter Access Token:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'access-token-form']); ?>

                <input name="access-token"></input>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
