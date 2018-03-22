<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker; 
use common\models\Country;
use common\models\PackageType;
use common\components\Commondata;  
 

$this->context->layout = 'index';

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;


$codelist = Country::getAllCountriesPhoneCode(); 
$phonetype = Commondata::phonetype();
$currDate = date('Y');
$currDate1 = $currDate+1;
$currDate2 = $currDate1+1;
$begin = array($currDate,$currDate1,$currDate2);

$packages = PackageType::getPackageType();
 
$qualification = array(1=>'High School',2=>'Intermediate',3=>'Diploma  or Certification',
					 4=>'Graduate',5=>'Post Graduate',6=>'Others');
$diduknow = array(1=>"Google Ad's Search/Display/Gmail",2=>"Google Organic Search",
				  3=>"Facebook / Google + / Social Media",
				  4=>"News paper / Magazine / print Media",
				  5=>"Friends / Reference/Teachers/Counsellors",
				  6=>"Events /Seminars / Work shops / School Fair",
				  7=>"Website",
				  8=>"Others"); 
?>
<!--<?php if(!empty($model->errors)): ?>

<div class="alert alert-danger" role="alert">
  <?= json_encode($model->errors); ?>
</div>
<?php endif; ?>-->
<div class="section-padding">
  <div class="site-signup container">
    <div class="row">
      <div class="col-md-6">
        <div class="group-title-index"> 
          <!--<h1><?= Html::encode($this->title) ?></h1>-->
          <h1>Get</br>
            Involved.</h1>
        </div>
        <div id="signup-status" style="display:none;"> </div>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="row">
          <div class="col-sm-6 pad-right-0">
            <?= $form->field($model, 'first_name')->textInput(['placeHolder'=>'First name *'])->label(false);?>
          </div>
          <div class="col-sm-6 pad-left-0">
            <?= $form->field($model, 'last_name')->textInput(['placeHolder'=>'Last name *'])->label(false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <?= $form->field($model, 'email')->textInput(['placeHolder'=>'Email * '])->label(false); ?>
          </div>
          <div class="col-sm-12">
            <?= $form->field($model, 'country')->dropDownList($countries, [ 'prompt' => 'Country of Residence *'])->label(false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 pad-right-0">
            <?= $form->field($model, 'password')->passwordInput(['placeHolder'=>'Password *'])->label(false); ?>
          </div>
          <div class="col-sm-6 pad-left-0">
            <?= $form->field($model, 'confirm_password')->passwordInput(['placeHolder'=>'Confirm Password *'])->label(false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2 col-xs-6 pad-right-0">
            <!--<?= $form->field($model, 'phonetype')->dropDownList($phonetype, [  'prompt' => 'Type *'])->label(false); ?>-->
            <div class="sign-up-call-ic">
            <img src="/images/call.svg" alt=""/>
            </div>
          </div>
          <div class="col-sm-4 col-xs-6 pad-0">
            <?= $form->field($model, 'code')->widget(Select2::classname(), [
			'name' => 'codelist',
			'data' => $codelist,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
          </div>
          <div class="col-sm-6 col-xs-12 pad-left-0">
            <?= $form->field($model, 'phone')->textInput(['placeHolder'=>'Phone Number *'])->label(false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <?= $form->field($model, 'degree_preference')->dropDownList($degree, ['id' => 'degrees', 'prompt' => 'Degree Preference'])->label(false); ?>
          </div>
          <div class="col-sm-12">
            <?= $form->field($model, 'majors_preference')->widget(Select2::classname(), [
			'name' => 'majors_preference',
			'data' => $majors,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Discipline Preference', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 pad-right-0">
            <?= $form->field($model, 'country_preference')->widget(Select2::classname(), [
			'name' => 'countries',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Country Preference', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
          </div>
          <div class="col-sm-6 pad-left-0">
            <?= $form->field($model, 'begin')->dropDownList($begin, [ 'prompt' => 'Enrollment Year *'])->label(false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 pad-right-0">
            <?= $form->field($model, 'package_type')->widget(Select2::classname(), [
			'name' => 'packages',
			'data' => $packages,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Preferred Package', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?>
          </div>
          <div class="col-sm-6 pad-left-0">
            <?= $form->field($model, 'qualification')->dropDownList($qualification, [ 'prompt' => 'Select Highest Qualification'])->label(false); ?>
          </div>
        </div>
        <!--<div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-6" id="eduothers" style="display:none;">
                <?= $form->field($model, 'others')->textInput(['placeHolder'=>'Please Specify'])->label(false); ?>
              </div>
            </div>
          </div>
        </div>-->
            <div class="row">
              <div class="col-sm-12">
                <?= $form->field($model, 'knowus')->dropDownList($diduknow, [ 'prompt' => 'How did you come to know about GTU'])->label(false); ?>
              </div>
              <!--<div class="col-sm-6" id="knowthers" style="display:none;">
                <?= $form->field($model, 'knowus_others')->textInput(['placeHolder'=>'Please Specify'])->label(false); ?>
              </div>-->
            </div>
        <div class="row">
          <div class="col-sm-12">
            <?= $form->field($model, 'agree')->checkbox(['class'=>'agreebox'])->label('I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Service and Privacy Statement</a>'); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <?= Html::submitButton('Register', ['class' => 'btn btn-blue', 'name' => 'signup-button', 'id' => 'signup-button']) ?>
          </div>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
      <div class="col-md-6">
        <div class="group-title-index">
          <h3>Reasons to sign up <span>on scroll</span></h3>
        </div>
        <ul class="register-info">
          <li class="active"><span></span> Access to the most updated information on courses and universities.</li>
          <li class="active"><span></span> Compare and evaluate courses and universities.</li>
          <li><span></span> Download brochures and application forms of the universities.</li>
          <li><span></span> Free advice from consultants.</li>
          <li><span></span> Optimize your search using advanced filters.</li>
          <li><span></span> Shortlist universities and programs.</li>
          <li><span></span> Simplify the application process. </li>
          <li><span></span> Stay updated about deadlines and other trends.</li>
          <li><span></span> Receive our newsletter to stay updated.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script language="javascript">
$( document ).ready(function() {
	
	$('#userlogin-qualification').on('change', function() {	  
	  if(this.value==6){	  
		  $('#eduothers').show();
	  }else{
		  $('#eduothers').hide();
	  }
	}); 
  
  	$('#userlogin-knowus').on('change', function() {	  
	  if(this.value==8){	  
		  $('#knowthers').show();
	  }else{
		  $('#knowthers').hide();
	  }
	}); 
	
});
 	
 
  /*$(document).ready(function(){
    $('#signup-button').click(function(e){
		var first_name = $('#userlogin-first_name').val();	  
		var last_name = $('#userlogin-last_name').val();
		var email = $('#userlogin-email').val();
		var country = $('#userlogin-country').val();
		var password_hash = $('#userlogin-password_hash').val();
		var phonetype = $('#userlogin-phonetype').val();
		var code = $('#userlogin-code').val();
		var phone = $('#userlogin-phone').val();
		var degree_preference = $('#degreesl').val();
		var majors_preference = $('#userlogin-majors_preference').val();
		var country_preference = $('#userlogin-country_preference').val();
		var begin = $('#userlogin-begin').val();
		var package_type = $('#userlogin-package_type').val();
		var qualification = $('#userlogin-qualification').val();
		var others = $('#userlogin-others').val();
		var knowus = $('#userlogin-knowus').val();
		var knowus_others = $('#userlogin-knowus_others').val();
      
      $.ajax({
        url: '?r=site/signup',
        method: 'POST',
        data: {
          first_name: first_name,last_name: last_name, email: email,country: country,
		  password_hash: password_hash, phonetype: phonetype, code: code, phone: phone,
		  degree_preference: degree_preference, majors_preference: majors_preference, 
		  country_preference: country_preference, begin: begin, package_type: package_type,
		  qualification: qualification, others: others, knowus: knowus, 
		  knowus_others: knowus_others, source: window.location.pathname
        },
        success: function(response) {
          response = JSON.parse(response);
          if(response.status == "success") {
            $('#signup-status').html('Thanks! You\'re subscribed to our news letters and updates.');
          } else {
            if(response.error) {
              $('#signup-status').html(email + ' is already subscribed');
            } else {
              console.error(error);
              $('#signup-status').html('We had a problem adding you to our mailing list. Please try again');
            }
          }
        },
        error: function(error) {
          console.error(error);
          $('#signup-status').html('We had a problem adding you to our mailing list. Please try again');
        }
      });
      e.preventDefault();
      return false;
    });
  });*/
</script>
<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> </div>
</div>
