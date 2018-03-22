<?php
    use yii\helpers\Html;
    use yii\helpers\FileHelper;
    use common\models\UniversityAdmission;
    use common\models\StandardTests;
    use yii\widgets\LinkPager;
    use common\models\FreeCounsellingSessions;
    $time = time();
?>
<?php if(!isset($fromUniversity)): ?>
    <div class="group-title-index">
        <h1><?= $totalCourseCount; ?> Courses</h1>
    </div>
<?php endif; ?>
<div class="course-list">
<?php if(!isset($fromUniversity)): ?>
    <div class="row course-list-header text-center all-titles">
        <div class="col-sm-4 text-center"><div class="list-title">Program Location</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Duration Format</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Tution Fees</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Deadlines</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Standard Test</div></div>
    </div>
<?php endif; ?>

<div class="panel-group course-list-body mywrap" >
<div class="body-3 loading" style="width: auto; height: auto;">
    <div class="dots-loader"></div>
</div>
    <?php foreach($courses as $i => $course): ?>
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
									$dTp  = '';
                                    if(isset($course->duration)) {
                                        $duration = Yii::$app->formatter->asInteger($course->duration);
										
										if(isset($course->duration_type)) { 
											$dTp.=  $durationType[$course->duration_type] ;
										}
                                    }
                                ?> 
								
                                <span> <?= $duration; ?>  <span class="" style="margin-top: 15px;"><?= $dTp ?></span></span> <span class="visible-xs">/</span>
                                <p class="cource-type" style="margin-top: 15px;"><?= ($course->type !== null && array_search($course->type, $types) !== null) ? $types[$course->type] : 'NA' ?></p>
                            </div>
                            <div class="col-sm-2 text-center">
                                <?php                                    
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
                                ?><label class="visible-xs">Tuition Fees :</label>
                                <span><?= $totalFees; ?></span>
                            </div>
                            <div class="col-sm-2 text-center">
                                									<label class="visible-xs">Deadline :</label>
                                <span> <?php
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
                                ?>  </span>
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
                    <?php if(!isset($fromUniversity)):?>
                        <div class="action-buttons">
                            <a title="University" href="?r=university/view&id=<?= $university->id ?>"><span class="fa fa-university"></span></a>
                        </div>
                    <?php endif; ?>
                    <div class="expand">
                        <a title="Expand" data-toggle="collapse" id="ac-<?= $i?>" data-parent="#accordion-<?= $time; ?>" onclick="coursetoggle('course-<?= $i?>-<?= $time; ?>','ac-<?= $i?>');" class="toggle-title more">More Details...</a>
                    </div>
                </div>
            </div>
            <div id="course-<?= $i?>-<?= $time; ?>" class="panel-collapse collapse qe" role="tabpanel" aria-labelledby="course-heading-<?= $i?>-<?= $time; ?>">
                <div class="panel-body">
                    <div class="row ">
                        <div class="col-xs-6">
                            <label>Language:</label>
                            <span><?= array_search($course->language, $languages) !== false ? $languages[$course->language] : 'English' ?></span>
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
									if(isset($rankings[0])) {
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
    <?php endforeach ?>

<?php
/****************************************
 @Created By :- Pankaj Kumar
 @Module :- Program Fillter
 @Controller :- Coursecontroller/index
 @Function :- custom Ajax based pagination work.
************************************************/

$cur_page = $currpage;
$page= $currpage-1;
$per_page = $pages->defaultPageSize; // Per page records
$previous_btn = true;
$next_btn = true;
$first_btn = true;
$last_btn = true;
$start = $page * $per_page;
$end = $cur_page * $per_page;
$count=$pages->totalCount;
if($count>0){
	$no_of_paginations = ceil($count / $per_page);
}else{
	$no_of_paginations = 0;
}

 /* Calculating the staring and ending value for paging */
        if ($cur_page >= 10) {
            $start_loop = $cur_page - 4;
            if ($no_of_paginations > $cur_page + 4) {
                $end_loop = $cur_page + 4;
                //echo "if no of pagination (end loop)= ". $end_loop;
            } else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 9) {
                $start_loop = $no_of_paginations - 9;
                //echo "else (start loop)= ". $start_loop;
            } else {
                $end_loop = $no_of_paginations;
                //echo "else (end loop)= ". $end_loop;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 10)
                $end_loop = 10;
            else
                $end_loop = $no_of_paginations;
        }
		$displaymsg='';
        if ($cur_page == 0 || $cur_page == 1) {
            if ($count <= $end) {
                $end = $count;
            }else if($end==0){
				$end = $per_page;
			}
            $displaymsg = 'Showing 1 to ' . $end . ' of ' . $count . ' entries';

			//echo  $displaymsg;
            /*if ($count == 0) {
                $displaymsg = 'No Records Found!';
            }*/
        } elseif ($cur_page > 1 && $cur_page <= $no_of_paginations) {
            if ($count <= $end) {
                $end = $count;
            }
            $displaymsg = 'Showing ' . $start . ' to ' . $end . ' of ' . $count . ' entries';
        }
		$msg='';
        $msg = "<div class='pagination'>";
        $msg .="<div style='float:left; height:14px; padding:8px' role='status' aria-live='polite'>";
        $msg .= $displaymsg;
        $msg .= "</div>";
        $msg .="<div style='float:right;'><ul class='pagination'>";

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $msg .="<li p='$pre'><a href='javascript:void()' onClick='pagingcustom($pre);'>Previous</a></li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {
            if ($cur_page == $i || ($cur_page == 0 && $i==1))
                $msg .="<li p='$i' class='active'><a>{$i}</a></li>";
            else
                $msg .="<li p='$i'><a href='javascript:void()' onClick='pagingcustom($i);'>{$i}</a></li>";
        }
        // for enabling the next button
        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $msg .="<li p='$nex'><a href='javascript:void()' onClick='pagingcustom($nex);'>Next</a></li>";
        }
        $msg = $msg . "</ul></div></div>";
		echo $msg;

		/******** End *******/

?>
</div>
</div>

<script >
$( document ).ready(function() {
   $('.course-apply').click(onBtnCourseApplyClick);
   
	/*	$('.more').click(function(){
		var $this = $(this); 
		$this.toggleClass('toggle-title');
		if($this.text()=='More Details...'){
			$this.text('Less Details...'); 
		} else {
			$this.text('More Details...');
		}
		}); */
});


function coursetoggle(id,aid) {
	  
	$(".qe").not('#'+id).hide();
	$('#'+id).toggle();
    if($('#'+aid).text()=="More Details..."){
        $('#'+aid).text('Less Details...');
    } else {
        $('#'+aid).text('More Details...');
    }
    $(".more").not('#'+aid).text('More Details...')
}
 </script >
<?php
$script = <<< JS
$('.body-3').removeClass('loading');
$('.body-3').addClass('loaded');
//jQuery.ias().reinitialize();
JS;
$this->registerJs($script);
?>
