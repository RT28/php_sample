<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use frontend\models\Favorites;
use common\models\University;
use common\models\Student;
use common\models\Degree;
use common\models\UniversityCourseList;
use yii\helpers\FileHelper;

$this->title = $model->name;
$this->context->layout = 'index';
$this->registerCssFile('css/blueimp-gallery.css');
$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
$this->registerJsFile('js/blueimp-gallery.js');
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content"><!-- SLIDER BANNER-->

<?php
$backgroundImage = '';
$logo = '';
$path = null;
$path1 = null;
if (is_dir("./../../backend/web/uploads/".$model->id."/cover_photo")) {
$path = FileHelper::findFiles("./../../backend/web/uploads/".$model->id."/cover_photo", [
'caseSensitive' => true,
'recursive' => false
]);

if (count($path) > 0) {
$backgroundImage = $path[0];
$backgroundImage = str_replace("\\","/",$backgroundImage);
}
}
if (is_dir("./../../backend/web/uploads/".$model->id."/logo")) {
$path1 = FileHelper::findFiles("./../../backend/web/uploads/".$model->id."/logo", [
'caseSensitive' => true,
'recursive' => false
]);

if (count($path1) > 0) {
$logo = $path1[0];
$logo = str_replace("\\","/",$logo);
}
}
?>
<!--<div class="uni-img-info main-bg" style="background-image: url(<?=  $backgroundImage; ?>);">-->
<div class="uni-img-info main-bg" style="background-image: url(http://gotouniversity.com/backend/web/uploads/58/cover_photo/cover1493797912.jpg);">

</div>
<div class="uni-details">
<div class="container">
<div class="row">
<div class="col-sm-8">
<h1 class="uni-name"> <?= $model->name ?> <small>EST. <?= $model->establishment_date ?></small> </h1>
</div>
<div class="col-sm-4">
<?php
$bestRank = 'NA';
$rankings = $model->institution_ranking;
if(isset($rankings)) {
$rankings = Json::decode($rankings);
$bestRank = $rankings[0]['rank'];
$len = sizeof($rankings);
for($i = 1; $i < $len; $i++ ) {
if ($bestRank > $rankings[$i]['rank']) {
$bestRank = $rankings[$i]['rank'];
}
}
$bestRank = '#' . $bestRank;
}
?>

<ul class="uni-links">
<?php
$url = '?r=site/login';
?>
<li> <a class="btn-review" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/review&university=' . $model->id : $url ?>"><img src="/images/review-btn.png"> Review & Rating</a> </li>
<!--<div class="col-xs-4"> <a class="btn-rating" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/review&university=' . $model->id : $url ?>"><img src="/images/rate-blue.png"> Rate</a> </div>-->
<?php
$src = 'images/follow.png';
$text = 'Shortlist';
if(!empty($favourite) && $favourite->favourite == 1) {
$src = 'images/unfollow.png';
$text = 'Shortlisted';
}
?>
<li> <a class="btn-favourites" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/favourite' : $url ?>"><img src="<?= $src; ?>"><span><?= $text ?></span></a> </li>
</div>
</div>
</div>
</div>
</div>
<div class="container univ-basic-details">
  <div class="row">
    <div class="col-sm-4">
      <div class="univ-info-block">
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <p class="uni-country"> <?= $model->country->name ?> </p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="univ-info-block">
        <i class="fa fa-link" aria-hidden="true"></i>
        <p class="uni-website"> <a href="<?= $model->website ?>" target="_blank"><?= $model->website ?></a></p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="univ-info-block">
        <i class="fa fa-bar-chart" aria-hidden="true"></i>
        <p class="ranking"><?= $bestRank ?></p>
      </div>
    </div>
  </div>
</div>
<div class="uni-txt-section section-padding">
<div class="container">

<div id="exTab1" class="container">
<ul class="nav nav-tabs">

<li class="active"><a class="program-tabs" href="#tab-aboutus" data-toggle="tab" aria-expanded="false"><i class="fa fa-info-circle" aria-hidden="true"></i> About Us</a></li>

<li class=""><a class="program-tabs" href="#tab-program" data-toggle="tab">
<i class="fa fa-graduation-cap" aria-hidden="true"></i> Programs</a></li>

<li class=""><a class="program-tabs" href="#tab-applications" data-toggle="tab">
<i class="fa fa-file-text-o" aria-hidden="true"></i> Application Requirements</a></li>

<li ><a class="program-tabs" href="#tab-cost" data-toggle="tab" aria-expanded="true"><i class="fa fa-money" aria-hidden="true"></i> Cost</a></li>

<li class=""><a class="program-tabs" href="#tab-deadlines" data-toggle="tab"><i class="fa fa-clock-o" aria-hidden="true"></i> Deadlines</a></li>

<li class=""><a class="program-tabs" href="#tab-notifications" data-toggle="tab">
<i class="fa fa-bell-o" aria-hidden="true"></i> Notifications</a></li>

<li class=""><a class="program-tabs" href="#tab-ranking" data-toggle="tab">
<i class="fa fa-line-chart" aria-hidden="true"></i> Ranking</a></li>

<li class=""><a class="program-tabs" href="#tab-downloads" data-toggle="tab">
<i class="fa fa-cloud-download" aria-hidden="true"></i> Downloads</a></li>
</ul>

<div class="tab-content clearfix">

<div class="tab-pane active" id="tab-aboutus">
<?php if(isset($model->description) && !empty($model->description)): ?>
<p><?= $model->description ?></p>
<?php endif; ?>
</div>



<div class="tab-pane " id="tab-program">
<div class="program-section section-padding">
<div class="container">

<div class="program-list">
<div>
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a data-university="<?= $model->id; ?>" data-degree="All" href="#tab-all" class="program-tabs" aria-controls="home" role="tab" data-toggle="tab">All(<?= $totalCourseCount; ?>)</a></li>
<?php foreach($disciplineCount as $discipline => $majorCount): ?>
<?php
$degree = Degree::findOne($discipline);
?>
<li role="presentation" class=""><a data-university="<?= $model->id; ?>" data-degree="<?= $degree->id; ?>" class="program-tabs" href="#tab-<?= $degree->id; ?>" aria-controls="home" role="tab" data-toggle="tab"><?= $degree->name;?>(<?= $majorCount; ?>)</a></li>
<?php endforeach; ?>
</ul>
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="tab-all">
<?php
echo $this->render('course-list', [
'courses' => $courses,
'types' => $types,
'languages' => $languages,
'pages' => $pages,
'totalCourseCount' => $totalCourseCount,
'durationType' => $durationType,
'shortlisted' => $shortlisted,
'fromUniversity' => true
]);
?>
</div>
<?php foreach($disciplineCount as $discipline => $majorCount): ?>
<?php
$degree = Degree::findOne($discipline);
?>
<div role="tabpanel" class="tab-pane" id="tab-<?= $degree->id; ?>"></div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</div>
</div>


<div class="tab-pane " id="tab-applications">
<?php if(isset($model->application_requirement ) && !empty($model->application_requirement )): ?>
<p><?= $model->application_requirement  ?></p>
<?php endif; ?>
</div>

<div class="tab-pane  " id="tab-cost">
<div class="row">
<div class="content">

<div class="col-sm-6">
<h3>Fees</h3>
<?php if(isset($model->fees) && !empty($model->fees)): ?>
<p><?= $model->fees ?></p>
<?php endif; ?>
</div>

<div class="col-sm-6">
<h3>Cost of Living</h3>
<?php if(isset($model->cost_of_living_text) && !empty($model->cost_of_living_text)): ?>
<p><?= $model->cost_of_living_text ?></p>
<?php endif; ?>
<h3>Accommodation</h3>
<?php if(isset($model->accommodation) && !empty($model->accommodation)): ?>
<p><?= $model->accommodation ?></p>
<?php endif; ?>
</div>

</div>
</div>

</div>


<div class="tab-pane " id="tab-deadlines">
<?php if(isset($model->deadlines) && !empty($model->deadlines)): ?>
<p><?= $model->deadlines ?></p>
<?php endif; ?>
</div>

<div class="tab-pane " id="tab-notifications">
<?php if(isset($UniversityNotifications)){
if(count($UniversityNotifications)>0){?>
<div class="group-title-index"><h1>Notifications</h1></div>
<ul class="noti-list">
<?php foreach($UniversityNotifications as $news): ?>
<li>
<a href="?r=university/news&id=<?php echo $news->id;?>" title="<?php  echo $news->title;?>" ><?php  echo $news->title;?></a>
</li>
<?php endforeach; ?>
</ul>
<?php }
}?>
</div>

<div class="tab-pane " id="tab-ranking">
ranking
</div>
<div class="tab-pane" id="tab-downloads">
downloads

</div>

</div>
</div>

</div>
</div>


<div class="section progress-bars inner section-padding">
<div class="container">
<div class="progress-bars-content">
<div class="progress-bar-wrapper">
<div class="row">
<div class="content">
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_students ?>" data-speed="1000" class="num">0</div>
<img src="/images/student-ic.png"/>
<p class="name-inner">Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_international_students ?>" data-speed="1000" class="num">0</div>
<img src="/images/inti-stu.png"/>
<p class="name-inner">International Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_undergraduate_students ?>" data-speed="1000" class="num">0</div>
<img src="/images/ug-ic.png"/>
<p class="name-inner">Undergraduate Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_post_graduate_students ?>" data-speed="1000" class="num">0</div>
<img src="/images/pg-ic.png"/>
<p class="name-inner">Post Graduate Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_faculties ?>" data-speed="1000" class="num">0</div>
<img src="/images/fac-ic.png"/>
<p class="name-inner">Faculties</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_international_faculty ?>" data-speed="1000" class="num">0</div>
<img src="/images/int-fac.png"/>
<p class="name-inner">International Faculty</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php if(is_dir('./../../backend/web/uploads/' . $model->id)): ?>
<div class="section section-padding gallery">
<div class="container">
<div class="group-title-index">
<h1>Photo Gallery</h1>
</div>
<?php
$gallery = [];
if (is_dir("./../../backend/web/uploads/$model->id/photos")) {
$gallery_path = FileHelper::findFiles("./../../backend/web/uploads/$model->id/photos", [
'caseSensitive' => true,
'recursive' => false,
]);
if (count($gallery_path) > 0) {
foreach($gallery_path as $path) {
array_push($gallery, $path);
}
}
}
?>
<div class="row">
<div id="imglinks">
<?php
$len = sizeof($gallery);
//$len = ($len < 4) ? $len : 4;
?>
<?php for($i = 0; $i < $len; $i++): ?>
<?php
$photo = $gallery[$i];
if($i<4){
?>
<div class="left col-sm-4  col-sm-3">
<a href="<?= $photo ?>" >
<div class="gallery-block"><img src="<?= $photo ?>" alt="<?= $model->name?> gallery"/></div>
</a>
</div>
<?php }else if($i==4){ ?>
<a href="<?= $photo ?>" class="btn btn-blue all-images">View All</a>
<?php }else{ ?>
<div class="left" style="display:none;">
<a href="<?= $photo ?>" >
<div class="gallery-block"><img src="<?= $photo ?>" alt="<?= $model->name?> gallery"/></div>
</a>
</div>
<?php } ?>
<?php endfor; ?>
</div>
<div id="blueimp-gallery" class="blueimp-gallery">
<div class="slides"></div>
<a class="prev">‹</a>
<a class="next">›</a>
<a class="close">×</a>
<a class="play-pause"></a>
<ol class="indicator"></ol>
</div>
<script>
document.getElementById('imglinks').onclick = function (event) {
event = event || window.event;
var target = event.target || event.srcElement,
link = target.src ? target.parentNode : target,
options = {index: link, event: event},
links = this.getElementsByTagName('a');
blueimp.Gallery(links, options);
};
</script>
</div>
</div>
</div>

<?php endif; ?>

<?php if(!empty($model->video)): ?>
<div class="section section-padding consultants">
<div class="container">
<div class="group-title-index">
<h1>Video </h1>
</div>
<div class="row">
<!--<div class="col-sm-8 col-sm-offset-2">
<div class="Video-block">
<iframe width="100%" height="400px" src="<?= $model->video ?>" frameborder="0" allowfullscreen></iframe>
</div>
</div>-->
<div class="col-sm-6 col-xs-12">
  <div class="video-link">
    <a href="https://www.youtube.com/watch?v=C4yASZjti5w">
      <img src="/images/video-img.jpg" alt="">
    </a>
  </div>
</div>
<div class="col-sm-6 col-xs-12">
  <div class="video-link">
    <a href="https://www.youtube.com/watch?v=C4yASZjti5w">
      <img src="/images/video-img.jpg" alt="">
    </a>
  </div>
</div>
</div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($model->virtual_tour)): ?>
<div class="section section-padding block-360">
<div class="container">
<div class="group-title-index">
<h1>Virtual Tour</h1>
</div>
</div>
<div id="canvas1" class="view-360 text-center">
<iframe id="map_canvas1" width="100%" height="500px" src="<?= $model->virtual_tour ?>" frameborder="0" allowfullscreen></iframe>
</div>
</div>
<?php endif; ?>



<?php
if(isset($UniversityCommonAdmission)){
if(count($UniversityCommonAdmission)>0){?>
<div class="section section-padding">
<div class="container">

<div class="group-title-index">
<h1>Common Admission Criteria</h1>
</div>
<div id="exTab1" class="container">
<ul  class="nav nav-pills">
<?php
$i=1;
foreach($UniversityCommonAdmission as $key => $value): ?>
<li class="<?php if($i==1){?>active<?php }?>"><a  class="program-tabs" href="#tab-<?= $key; ?>" data-toggle="tab"><?= $key;?></a></li>
<?php
$i++;
endforeach; ?>
</ul>

<div class="tab-content clearfix">
<?php $k=1;
foreach($UniversityCommonAdmission as $degree => $tests): ?>

<div class="tab-pane <?php if($k==1){?>active<?php }?>"  id="tab-<?= $degree; ?>">
<?php
foreach($tests as $test => $score):
echo $test .' : '.$score ."<br/>";

endforeach;
?>

</div>
<?php
$k++;
endforeach; ?>
</div>
</div>

</div>
</div>

<?php }
}?>

<div class="section section-padding">
<div class="container">
<div class="row">
<?php if(count($latestReviews)>0){ ?>
<div class="col-sm-8">
<div class="group-title-index">
<h1>Review & Rating</h1>
</div>
<?php foreach($latestReviews as $review): ?>
<div class="row review-content">
<div class="col-xs-2">
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
<div class="col-xs-10">
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
<?php } if(count($latestRatings)>0){ ?>
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
<?php } ?>
</div>
</div>
</div>


<div class="section section-padding contact">
<div class="container">
<div class="row">
<div class="col-sm-5">
<div class="group-title-index">
<h1>Contact Info</h1>
</div>
<div class="contact-info-subblock visit">
<h3 class="title">Address</h3>
<p class="content"><?= $model->address ?>, <?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->pincode ?>, <?= $model->country->name ?></p>
</div>
<div class="contact-info-subblock mail">
<h3 class="title">Email</h3>
<p class="content"><a href="mailto:<?= $model->email ?>"><?= $model->email ?></a></p>
</div>
<div class="contact-info-subblock call">
<h3 class="title">Phone</h3>
<p class="content"><a href="tel:<?= $model->phone_1 ?>"><?= $model->phone_1 ?></a></p>
</div>
<div class="contact-info-subblock hour">
<h3 class="title">Fax</h3>
<p class="content"><?= $model->fax ?></p>
</div>
</div>
<div class="col-sm-7">
<div class="uni-location">
<div id="map" style="width: 100%; height: 370px;"></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
<div class="modal vcenter" id="video-popup" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <button type="button" class="closeVideo" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <div class="video-iframe"></div>
  </div>
</div>
</div>
<script >

function CheckSelected(university_id,course_id) {

$.ajax({
url: '?r=university/mostviewed',
method: 'POST',
data: {
university_id: university_id,
course_id: course_id,
},
success: function(response, data) {
response = JSON.parse(response);
if(response.status == 'success') {
alert(response);
}
},
error: function(error) {
console.log(error);
}
});
}
</script>
<?php
$location = $model->location;
$location = str_replace([' '], ',', $location);
$location = str_replace(['POINT', 'GeomFromText(\'', '\')', ')', '('], '', $location);
$latLng = [0, 0];
if(!empty($location)) {
$latLng = explode(',', $location);
}
echo '<input type="hidden" value="'. $latLng[0] .'" id="latitude"/>';
echo '<input type="hidden" value="'. $latLng[1] .'" id="longitude"/>';
echo '<input type="hidden" value="'. $model->id .'" id="university"/>';

$this->registerJsFile('@web/js/university.js');
$this->registerJsFile('@web/js/youtube-modal.js');
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAv4wp5sZdpP31AWEAZuyLMyRKDhhOtWLw&callback=initMap');
?>
