<?php
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;

  /* @var $this yii\web\View */
  $this->title = 'Privacy Statement';
  $this->context->layout = 'index';
  $this->registerJsFile('@web/js/site.js');
?>

<div id="wrapper-content" class="content-page"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
                <div class="section-padding">
        	        <div class="container">
            	        <div class="row">
                	        <div class="col-sm-12">
                                <?= $policy; ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
