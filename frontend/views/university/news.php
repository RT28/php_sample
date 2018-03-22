<?php
    use yii\helpers\Html; 
    use yii\helpers\FileHelper;
    $this->context->layout = 'index';
 ?>

<div id="wrapper-content" class="notification"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
               
               
                <div class="section-padding">
                    <div class="container">
                        <div class="row"> 
                            <div class="col-sm-12">
                               <!-- <p>We believe that every student with a potential deserves the best.</p>-->
                               <h1>&nbsp;</h1>
                               <?php foreach($model as $news): ?>
                                        <h3 class="news-title"><?php echo  $news->title; ?></h3>
                                           <p class="news-info"><?php echo  $news->message; ?></p>
                                           <?php if(!empty($news->link)){ ?>
                                           <p>
                                           <a href="<?php echo $news->link; ?>" target="_blank">News link</a> 
                                           </p>
                                           <?php } ?>
                                <?php endforeach; ?>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div> 