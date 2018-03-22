<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
$this->context->layout = 'index';

$this->title = 'Account Activation';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="wrapper-content" class="account-activation"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
                <div class="container">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php 
                        if(isset($status)) {
                            if ($status === 'success') {
                                echo '<div class="alert alert-success" role="alert">';
                                    echo 'Please activate your account using the mail in your inbox';
                                echo '</div>';
                            }
                            elseif($status === 'error') {
                                echo '<div class="alert alert-danger" role="alert">';
                                    echo $error;
                                echo '</div>';
                            }
                            if(isset($id) && isset($email)) {
                                echo Html::a('Resend Activation Link', ['resend-activation-link', 'id' => $id, 'email' => $email], ['class' => 'btn btn-primary']);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>