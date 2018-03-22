<?php
    use yii\helpers\Html;
    use yii\helpers\FileHelper;
    use common\models\UniversityAdmission;
    use common\models\StandardTests;
    use yii\widgets\LinkPager;
    use common\models\FreeCounsellingSessions;
    use yii\widgets\Pjax;
    $time = time();
?>
<div class="course-list">
    <div class="row course-list-header text-center">
        <div class="col-sm-3"><div class="list-title">Program</div></div>
        <div class="col-sm-2"><div class="list-title">Duration</div></div>
        <div class="col-sm-2"><div class="list-title">Format</div></div>
        <div class="col-sm-2"><div class="list-title">Tuition Fees</div></div>
        <div class="col-sm-1"><div class="list-title">Deadlines</div></div>
        <div class="col-sm-2"><div class="list-title">Standard Test</div></div>
    </div>

<div class="panel-group course-list-body" id="accordion-<?= $time; ?>" role="tablist" aria-multiselectable="true">
    <?php foreach($courses as $i => $course): ?>
        <?php
            $university = $course->university;
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="course-heading-<?= $i?>-<?= $time; ?>">
                <div class="panel-title program-title">
				<div onclick="CheckSelected(<?= $course->university_id; ?>,<?= $course->id; ?>);" role="button" data-toggle="collapse" data-parent="#accordion-<?= $time; ?>" href="#course-<?= $i?>-<?= $time; ?>" aria-expanded="true" aria-controls="course-<?= $i?>-<?= $time; ?>">
                    
                        <div class="row">
                            <div class="col-sm-3">
							<span class="large-text program-name viewed" title="<?= $course->name; ?>"  >  	<?= $course->name; ?></span>
                            </div>
                            <div class="col-sm-2 text-center">
                            <lable class="visible-xs">Duration :</lable>
                                <?php
                                    $duration = 'NA';
                                    if(isset($course->duration)) {
                                        $duration = Yii::$app->formatter->asInteger($course->duration);
                                    }
                                ?>
                                <span> <?= $duration; ?>  <span class="" style="margin-top: 15px;"><?= isset($durationType[$course->duration_type]) ? $durationType[$course->duration_type] : 'NA' ?></span></span> <span class="visible-xs">/</span>
                            </div>
                            <div class="col-sm-2 text-center">
                            <lable class="visible-xs">Format :</lable>
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
                                ?><lable class="visible-xs">Tuition Fees :</lable>
                                <span><?= $currency; ?> <?= $fees; ?></span>
                            </div>
                            <div class="col-sm-1 text-center">
                                <?php
                                    $deadline = 'NA';
                                    $admissionOpen = 'NA';
                                    $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $university->id],['=', 'degree_level_id', $course->degree_level_id], ['=', 'course_id', $course->id]])->one();

                                    if (empty($admission)) {
                                        $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $university->id],['=', 'degree_level_id', $course->degree_level_id]])->one();
                                    }

                                    if(!empty($admission)) {
                                        $deadline = date_format(date_create($admission->end_date), 'jS M');
                                        $admissionOpen = date_format(date_create($admission->start_date), 'jS F');
                                    }
                                ?><lable class="visible-xs">Deadline :</lable>
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
                                ?><lable class="visible-xs">Standard Test :</lable>
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
                        <a title="Expand" data-toggle="collapse" data-parent="#accordion-<?= $time; ?>" href="#course-<?= $i?>-<?= $time; ?>" class="toggle-title">More Details...</a>
                    </div>
					
                </div>
            </div>
            <div id="course-<?= $i?>-<?= $time; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="course-heading-<?= $i?>-<?= $time; ?>">
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
						  <p title="University"><a href="<?= $website; ?>"><?= $website;?></a></p>
						  <?php	} ?>
						   
					
                    <?php
                        $url = '';
                        $className = 'btn btn-info course-apply';
                        $text = 'shortlist';
                        if (Yii::$app->user->isGuest) {
                            $url = '?r=site/login';
                            $className = 'btn btn-info course-apply';
                            $text = 'shortlist';
                        }
                        else if (isset($shortlisted) && sizeof($shortlisted) > 0 && isset($shortlisted[$course->id])) {
                            $url = '?r=student';
                            $className = 'btn btn-success course-apply';
                            $text = 'shortlisted';
                        } else {
                            $url = '?r=course/shortlist';
                            $className = 'btn btn-info course-apply';
                            $text = 'shortlist';
                        }
                    ?>
                    <a href="<?= $url ?>" class="<?= $className; ?>" type="button" data-course="<?= $course->id ?>" data-university="<?= $course->university_id ?>"><?= $text; ?></a>
                    <?php if(Yii::$app->user->isGuest): ?>
                        <?= Html::a('<button type="button" class="btn btn-info">Register for a free counselling session</button>', ['site/signup'], ['class' => '']); ?>
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
</div>
</div>
<?= LinkPager::widget([
    'pagination' => $pages
]); ?>

<script>
$('.pagination li').each(function(){
    if($(this).children('a').attr('href'))
    $(this).children('a').attr('data-link',$(this).children('a').attr('href'));
    $(this).children('a').attr('href',$('#program-tab .active').children('a').attr('href'));
});
$('.pagination li').click(function(){
    //var url = $(this).children('a').attr('data-link');
    var page = $(this).children('a').attr('data-page');
    var container = $(this).children('a').attr('href');
    var university = $('#program-tab .active').children('a').attr('data-university');
    var degree = $('#program-tab .active').children('a').attr('data-degree');
    var url = '/frontend/web/index.php?r=university/courses&university=' + university + '&degree=' + degree + '&page=' + page;
    $(container).load(url, function(responseText, status, xhr){
        if(status !== 'success') {
            alert('Error loading programs for discipline ' + $(button).html);
        }
    });
});
</script>
