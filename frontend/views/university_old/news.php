<?php
    use yii\helpers\Html; 
	use yii\helpers\FileHelper;
	$this->context->layout = 'index';
 ?>

<div id="wrapper-content" class="about-us"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
               
               
                <div class="section-padding">
        	        <div class="container">
            	        <div class="row"> 
                	        <div class="col-sm-12">
                               <!-- <p>We believe that every student with a potential deserves the best.</p>-->
                               
    <h1><?php echo  $model->title; ?></h1>
	   <?php echo  $model->message; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div> 