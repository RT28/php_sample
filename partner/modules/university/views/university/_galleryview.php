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
?>

<?php
$uid = Yii::$app->user->identity->partner_id;
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
<div class="row">
	<?php
	$i = 0;
	$len = sizeof($logos);
?>
<?php for($i = 0; $i < $len; $i++): ?>
	<?php
		$photo = $logos[$i];
		$filename = $LogoPath.$photo->filename;
	?>
		<div class=" col-sm-3">
				<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>
		</div>
	<?php   ?>
<?php endfor; ?>
</div>
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
<?php if(isset($coverPhotos)): ?>
<div class="row">
	<div class="col-sm-3">
	 <?php
	$i = 0;
	$len = sizeof($coverPhotos);
?>
<?php for($i = 0; $i < $len; $i++): ?>
	<?php
		$photo = $coverPhotos[$i];
		$filename = $coverPhotoPath.$photo->filename;
	?>
				<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>


	<?php   ?>
<?php endfor; ?>
</div>
</div>
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

                                if($i<4){
                                ?>
                                    <div class=" col-sm-3">
                                        <a href="<?= $filename?>" >
                                            <div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>
                                        </a>
                                    </div>
                                <?php }else if($i==4){ ?>
                                    <div class="" style="float:right;">
                                        <a href="<?= $filename ?>">More...</a>
                                    </div>
                                <?php }else{ ?>
                                    <div class="" style="display:none;">
                                        <a href="<?= $filename ?>" >
                                            <div class="gallery-block"><img src="<?= $filename ?>" alt="<?= $model->name?> gallery"/></div>
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
				</div>  </div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Video</div>
            <div class="panel-body">
<?php if(!empty($model->video)): ?>
<div class="row">
	<div class="col-sm-6">
<div class="video-block">
<iframe width="100%" height="400px" src="<?= $model->video ?>" frameborder="0" allowfullscreen></iframe>
</div>
</div>
</div>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Virtual Tour</div>
            <div class="panel-body">
<?php if(!empty($model->virtual_tour)): ?>
<div class="row">
    <div class="col-sm-12">
	<iframe id="map_canvas1" width="100%" height="500px" src="<?= $model->virtual_tour ?>" frameborder="0" allowfullscreen></iframe>
</div>
</div>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
