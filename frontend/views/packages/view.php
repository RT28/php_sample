<?php
    use common\models\PackageOfferings;
    use common\models\StudentPackageDetails;
    use common\models\Currency;
    use yii\helpers\FileHelper;
    $this->registerCssFile("css/slick-theme.css");
    $this->registerCssFile("css/slick.css");
    $this->title = $package->name;
    $this->context->layout = 'index';
?>
<?php if(isset($error)): ?>

<div class="alert alert-danger">
  <?= $error; ?>
</div>
<?php endif; ?>
<div id="wrapper-content">
<!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
  <div class="main-content"><!-- CONTENT-->
    <div class="content section-padding package-detail" style="background-image :url(../frontend/web/images/package-bg.jpg);">
      <div class="container">
        <div class="group-title-index">
          <h1><?= Yii::t('gtuservice', 'Our') ?></br>
            <?= Yii::t('gtuservice', 'Packages') ?></h1>
        </div>
        <div class="row">
          <div class="col-sm-8">
            <h2 class="package-title">
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
                ?>            </h2>
            <p style="text-align: justify;" class="package-content">
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
            <div class="row">
              <div class="col-sm-12">
                <?php if($package->name === 'Free Application Package'): ?>
                <?= $package->description; ?>
                <?php
                                    $href = '/site/login';
                                    $packageDetail = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id],['=', 'package_type_id', $package->id]])->one();
                                    if(!Yii::$app->user->isGuest) {
                                        if(!empty($packageDetail)) {
                                            echo '<div class="alert alert-success">You have alreay bought this package.</div>';
                                        } else {
                                            $href = '/student/buy-free-application-package?id=' . $package->id;
                                            echo '<a class="btn btn-blue btn-application-buy" href="' . $href .  '">Buy</a>';
                                        }
                                    }
                                ?>
                <?php else: ?>
                <div class="section-padding plan-list">
                  <section class="center slider package-slide">
                    <?php foreach($models as $model): ?>
                    <div>
                      <div class="plan-block">
                        <div class="plan-name">
                          <?= $model->name; ?>
                        </div>
                        <div class="plan-features">
                          <?php
                                                        $offerings = explode(',', $model->package_offerings);
                                                        $offerings = PackageOfferings::find()->where(['in', 'id', $offerings])->orderBy(['name' => 'ASC'])->all();
                                                    ?>
                          <ul>
                            <?php foreach($offerings as $offering): ?>
                            <li>
                              <?= $offering->name; ?>
                            </li>
                            <?php endforeach; ?>
                          </ul>
                          <!-- <a class="btn btn-white" href="?r=packages/offerings&id=<?= $model->id; ?>">View</a> --> 
                        </div>
                        <div class="plan-amount">
                        <?php $currency = Currency::find()->where(['=', 'id', $model->currency])->one(); echo $currency->symbol; ?> 
                        <?= $model->fees ?>
                        </div>
                        <!--<div class="short-list-link">
                                                	<a href="#"> +</a>
                                                </div>--> 
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </section>
                </div>
                <?php endif; ?>
                <?php if(Yii::$app->user->isGuest) {?>
                <a class="btn btn-blue book-session" href="/site/signup"><?= Yii::t('gtuservice', 'Book a free session with our consultant') ?></a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
      <h3 class="other-packages-title">
      <?= Yii::t('gtuservice', 'Other Packages') ?>
      </h3>
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
            <img src="<?= $src ?>" alt=""></div>
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
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
    $this->registerJsFile('js/packages.js');
?>
