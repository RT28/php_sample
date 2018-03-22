<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use common\models\UniversityAdmission;
use common\models\StandardTests;
use yii\widgets\LinkPager;
use common\models\FreeCounsellingSessions;

use common\components\ConnectionSettings;
use common\models\Advertisement;
    $time = time();

$TodayDate = date('Y-m-d');
?>
<?php if(!isset($fromUniversity)): ?>
                    <div class="group-title-index title-with-count" id="set_todiv">
                        <h4>Listing</h4>
                        <h1><?= $totalCourseCount; ?> Courses</h1>
                    </div>
                <?php endif; ?>
<div class="course-list">
<?php if(!isset($fromUniversity)): ?>
    <div class="row course-list-header text-center all-titles">
        <div class="col-sm-5 text-center"><div class="list-title">Program</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Duration</div></div>
        <div class="col-sm-3 text-center"><div class="list-title">Tution Fees</div></div>
        <div class="col-sm-2 text-center"><div class="list-title">Deadlines</div></div>
        <!--<div class="col-sm-2 text-center"><div class="list-title">Standard Test</div></div>-->
    </div>
<?php endif; ?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php 
	
	$rowcount = count($courses);
	$c = 1;
	$n = 5;
	
	foreach($courses as $i => $course): ?>
        <div class="panel panel-default">


            <div class="panel-heading" role="tab" id="heading-<?= $i?>">
                <div class="panel-title program-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $i?>" aria-expanded="false" aria-controls="collapse-<?= $i?>">
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
                            <div class="col-sm-5">
                            <div class="row">
                            <div class="col-sm-4">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $i?>" aria-expanded="false" aria-controls="collapse-<?= $i?>" onclick="CheckSelected('<?= $university->id?>','<?= $course->id ?>');">
								<div class="uni-list-logo">
								<img src="<?= $backgroundImage; ?>" alt="<?= $university->name?>" target="_blank" class="course-list-university-logo"/>
								</div></a>
                                </div>
                            <div class="col-sm-8">
                            	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $i?>" aria-expanded="false" aria-controls="collapse-<?= $i?>"><span class="large-text program-name" title="<?= $course->name; ?>"><?= $course->name ?></span></a>
                                <?php 
                                    $res = strtolower($university->name);
                                    $url_key = str_replace(" ", "-", $res);
                                    $url_key = rawurlencode($url_key);
                                 ?>
                                <a title="University" href="/university/view/<?= $url_key ?>" target="_blank">

                                <p class="university-name" title="<?= $university->name ?>"><?= $university->name ?></p>
                                </a>
                                <!-- <p class="university-name" title="<?= $university->name ?>">
                                <?= Html::a($university->name, ['university/view', 'id' => $url_key], ['title'=>$university->name, 'target'=>"_blank"]) ?>
                                </p> -->
                                <p class="location-name" title="<?= $university->city->name . ' ' . $university->state->name ?>"> <?= $university->city->name ?>, <?= $university->state->name ?></p>
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
								
                                <div class="duration"> <?= $duration; ?>  <span class="" style="margin-top: 15px;"><?= $dTp ?></span></div> <span class="visible-xs">/</span>
                                <p class="cource-type"><?= ($course->type !== null && array_search($course->type, $types) !== null) ? $types[$course->type] : 'NA' ?></p>
                            </div>
                            <div class="col-sm-3 text-center">
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
                                <div class="t-fees"><?= $totalFees; ?></div>
                            </div>
                            <div class="col-sm-2 text-center">
                                									<label class="visible-xs">Deadline :</label>
                                <div class="deadline-date"> <?php
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
                                ?>  </div>
                            </div>
                            <!--<div class="col-sm-2 text-center">
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
                            </div>-->
                        </div>
                          <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $i?>" aria-expanded="false" aria-controls="collapse-<?= $i?>">
                        <div class="expand"></div>
                        </a>
                    </a>
                    <?php if(!isset($fromUniversity)):?>
                        <!--<div class="action-buttons">
                            <a title="University" href="?r=university/view&id=<?= $university->id ?>"><span class="fa fa-university"></span></a>
                        </div>-->
                    <?php endif; ?>
                </div>
				

  
            </div>
            <div id="collapse-<?= $i?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?= $i?>">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6 mbot-30">
                            <label>Language:</label>
                            <span><?= array_search($course->language, $languages) !== false ? $languages[$course->language] : 'English' ?></span>
                        </div>
                        <div class="col-sm-6 mbot-30">
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
                    <div class="row">
                    <div class="col-sm-6 mbot-30">
                    <label>Program Description</label>
                    <p><?= empty($course->description) ? 'NA' : $course->description ?></p>
					</div>
                    <div class="col-sm-6 mbot-30">
                    <label>Eligibility Criteria</label>
                    <p><?= empty($course->eligibility_criteria) ? 'NA' : $course->eligibility_criteria ?></p>
                    </div>
					</div>
                    <div class="row">
                    <div class="col-sm-6 mbot-30">
                    <label>Careers</label>
                    <p><?= empty($course->careers) ? 'NA': $course->careers ?></p>
                    </div>
                    <div class="col-sm-6 mbot-30">
                    <label>Deadline (Fall)</label>
                    <p>
                        <!-- <span>Admission Starts: </span> <?= $admissionOpen; ?>
                        <span> Admission Ends: </span> <?= $deadline; ?> -->
                    <?= $deadline; ?>    
                    </p>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-6">
						<?php
						  $website = '#';
						  if(isset($course->program_website)) {?>
						  <label>Program Website</label>
						  <?php
						  $website = $course->program_website;?>
						   <a href="<?= $website; ?>" target="_blank"><img src="/images/link-ic.png" alt=""><!--<?= $website;?>--></a>
						  <?php	} ?>
                          </div>
                    <div class="col-sm-6">

                    <?php
                    $url = '/site/login';
                     if (isset($shortlisted) && sizeof($shortlisted) > 0 && isset($shortlisted[$course->id])) { $action_val = 1; ?>
                  <button type="button" class="btn-favourites added-button shortlist-btn shortlist-course with-info course-apply" data-course="<?= $course->id ?>" data-university="<?= $course->university_id ?>" data-action_val="<?= $action_val ?>" value="<?= (!Yii::$app->user->isGuest) ? '/course/shortlist' : $url ?>"><i class="fa fa-plus" aria-hidden="true"></i><span></span></button>
                  <?php } else{ $action_val = 0; ?>
                  <button type="button" class="btn-favourites add-button shortlist-btn shortlist-course with-info course-apply" data-course="<?= $course->id ?>" data-university="<?= $course->university_id ?>" data-action_val="<?= $action_val ?>" data-toggle="modal" data-target="#login-modal" value="<?= (!Yii::$app->user->isGuest) ? '/course/shortlist' : $url ?>"><i class="fa fa-plus" aria-hidden="true"></i><span></span></button>
                    <?php }?>
                    
                    <?php if(Yii::$app->user->isGuest): ?>
                        <?= Html::a('<button type="button" class="btn btn-blue">Book a free session with our consultant</button>', ['site/signup'], ['class' => '']); ?>
                    <?php endif;?>
                    </div>
                    </div>
                </div>
            </div>
</div>
    
<?php 
//if($c % $n == 0 && $c != 0) // If $c is divisible by $n...
//  {
 
$Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'programfinder'],
['=', 'status',  '1' ],['=', 'section',  'between' ],['=', 'position',  $c ],
['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all();
$path= ConnectionSettings::BASE_URL.'backend';
?>
<div class="ad-blocks tile-ad">
<?php foreach($Ads as $ad): ?>
<a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="width:<?= $ad->width?> px; height:<?= $ad->height?> px;"/> </a>
<?php   ?>
<?php endforeach; ?>
</div>

 <?php 
// }
$c++;
?>
    <?php endforeach; ?>
<?php
 
$cur_page = $currpage;
$page= $currpage-1;
$per_page = $pages->defaultPageSize;  
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
            if ($no_of_paginations > $cur_page + 5) {
                $end_loop = $cur_page + 4;
                //echo "if no of pagination (end loop)= ". $end_loop;
            } else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 5) {
                $start_loop = $no_of_paginations - 5;
                $end_loop = $no_of_paginations;
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
            if ($count <= $per_page) {
                $end = $count;
            }else if($end==0){
                $end = $per_page;
            }
            if($count>0){
                $displaymsg = 'Showing 1 to '.$end.' of '.$count.' entries';
			}
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
        $msg .="<div style='float:right;'><ul class='pagination' id='pagin_count'>";

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
