<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'index';

?>
<div class="site-request-password-reset container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php echo '<div class="alert alert-success" role="alert">';
                echo $message;
            echo '</div>'; ?>
        </div>
    </div>
</div>
