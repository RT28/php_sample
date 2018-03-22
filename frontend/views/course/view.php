<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Favorites;
use common\models\University;
use common\models\Student;
use common\models\UniversityCourseList;
use yii\helpers\FileHelper;

/* @var $this yii\web\View */
$this->title = $model->name;
$this->context->layout = 'index';
?><!-- WRAPPER-->
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->

            <div class="content"><!-- SLIDER BANNER-->
                <?php
                    $backgroundImage = '';
                    if (is_dir("./../../backend/web/uploads/$university->id/cover_photo")) {
                        $path = FileHelper::findFiles("./../../backend/web/uploads/$university->id/cover_photo", [
                            'caseSensitive' => true,
                            'recursive' => false
                        ]);
                    
                        if (count($path) > 0) {
                            $backgroundImage = $path[0];
                            $backgroundImage = str_replace("\\","/",$backgroundImage);
                        }
                    }
                ?>
                <div class="uni-img-info" style="background-image: url(<?=  $backgroundImage; ?>);">
                    <div class="uni-details">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6 col-sm-offset-1">
                                    <h1 class="uni-name"> <?= $university->name ?> <small>EST. <?= $university->establishment_date?></small> </h1>
                                    <h2 class="uni-country"> <?= $country; ?> </h2>
                                    <div class="uni-website"> <a href="<?= $university->website ?>" target="_blank"><?= $university->website ?></a> </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="ranking"> Ranking <span>#3</span> </div>
                                    <div class="row uni-links">
                                    <?php
                                        $url = '/site/login';
                                    ?>
                                    <div class="col-sm-4"> <a class="btn-course-review" href="<?= (!Yii::$app->user->isGuest) ? '/course/review?university=' . $university->id . '&course=' . $model->id : $url ?>"><img src="/images/review-blue.png"> Review</a> </div>
                                    <div class="col-sm-4"> <a class="btn-course-rating" href="<?= (!Yii::$app->user->isGuest) ? '/course/review?university=' . $university->id . '&course=' . $model->id : $url ?>"><img src="/images/rate-blue.png"> Rate</a> </div>
                                    <?php
                                        $src = 'images/follow-blue.png';
                                        $text = 'Follow';
                                        if(!empty($favourite) && $favourite->favourite == 1) {
                                            $src = 'images/unfollow-white.png';
                                            $text = 'Unfollow';
                                        }
                                    ?>
                                    <div class="col-sm-4"> <a class="btn-course-favourite" href="<?= (!Yii::$app->user->isGuest) ? '/course/favourite' : $url ?>"><img src="<?= $src; ?>"><span><?= $text ?></span></a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-padding">
        	    <div class="container">
                	<div class="row">
                    	<div class="col-sm-9">
                        	<div class="course-info">
                                <div class="row">
                                    <div class="col-sm-4">
                                    	<div class="uni-logo">
                                            <?php
                                                $backgroundImage = '';
                                                if (is_dir("./../../backend/web/uploads/$university->id/logo")) {
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
                                    		<img src="<?= $backgroundImage; ?>" alt="<?= $university->name; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                	    <h2 class="course-name"><?= $model->name ?></h2>
                                        <h3 class="course-uni"><a href="/university/view?id=<?= $university->id ?>"><?= $university->name ?></a></h3>
                                        <h4 class="course-location"><?= $country; ?></h4>
                                    </div>
                                </div>
                                <div class="course-features">
                                    <ul>
                                        <li>
                                    		<img src="/images/f-ic-1.png" alt=""/>
                                            <p><?= Yii::$app->formatter->asCurrency($model->fees, $university->currency->iso_code)?></p>
                                        </li>
                                    	<!--<li>
                                    		<img src="/images/f-ic-2.png" alt=""/>
                                            <p><?= Yii::$app->formatter->asInteger($model->intake) ?> Seats</p>
                                        </li>-->
                                	    <li>
                                		    <img src="/images/f-ic-3.png" alt=""/>
                                            <p><?= Yii::$app->formatter->asInteger($model->duration, 1) ?> Year</p>
                                        </li>
                                	    <li>
                                    		<img src="/images/f-ic-4.png" alt=""/>
                                            <p><?= $type ?></p>
                                        </li>
                                    	<li>
                                    		<img src="/images/f-ic-5.png" alt=""/>
                                            <p><?= $language ?></p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="row">
                            	    <div class="col-sm-12 course-info-p">
                                	    <h3>Description</h3>
                                        <p><?= $model->description ?></p>
                                    </div>                            	    
                            	    <div class="col-sm-12 course-info-p">
                                	    <h3>Test Requirements</h3>

                                        <?php foreach($tests as $category => $value): ?>
                                            <h4><?= $category; ?></h4>
                                            <?php foreach($value as $test): ?>
                                                <p><a target="_blank" href="<?= $test['source']; ?>"><?= $test['name']?></a></p>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        </div>
                                    <div class="col-sm-12 course-info-p">
                                	    <h3>Apply Online</h3>
                                        <p>
                                            <?php
                                                $href = 'href="/site/login"';
                                                $text = 'Apply';
                                                if (isset(Yii::$app->user->identity->id)) {
                                                    $href = 'href="/course/apply-to-course"';
                                                }
                                                if(!empty($application)) {
                                                    $href = 'href="/university-applications/view&id=' . $application->id . '"';
                                                    $text = 'View';
                                                }
                                            ?>
                                            <a class="btn btn-blue btn-course-apply" <?= $href; ?>><?= $text ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                	    <div class="col-sm-3">
                        	<div class="ad-blocks">
                        		<div class="ad-block" style="background-color:#414e57; height:600px; margin-bottom: 40px"></div>
                    		    <div class="ad-block" style="background-color:#414e57; height:450px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section section-padding review-block">
        	    <div class="container">
                    <div class="row">
            	        <div class="col-sm-8">
                            <div class="group-title-index">
                                <h1>Review</h1>
                            </div>
                            <?php foreach($latestReviews as $review): ?>
                                <div class="row review-content">
                                    <div class="col-sm-2">
                                        <?php
                                            $profile = 'noprofile.gif';
                                            if (is_dir("uploads/$review->student_id/profile_photo")) {
                                                $profile_path = FileHelper::findFiles("./uploads/$review->student_id/profile_photo", [
                                                    'caseSensitive' => true,
                                                    'recursive' => false
                                                ]);
                                            
                                                if (count($path) > 0) {
                                                    $profile = $profile_path[0];
                                                    $profile = str_replace("\\","/",$profile);
                                                }
                                            }
                                        ?>
                                        <div class="review-img">
                                            <img src="<?= $profile; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <?php
                                            $user = $review->student->email;
                                            if(!empty($review->student->student)) {
                                                $user = $review->student->student->first_name . ' ' . $review->student->student->last_name;
                                            }
                                        ?>
                                        <h2 class="review-name"><?= $user; ?></h2>
                                        <p><?= $review->review; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    	<div class="col-sm-4">
                        	<div class="group-title-index">
                                <h1>Rating</h1>
                            </div>
                            <?php foreach($latestRatings as $rate): ?>
                                <div class="rating-output">
                                    <div class="raters-img">
                                    <?php
                                        $profile = 'noprofile.gif';
                                        if (is_dir("uploads/$rate->student_id/profile_photo")) {
                                            $profile_path = FileHelper::findFiles("./uploads/$rate->student_id/profile_photo", [
                                                'caseSensitive' => true,
                                                'recursive' => false
                                            ]);
                                        
                                            if (count($path) > 0) {
                                                $profile = $profile_path[0];
                                                $profile = str_replace("\\","/",$profile);
                                            }
                                        }
                                    ?>
                                    <img src="<?= $profile; ?>"/>
                                    </div>
                                    <div class="raters-name">John Doe</div>
                                    <div class="rating-count">
                                        <?php for($i = 0; $i < $rate->rating; $i++ ): ?>
                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>

<input type="hidden" id="university" value="<?= $university->id; ?>" />
<input type="hidden" id="course-id" value="<?= $model->id; ?>" />

<?php
    $this->registerJsFile('@web/js/course.js');
?>