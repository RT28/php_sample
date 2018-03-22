<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\captcha\Captcha;
use common\models\Country;
use backend\models\SiteConfig;

$this->title = 'Contact Us';
$this->params['breadcrumbs'][] = $this->title;

  $this->context->layout = 'index';

  $codelist = Country::getAllCountriesPhoneCode();
?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content">
      <div class="section-padding">
        <div class="container">
        <div class="group-title-index">

    <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row">
        	<div class="col-sm-6">


<div class="site-contact">

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

				 <div class="row">
<div class="col-sm-4">
<?= $form->field($model, 'code')->widget(Select2::classname(), [
			'name' => 'codelist',
			'data' => $codelist,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
			'pluginOptions' => [
				'tags' => true,
			]
		]); ?>
</div>

			<div class="col-sm-8">
				<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
				</div></div>
                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('Message'); ?>

                
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-blue', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>


</div>

            </div>
        	<div class="col-sm-6">
<!--
				 <div class="contact-map" id="canvas1">
				 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1806.8363912201978!2d55.14920665795167!3d25.079077425329658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f6ca7bebcd3e9%3A0x8c9a7fc3da9b1f58!2sBrighter+Admission+Consultant+DMCC.+1602!5e0!3m2!1sen!2sin!4v1499602111005" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

        </div> -->
            </div>
        </div>
        </div>
        </div>

      </div>
    </div>
  </div>
  <!-- BUTTON BACK TO TOP-->
  <div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
</div>
