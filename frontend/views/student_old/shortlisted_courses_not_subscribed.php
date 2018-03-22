<?php

use yii\helpers\Html;
$this->context->layout = 'profile-notsubscribed';
$this->title = 'Shortlisted Programs';
use common\models\PackageType;
use yii\helpers\FileHelper;
use common\models\StudentPackageDetails;
use common\models\FreeCounsellingSessions;
use common\models\UniversityAdmission;
use common\models\StandardTests;
$time = time();
?>
<?php
$this->registerCssFile('css/site.css');
?>

<?php
    $package = PackageType::find()->where(['=', 'id', 6])->one()->id;
    $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $package]])->one();
    if(empty($hasFreeApplicationPackage)) {
        echo '<p type="hidden" id="free-application-package" style="margin:0;"></p>';
    }
?>
<div id="wrapper-content" class="interim-page section-padding"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content">
<div class="container">
<div class="row"> 
    <div class="col-sm-10">
	<?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
<ul class="dashboard-left-menu">
	<li class="s-program-tab"><a href="?r=student/student-not-subscribed" class="<?= ($activeTab == 'dashboard') ? 'active' : '';?>">Shortlisted Programs</a></li>
	<li class="s-univ-tab"><a href="?r=favourite-universities/student-not-subscribed" class="">Shortlisted Universities</a></li>
</ul>
<div id="course-list" class="shortlisted-block">
<div class="row"> 
    <div class="col-xs-6">
    <div class="group-title-index">
    <h1><?= Html::encode($this->title) ?></h1>
    </div>
    </div>
	  <div class="col-xs-6 text-right">
            <a class="btn btn-blue" href="?r=course/index">View Programs</a>
        </div>
    <?php if(sizeof($models) === 0): ?>
        <h2> You haven't shortlisted any course yet.</h2>
      
    <?php else: ?>
	  <div class="col-xs-12">    
	         <div class="row text-left">
<?php foreach($models as $model):
$course = $model->course; ?> 
			
			<div class="col-sm-6 clearfix">
            	<div class="shortlisted-course-block">
                	<div class="logo-univ-info">
                    	<div class="row">
                        	<div class="col-sm-4">
							<a href="?r=university/view&id=<?= $model->university->id; ?>">
							 <?php
                            $university = $model->university;
                            #check for university logo
                            $backgroundImage = './../../backend/web/default-university.png';
                            if (is_dir("./../../backend/web/uploads/". $university->id . "/logo")) {
                                $path = FileHelper::findFiles("./../../backend/web/uploads/$university->id/logo", [
                                    'caseSensitive' => true,
                                    'recursive' => false
                                ]);

                                if (count($path) > 0) {
                                    $backgroundImage = $path[0];
                                    $backgroundImage = str_replace("\\","/",$backgroundImage);
                                }
                            }
                        ?>
                           <img src="<?= $backgroundImage; ?>" alt="<?= $university->name?>" target="_blank" class="course-list-university-logo"/>
							
							</a>
                            </div>
                        	<div class="col-sm-8">
                            	<h3 class="course-name"><?= $model->course->name; ?></h3>
                            	<a href="?r=university/view&id=<?= $model->university->id; ?>"><p class="course-univ"><?= $model->university->name; ?></p></a>
                            	<p class="univ-location"> <?= $university->city->name ?>, <?= $university->state->name ?>, <?= $university->country->name ?></p>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-12">
                            	<div class="shortlisted-course-info line-1">
                                	<span class="duration"><strong>Duration :</strong> 
									 <?php
                                    $duration = 'NA';
									$dTp  = '';
                                    if(isset($course->duration)) {
                                        $duration = Yii::$app->formatter->asInteger($course->duration);
										
										if(isset($course->duration_type)) { 
											$dTp.=  $durationType[$course->duration_type] ;
										}
                                    }
                                ?> 
								<?= $duration; ?> <?= $dTp ?> </span>
                                	<span class="format"><strong>Format :</strong>  
									<?php if(isset($types[$course->type])){ echo $types[$course->type] ; }else{  'NA'; }?></span>
									 
								</div>
                            	<div class="shortlisted-course-info line-2">
                                	<span class="fees"><strong>Tution Fees :</strong>  <?php                                    
                                    $fees = '';
									$currency = '';
									$currency = $university->currency->iso_code;
                                    if (isset($course->fees_international_students)) {
                                      	 $fees =  $course->fees_international_students;
										if(!empty($fees)){											
											if(isset($university->currency->symbol)) {
												$currency = $university->currency->symbol;
											}
											$totalFees = $currency.$fees;
										
										}
                                    }
                                ?><?= $totalFees; ?></span>
                                	<span class="deadlines"><strong>Deadlines :</strong>
									<?php
									if($course->rolling==1){
										echo "Rolling";
									}else{
                                    $deadline = 'NA';
                                    $admissionOpen = 'NA';
                                    $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $university->id],['=', 'degree_level_id', $course->degree_level_id], ['=', 'course_id', $course->id]])->one();

                                    if (empty($admission)) {
                                        $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $university->id],['=', 'degree_level_id', $course->degree_level_id]])->one();
                                    }

                                    if(!empty($admission)) {
										$deadline = '';
										if($admission->end_date!='0000-00-00'){

											$deadline = date_format(date_create($admission->end_date), 'jS M');
										}
										/*if($admission->start_date!='0000-00-00'){
											$admissionOpen = date_format(date_create($admission->start_date), 'jS F');
										}*/
									}
echo $deadline;
									}
                                ?> </span>
                                </div>
								 <?php
                                    $tests = 'NA';
                                    $standardTests = $course->standard_test_list;

                                    if(isset($standardTests)) {
                                        $ids = explode(',', $standardTests);
                                        $testModels = StandardTests::find()->where(['in', 'id', $ids])->all();
                                        $test = [];
                                        $tests = '';
                                        foreach($testModels as $testModel) {
                                              $category = $testModel->test_category_id;
                                             if(isset($test[$category])) {
                                                 array_push($test[$category], $testModel->name);
                                             } else {
                                                 $test[$category] = [$testModel->name];
                                             }
                                        }
                                        foreach($test as $t) {
                                            $tests .= '' . implode('/', $t) . ', ';
                                        }
                                    }?><?php 
									if(!empty($tests)){?>
                            	<div class="shortlisted-course-info line-3"> 
									
									<span class="standard-test"><strong>Standard Test :</strong>
									<?php 
                                echo  $tests; ?></span></div>
                              <?php  }  ?>
                            </div>
                            <div class="col-sm-12">
                            	<div class="shortlisted-action-buttons text-right">
								
							<?php
							$counsellingSession = FreeCounsellingSessions::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
							if(empty($counsellingSession)): ?>
							<a href="?r=site/register-for-free-counselling-session" class="btn btn-blue">Click to get Free counselling session</a>
							<?php endif; ?> 
									 <button class="btn btn-danger btn-unlist-course" data-id="<?= $model->id; ?>">Remove</button>
									 
                                	<?php if($model->university->is_partner): ?>
									<a class="btn btn-blue"  data-course-id="<?= $model->course->id; ?>" data-university-id="<?= $model->university->id; ?>" >University Details</a>
                                     <?php endif; ?>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        <?php endforeach; ?>
        
 
        	
           
		   
        </div>
        
        </div>
    <?php endif; ?>
</div>
</div>
</div>
<!-- <div class="col-sm-2">
<a href="http://www.brighterprep.com/" target="_blank" title="Test">
	<img src="http://gotouniversity.com/backend/web/uploads/advertisements/1/winter special ad_160x6001499950572.png" alt="Test"> 
	</a>
</div> -->
</div>
</div>
</div>


</div>
 
 
</div>
</div> 

<?php
    $this->registerJsFile('@web/js/dashboard.js');
?>

<div class="modal fade" tabindex="-1" role="dialog" id="apply-warning">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Alert</span></button>
      </div>
      <div class="modal-body">
        <p>Please buy the <strong> Free Application Package </strong> to apply to this course.</p>
        <a href="?r=packages/index" class="btn btn-blue">Buy</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="course-application">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Alert</span></button>        
      </div>
      <div class="modal-body">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-pay">Proceed to Pay</button>
      </div>
    </div>
  </div>
</div>