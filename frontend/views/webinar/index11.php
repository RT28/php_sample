<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;

  /* @var $this yii\web\View */
  $this->title = 'Upcoming Webinars';
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
<div class="col-sm-6"><h1>Upcoming Webinars</h1>
</div>
<div class="col-sm-6">
    <p style="float: right;">
        <?= Html::a('Conduct A Webinar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
</div>
<?php $time = gmmktime();
echo date("Y-m-d H:i:s", $time);  ?>

            </div>
            <div class="home-packages">
              <?php
                $i = 0;
              ?>
              <div class="row">
                <?php foreach($webinars as $webinar):?>
                  <?php if($i % 3 == 0 && $i != 0): ?>
                    </div>
                    <div class="row mtop-40">
                  <?php endif; ?>
                    <div class="col-sm-4" style="width: 80%">
                      <!-- <a href="?r=packages/view&id=<?= $webinar->id; ?>"> -->
                      <div class="inner-block green">
                        <?php
                          $src = '../web/noprofile.gif';
                          /*if (is_dir("./../../backend/web/package_uploads/$webinar->id")) {
                            $icon = FileHelper::findFiles("./../../backend/web/package_uploads/$webinar->id", [
                              'caseSensitive' => true,
                              'recursive' => false,
                            ]);
                            if (count($icon) > 0) {
                              $src = $icon[0];
                              $src = str_replace('\\','/', $src);
                            }
                          }*/
                        ?>
                        
                        <div class="block-content">
                        <div class="university-logo"><img style="float: left; margin: 0px 15px 15px 0px;" src="<?= $src ?>" width="100" /></div>
                        
                            <h2 class="head"><?= $webinar->topic ?></h2>
                            <?php $new_date_format = date('F d, Y h:mA', strtotime($webinar->date_time)); ?>
                            <p><?= $new_date_format ?> 
                            <br> <i>Expert Speaker : <?= $webinar->author_name ?> , <?= $webinar->institution_name ?></i></p>
                        </div>
                        <div class="hblock-footer">
                            <div class="row">
                                <div class="col-md-6 no-right">
                                    <div class="apply"></div>
                                </div>
                                <div class="block-round col-md-6 hidden-sm hidden-xs">
                                    <img src="/images/FXwebinar_icon.png" alt="">
                                </div>
                                <div class="col-md-6 no-left">
                                <?php
                                    $url = '';
                                    $className = 'btn btn-blue course-apply';
                                    $text = 'Register';
                                    if (Yii::$app->user->isGuest) {
                                        $url = '/site/login';
                                        $className = 'btn btn-blue course-apply';
                                        $text = 'Register';
                                    }
                                     else {
                                        $url = '/course/shortlist';
                                        $className = 'btn btn-blue course-apply';
                                        $text = 'shortlist';
                                    }
                                ?>
                                    <div class="price">
                                    
                                      <button type="button" class="btn-review" style="background-color:transparent;border:none;" data-toggle="modal" data-target="#login-modal" value="<?= (!Yii::$app->user->isGuest) ? '/university/review?university=' . $model->id : $url ?>">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                     <!-- </a> -->
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
<?php $this->registerJsFile('@web/js/university.js');


