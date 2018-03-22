<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use common\models\PackageType;  
 
$this->title = 'Terms and Conditions';
$this->params['breadcrumbs'][] = $this->title;

  $this->context->layout = 'index';
   
  $tncDetail = PackageType::find()->where(['=', 'id', $ptid])->one(); 
?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content">
	  
      <div class="section-padding">
        <div class="container">
 
	<!-- Modal -->
	<div class="modal-dialog" style="width:1050px;">
	<div class="modal-content">  	 
	<div class="modal-body" id="modal-container">   

	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>	

	<div class="row">
	<div class="col-sm-12">
	
	<?php if(isset($tncDetail)){
		if(!empty($tncDetail->name)){
			?>
			<div class="text-center">
			<h2><?= $tncDetail->name?> </h2> 
			</div>
			<h3><?= Html::encode($this->title) ?> : </h3>
			<?php 
		}
		if(!empty($tncDetail->tnc)){
			echo $tncDetail->tnc ;  
		}		
	}else{?>
		 
	<h3>Free Admission Counseling Package </h3>
	
	<h3><?= Html::encode($this->title) ?> : </h3>
	<p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution. Your counselor will guide you through the entire application process and also about the document submissions and deadlines. You can access your student dashboard and can pin your shortlisted universities and programs for further evaluation. GTU not only enables you to track the status of your application but also speeds up theprocess thus, reducing the duration of the process.Students will be assigned a task list by their counselor which will enlist all the tasks necessary for completion of the entire application process. Through the video and chat features you will be able to chat regularly with your assigned counselor.</p>

	<p><b>Terms and Conditions : </b></p>
	<ul style="list-style: number;">
	<li>Our goal is to place you at your dream university however the admission is solely dependent on the discretion of the institution.</li>
	<li>Meeting the deadlines is very important while filling applications for the universities, so the requirements of the universities (financial and non-financial) as per the deadlines have to be met by you.</li>
	<li>Our counselors are there to help you to simplify the admission process; hence you have to provide the documents that are asked by the counselor within the timeline provided.</li>
	<li>To speak to the allotted counselor, please book the time-slot in advance as due to the high number of enquiries received the counselor will be available during the time slot booked.</li>
	<li>Though we work towards securing your admission in the institution of your choice, GTU will not be responsible for any rejection that may occur.</li>
	<li>Since it is a free package, the course fee is to be paid directly to the institution you are seeking admission in. Consequently, in case of any queries about refunds GTU will not be responsible.</li>
	<li>Though this is a free package in case of any administrative charges (if applicable) will be communicated to you by the counselor.</li>
	</ul>
		<?php }?>
	<p>  <?= $form->field($model, 'agree')->checkbox() ?> I hereby agree to abide by the terms and conditions mentioned above and I provide my consent to subscribe the free counseling package. </p>
	</div>
	</div>
	
	<?= Html::submitButton('Subscribe the free Counselling Package', ['class' => 'btn btn-blue', 'name' => 'signup-button']); ?>

<?php ActiveForm::end(); ?>
	</div>   
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
