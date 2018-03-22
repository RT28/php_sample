<?php
use yii\helpers\Html;
use yii\bootstrap\Modal; 

/* @var $this yii\web\View */
$this->title = 'Welcome on GTU Partner universities portal';
$this->context->layout = 'index';
?>


<div id="wrapper-content"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content">
	  
      <div class="section-padding">
        <div class="site-signup container">
 		<div class="group-title-index">
                <h1>Our</br>
                Partner Portal.</h1>
              </div>
	<!-- Modal -->
	<div class="row">
	<div class="col-sm-12">
    <p>Get involved with us. We welcome you with the following four houses, </br>
    please select the prospect you identify with.</p>
    </div> 
		
 <?php //if(!empty($_GET['action']) && $_GET['action']=='signup'){ ?>
	<div class="row text-center"> 
		<div class="col-sm-3 col-xs-6">
        <a href="/partner-with-us/general">
		<div class="partner-portal-tab">
        	<img src="../../frontend/web/images/partner-form-1.svg" alt=""/>
			<h4>General Enquiry</h4>
        </div>
        </a>
    </div> 
	<div class="col-sm-3 col-xs-6">
    <a href="/partner-with-us/university-enquiry">
		<div class="partner-portal-tab">
        	<img src="../../frontend/web/images/partner-form-2.svg" alt=""/>
	<h4>University Enquiry</h4>
    </div>
    </a>
    </div>  
	<div class="col-sm-3 col-xs-6">
    <a href="/partner-with-us/agency-enquiry">
		<div class="partner-portal-tab">
        	<img src="../../frontend/web/images/partner-form-3.svg" alt=""/>
	<h4>Agency Enquiry</h4>
    </div>
    </a>
    </div> 
	<div class="col-sm-3 col-xs-6"><a href="/partner-with-us/consultant-enquiry">
		<div class="partner-portal-tab">
        	<img src="../../frontend/web/images/partner-form-4.svg" alt=""/>
	<h4>Consultant Enquiry</h4>
    	</div>
        </a>
    </div>  
	</div> 
 <?php //} ?>
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

 