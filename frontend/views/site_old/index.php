<?php
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use common\components\ConnectionSettings;
use yii\web\JqueryAsset;
use common\models\Country;

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
          backgroundColor: '#f2f2f2',
          color: '#ffffff',
          hoverOpacity: 0.7,
          selectedColor: '#01a4b7',
          enableZoom: true,
          showTooltip: true,
		  showLabels : false,
          scaleColors: ['#C8EEFF', '#006491'],
          values: sample_data,
          normalizeFunction: 'polynomial',
		  showTooltip: true,
		  onLabelShow :function (event, label, code){

			  $.ajax({
            url: '?r=site/countydata/',
            method: 'GET',
			data: {
                code: code,
            },
            success: function(response, data) {
                response = JSON.parse(response);
				//alert(response.name);
				var name = response.name;
				var universities = response.universities;
				var courses = response.courses;
				var resdata = name+ ' <br/> Total Universities ('+universities+') <br/> Total Programs ('+courses+')';
                 label.html(resdata);
            }
			});

		 },onRegionClick:function (event, code, region){
				window.location.href = '?r=course/index&degreeLevel=&region=' + region+'&major=';
		},
        });
	  }) ;",\yii\web\View::POS_END
);

$this->registerJs("
jQuery(document).ready(function(){

  function getCountyData(code){
  alert(code);
        $.ajax({
            url: '?r=site/countydata/',
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
					<div class="banner-caption show">
						<h5 class="caption-head">We are here to get you into dream university</h5>
						<div class="text-center">
							<button class="btn btn-blue banner-tab-1">
                <span>
                  <img src="/images/tab-1.png" class="tab-ic" alt=""/>
                  Program Finder
                </span>
              </button>

						</div>
					</div>
					<div class="banner-form hide">
						<div class="container">
							<form class="search-form wow zoomIn">
								<div class="row">
									<div class="col-xs-4">
										<label class="radio-banner checked">
                      <input type="radio" name="degree-level" id="inlineRadio1" value="Bachelors" checked>
                  	  <div class="text-center form-caps">
                        <img src="/images/w-cap.png" alt=""/>
                      	<h5 class="uni-type">Bachelors</h5>
                      </div>
                    </label>

									</div>
									<div class="col-xs-4">
										<label class="radio-banner">
                      <input type="radio" name="degree-level" id="inlineRadio2" value="Masters">
                    	<div class="text-center form-caps">
                        <img src="/images/w-cap-2.png" alt=""/>
                  	    <h5 class="uni-type">Masters</h5>
                      </div>
                    </label>

									</div>
									<div class="col-xs-4">
										<label class="radio-banner">
                      <input type="radio" name="degree-level" id="inlineRadio3" value="Phd">
                	    <div class="text-center form-caps">
                        <img src="/images/w-cap-3.png" alt=""/>
                	      <h5 class="uni-type">Phd</h5>
                	    </div>
                    </label>

									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="text-center"><i class="fa fa-globe fa-5x" aria-hidden="true"></i>
										</div>
										<div class="auto-complete-container">
											<input type="text" class="form-control" id="region" placeholder="Country, University..." name="region">
										</div>
									</div>
									<div class="col-xs-6">
										<div class="text-center"><i class="fa fa-flask fa-5x" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="course" placeholder="Course" name="course">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="text-center">
											<a href="?r=course/index&degreeLevel=Bachelors" class="btn btn-blue banner-search-btn">Search</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

<!-- WORLD MAP BARS-->
<div class="section world-map section-padding">

	<div class="container-fluid">
	<div class="container">
	<div class="group-title-index">
	<h1>Select Preferred Study Destination</h1>
	</div></div>
		  <div id="vmap"  style="width: 100%; height: 550px;"></div>
<div class="container">
  <p class="text-right">* Color coding is random and there is no classification by color</p>
</div>
	</div>
</div>

				<!-- CHOOSE COURSES-->
				<div class="section section-padding choose-course" id="services">
					<div class="container">
						<div class="group-title-index">
							<h1>Our Services</h1>
						</div>
						<div class="row">
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
						</div>

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
												<p class="name-inner">Universities</p>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="progress-bar-number">
												<div data-from="0" data-to="<?= $programmeCount ?>" data-speed="1000" class="num">0</div>
												<p class="name-inner">Programs</p>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="progress-bar-number">
												<div data-from="0" data-to="<?= $studentCount ?>" data-speed="1000" class="num">0</div>
												<p class="name-inner">Happy Students</p>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="progress-bar-number">
												<div data-from="0" data-to="<?= $consultantCount ?>" data-speed="1000" class="num">0</div>
												<p class="name-inner">Consultant</p>
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
							<h1>Our Packages</h1>
						</div>
						<div class="home-packages">
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
										<h3 class="home-package-title" style="background-image: url('<?= $src ?>')"><a href="?r=packages/view&id=<?= $package->id; ?>"> <?= $package->name ?></a ></h3>
										<p class="home-package-dis">
											<?= $package->description ?>
										</p>
									</div>
								</div>
								<?php $i++; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>


<!-- Begin CONSULTANTS -->

 <?= $this->render('_consultant',['consultants' => $consultants]); ?>
 <!-- End CONSULTANTS -->

<!-- Begin ARTICLES -->

 <?= $this->render('_articles'); ?>
 <!-- End ARTICLES -->

				<!-- PARTNER UNIVERSITIES -->
				<div class="section section-padding partner" id="university-info">
					<div class="container">
						<div class="group-title-index">
							<h1>Featured Universities</h1>
						</div>
						<div class="logos uni-logos">
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

							<a href="<?= ConnectionSettings::BASE_URL . 'frontend/web/index.php?r=university/view&id=' . $university->university_id ?>">
								<div class="partner-logo"><img src="<?= $src; ?>" alt="" class="feature-university-logo"/>
								</div>

								<p class="featured-university-name">
									<!--<?= empty($src) ? $university->university->name : ''?>-->
									<?= $university->university->name; ?>
								</p>
							</a>

							<?php endforeach; ?>
						</div>
					</div>
				</div>


				<!-- notification-->
<div class="section section-padding notification" id="notification">
<div class="container">
		<div class="group-title-index">
			<h1>Latest Updates</h1>
		</div>
		<ul class="noti-list notification-slider">

	<?php foreach($UniversityNotifications as $news): ?>
	<li>
	<a href="?r=university/news&id=<?php echo $news->id; ?>" title="<?php echo $news->title; ?>"><?php echo $news->title; ?></a>
	</li>
	<?php endforeach; ?>


		</ul>
	</div>
</div>
			</div>
		</div>
	</div>
</div>
