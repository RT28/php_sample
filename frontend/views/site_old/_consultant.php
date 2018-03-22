<?php
    use yii\helpers\FileHelper;
    $this->title = 'Consultant';
    $this->context->layout = 'index';
?>

<!-- CONSULTANTS -->
<div class="section section-padding consultants" id="consultant">
<div class="container">
	<div class="group-title-index">
		<h1>Our Consultants</h1>
	</div>
	<div class="row">
	 
		 
	  
	  <?php foreach($consultants as $con): ?>
<div class="col-sm-3 col-xs-6">
<?php
/*$src = './../../partner/web/noprofile.gif';
if (is_dir("./../../partner/web/uploads/$con->consultant_id/")) {
  $path = FileHelper::findFiles("./../../partner/web/uploads/$con->consultant_id/", [
	'caseSensitive' => true,
	'recursive' => false,
	'only' => ['profile_photo.*']
  ]);
  if (count($path) > 0) {
	$src = $path[0];
  }
}*/ 
$profile_path = "./../../partner/web/uploads/".$con->consultant_id."/consultant_image_228X228";
if(glob($profile_path.'.jpg')){
  $src = $profile_path.'.jpg';
} else if(glob($profile_path.'.png')){
  $src = $profile_path.'.png';
} else if(glob($profile_path.'.gif')){
  $src = $cover_path.'.gif';
} else {
	$src = './../../partner/web/noprofile.gif';
}
?>
<style type="text/css">
  .con_12120{
    height: 200px;
    width: 100%;
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

</style>
<div class="consultants-block"> <img class="con_12120" src="<?= $src;?>" alt=""/>
<div class="name">
<a href="?r=consultant/view&id=<?= $con->consultant_id; ?>" ><?= $con->first_name. ' '.$con->last_name; ?></a>
</div>
</div> 
</div>
<?php endforeach; ?> 
	</div>
	<div class="row text-center">
		<a class="btn btn-blue mtop-20" href="?r=consultant/index">View all</a>
	</div>
</div>
</div>
				
 