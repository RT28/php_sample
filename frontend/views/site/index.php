<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use common\components\ConnectionSettings;
use yii\web\JqueryAsset;
use common\models\Country;
use yii\helpers\Html;

$contriesData = Country::find()->where(['=', 'status', '1'])->all();

/* @var $this yii\web\View */
$this->title = 'Go to University';
$this->context->layout = 'index';
$this->registerJsFile('@web/js/site.js' );
$this->registerCssFile('@web/css/jqvmap.css');


$this->registerJsFile('@web/js/jquery.vmap.js',['position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/jquery.vmap.world.js',['position' => \yii\web\View::POS_END] );
$this->registerJsFile('@web/js/jquery.vmap.sampledata.js',['position' => \yii\web\View::POS_END]);

$this->registerJs("
jQuery(document).ready(function(){
  jQuery('#vmap').vectorMap({
          map: 'world_en',
          backgroundColor: '#f0f0f0',
          color: '#03f29a',
          hoverOpacity: 0.7,
          selectedColor: '#08f29b',
          enableZoom: true,
          showTooltip: true,
      showLabels : false,
          scaleColors: ['#b4fae0', '#a3fad9','#6af6c1', '#61b596','#07f29b', '#d5fcee'],
          values: sample_data,
          normalizeFunction: 'polynomial',
      onRegionOver :function (event, code, region){
        $.ajax({
            url: '/site/countydata/',
            method: 'GET',
      data: {
                code: code,
            },
            success: function(response, data) {
        response = JSON.parse(response);
        var name = response.name;
        var universities = response.universities;
        var courses = response.courses;
        var resdata = '<div class=\"country-name\">'+name+'</div>  <span class=\"count\">'+universities+'</span><br/> Universities <br/> <span class=\"count\">'+courses+'</span><br/> Programs</div>';
                $('.maptitlebox').html(resdata);
                 
            }
      });

     },onRegionClick:function (event, code, region){
        window.location.href = '/university/index?region=' + region;
    },
        });
    }) ;",\yii\web\View::POS_END
);

$this->registerJs("
jQuery(document).ready(function(){

  function getCountyData(code){
  alert(code);
        $.ajax({
            url: '/site/countydata/',
            method: 'GET',
      data: {
                code: code,
            },
            success: function(response, data) {
                response = JSON.parse(response);
                return  response;
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    }) ;",\yii\web\View::POS_END
);
?>

<div id="wrapper-content"> 
  <!-- PAGE WRAPPER-->
  <div id="page-wrapper"> 
    <!-- MAIN CONTENT-->
    <div class="main-content"> 
      <!-- CONTENT-->
      <div class="content"> 
        <!-- SLIDER BANNER-->
        <div class="banner" id="banner">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h1 class="banner-tag-line"><?= Yii::t('gtuhome', 'Plan your next') ?>  </br>
                 <?= Yii::t('gtuhome', 'community.') ?> </br>
                 <?= Yii::t('gtuhome', 'Go to your') ?> </br>
                 <?= Yii::t('gtuhome', 'dream university.') ?> </h1>
                  <div class="form-tigger-block">
                    <button class="btn btn-blue form-tigger"><?= Yii::t('gtuhome', 'Find Your Program') ?></button>
                  </div>
              </div>
              <div class="col-sm-6 search-form-univ">
                <div class="banner-form">
                  <form class="search-form">
                    <div class="digree-tabs">
                      <label class="radio-banner checked">
                      <input type="radio" name="degree-level" id="inlineRadio1" value="Bachelors" checked>
                      <div class="text-center form-caps"> <img src="/images/bachelors-ic.png" alt=""/>
                        <h5 class="uni-type"><?= Yii::t('gtuhome', 'Bachelors') ?></h5>
                      </div>
                      </label>
                      <label class="radio-banner">
                      <input type="radio" name="degree-level" id="inlineRadio2" value="Masters">
                      <div class="text-center form-caps"> <img src="/images/masters-ic.png" alt=""/>
                        <h5 class="uni-type"><?= Yii::t('gtuhome', 'Masters') ?></h5>
                      </div>
                      </label>
                      <label class="radio-banner">
                      <input type="radio" name="degree-level" id="inlineRadio3" value="Phd">
                      <div class="text-center form-caps"> <img src="/images/phd-ic.png" alt=""/>
                        <h5 class="uni-type"><?= Yii::t('gtuhome', 'Phd') ?></h5>
                      </div>
                      </label>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="auto-complete-container">
                          <input type="text" class="form-control" id="region" placeholder="Country, University..." name="region">
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="auto-complete-container">
                           <input type="text" class="form-control" id="course" placeholder="Course" name="course">
                         </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-search-tab"> <a href="/programs/bachelors" class="btn btn-blue banner-search-btn"><?= Yii::t('gtuhome', 'Search') ?></a> </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="banner-caption hide">
            <h5 class="caption-head"><?= Yii::t('gtuhome', 'We are here to get you into dream university') ?></h5>
            <div class="text-center">
              <button class="btn btn-blue banner-tab-1"> <span> <img src="/images/tab-1.png" class="tab-ic" alt=""/><?= Yii::t('gtuhome', 'Program Finder') ?></span> </button>
            </div>
          </div>
        </div>
        
        <!-- WORLD MAP BARS-->
        <div class="section world-map section-padding">
          <div class="container-fluid">
            <div class="container">
              <div class="group-title-index">
                <h1><?= Yii::t('gtuhome', 'Pick Your') ?></br>
                  <?= Yii::t('gtuhome', 'Destination') ?></h1>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <div class="maptitlebox"> 
                  
                  </div>
                    <!--<div class="average-fee-block">
                      <div class="title">Average Fees</div>
                      <div class="fees">2000 EUR</div>
                    </div>-->
                </div>
                <div class="col-sm-9">
                  <div id="vmap"  style="width: 100%; height: 550px;"></div>
                </div>
              </div>
              <div class="container">
                <p class="text-right"><?= Yii::t('gtuhome', '* Color coding is random and there is no classification by color') ?></p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- CHOOSE COURSES-->
        <div class="section section-padding choose-service" id="services">
          <div class="services-bg"> <img src="/images/service-bg.png" alt=""/> </div>
          <div class="container">
            <div class="group-title-index">
              <h1><?= Yii::t('gtuhome', 'Our') ?></br>
                <?= Yii::t('gtuhome', 'Services') ?></h1>
            </div>
            <div class="service-panel">
              <div class="row">
                <div class="col-sm-4"> 
                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">

                    <?php $active = 'active'; foreach($services as $service): ?>
                      <li role="presentation" class="<?= $active; ?>"><a href="#ser-<?= $service->id; ?>" aria-controls="ser-<?= $service->id; ?>" role="tab" data-toggle="tab">
                        <?php
                        if(isset($_COOKIE['lang'])){
                          $temp = 'name_'.$_COOKIE['lang']; 
                          if(isset($service->$temp)){
                            echo $service->$temp; 
                          }else{
                            echo $service->name; 
                          }
                        }else{
                          echo $service->name; 
                        } 
                        
                        ?>
                          
                        </a></li>
                    <?php $active = ''; endforeach; ?>
                    <a href="/site/signup" class="bk-session"><?= Yii::t('gtuhome', 'Book a Free Session with Our Consultant') ?></a>
                  </ul>
                </div>
                <div class="col-sm-8"> 
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <?php $active = 'in active'; foreach($services as $service): ?>
                      <div role="tabpanel" class="tab-pane fade <?= $active; ?>" id="ser-<?= $service->id; ?>">
                        <div class="ser-short-info">
                          <div class="ser-short-description">
                          <?php
                            if(isset($_COOKIE['lang'])){
                              $temp = 'description_'.$_COOKIE['lang']; 
                              if(isset($service->$temp)){
                                echo $service->$temp; 
                              }else{
                                echo $service->description; 
                              }
                            }else{
                              echo $service->description; 
                            } 
                          ?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="service-tab-space"></div>
                          </div>
                          <div class="col-sm-4"> <a href="/service/view?id=<?= $service->id; ?>" class="service-more-info"><?= Yii::t('gtuhome', 'Know More') ?></a> </div>
                        </div>
                      </div>
                    <?php $active = ''; endforeach; ?>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!--<div class="row">
              <?php foreach($services as $service): ?>
              <div class="col-md-3 col-sm-3 col-xs-6">
                <a href="?r=service/view&id=<?= $service->id; ?>" class="home-service-link">
                  <div class="service-home-blk">
                    <?php
                          $backgroundImage = './../../backend/web/default-university.png';
                          if (is_dir('./../../backend/web/services-uploads/'. $service->id . '/')) {
                              $path = FileHelper::findFiles('./../../backend/web/services-uploads/' . $service->id . '/', [
                                  'caseSensitive' => true,
                                  'recursive' => false,
                                  'only' => ['icon.*']
                              ]);

                              if (count($path) > 0) {
                                  $backgroundImage = $path[0];
                                  $backgroundImage = str_replace("\\","/",$backgroundImage);
                              }
                          }
                      ?>
                    <div class="service-icon services-icon" style="background-image: url(<?= $backgroundImage; ?>)"></div>
                    <div class="service-text">
                      <?= $service->name; ?>
                    </div>
                  </div>
                </a>
              </div>
              <?php endforeach; ?>
            </div>--> 
          
          <!--  <div class="row">

           <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="?r=partneruniversities" class="home-service-link">
                  <div class="service-home-blk">
                                        <div class="service-icon services-icon" style="background-image: url(./../../backend/web/default-university.png)"></div>
                    <div class="service-text">Apply to our Partner Universities for Free</div>
                  </div>
                </a>
              </div>

                          <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="?r=counselor" class="home-service-link">
                  <div class="service-home-blk">
                                        <div class="service-icon services-icon" style="background-image: url(./../../backend/web/default-university.png)"></div>
                    <div class="service-text">Take Advice from expert</div>
                  </div>
                </a>
              </div>

                          <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="?r=packages/index" class="home-service-link">
                  <div class="service-home-blk">
                                        <div class="service-icon services-icon" style="background-image: url(./../../backend/web/default-university.png)"></div>
                    <div class="service-text">University Essay/PS/SOP</div>
                  </div>
                </a>
              </div>


                          <div class="col-md-3 col-sm-4 col-xs-6">
                <a href="?r=packages/freesession" class="home-service-link">
                  <div class="service-home-blk">
                                        <div class="service-icon services-icon" style="background-image: url(./../../backend/web/default-university.png)"></div>
                    <div class="service-text">Book your free session</div>
                  </div>
                </a>
              </div>
                      </div>
       --> 
          
        </div>
      </div>
      <!-- PROGRESS BARS-->
      <div class="section progress-bars section-padding" id="university-info">
        <div class="container">
          <div class="progress-bars-content">
            <div class="progress-bar-wrapper">
              <div class="row">
                <div class="content">
                  <div class="col-sm-3 col-xs-6">
                    <div class="progress-bar-number">
                      <div data-from="0" data-to="<?= $universityCount ?>" data-speed="1000" class="num">0</div>
                      <p class="name-inner"><?= Yii::t('gtuhome', 'Universities') ?></p>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-6">
                    <div class="progress-bar-number">
                      <div data-from="0" data-to="<?= $programmeCount ?>" data-speed="1000" class="num">0</div>
                      <p class="name-inner"><?= Yii::t('gtuhome', 'Programs') ?></p>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-6">
                    <div class="progress-bar-number">
                    <?php $studentCount = $studentCount + 8000; ?>
                      <div data-from="0" data-to="<?= $studentCount ?>" data-speed="1000" class="num">0</div>
                      <p class="name-inner"><?= Yii::t('gtuhome', 'Happy Students') ?></p>
                    </div>
                  </div>
                  <div class="col-sm-3 col-xs-6">
                    <div class="progress-bar-number">
                      <div data-from="0" data-to="<?= $consultantCount ?>" data-speed="1000" class="num">0</div>
                      <p class="name-inner"><?= Yii::t('gtuhome', 'Consultant') ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- PACKAGES-->
      <div class="section section-padding package" id="packages">
        <div class="container">
          <div class="group-title-index">
            <h1><?= Yii::t('gtuhome', 'Our') ?></br> <?= Yii::t('gtuhome', 'Packages') ?></h1>
          </div>

            <div class="row hidden-xs">
          <?php foreach($packages as $package):?>
            <?php
              $src = '../web/images/package-ic.png';
              if ( is_dir( "./../../backend/web/package_uploads/$package->id" ) ) {
                $icon = FileHelper::findFiles( "./../../backend/web/package_uploads/$package->id", [
                  'caseSensitive' => true,
                  'recursive' => false,
                ] );
                if ( count( $icon ) > 0 ) {
                  $src = $icon[ 0 ];
                  $src = str_replace( '\\', '/', $src );
                }
              }
              ?>

            <div class="col-sm-6 col-md-4">
            <a href="/packages/view?id=<?= $package->id; ?>">
              <div class="thumbnail package-block-home">
                <div class="package-block-image">
                  <img src="<?= $src ?>" alt="packages">
                </div>
                <div class="caption">
                  <h3>
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
          <?php endforeach; ?>
</div>

		<div class="visible-xs">
            <div class="package-card-block">
          <?php foreach($packages as $package):?>
            <?php
              $src = '../web/images/package-ic.png';
              if ( is_dir( "./../../backend/web/package_uploads/$package->id" ) ) {
                $icon = FileHelper::findFiles( "./../../backend/web/package_uploads/$package->id", [
                  'caseSensitive' => true,
                  'recursive' => false,
                ] );
                if ( count( $icon ) > 0 ) {
                  $src = $icon[ 0 ];
                  $src = str_replace( '\\', '/', $src );
                }
              }
              ?>

            <div class="package-card">
            <a href="/packages/view?id=<?= $package->id; ?>">
              <div class="thumbnail package-block-home">
                <div class="package-block-image">
                  <img src="<?= $src ?>" alt="packages">
                </div>
                <div class="caption">
                  <h3><?= $package->name ?></h3>
                  <p><?= $package->description ?></p>
                </div>
              </div>
              </a>
            </div>
          <?php endforeach; ?>
          </div>
</div>
<!--  <div class="col-sm-6 col-md-4">
    <div class="thumbnail package-block-home">
      <img src="/images/package-img.png" alt="packages">
      <div class="caption">
        <h3>Free Admission Counselling</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
      </div>
    </div>
  </div>
          <div class="col-sm-6 col-md-4">
    <div class="thumbnail package-block-home">
      <img src="/images/package-img.png" alt="packages">
      <div class="caption">
        <h3>Free Admission Counselling</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
      </div>
    </div>
  </div>
          <div class="col-sm-6 col-md-4">
    <div class="thumbnail package-block-home">
      <img src="/images/package-img.png" alt="packages">
      <div class="caption">
        <h3>Free Admission Counselling</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail package-block-home">
      <img src="/images/package-img.png" alt="packages">
      <div class="caption">
        <h3>Free Admission Counselling</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail package-block-home">
      <img src="/images/package-img.png" alt="packages">
      <div class="caption">
        <h3>Free Admission Counselling</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
      </div>
    </div>
  </div> -->
          <!--<div class="home-packages">
            <?php
              $i = 0;
              ?>
            <div class="row">
              <?php foreach($packages as $package):?>
              <?php if($i % 3 == 0 && $i != 0): ?>
            </div>
            <div class="row mtop-40">
              <?php endif; ?>
              <div class="col-md-4 col-sm-6">
                <div class="home-package-block">
                  <?php
                    $src = '../web/images/package-ic.png';
                    if ( is_dir( "./../../backend/web/package_uploads/$package->id" ) ) {
                      $icon = FileHelper::findFiles( "./../../backend/web/package_uploads/$package->id", [
                        'caseSensitive' => true,
                        'recursive' => false,
                      ] );
                      if ( count( $icon ) > 0 ) {
                        $src = $icon[ 0 ];
                        $src = str_replace( '\\', '/', $src );
                      }
                    }
                    ?>
                  <h3 class="home-package-title" style="background-image: url('<?= $src ?>')"><a href="?r=packages/view&id=<?= $package->id; ?>">
                    <?= $package->name ?>
                    </a ></h3>
                  <p class="home-package-dis">
                    <?= $package->description ?>
                  </p>
                </div>
              </div>
              <?php $i++; ?>
              <?php endforeach; ?>
            </div>
          </div>-->
        </div>
      </div>
      
      <!-- Begin CONSULTANTS -->
      
      <?= $this->render('_consultant',['consultants' => $consultants]); ?>
      <!-- End CONSULTANTS --> 
      
      
      <!-- notification-->
      <div class="section section-padding notification" id="notification">
        <div class="container">
          <div class="group-title-index">
            <h1><?= Yii::t('gtuhome', 'Latest') ?></br> <?= Yii::t('gtuhome', 'Updates') ?></h1>
          </div>
          <div class="bell-ic">
            <img src="/images/bell-ic.png" alt=""/>
          </div>
          <ul class="noti-list notification-slider">
            <?php foreach($UniversityNotifications as $news): ?>
            <li> <a href="/university/news?id=<?php echo $news->id; ?>" title="<?php echo $news->title; ?>"><?php echo '* '.$news->title.' *'; ?></a> </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      
      <!-- Begin ARTICLES -->
      
      <?= $this->render('_articles'); ?>
      <!-- End ARTICLES --> 
      
      <!-- PARTNER UNIVERSITIES -->
      <div class="section section-padding partner" id="university-info">
        <div class="container">
          <div class="group-title-index">
            <h1><?= Yii::t('gtuhome', 'Featured') ?></br> <?= Yii::t('gtuhome', 'Universities') ?></h1>
          </div>
          <div class="university-logos-slider">
            <div class="university-logos-column">
              <?php $i=0; foreach($featuredUniversities as $university): ?>
                <?php
                $src = "https://gotouniversity.com/backend/web/uploads/".$university->university_id."/logo/logo_170X115"; 
                $profile_path = "./../../backend/web/uploads/".$university->university_id."/logo/logo_170X115";
                if(glob($profile_path.'.jpg')){
                  $src = $src.'.jpg';
                } else if(glob($profile_path.'.png')){
                  $src = $src.'.png';
                } else if(glob($profile_path.'.gif')){
                  $src = $src.'.gif';
                }
                if($i % 3 == 0 && $i != 0): ?>
                  </div>
                  <div class="university-logos-column">
                <?php endif; ?>
                 <?php 
                    $res = strtolower($university->university->name);
                    $url_key = str_replace(" ", "-", $res);
                    $url_key = rawurlencode($url_key);
                 ?>
               
                <a href="/university/view/<?php echo $url_key; ?>" class="partner-univ">
                  <div class="university-logos-block">
                  <div class="home-page-logos">
                      <img src="<?= $src ?>" alt="" class="feature-university-logo"/>
                    </div>
                      <p class="featured-university-name"><?= $university->university->name; ?></p>
                 </div>
               </a>
            <?php $i++; endforeach; ?>
          </div>
          
          
          <!--<div class="logos row">
            <?php foreach($featuredUniversities as $university): ?>
            <?php
              $src = '';
              if ( is_dir( "./../../backend/web/uploads/$university->university_id/logo" ) ) {
                $logo_path = FileHelper::findFiles( "./../../backend/web/uploads/$university->university_id/logo", [
                  'caseSensitive' => true,
                  'recursive' => false,
                ] );
                if ( count( $logo_path ) > 0 ) {
                  $src = $logo_path[ 0 ];
                }
              }
              ?>
                            <div class="col-sm-4">
            <a href="<?= ConnectionSettings::BASE_URL . 'frontend/web/index.php?r=university/view&id=' . $university->university_id ?>" class="partner-univ">
            <div class="partner-logo"><img src="http://gotouniversity.com/backend/web/uploads/55/logo/logo_170X115.jpg" alt="" class="feature-university-logo"/>
            <img src="<?= $src; ?>" alt="" class="feature-university-logo"/> </div>
            <p class="featured-university-name"> 
              <?= empty($src) ? $university->university->name : ''?>
              <?= $university->university->name; ?>
            </p>
            </a>
            </div>
            <?php endforeach; ?>
          </div>-->
        </div>
      </div>
      
    </div>
  </div>
</div>
</div>

