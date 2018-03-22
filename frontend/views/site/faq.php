<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use common\models\Country;
use backend\models\SiteConfig;
 
$this->title = 'FAQs';
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
          <div class="col-sm-12">
      
<!-- ------------------------------------------------------------------------------------------------------------- -->   
<div class="section-padding faq-page">

<ul class="nav nav-tabs faq-tabs">
<?php
$activeDiv = '';
$j = 0;
foreach ($faqcategory as $categorySingle) { if($j==0) { $activeDiv = 'active'; ?> 
<script type="text/javascript">$(document).ready(function(){
        get_faqList('<?php echo $categorySingle['id']; ?>');
        
    });</script> <?php } else { $activeDiv = ''; }
?>
<li class="<?php echo $activeDiv;?>"><a class="faq-button" href="#tab-<?php echo $categorySingle['id']; ?>" data-toggle="tab" aria-expanded="false" onclick="get_faqList('<?php echo $categorySingle['id']; ?>');">
<?php  echo $categorySingle['category']; ?></a></li>

<?php $j++ ;} ?>  
</ul>

<div class="tab-content clearfix">

  <div class="faq-section">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i=0; foreach ($faq as $faqSingle) { if($i==0) { $open_answer = ''; } else { $open_answer = ''; }?>
                <div class="tab-pane <?php echo $activeDiv;?> tab-<?php echo $faqSingle['category_id']; ?>"  style='display: none;'>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>" class="collapsed">
                      <h4 class="panel-title">
                          <?php echo $faqSingle['question']; ?>
                        <i class="fa fa-plus pull-right" aria-hidden="true"></i>
                      </h4>
                        </a>
                    </div>
                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php echo $open_answer; ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                      <div class="panel-body">
                        <?php echo $faqSingle['answer']; ?>
                      </div>
                    </div>
                  </div>
                </div>  
                <?php $i++ ;} ?>  

              </div>
</div>

</div>
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
<script type="text/javascript">
  function get_faqList(id){
    $('.tab-pane').hide();
    $('.tab-'+id).show();
  }
</script>
