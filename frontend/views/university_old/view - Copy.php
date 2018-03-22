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
$this->context->layout = 'index';
$this->registerCssFile('css/blueimp-gallery.css');
$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
$this->registerJsFile('js/blueimp-gallery.js');

$script = <<< JS
$('#program-tab-selector').on('change', function (e) {
 $('#program-tab-ul li a').eq($(this).val()).tab('show');
});
JS;
$this->registerJs($script);
 
 
$uid = $model->id;
$path= ConnectionSettings::BASE_URL.'backend';

$LogoPath = $path."/web/uploads/$uid/logo/";
$coverPhotoPath = $path."/web/uploads/$uid/cover_photo/";
$galleryPath = $path."/web/uploads/$uid/photos/"; 

$UGallery = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	 
				['=', 'status',  '1' ],
				['=', 'active',  '1' ]
				])->all();
 
$coverPhotos = '';	
$logo = ''; 
$gallery = [];	
$galleryList = [];	 
	
if($UGallery){
	foreach($UGallery as $file) {		
		if($file->photo_type=='cover_photo'){ 
		 $coverPhoto = $file->filename;
		 $coverPhotos = $coverPhotoPath.$coverPhoto;
		}
	} 

	foreach($UGallery as $file) {		
		if($file->photo_type=='logo'){ 
			$logo = $file->filename;
			$logo = $LogoPath.$logo;
		}
	}
 
	foreach($UGallery as $file) {		
		if($file->photo_type=='photos'){ 
			array_push($galleryList, $file);
		}
	}
}



if(empty($logo)){
	$logo_path = "./../../backend/web/uploads/".$model->id."/logo/logo";
	if(glob($logo_path.'.jpg')){
	$logo = $logo_path.'.jpg';
	} else if(glob($logo_path.'.png')){
	$logo = $logo_path.'.png';
	} else if(glob($logo_path.'.gif')){
	$logo = $logo_path.'.gif';
	}
}

if(empty($coverPhotos)){
	 $backgroundImage = '';
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
	$coverPhotos =$backgroundImage;
}

?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content"><!-- SLIDER BANNER-->


<style type="text/css">
  .logo_univ_12120{
    height: 100px;
    width: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

</style>
<!-- <div class="uni-img-info main-bg" style="background-image: url(<?=  $coverPhotos; ?>);background-repeat: no-repeat;
    background-position: center;">
</div> -->
<div class="uni-img-info main-bg" style="background-image: url(<?=  $coverPhotos; ?>);background-repeat: no-repeat;
    background-position: center;">
</div>
<div class="uni-details">
<div class="container">
<div class="row">
<div class="col-sm-2">
  <div class="uni-logo"><img class="logo_univ_12120" src="<?=  $logo; ?>"/></div>
</div>
<div class="col-sm-7">
<h1 class="uni-name"> <?= $model->name ?> <small>EST. <?= $model->establishment_date ?></small> </h1>
</div>
<div class="col-sm-3">
<?php
function ordinal_suffix($n, $return_n = true) {
  $n_last = $n % 100;
  if (($n_last > 10 && $n_last << 14) || $n == 0) {
    $suffix = "th";
  } else {
    switch(substr($n, -1)) {
      case '1':    $suffix = "st"; break;
      case '2':    $suffix = "nd"; break;
      case '3':    $suffix = "rd"; break;
      default:     $suffix = "th"; break;
    }
  }
  return $return_n ? $n . $suffix : $suffix;
}

$bestRank = 'NA';
 $rankings = $model->institution_ranking;
 
if(isset($rankings)) {
$rankings = Json::decode($rankings);
$bestRank =ordinal_suffix($rankings[0]['rank'])." ".$rankings[0]['name'];
	/*$len = sizeof($rankings);
	for($i = 0; $i < $len; $i++ ) {
	if ($bestRank > $rankings[$i]['rank']) {
	echo $bestRank = $rankings[$i]['rank'];
	}
	} */
$bestRank = '#' . $bestRank; 
}
?>

<ul class="uni-links">
<?php
$url = '?r=site/login';
?>
<li> 
  <!--<a class="btn-review" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/review&university=' . $model->id : $url ?>"><img src="/images/review-btn.png"> Review & Rating</a>--> 
  <button type="button" class="btn-review" style="background-color:transparent;border:none;" data-toggle="modal" data-target="#login-modal" value="<?= (!Yii::$app->user->isGuest) ? '?r=university/review&university=' . $model->id : $url ?>"><img src="/images/review-btn.png"> Review & Rating</button>
</li>
<!--<div class="col-xs-4"> <a class="btn-rating" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/review&university=' . $model->id : $url ?>"><img src="/images/rate-blue.png"> Rate</a> </div>-->
<?php
$src = 'images/follow.png';
$text = 'Shortlist';
if(!empty($favourite) && $favourite->favourite == 1) {
$src = 'images/unfollow-white.png';
$text = 'Shortlisted';
}
?>
<li> 
  <!--<a class="btn-favourites" href="<?= (!Yii::$app->user->isGuest) ? '?r=university/favourite' : $url ?>"><img src="<?= $src; ?>"><span><?= $text ?></span></a>-->
  <button type="button" class="btn-favourites" style="background-color:transparent;border:none;" data-toggle="modal" data-target="#login-modal" value="<?= (!Yii::$app->user->isGuest) ? '?r=university/favourite' : $url ?>"><img src="<?= $src; ?>"><span><?= $text ?></span></button>
</li>
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
<?php
$activeProgram = '';
$activeAbout = '';
if(!empty($_GET['page'])){
		 $activeProgram = "active";
	}else{
		 $activeAbout = "active";
	}
?>
<li class="<?php echo $activeAbout;?>"><a class="program-tabs" href="#tab-aboutus" data-toggle="tab" aria-expanded="false"><i class="fa fa-info-circle" aria-hidden="true"></i> About Us</a></li>

<li class="<?php echo $activeProgram;?>"><a class="program-tabs" href="#tab-program" data-toggle="tab">
<i class="fa fa-graduation-cap" aria-hidden="true"></i> Programs</a></li>

<li><a class="program-tabs" href="#tab-applications" data-toggle="tab">
<i class="fa fa-file-text-o" aria-hidden="true"></i> Application Requirements</a></li>

<li><a class="program-tabs" href="#tab-cost" data-toggle="tab" aria-expanded="true"><i class="fa fa-money" aria-hidden="true"></i> Cost</a></li>

<li><a class="program-tabs" href="#tab-deadlines" data-toggle="tab"><i class="fa fa-clock-o" aria-hidden="true"></i> Deadlines</a></li>

<li><a class="program-tabs" href="#tab-notifications" data-toggle="tab">
<i class="fa fa-bell-o" aria-hidden="true"></i> Notifications</a></li>

<li><a class="program-tabs" href="#tab-ranking" data-toggle="tab">
<i class="fa fa-line-chart" aria-hidden="true"></i> Ranking</a></li>

<li><a class="program-tabs" href="#tab-downloads" data-toggle="tab">
<i class="fa fa-cloud-download" aria-hidden="true"></i> Downloads</a></li>
<li><a class="program-tabs" href="#tab-stories" data-toggle="tab">  Stories</a></li>
<li><a class="program-tabs" href="#tab-info" data-toggle="tab">
<i class="fa fa-line-chart" aria-hidden="true"></i> info</a></li>
</ul>

<div class="tab-content clearfix">

<div class="tab-pane <?php echo $activeAbout;?>" id="tab-aboutus">
<?php if(isset($model->description) && !empty($model->description)): ?>
<p><?= $model->description ?></p>
<?php endif; ?>
</div>



<div class="tab-pane <?php echo $activeProgram;?> " id="tab-program">

<?php if(count($courses)>0){ ?>
<div class="program-section section-padding">
<div class="program-list">
<div>
  <form>
    <select class="form-control" id="program-tab-selector" style="display:none;">

      <?php
      $count = -1;

      foreach($disciplineCount as $discipline => $majorCount): ?>
      <?php
      $degree = Degree::findOne($discipline);
      ?>
      <option value="<?= $count += 1; ?>"><?= $degree->name;?>(<?= $majorCount; ?>)</option>
      <?php endforeach; ?>
    </select>
  </form>
<ul class="nav nav-tabs" role="tablist" id="program-tab">
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
<?php }else{ ?>
	There are not any program uploaded for this university.
<?php }?>

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
<div class="col-xs-12 col-sm-12">
<?php
$rankings = [];
$rankings = Json::decode($model->institution_ranking);
if(!is_array($rankings)){
	$rankings = [];
}
$i = 0;
?>
<table class="table table-bordered" id="institution-rankings">
<tr>
	<th>Rank</th>
	<th>Source</th>
	<th>Name</th>
</tr>
<?php foreach ($rankings as $rank): ?>
	<tr data-index="<?= $i++; ?>">
		<td><?= $rank['rank'] ?></td>
		<td><?= $rank['source'] ?></td>
		<td><?= $rank['name'] ?></td>
	</tr>
<?php endforeach; ?>
</table>



</div>
</div>
<div class="tab-pane" id="tab-downloads">


 <?php  if(count($documentlist)>0){?>
<div class="btn-grp"><a class="btn btn-blue pull-right" href="?r=university/download-all&id=<?php echo $model->id; ?>"> Download All</a>
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
$ext = pathinfo($document_file, PATHINFO_EXTENSION); 	

$docurl = "?r=university/download&name=".$document_file."&id=".$model->id ;?>
  <?php  if (Yii::$app->user->isGuest) {
	  $docurl = "?r=site/signup";
  }
	  ?>
<div class="col-sm-12">
<a href="<?= $docurl; ?>" role="button">
  <div class="download-tab">
<?php
if($ext=="pdf"){ ?>
<img src="./../../frontend/web/images/pdf.png" alt="document" height="50">
 <?= $document_name; ?>

<?php }else if($ext=="docx" || $ext=="doc" ){ ?>
<img src="./../../frontend/web/images/docx.png" alt="document" height="50"><?= $document_name; ?>
<?php } else { ?>
<img src="?r=university/download&name=<?= $document_file; ?>&id=<?php echo $model->id; ?>" alt="document" height="50"><?= $document_name; ?>
<?php } ?>
</div>
</a>
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
<div class="tab-pane" id="tab-stories">
<?php if(isset($model->success_stories) && !empty($model->success_stories)): ?>
<p><?= $model->success_stories ?></p>
<?php endif; ?>
</div>


<div class="tab-pane " id="tab-info">
<div class="col-xs-12 col-sm-12">
<?php
$rankings = [];
$rankings = Json::decode($model->institution_ranking);
if(!is_array($rankings)){
	$rankings = [];
}
$i = 0;
?>
<table class="table table-bordered" id="institution-rankings">
<tr>
	<th>Rank</th>
	<th>Source</th>
	<th>Name</th>
</tr>
<?php foreach ($rankings as $rank): ?>
	<tr data-index="<?= $i++; ?>">
		<td><?= $rank['rank'] ?></td>
		<td><?= $rank['source'] ?></td>
		<td><?= $rank['name'] ?></td>
	</tr>
<?php endforeach; ?>
</table>

<!-- ------------------------------------------------------------------------------------------------------------- -->   
<div class="uni-txt-section section-padding">

<ul class="nav nav-tabs faq-tabs">
<?php
$activeDiv = '';
$j = 0;
foreach ($rankings as $rank) { if($j==0) { $activeDiv = 'active'; ?> 
<script type="text/javascript">$(document).ready(function(){
        //abcd('<?php echo $rank['rank']; ?>');
        
    });</script> <?php } else { $activeDiv = ''; }
?>
<li class="<?php echo $activeDiv;?>"><a class="program-tabs" href="#tab-<?php echo $rank['rank']; ?>" data-toggle="tab" aria-expanded="false" onclick="abcd('<?php echo  $rank['rank']; ?>');">
<i class="fa fa-file-text-o" aria-hidden="true"></i> <?php  echo  $rank['rank']; ?></a></li>

<?php $j++ ;} ?>  
</ul>

<div class="tab-content clearfix">

  <div class="faq-section">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i=0; foreach ($faq as $faqSingle) { if($i==0) { $open_answer = ''; } else { $open_answer = ''; }?>
                <div class="tab-pane <?php echo $activeDiv;?> tab-<?php echo $faqSingle['category_id']; ?>"  >
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                          <?php echo $faqSingle['question']; ?>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php echo $open_answer; ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                      <div class="panel-body">
                        <?php echo $faqSingle['answer']; ?>
                      </div>
                    </div>
                  </div>
                </div>  
                <?php $i++ ;} ?>  

              </div>
</div>

</div>
</div>  
<!-- ------------------------------------------------------------------------------------------------------------- --> 
<!-- newww sdection ------------------------------------------------------------------------------------>
<!--             <div class="faq-section">
            	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            	<?php foreach ($rankings as $rank): ?>

  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Frequently asked questions #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
<?php endforeach; ?>

</div>
</div> -->
<!-- newww sdection ------------------------------------------------------------------------------------>

</div>
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
if(isset($galleryList)){
$i = 0;   
$len = sizeof($galleryList);
//$len = ($len < 4) ? $len : 4;
?>
<?php for($i = 0; $i < $len; $i++): ?>
<?php
	$photo = $galleryList[$i];	
	$filename = $galleryPath.$photo->filename;	 
 
if($i<4){
?>
<div class="left col-sm-4  col-sm-3">
<a href="<?= $filename?>" >
<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>
</a>
</div>
<?php }else if($i==4){ ?>
<a href="<?= $filename?>" class="btn btn-blue all-images">View All</a>
<?php }else{ ?>
<div class="left" style="display:none;">
<a href="<?= $filename?>" >
<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>
</a>
</div>
  
<?php   } ?>
<?php endfor; 
}else { ?>



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
<?php endfor; 
}?>



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





<?php if(count($latestRatings)>0){ ?>
<div class="section section-padding">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="group-title-index">
<h1>Review & Rating</h1>
</div>
<div class="row">
<?php
foreach($latestRatings as $review): ?>
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
<?php
$user = $review->student->email;
if(!empty($review->student->student)) {
$user = $review->student->student->first_name . ' ' . $review->student->student->last_name;
}
?>
<div class="col-sm-6">
    <a data-toggle="modal" data-target=".<?php echo $review->id;?>">
    <div class="review-card">
        <div class="review-user-img">
          <img src="<?= $profile; ?>" alt=""/>
        </div>
        <div class="review-user-info">
          <h3 class="review-user-name"><?= $user; ?></h3>
		<div class="review-user-rating">
			  <?php
		echo StarRating::widget(['model' => $review,
		'readonly' => true,
		'name' => 'rating_'.$review->id,
		'value' => $review->rating,
		'pluginOptions' => [
		'theme' => 'krajee-uni',
		'filledStar' => '&#x2605;',
		'emptyStar' => '&#x2606;',
		'showClear' => false,
		'showCaption' => false,
		'size' =>'xs'

		]
		]);
		?>
		</div>
          <p class="review-user-content"><?php
		  $string = $review->review;
		  echo strlen($string) >= 100 ? substr($string, 0, 100) . '<a>Read more ... </a>' : $string;
?></p><span>Click to Read More</span>
        </div>
    </div>
  </a>
  </div>

 <div class="modal fade <?php echo $review->id;?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content review-modal">
      <div class="review-user-img">
        <img src="<?= $profile; ?>" alt=""/>
      </div>
      <h3 class="review-user-name"><?= $user; ?></h3>
      <div class="review-user-rating">
       <?php
		echo StarRating::widget(['model' => $review,
		'readonly' => true,
		'name' => 'rating_'.$review->id,
		'value' => $review->rating,
		'pluginOptions' => [
		'theme' => 'krajee-uni',
		'filledStar' => '&#x2605;',
		'emptyStar' => '&#x2606;',
		'showClear' => false,
		'showCaption' => false,
		'size' =>'xs'

		]
		]);
		?>
      </div>
      <p class="review-user-content"><?= $review->review; ?></p>
    </div>
  </div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</div>
</div>

<?php }   ?>



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
function abcd(id){
    $('.tab-pane').hide();
    $('.tab-'+id).show();
  }
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
