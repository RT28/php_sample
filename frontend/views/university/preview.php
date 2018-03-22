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
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use common\components\ConnectionSettings;
use common\models\UniversityGallery; 
 

$this->title = $model->name;
//$this->context->layout = 'index';
$this->registerCssFile('css/blueimp-gallery.css');
$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
$this->registerJsFile('js/blueimp-gallery.js');
 
?>

<?php
$uid = $model->university_id;
$basePath= ConnectionSettings::BASE_URL;
$path= ConnectionSettings::BASE_URL.'backend';

$LogoPath = $path."/web/uploads/$uid/logo/";
$coverPhotoPath = $path."/web/uploads/$uid/cover_photo/";
$galleryPath = $path."/web/uploads/$uid/photos/"; 

$backgroundImage = '';
$logo = '';
$logofile = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	
				['=', 'photo_type',  'logo' ],				
				['=', 'status',  '0' ],
				['=', 'active',  '0' ]
				])->one();
if($logofile){ 
	 if(!empty($logofile->filename))	{		
		$logo= $LogoPath.$logofile->filename;
	}
}else{
	
	$Mainlogofile = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	
				['=', 'photo_type',  'logo' ],				
				['=', 'status',  '1' ],
				['=', 'active',  '1' ]
				])->one();
	if(!empty($Mainlogofile->filename))	{		
		$logo= $LogoPath.$Mainlogofile->filename;
	}
}
				
$coverPhoto = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	
				['=', 'photo_type',  'cover_photo' ],				
				['=', 'status',  '0' ],
				['=', 'active',  '0' ]
				])->one();
if($coverPhoto){
	if(!empty($coverPhoto->filename))	{  
	  $backgroundImage= $coverPhotoPath.$coverPhoto->filename;
	}
}else{
	$MainCoverPhoto = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	
				['=', 'photo_type',  'cover_photo' ],				
				['=', 'status',  '1' ],
				['=', 'active',  '1' ]
				])->one();
	if(!empty($MainCoverPhoto->filename))	{ 			
	 $backgroundImage= $coverPhotoPath.$MainCoverPhoto->filename;
	}
	
}
				
$UGallery = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 
				['=', 'photo_type',  'photos' ],				
				['=', 'status',  '0' ],
				['=', 'active',  '0' ]
				])->all();
				
 
$gallery = [];	
		
if(isset($UGallery)){	  
	foreach($UGallery as $file) {		 
			array_push($gallery, $file);
		}
	}
		 		
 
?> 

<div id="wrapper-content">
    <div id="page-wrapper">
        <div class="main-content">
            <div class="content"> 
                     
<div class="uni-img-info main-bg"  style="background-image: url(<?= $backgroundImage; ?>);">
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
$url = '/site/login';
?>
<li> <img src="/images/review-btn.png"> Review & Rating</li>
<?php
$src = 'images/follow.png';
$text = 'Shortlist';
if(!empty($favourite) && $favourite->favourite == 1) {
$src = 'images/unfollow.png';
$text = 'Shortlisted';
}
?>
<li> <img src="<?= $src; ?>"><span><?= $text ?></span></li>
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
<a href="/university/news?id=<?php echo $news->id;?>" title="<?php  echo $news->title;?>" ><?php  echo $news->title;?></a>
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


 <?php  if(count($documentlist)>0){?>
<div class="btn-grp"><a class="btn btn-blue pull-right" href="/university/download-all?id=<?php echo $model->id; ?>"> Download All</a>
<div class="clearfix"></div>
</div>
<div class="row">
<?php
foreach($doclist as $key=> $value):
	?>
  <div class="col-sm-4">
<div class="group-title-index"><h1><?php echo $value; ?></h1></div>
	<div class="row">
	<?php
foreach($documentlist as $getdocument):
$documentType=$getdocument->document_type;
if($documentType==$key){
$document_name=$getdocument->title;
$document_file=$getdocument->filename;
$id=$getdocument->id;
$ext = pathinfo($document_file, PATHINFO_EXTENSION); 	?>

<div class="col-sm-12">
  <div class="download-tab">
<?php
if($ext=="pdf"){ ?>
<img src="./../../frontend/web/images/pdf.png" alt="document" height="50">
 <?= $document_name; ?>

<?php }else if($ext=="docx" || $ext=="doc" ){ ?>
<img src="./../../frontend/web/images/docx.png" alt="document" height="50"><?= $document_name; ?>
<?php } else { ?>
<img src="/university/download?name=<?= $document_file; ?>&id=<?php echo $model->id; ?>" alt="document" height="50"><?= $document_name; ?>
<?php } ?>
</div>
</div>

<?php }
endforeach; ?>
</div>
</div>
<?php  endforeach; ?>
</div>
<?php }else{
	?>
There are not any document uploaded here.

<?php

}?>


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
<img src="<?= $basePath?>/frontend/web/images/student-ic.png"/>
<p class="name-inner">Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_international_students ?>" data-speed="1000" class="num">0</div>
<img src="<?= $basePath?>/frontend/web/images/inti-stu.png"/>
<p class="name-inner">International Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_undergraduate_students ?>" data-speed="1000" class="num">0</div>
<img src="<?= $basePath?>/frontend/web/images/ug-ic.png"/>
<p class="name-inner">Undergraduate Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_post_graduate_students ?>" data-speed="1000" class="num">0</div>
<img src="<?= $basePath?>/frontend/web/images/pg-ic.png"/>
<p class="name-inner">Post Graduate Students</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_faculties ?>" data-speed="1000" class="num">0</div>
<img src="<?= $basePath?>/frontend/web/images/fac-ic.png"/>
<p class="name-inner">Faculties</p>
</div>
</div>
<div class="col-sm-2">
<div class="progress-bar-number">
<div data-from="0" data-to="<?= $model->no_of_international_faculty ?>" data-speed="1000" class="num">0</div>
<img src="<?= $basePath?>/frontend/web/images/int-fac.png"/>
<p class="name-inner">International Faculty</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php if(is_dir('./../../backend/web/uploads/' . $model->university_id)): ?>
<div class="section section-padding gallery">
<div class="container">
<div class="group-title-index">
<h1>Photo Gallery</h1>
</div>

<div class="row">
<div id="imglinks">
<?php
$len = sizeof($gallery);
//$len = ($len < 4) ? $len : 4;
?>
<?php for($i = 0; $i < $len; $i++): ?>
<?php
echo $photo = $gallery[$i];
$filename = $galleryPath.$photo->filename;
if($i<4){
?>
<div class="left col-sm-3"> 
<div class="gallery-block"><img src="<?= $filename ?>" alt="<?= $model->name?> gallery"/></div>

</div>
<?php }else if($i==4){ ?>
<div class="left" style="float:right;">
<a href="#">More...</a>
</div> 
<?php }else{ ?>
<div class="left" style="display:none;"> 
<div class="gallery-block"><img src="<?= $filename ?>" alt="<?= $model->name?> gallery"/></div>

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
<div class="col-sm-8 col-sm-offset-2">
<div class="Video-block">
<iframe width="100%" height="400px" src="<?= $model->video ?>" frameborder="0" allowfullscreen></iframe>
</div>
</div>
</div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($model->virtual_tour)): ?>
<div class="section section-padding 360-block">
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
			<p class="content"><?= $model->email ?></p>
		</div>
		<div class="contact-info-subblock call">
			<h3 class="title">Phone</h3>
			<p class="content"><?= $model->phone_1 ?></p>
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
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>

 

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
    $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyAv4wp5sZdpP31AWEAZuyLMyRKDhhOtWLw&callback=initMap');
?>
