<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;  
 
use kartik\select2\Select2; 
use common\models\Country;
$codelist = Country::getAllCountriesPhoneCode(); 
 

/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-enquiry-form">


<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?> 


<div class="row">
<div class="col-sm-6" style="text-align:justify;">
<div class="partner-reg">
<p>GoToUniversity aims to guide students on their path to admissions in their dream university. This portal renders an opportunity to the prospective students to connect with the universities and institutions around the world. We are reliable medium to increase your visibility to the prospective students. A number of benefits follow by joining hands with us.</p>

<h4>Universities</h4>
<ol class="partner-enq-list">
  <li><b>Global Reach:</b> Get your institution listed with us and obtain global reach. Since it’s an online platform, it is virtually present across the world. To overcome the language/cultural barriers, the prospective students will be counseled by our experienced and multilingual consultants. This will ensure a deep penetration into the global market for the institutions that are listed on the platform.</li>

  <li><b>Webinars:</b> Communicate with the students across the world by holding the webinars. Not only it’s a more cost effective way to reach prospective students in multiple regions but also the most efficient. The representatives of the universities/colleges can speak to the students and address their concerns on a real time basis.</li>

  <li><b>Dedicated University Page:</b> Every institution will be provided with the dedicated university page where all the information about the institution, courses offered, application requirements, deadlines, tuition fee, accommodation cost, pictures, videos, notification, virtual tour map and contact details are shared.  </li>

  <li><b>Partner University Dashboard:</b> Once listed the institutions will get a personalized university dashboard which controls the respective university’s page on our portal. It’s a tool that controls the university page. The universities can use it as a marketing platform to enhance their visibility on gotouniversity.com</li>

  <li><b>Analytics and Information:</b> We provide the statistics that help you analyze and understand the programs and courses that are much in demand and fit the interest of the students. This will not only help in introducing new programs but also help you in planning a strategy as per the marketing intelligence.</li>

  <li><b>Advertise and Featured Search Results:</b> The universities can advertise themselves and their courses by featuring in the search results and through the banner advertisements. </li>

</ol>

</div>
</div>
<div class="col-sm-6 site-signup">
    <?php $form = ActiveForm::begin(); ?>


	<div class="row">
	<div class="col-sm-6 pad-right-0"> 
	 <?= $form->field($model, 'name')->textInput(['placeHolder'=>'Name *'])->label(false); ?> 
	</div>
	<div class="col-sm-6 pad-left-0">
	<?= $form->field($model, 'email')->textInput(['placeHolder'=>'Email *'])->label(false) ?> 
	</div>
	</div>
	
   <div class="row">
	<div class="col-sm-6 pad-right-0"> 
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
	<div class="col-sm-6 pad-left-0">
	<?= $form->field($model, 'phone')->textInput(['placeHolder'=>'Phone *'])->label(false); ?>
	</div>
	</div>

     <div class="row">
	<div class="col-sm-6 pad-right-0"> 
	  <?= $form->field($model, 'institute_name')->textInput(['placeHolder'=>'Institute Name *'])->label(false);  ?>
	</div>
	<div class="col-sm-6 pad-left-0">
	 <?= $form->field($model, 'institute_website')->textInput(['placeHolder'=>'Website'])->label(false);  ?>
	</div>
	</div>

    
	<div class="row">
	<div class="col-sm-6 pad-right-0"> 
	<?= $form->field($model, 'institution_type')->dropDownList($institutionType, ['prompt'=>'Select Institute Type *'])->label(false);  ?>
	</div>
	<div class="col-sm-6 pad-left-0">
	<?= $form->field($model, 'country_id')->dropDownList($countries, [ 'prompt'=>'Select Country'])->label(false);  ?>
	</div>
	</div>
    

	<div class="row">
	<div class="col-sm-12"> 
	    <?= $form->field($model, 'message')->textarea(['placeHolder'=>'Message','rows' => 6])->label(false);  ?>
	</div> 
	</div>
	 
	<div class="row">
<div class="col-sm-12"> 
<?= $form->field($model, 'agree')->checkbox(['label'=>'I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Use and Policy</a>'], true)->label(''); ?>

</div> 
</div>
	 
   

    <div class="form-group">
        <?= Html::submitButton( 'Submit', [ 'class' => 'btn btn-blue', 'id' => 'signup-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
 
 
 
<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> 
  </div>
</div>