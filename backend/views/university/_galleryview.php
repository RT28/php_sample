<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;

use common\components\ConnectionSettings;
use common\models\UniversityGallery;

 $this->registerCssFile('css/blueimp-gallery.css');
$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
$this->registerJsFile('js/blueimp-gallery.js');
   
  
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
 
$coverPhotos = [];	
$logos = []; 
$gallery = [];	
	 
	
if($UGallery){
	foreach($UGallery as $file) {		
		if($file->photo_type=='cover_photo'){ 
			array_push($coverPhotos, $file);
		}
	} 

	foreach($UGallery as $file) {		
		if($file->photo_type=='logo'){ 
			array_push($logos, $file);
		}
	}
 
	foreach($UGallery as $file) {		
		if($file->photo_type=='photos'){ 
			array_push($gallery, $file);
		}
	}
}		 		
  
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Logo</div>
            <div class="panel-body"> 
<?php if(isset($logos)): ?>	
 
	<?php 
	$len = sizeof($logos); 
?>
<?php for($i = 0; $i < $len; $i++): ?>
	<?php
		$photo = $logos[$i]; 
		$filename = $LogoPath.$photo->filename;  
	?>
	 <img src="<?= $filename?>" alt="<?= $model->name?>"/> 
		 
	<?php   ?>
<?php endfor; ?>
 
<?php endif; ?>				
            </div>
        </div>
    </div>
</div>
 
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Cover Photos</div>
            <div class="panel-body">
<?php if(isset($coverPhotos)):  
	$len = sizeof($coverPhotos); 
?>
<?php for($i = 0; $i < $len; $i++): ?>
	<?php
		$photo = $coverPhotos[$i]; 
		$filename = $coverPhotoPath.$photo->filename;  
	?>  
	 
 <img src="<?= $filename?>" alt="<?= $model->name?> gallery" class=" col-sm-12"/>
 
	<?php   ?>
<?php endfor; ?> 
<?php endif; ?>	             
            </div>
        </div>
    </div>
</div>

     
 
<div class="row">
<div class="col-xs-12 gallery" >
<div class="panel panel-default">
<div class="panel-heading">Photo Gallery</div>
<div class="panel-body">
<div class="row">
<div id="imglinks">
<?php
$i = 0;   
$len = sizeof($gallery);
//$len = ($len < 4) ? $len : 4;
?>
<?php for($i = 0; $i < $len; $i++): ?>
<?php
	$photo = $gallery[$i];	
	$filename = $galleryPath.$photo->filename;	 
 
?>
	<div class=" col-sm-3">
		<a href="<?= $filename?>" >
			<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery" class="col-sm-12"/></div>
		</a>
	</div>
<?php    ?>
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
</div>  
</div>    
 
 
 
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Video and Virtual Tour</div>
            <div class="panel-body">                
                <?= $form->field($model, 'virtual_tour')->textInput(['readonly'=>true]) ?>                
               <table class="table table-bordered" id="video-form">
<tr>
<th>URL</th> 
</tr>
<?= Html::hiddenInput('university-videos', $model->video, ['id' => 'university-videos']); 
	
	function is_JSON(...$args) {
    json_decode(...$args);
    return (json_last_error()===JSON_ERROR_NONE);
}

	$rankings = [];
	if(!$model->isNewRecord){
		 
		if(!empty($model->video)){ 
		 $string = array('url'=>$model->video); 
		 $encodestring = Json::encode($string); 
		 $rankings = Json::decode($encodestring); 
		} 
	} 
	if(!is_array($rankings)){
		$rankings = [];
		}
	  
	
	 $i = 0;
	?>
<?php
 
 foreach ($rankings as  $rank): 
 
 ?>
 
<?php if(isset($rank['url'])){ echo $rank['url']; }
else{ 
if (is_JSON($rank)) { 
	$jrankings = Json::decode($rank); 
	foreach ($jrankings as  $jrank){ ?>
	<tr data-index="<?= $i++; ?>">
<td><?php echo $jrank['url'];?></td> 
</tr>
<?php
	}
} else {
   // $error = json_last_error_msg(); ?>
<tr data-index="<?= $i++; ?>">
<td><?php echo $rank;?></td> 
</tr>
	<?php 
}
 } ?>
 
 
<?php  
endforeach; ?>
</table>                
            </div>
        </div>
    </div>
</div>
