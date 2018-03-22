<?php
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;

  /* @var $this yii\web\View */
  $this->title = 'Packages';
  $this->context->layout = 'index';
  $this->registerJsFile('@web/js/site.js');
?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <!-- PROGRESS BARS-->
        <div class="section section-padding package" id="packages">
          <div class="container">
            <div class="group-title-index">

			  <div class="row">
<div class="col-sm-6"><h1>
      	<?= Yii::t('gtuservice', 'Our') ?></br> <?= Yii::t('gtuservice', 'Packages') ?></h1>
</div>
<div class="col-sm-6">
  <?php if(Yii::$app->user->isGuest) {?>
	<a href ="/signup" class= 'btn btn-blue pull-right' target="_blank" ><?= Yii::t('gtuservice', 'Book your free session with our consultant') ?></a>
  <?php } ?>
</div>

</div>


            </div>
            <div class="home-packages">
              <?php
                $i = 0;
              ?>
              <div class="row">
                <?php foreach($packages as $package):?>
                  <?php if($i % 3 == 0 && $i != 0): ?>
                    </div>
                    <div class="row">
                  <?php endif; ?>
                    <div class="col-sm-4">
                      <a href="/packages/view?id=<?= $package->id; ?>">
                      <div class="thumbnail package-block-home">
                        <?php
                          $src = '../web/images/block-img-3.jpg';
                          if (is_dir("./../../backend/web/package_uploads/$package->id")) {
                            $icon = FileHelper::findFiles("./../../backend/web/package_uploads/$package->id", [
                              'caseSensitive' => true,
                              'recursive' => false,
                            ]);
                            if (count($icon) > 0) {
                              $src = $icon[0];
                              $src = str_replace('\\','/', $src);
                            }
                          }
                        ?>
                        <div class="package-block-image"><img src="<?= $src ?>" alt=""></div>
                        <div class="caption">
                          <h3 class="head">
                            <?php
                            if(isset($_COOKIE['lang'])){
                              $temp = 'name_'.$_COOKIE['lang']; 
                              if(isset($package->$temp)){
                                echo $package->$temp; 
                              }else{
                                echo $package->name; 
                              }
                            }else{
                              echo $package->name; 
                            } 
                            ?>
                          </h3>
                          <p>
                            <?php
                            if(isset($_COOKIE['lang'])){
                              $temp = 'description_'.$_COOKIE['lang']; 
                              if(isset($package->$temp)){
                                echo $package->$temp; 
                              }else{
                                echo $package->description; 
                              }
                            }else{
                              echo $package->description; 
                            } 
                            ?>
                          </p>
                        </div>
                      </div>
                     </a>
                    </div>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/easyNotify.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>

