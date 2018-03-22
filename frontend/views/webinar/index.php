<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;
  use common\models\Country; 
  use common\models\DegreeLevel;
  use common\models\Majors; 
  use common\models\StandardTests;

  /* @var $this yii\web\View */
  $this->title = 'Upcoming Webinars';
  $this->context->layout = 'index';
  //$this->registerJsFile('@web/js/site.js');
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
<!-- <div class="col-sm-6">
    <p style="float: right;">
        <?= Html::a('Conduct A Webinar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div> -->
</div>


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
                        <?php
                        $cover_photo_path = [];
                        $src = './noprofile.gif';
                        $is_profile = 0;
                        if(is_dir('./../web/uploads/webinar/' . $webinar->id . '')) {
                          $cover_photo_path = "./../web/uploads/webinar/".$webinar->id."/logo_170X115";
                          if(glob($cover_photo_path.'.jpg')){
                            $src = $cover_photo_path.'.jpg';
                            $is_profile = 1;
                          } else if(glob($cover_photo_path.'.png')){
                            $src = $cover_photo_path.'.png';
                            $is_profile = 1;
                          } else if(glob($cover_photo_path.'.gif')){
                            $src = $cover_photo_path.'.gif';
                            $is_profile = 1;
                          }
                          /*$cover_photo_path = FileHelper::findFiles('./../web/uploads/' . $user->id . '/profile_photo/', [
                            'caseSensitive' => true,
                            'recursive' => false,
                            //'only' => ['profile_photo.*']
                          ]);*/
                        }
                        ?>
                        <a href="/webinar/view?id=<?php echo $webinar->id; ?>">
                        <div class="block-content" >
                        <div class="university-logo"><img style="float: left; margin: 0px 15px 15px 0px;" src="<?= $src ?>" width="100" /></div>
                        
                            <h2 class="head"><?= $webinar->topic ?></h2>
                            <?php $new_date_format = date('F d, Y h:mA', strtotime($webinar->date_time)); ?>
                            <p><?= $new_date_format ?> 
                            <br> <i>Expert Speaker : <?= $webinar->author_name ?> , <?= $webinar->institution_name ?></i></p>
                        </div>
                        </a>
                        <?php
                                if(!empty($webinar->country)){
                                    $country_p = array();
                                    $country_preference = explode(',',$webinar->country);
                                    $arr = Country::find()->select('name')->where(['in', 'id', $country_preference]) 
                                    ->orderBy(['name'=>'ASC'])->all();        
                                    foreach($arr as $cnt) {
                                      $country_p [] = $cnt['name'];
                                    }
                                      if(isset($country_p)){
                                        $countryVal = implode(', ',$country_p);
                                        
                                      }
                                    } 
                                ?>
                        <?php
                                if(!empty($webinar->disciplines)){
                                    $disciplines_p = array();
                                    $disciplines_preference = explode(',',$webinar->disciplines);
                                    $arr = Majors::find()->select('name')->where(['in', 'id', $disciplines_preference]) 
                                    ->orderBy(['name'=>'ASC'])->all();        
                                    foreach($arr as $cnt) {
                                      $disciplines_p [] = $cnt['name'];
                                    }
                                      if(isset($disciplines_p)){
                                        $disciplinesVal = implode(', ',$disciplines_p);
                                        
                                      }
                                    } 
                                ?>
                          <?php
                                if(!empty($webinar->degreelevels)){
                                    $degreelevels_p = array();
                                    $degreelevels_preference = explode(',',$webinar->degreelevels);
                                    $arr = DegreeLevel::find()->select('name')->where(['in', 'id', $degreelevels_preference]) 
                                    ->orderBy(['name'=>'ASC'])->all();        
                                    foreach($arr as $cnt) {
                                      $degreelevels_p [] = $cnt['name'];
                                    }
                                      if(isset($degreelevels_p)){
                                        $degreelevelsVal = implode(', ',$degreelevels_p);
                                        
                                      }
                                    } 
                                ?>
                            <?php
                                if(!empty($webinar->test_preperation)){
                                    $test_preperation_p = array();
                                    $test_preperation_preference = explode(',',$webinar->test_preperation);
                                    $arr = StandardTests::find()->select('name')->where(['in', 'id', $test_preperation_preference]) 
                                    ->orderBy(['name'=>'ASC'])->all();        
                                    foreach($arr as $cnt) {
                                      $test_preperation_p [] = $cnt['name'];
                                    }
                                      if(isset($test_preperation_p)){
                                        $test_preperationVal = implode(', ',$test_preperation_p);
                                        
                                      }
                                    } 
                                ?>        

                        <div class="hblock-footer">
                            <div class="row">
                                <div class="price" >
                                    <p><?php echo $countryVal;?></p>
                                    <p><?php echo $disciplinesVal;?></p>
                                    <p><?php echo $degreelevelsVal;?></p>
                                    <p><?php echo $test_preperationVal;?></p>
                                    </div>
                                <!-- <div class="block-round col-md-6 hidden-sm hidden-xs">
                                    <img src="/images/FXwebinar_icon.png" alt="">
                                </div> -->
                                <?php
                        $url = '';
                        $className = 'btn btn-blue course-apply';
                        $text = 'Join';
                        if (Yii::$app->user->isGuest) {
                            $url = '/site/login';
                            $className = 'btn ';
                            $text = 'Register now for this webinar';
                        }
                         else {
                            $url = '/course/shortlist';
                            $className = 'btn btn-blue course-apply';
                            $text = 'Join';
                        }
                    ?>
                    <a style="background-color: #212940; color: white; float: right;margin-right: 20px;" href="<?= $url ?>" class="<?= $className; ?>" type="button" data-course="<?= $webinar->id ?>" data-university="<?= $webinar->id ?>"><?= $text; ?></a>
                    
                                    <!-- <a style="background-color: green;" href ="" class= 'btn btn-blue' >Register</a> -->
                                    
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
