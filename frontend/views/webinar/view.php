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
<?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link; ?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <!-- PROGRESS BARS-->
        <div class="section section-padding package" id="packages">
          <div class="container">
            <div class="group-title-index">

              <div class="row">
<div class="col-sm-6"><h1><?= $model->topic ?></h1>
</div>
<!-- <div class="col-sm-6">
    <p style="float: right;">
        <?= Html::a('Conduct A Webinar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div> -->
</div>


            </div>
            <div class="home-packages">

                    <div class="row mtop-40">
                    <div class="col-sm-4" style="width: 80%">
                      <div class="inner-block green">
                        <?php
                          $src = '../web/noprofile.gif';

                        ?>
                        <?php
                        $cover_photo_path = [];
                        $src = './noprofile.gif';
                        $is_profile = 0;
                        if(is_dir('./../web/uploads/webinar/' . $model->id . '')) {
                          $cover_photo_path = "./../web/uploads/webinar/".$model->id."/logo_170X115";
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

                        }
                        ?>
                        <div class="block-content" >
                        <div class="university-logo"><img style="float: left; margin: 0px 15px 15px 0px;" src="<?= $src ?>" width="100" /></div>
                        
                            <h2 class="head"><?= $model->topic ?></h2>
                            <?php $new_date_format = date('F d, Y h:mA', strtotime($model->date_time)); ?>
                            <p><?= $new_date_format ?> 
                            <br> <i>Expert Speaker : <?= $model->author_name ?> , <?= $model->institution_name ?></i></p>
                        </div>
                        <?php
                                if(!empty($model->country)){
                                    $country_p = array();
                                    $country_preference = explode(',',$model->country);
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
                                if(!empty($model->disciplines)){
                                    $disciplines_p = array();
                                    $disciplines_preference = explode(',',$model->disciplines);
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
                                if(!empty($model->degreelevels)){
                                    $degreelevels_p = array();
                                    $degreelevels_preference = explode(',',$model->degreelevels);
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
                                if(!empty($model->test_preperation)){
                                    $test_preperation_p = array();
                                    $test_preperation_preference = explode(',',$model->test_preperation);
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
                        else if (isset($shortlisted) && sizeof($shortlisted) > 0 && isset($shortlisted[$course->id])) {
                            $url = '/student/student-shortlisted-courses';
                            $className = 'btn btn-success course-apply';
                            $text = 'Register now for this webinar';
                        } else {
                            $url = '/course/shortlist';
                            $className = 'btn btn-blue course-apply';
                            $text = 'Join';
                        }
                    ?>
                    <a style="background-color: #212940; color: white; float: right;margin-right: 20px;" href="<?= $url ?>" class="<?= $className; ?>" type="button" data-course="<?= $model->id ?>" data-university="<?= $model->id ?>"><?= $text; ?></a>
                    
                                    
                            </div>
                        </div>
                      </div>
                      <p><b>More About <?= $model->topic ?></b></p>
                      <p style="text-align: justify;"><?= $model->webinar_description ?></b></p> <br/>
                      <p><b>About <?= $model->author_name ?></b></p>
                      <p>Email : <?= $model->email ?></p>
                      <p>Phone : +<?= $model->code ?>&nbsp;<?= $model->phone ?></p>
                      <p style="text-align: justify;"><?= $model->speaker_description ?></p> <br/>

                    </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
</div>
