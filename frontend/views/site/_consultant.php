<?php
    use yii\helpers\FileHelper;
    $this->context->layout = 'index';
?>

<!-- CONSULTANTS -->

<div class="section section-padding consultants" id="consultant">
  <div class="container">
    <div class="group-title-index">
      <h1><?= Yii::t('gtuhome', 'Our') ?></br>
        <?= Yii::t('gtuhome', 'Consultants') ?></h1>
    </div>
    <div class="consultants-slider">
	<?php if(isset($consultants)){ ?>
        <?php foreach($consultants as $con): ?>
    	
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
            $profile_path = "./../../partner/web/uploads/consultant/".$con->consultant_id."/profile_photo/consultant_image_228X228";
            if(glob($profile_path.'.jpg')){
              $src = $profile_path.'.jpg';
            } else if(glob($profile_path.'.png')){
              $src = $profile_path.'.png';
            } else if(glob($profile_path.'.gif')){
              $src = $profile_path.'.gif';
            } else if(glob($profile_path.'.jpeg')){
              $src = $profile_path.'.jpeg';
            } else if(glob($profile_path.'.JPG')){
              $src = $profile_path.'.JPG';
            } else if(glob($profile_path.'.PNG')){
              $src = $profile_path.'.PNG';
            } else if(glob($profile_path.'.GIF')){
              $src = $profile_path.'.GIF';
            } else if(glob($profile_path.'.JPEG')){
              $src = $profile_path.'.JPEG';
            } else {
                $src = './../../partner/web/noprofile.gif';
            }
        ?>

        <div class="consultants-block">
        	<div class="consultants-profile-pic">
        	<div class="profile-pic-container">
            <img src="<?= $src;?>" alt=""/>
            </div>
            	<h3 class="consultants-name"><a href="/consultant/index#<?= $con->consultant_id; ?>" ><?= $con->first_name. ' '.$con->last_name; ?></a></h3>
                </div>
            <div class="consultants-information">
                <p class="consultants-name"><?= $con->description ?></p>
                <div class="consultants-basic-details">
                	 <div class="row">
                                <div class="col-sm-6">
                                  <div class="consultant-info-div">
                                    <label><?= Yii::t('gtuhome', 'Country:') ?> </label>
                                    <span><?= $con->country->name; ?></span></div>
                                  <div class="consultant-info-div">
                                    <label><?= Yii::t('gtuhome', 'Experience:') ?> </label>
                                    <span><?php echo $con->experience_years.' Years '.$con->experience_months.' Months';?></span></div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="consultant-info-div">
                                    <label><?= Yii::t('gtuhome', 'Languages:') ?> </label>
                                    <span><?php if(isset($con->languages)) { echo $con->languages;  } ?></span></div>
                                </div>
                              </div>
                </div>
            </div>
        </div>
        <?php endforeach; 
	}?>
		
    </div>
    
    <a class="btn btn-blue all-consultant-tab" href="/consultant/index"><?= Yii::t('gtuhome', 'View all') ?></a>
    
<!--<div class="col-sm-3 col-xs-6">
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
<div class="consultants-block"> <img class="con_12120" src="<?= $src;?>" alt=""/>
<div class="name">
<a href="?r=consultant/view&id=<?= $con->consultant_id; ?>" ><?= $con->first_name. ' '.$con->last_name; ?></a>
</div>
</div> 
</div>-->
  </div>
</div>

