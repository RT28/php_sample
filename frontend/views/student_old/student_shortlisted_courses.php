<?php

use yii\helpers\Html;
$this->context->layout = 'profile';
$this->title = 'Shortlisted Programs';
use common\models\PackageType;
use common\models\StudentPackageDetails;
use common\models\FreeCounsellingSessions;
use common\models\UniversityAdmission;
use common\models\StandardTests;
 use yii\helpers\FileHelper;
$time = time();
?>
<?php
$this->registerCssFile('css/site.css');
?>

<?php
    $package = PackageType::find()->where(['=', 'id', 6])->one()->id;
    $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $package]])->one();
    if(empty($hasFreeApplicationPackage)) {
        echo '<p type="hidden" id="free-application-package"></p>';
    }
?>
<div id="course-list">
<div class="row">
    <?= $this->render('_student_common_details'); ?>
    <div class="col-xs-12"><h1><?= Html::encode($this->title) ?></h1></div>
	  <div class="col-xs-12 text-right mbot-10">
            <a class="btn btn-blue" href="?r=course/index">View Programs</a>
        </div>
    <?php if(sizeof($models) === 0): ?>
        <h2> You haven't shortlisted any course yet.</h2>
      
    <?php else: ?>
	  <div class="col-xs-12">    
      <div class="row course-list-header text-center all-titles">
        <div class="col-sm-4 text-center"><div class="list-title">Program Location</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Duration Format</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Tution Fees</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Deadlines</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Standard Test</div></div>
    </div>
<div class="panel-group course-list-body mywrap">
        <?php foreach($models as $i => $model): $course = $model->course;?> 	
            <div class="panel panel-default item">
            <div class="panel-heading" role="tab" id="course-heading-<?= $i?>-<?= $time; ?>">
                <div class="panel-title program-title">
                    <div onclick="CheckSelected(<?= $course->university_id; ?>,<?= $course->id; ?>);"   role="button" >
                        <?php
                            $university = $course->university;
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
                        <div class="row">
                            <div class="col-sm-4">
                            <div class="row">
                            <div class="col-sm-4">
                                <a href="?r=university/view&id=<?= $university->id ?>" >
								<div class="uni-list-logo">
								<img src="<?= $backgroundImage; ?>" alt="<?= $university->name?>" target="_blank" class="course-list-university-logo"/>
								</div></a>
                                </div>
                            <div class="col-sm-8">
                                <span class="large-text program-name" title="<?= $course->name; ?>"><?= $course->name ?></span>
                                <p class="university-name" title="<?= $university->name ?>"><?= $university->name ?></p>
                                <p class="location-name" title="<?= $university->city->name . ' ' . $university->state->name ?>"><i class="fa fa-map-marker" aria-hidden="true"></i>  <?= $university->city->name ?>, <?= $university->state->name ?></p>
                            	</div>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center">
                            <label class="visible-xs">Duration Format :</label>
                                <?php
                                    $duration = 'NA';
                                    if(isset($course->duration)) {
                                        $duration = Yii::$app->formatter->asInteger($course->duration);
                                    }
                                ?>
                                <span> <?= $duration; ?>  <span class="" style="margin-top: 15px;"><?= isset($durationType[$course->duration_type]) ? $durationType[$course->duration_type] : 'NA' ?></span></span> <span class="visible-xs">/</span>
                                
                            </div>
                            <div class="col-sm-2 text-center">
                                <?php
                                    $currency = $university->currency->iso_code;
                                    $fees = 'NA';
                                    if(isset($university->currency->symbol)) {
                                        $currency = $university->currency->symbol;
                                    }
                                    if (isset($course->fees_international_students)) {
                                       // $fees = Yii::$app->formatter->asInteger($course->fees / 1000) . 'k';
										$fees =  $course->fees_international_students;
                                    }
                                ?><label class="visible-xs">Tuition Fees :</label>
                                <span><?= $currency.$fees; ?></span>
                            </div>
                            <div class="col-sm-2 text-center">
                                <?php
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


                                ?><label class="visible-xs">Deadline :</label>
                                <span> <?= $deadline ?></span>
                            </div>
                            <div class="col-sm-2 text-center">
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
                                            $tests .= '<p>' . implode('/', $t) . '</p>';
                                        }
                                    }
                                ?><label class="visible-xs">Standard Test :</label>
                                <span class="dark"> <?= $tests ?></span>
                            </div>
                        </div>
                    </div>
					<div class="action-buttons bor-0">
                    <?php if(!isset($fromUniversity)):?>
                        
                            <a title="University" href="?r=university/view&id=<?= $university->id ?>"><span class="fa fa-university"></span></a>
                        
                    <?php endif; ?>
					 <button class="btn btn-danger btn-unlist-course" data-id="<?= $model->id; ?>">Remove</button>
					 </div>
                </div>
            </div>
            <div id="course-<?= $i?>-<?= $time; ?>" class="panel-collapse collapse qe" role="tabpanel" aria-labelledby="course-heading-<?= $i?>-<?= $time; ?>">
                <div class="panel-body">
                    <div class="row ">
                        <div class="col-xs-6">
                            <label>Language:</label>
                            <span><?= isset($languages)&&array_search($course->language, $languages) !== false ? $languages[$course->language] : 'English' ?></span>
                        </div>
                        <div class="col-xs-6">
                            <?php
                                $rank = null;
                                $rankings = $university->institution_ranking;
                                $source = null;
                                $name = null;
                                if (!empty($rankings) && sizeof($rankings) > 0) {
                                    $rankings = json_decode($rankings, true);
                                    $len = sizeof($rankings);
									if(isset($rankings[0])){
                                    $rank = $rankings[0]['rank'];
                                    $source = $rankings[0]['source'];
                                    $name = $rankings[0]['name'];
                                    for($count = 1; $count < $len; $count++ ) {
                                        if($rankings[$count]['rank'] < $rank) {
                                            $rank = $rankings[$count]['rank'];
                                            $source = $rankings[$count]['source'];
                                            $name = $rankings[$count]['name'];
                                        }
                                    }
									}
                                }
                            ?>
                            <label>University Rank: </label>
                            <?php if(isset($rank)): ?>
                                <span><?= $rank; ?> <a href="<?= $source; ?>" target="_blank"> <?= $name; ?></a></span>
                            <?php else: ?>
                                <span>NA</span>
                            <?php endif; ?>

                        </div>
                    </div>
                    <label>Program Description</label>
                    <p><?= empty($course->description) ? 'NA' : $course->description ?></p>

                    <label>Eligibility Criteria</label>
                    <p><?= empty($course->eligibility_criteria) ? 'NA' : $course->eligibility_criteria ?></p>

                    <label>Careers</label>
                    <p><?= empty($course->careers) ? 'NA': $course->careers ?></p>

                    <label>Admissions</label>
                    <p>
                        <span>Admission Starts: </span> <?= $admissionOpen; ?>
                        <span> Admission Ends: </span> <?= $deadline; ?>
                    </p>
						<?php
						  $website = '#';
						  if(isset($course->program_website)) {?>
						  <label>Program Website</label>
						  <?php
						  $website = $course->program_website;?>
						  <p title="University"><i class="fa fa-globe" aria-hidden="true"></i> <a href="<?= $website; ?>"><?= $website;?></a></p>
						  <?php	} ?>
                    <?php
                        $url = '';
                        $className = 'btn btn-blue course-apply';
                        $text = 'shortlist';
                        if (Yii::$app->user->isGuest) {
                            $url = '?r=site/login';
                            $className = 'btn btn-blue course-apply';
                            $text = 'shortlist';
                        }
                        else if (isset($shortlisted) && sizeof($shortlisted) > 0 && isset($shortlisted[$course->id])) {
                            $url = '?r=student/student-shortlisted-courses';
                            $className = 'btn btn-success course-apply';
                            $text = 'shortlisted';
                        } else {
                            $url = '?r=course/shortlist';
                            $className = 'btn btn-blue course-apply';
                            $text = 'shortlist';
                        }
                    ?>

                    <a href="<?= $url ?>" class="<?= $className; ?>" type="button" data-course="<?= $course->id ?>" data-university="<?= $course->university_id ?>"><?= $text; ?></a>
					
					
                                	 
									 
                    <?php if(Yii::$app->user->isGuest): ?>
                        <?= Html::a('<button type="button" class="btn btn-blue">Register for a free counselling session</button>', ['site/signup'], ['class' => '']); ?>
                    <?php endif;?>
                    <?php
                        if(!Yii::$app->user->isGuest) {
                            $freeSession = FreeCounsellingSessions::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
                        }
                    ?>
                    <?php if(!empty($freeSession)): ?>
                        <a class="btn btn-blue" href="?r=site/register-for-free-counselling-session">Click here to get a free counselling session</a>
                    <?php endif; ?>
					
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