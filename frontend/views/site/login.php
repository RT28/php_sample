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
	  
        <div class="form-group col-sm-12 text-center">
	<div class="col-sm-6 text-right">
	<label class="control-label login-radio active">
	<input type="radio" name="loginpage" value="0" checked="checked" onchange="menuTypeChange(this);"> Student
	</label>
	</div>
	<div class="col-sm-6 text-left">
	<label class="control-label login-radio">
	<input type="radio" name="loginpage" value="1" onchange="menuTypeChange(this);" > Others  
	</label>
	</div>

	</div>
		
	<div id="studentloginform">
	<div class="col-xs-12"> 
	
	
	<?php $form = ActiveForm::begin(['id' => 'login-form','action' => '/site/login', 'options' => ['enctype' => 'multipart/form-data'], 'validationUrl' => ['site/validate-login'],
	'validateOnSubmit' => true,
	'enableAjaxValidation' => true, ]); ?>
	<div class="alert alert-danger hidden">
	</div>
 
	<div class="col-xs-12">
	<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control login-fields'])->label('Email') ?>
	<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control login-fields']) ?>
	
	
	<?= $form->field($model, 'rememberMe')->checkbox() ?>
	<input type="hidden" value="" name="url" id="login-redirect-url"/>

	<?= Html::submitButton('Get In', ['class' => 'btn btn-primary btn-blue login-button', 'id' => 'get_in_btn', 'name' => 'login-button']) ?>
	<?= Html::a('Forgot Password', ['site/request-password-reset']) ?>
	<a  class="create-ac"  onclick="askSignupFor();" >Don’t Have an Account? Sign Up</a>
	<?php ActiveForm::end(); ?> 
	</div>

	</div>
	</div> 
	 
	<div id="partnerloginform" style="display:none;" >
	<div class="col-xs-12"> 
	<?php $form = ActiveForm::begin(['id' => 'login-form','action' => Url::to('partner/web/index.php?r=site/login', true), 'options' => ['enctype' => 'multipart/form-data'], 'validationUrl' => ['site/validate-login'],
	'validateOnSubmit' => true,
	'enableAjaxValidation' => true, ]); ?>
	<div class="alert alert-danger hidden">
	</div> 
	<div class="col-xs-12">
	<?= $form->field($partnerLogin, 'username')->textInput(['autofocus' => true, 'class' => 'form-control login-fields'])->label('Email') ?>
	<?= $form->field($partnerLogin, 'password')->passwordInput(['class' => 'form-control login-fields']) ?>
	<?= Html::a('Forgot Password', ['site/request-password-reset']) ?>
	<!--<?= $form->field($partnerLogin, 'rememberMe')->checkbox() ?>-->
	<input type="hidden" value="" name="url" id="login-redirect-url"/>

	<?= Html::submitButton('Get In', ['class' => 'btn btn-primary btn-blue login-button', 'name' => 'login-button']) ?>
	
	<?php ActiveForm::end(); ?> 
	</div>

	</div>
	</div>
	
	
    </div>
	
	<?php $form = ActiveForm::begin(['id' => 'signup-form', 'action' => '/site/signup', 'options' => [ 'enctype' => 'multipart/form-data']]); ?>
			 
		<div class="row">
		 	 
		
		
			<div id="partnerlink" style="display:none;" > 
			<div class="form-group col-sm-12">
			<div class="col-xs-3 ">&nbsp;
			</div>
		
		<div class="col-xs-9 ">&nbsp;
		
			<div class="col-sm-3  ">
			<label class="control-label login-radio active">
			<input type="radio" name="signup" value="0" checked="checked" onchange="signupPage(this);"> Student
			</label>
			</div>
			<div class="col-sm-3 ">
			<label class="control-label login-radio">
			<input type="radio" name="signup" value="1" onchange="signupPage(this);" > Others  
			</label>
			</div> 
				<div class="form-group">
                    <div class="col-sm-3 text-center">
                        <?= Html::submitButton('Go', ['class' => 'btn btn-primary btn-blue', 'name' => 'signup-button']) ?> 
                    </div>
                </div>
			</div>	
			</div> 
			</div>
			 
		
		</div>
		<?php ActiveForm::end(); ?>	
</div>

<script language="javascript">

function askSignupFor() {
	var x = document.getElementById("partnerlink");
	//$('#get_in_btn').hide();
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
	 
}

function menuTypeChange(radioButtonList){ 
	
var rates = document.getElementsByName('loginpage');
var rate_value;
for(var i = 0; i < rates.length; i++){
    if(rates[i].checked){
        rate_value = rates[i].value;		
    }
}
if(rate_value==0){ 
	document.getElementById("studentloginform").style = "display:block"; 
	document.getElementById("partnerloginform").style = "display:none"; 
}
if(rate_value==1){
	document.getElementById("partnerloginform").style = "display:block"; 
	document.getElementById("studentloginform").style = "display:none"; 
}
}


function signupPage(radioButtonList){ 
 
var rates = document.getElementsByName('signup');
var rate_value;
for(var i = 0; i < rates.length; i++){
    if(rates[i].checked){
        rate_value = rates[i].value;		
    }
}
if(rate_value==0){ 
	document.getElementById("signup-form").action =   '/site/signup';  
}
if(rate_value==1){
	document.getElementById("signup-form").action = '<?=Url::to('partner/web/index.php?r=site/index', true)?>';  
}
}
 $('label.login-radio').click(function () {
        $('label.login-radio').removeClass('active');
        $(this).addClass('active');
    });

    $('label.login-radio:checked').parent().addClass('active');
  </script>
