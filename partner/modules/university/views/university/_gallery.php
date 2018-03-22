<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use common\components\ConnectionSettings;
use common\models\UniversityGallery;

?>

<?php
	//$path = Yii::getAlias('@backend');
	$path= ConnectionSettings::BASE_URL.'backend';
	if( Yii::$app->user->identity->partner_id){
		$uid =  Yii::$app->user->identity->partner_id; 
	}else{
		$uid =$model->id;
	}
	if(!empty($model->id)){
		$LogoPath = $path."/web/uploads/$uid/logo";
		$coverPhotoPath = $path."/web/uploads/$uid/cover_photo";
		$galleryPath = $path."/web/uploads/$uid/photos";
		$galleryPath = str_replace('\\','/',$galleryPath);
	}
	
 


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

    $initialPreview = [];
    $intialLogoPreview = [];
    $initialGalleryPreview = [];
    $galleryPreviewConfig = [];
    if (is_dir("./../../backend/web/uploads/$uid/cover_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../../backend/web/uploads/$uid/cover_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            //'only' => ['cover.*']
        ]);       
    
        if (count($cover_photo_path) > 0) {
            $initialPreview = [Html::img($cover_photo_path[0], ['title' => $model->name, 'class' => 'cover-photo'])];
        }
    }
	

    if (is_dir("./../../backend/web/uploads/$uid/logo")) {
        $logo_path = FileHelper::findFiles("./../../backend/web/uploads/$uid/logo", [
            'caseSensitive' => true,
            'recursive' => false,
            //'only' => ['logo.*']
        ]);       
    
        if (count($logo_path) > 0) {
            $intialLogoPreview = [Html::img($logo_path[0], ['title' => $model->name, 'class' => 'cover-photo'])];
        }
    }

    if (is_dir("./../../backend/web/uploads/$uid/photos")) {
        $gallery_path = FileHelper::findFiles("./../../backend/web/uploads/$uid/photos", [
            'caseSensitive' => true,
            'recursive' => false,
        ]);       
    
        if (count($gallery_path) > 0) {
            foreach($gallery_path as $path) {
                array_push($initialGalleryPreview, Html::img($path, ['class' => 'photo-thumbnail']));
                array_push($galleryPreviewConfig, [
                    'caption' => basename($path),
                    'url' => Url::to(['/university/university/delete-photo']),
                    'key'=> basename($path)
                ]);
            }
        }
    }
?>
<div class="row">
    <div class="col-xs-6 col-sm-6">
        <?= $form->field($upload, 'imageFile')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => true,
                    'intialPreviewAsData' => true,
                    'resizeImages' => true,
                    'minImageWidth' => 1350,
                    'initialPreview' => $initialPreview,
                    'minImageHeight' => 650,
                ]
            ]); 
        ?>
    </div>
    <div class="col-xs-6 col-sm-3">
        <?= $form->field($upload, 'logoFile')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => true,
                    'intialPreviewAsData' => true,
                    'resizeImages' => true,
                    'minImageWidth' => 100,
                    'initialPreview' => $intialLogoPreview,
                    'minImageHeight' => 100,
					'checkExtensionByMimeType'=>false
                ]
            ]); 
        ?>
    </div>
</div>
<div class="row">
<div class="col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">Gallery</div>
<div class="panel-body" id="gallery">
<!--<div class="row">
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
					<div class="left col-sm-3">
						<a href="<?= $filename?>" >
							<div class="gallery-block"><img src="<?= $filename?>" alt="<?= $model->name?> gallery"/></div>
						</a>
					</div>
				<?php }else if($i==4){ ?>
					<div class="left" style="float:right;">
						<a href="<?= $filename ?>">More...</a>
					</div> 
				<?php }else{ ?>
					<div class="left" style="display:none;">
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
		</div>-->

<?= $form->field($upload, 'universityPhotos[]')->widget(FileInput::classname(), [
		'options' => [
			'accept' => 'image/*',
			'multiple' => true
		], 
		'pluginOptions' => [
			'deleteUrl' => Url::to(['/university/university/delete-photo']),
			'showUpload' => false,
			'showPreview' => true,
			'intialPreviewAsData' => true,
			'resizeImages' => true,
			'minImageWidth' => 1350, 
			'minImageHeight' => 650,
			'initialPreviewConfig' => $galleryPreviewConfig,
			'initialPreview' => $initialGalleryPreview,
			'deleteExtraData' => [
				'university_id' => $uid
			],
			'checkExtensionByMimeType'=>false
		]
	]); 
?>
</div>
</div>
</div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Video and Virtual Tour</div>
            <div class="panel-body">
                <?= $form->field($model, 'virtual_tour')->textInput() ?>
                <?= $form->field($model, 'video')->textInput() ?>
            </div>
        </div>
    </div>
</div>
