<?php
    $this->title = $model->name;
    $this->context->layout = 'index';
    use yii\helpers\FileHelper;
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
                <div class="section-padding service-detail" style="background-image :url(images/services-bg.jpg);">
        	        <div class="container">
                    <div class="group-title-index">
                        <h1><?= Yii::t('gtuservice', 'Our') ?><br> <?= Yii::t('gtuservice', 'Services.') ?></h1>
                        <p class="service-name">
                        <?php
                        if(isset($_COOKIE['lang'])){
                          $temp = 'name_'.$_COOKIE['lang']; 
                          if(isset($model->$temp)){
                            echo $model->$temp; 
                          }else{
                            echo $model->name; 
                          }
                        }else{
                          echo $model->name; 
                        } 
                        ?>
                        </p>
                      </div>
            	        <div class="row">
                	        <div class="col-sm-7">
                                <!--<?php 
                                    $backgroundImage = './../../backend/web/default-university.png';
                                    if (is_dir('./../../backend/web/services-uploads/'. $model->id . '/')) {
                                        $path = FileHelper::findFiles('./../../backend/web/services-uploads/' . $model->id . '/', [
                                            'caseSensitive' => true,
                                            'recursive' => false,
                                            'only' => ['icon.*']
                                        ]);

                                        if (count($path) > 0) {
                                            $backgroundImage = $path[0];
                                            $backgroundImage = str_replace("\\","/",$backgroundImage);
                                        }
                                    }
                                ?>-->
                                <!--<img src="<?= $backgroundImage; ?>" alt="<?= $model->name; ?>" /> -->
                                <div class="service-content">
                                  <?php
                                  if(isset($_COOKIE['lang'])){
                                    $temp = 'description_'.$_COOKIE['lang']; 
                                    if(isset($model->$temp)){
                                      echo $model->$temp; 
                                    }else{
                                      echo $model->description; 
                                    }
                                  }else{
                                    echo $model->description; 
                                  } 
                                  ?>
                                </div>
                                <?php if(Yii::$app->user->isGuest) {?>
                                  <a class="btn btn-blue book-session" href="/site/signup">Book a free session with our consultant</a>
                                  <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
      <h3 class="other-packages-title">
      	<?= Yii::t('gtuservice', 'Other Packages') ?>
      </h3>
      <?php $i = 0; ?>
        <div class="other-packages">
          <?php foreach($packages as $package):?>
          <a href="/packages/view?id=<?= $package->id; ?>">  
          <div class="thumbnail package-block-home">
            <div class="package-block-image">
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
            <img src="<?= $src ?>" alt="<?= $package->name ?>">
            </div>
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
          <?php $i++; 
          endforeach; ?>
        </div>
      </div>
                </div>
            </div>
        </div>
    </div>
</div>