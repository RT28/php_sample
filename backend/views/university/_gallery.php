<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url; 
use yii\helpers\Json;

use common\components\ConnectionSettings;
use common\models\UniversityGallery;
 


$uid = $model->id;
$path= ConnectionSettings::BASE_URL.'backend';
$backend= ConnectionSettings::BASE_URL.'backend';
$logoPath = '';  
$coverPhotoPath = '';

$UGallery = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 	 
				['=', 'status',  '1' ],
				['=', 'active',  '1' ]
				])->all();
   
$gallery = [];	
	  

if($UGallery){
	foreach($UGallery as $file) {		
		if($file->photo_type=='cover_photo'){ 
		 $coverPhoto = $file->filename; 
		}
	} 

	foreach($UGallery as $file) {		
		if($file->photo_type=='logo'){ 
			$logo = $file->filename; 
		}
	}
  
}

    $initialPreview = [];
    $intialLogoPreview = [];
    $initialGalleryPreview = [];
    $galleryPreviewConfig = [];
    if (is_dir("./../web/uploads/$model->id/cover_photo")) {  
		if(!empty($coverPhoto)){
			$coverPhotoPath = "./../web/uploads/$model->id/cover_photo/".$coverPhoto;
			
            $initialPreview = [Html::img($coverPhotoPath, ['title' => $model->name, 'class' => 'cover-photo'])];
		}
    }

    if (is_dir("./../web/uploads/$model->id/logo")) {
		if(!empty($logo)){
         $logoPath = "./../web/uploads/$model->id/logo/".$logo;
		$intialLogoPreview = [Html::img($logoPath, ['title' => $model->name, 'class' => 'cover-photo'])];
		}
    }

    if (is_dir("./../web/uploads/$model->id/photos")) {
        $gallery_path = FileHelper::findFiles("./../web/uploads/$model->id/photos", [
            'caseSensitive' => true,
            'recursive' => false,
        ]);       
    
        if (count($gallery_path) > 0) {
            foreach($gallery_path as $path) {
                array_push($initialGalleryPreview, Html::img($path, ['class' => 'photo-thumbnail']));
                array_push($galleryPreviewConfig, [
                    'caption' => basename($path),
                    'url' => Url::to(['/university/delete-photo']),
                    'key'=> basename($path)
                ]);
            }
        }
    }
	
	
?>
<div class="row">
    <div class="col-xs-6 col-sm-6">
	<div id="deleteCoverPhotoImage">
        <?= $form->field($upload, 'imageFile')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => true,
					'showRemove' => false,
                    'intialPreviewAsData' => false,
                    'resizeImages' => true,
                    'minImageWidth' => 1350,
                    'initialPreview' => $initialPreview,
                    'minImageHeight' => 650,
                ]
            ]); 
        ?>
		 </div>
		<?php
if (!empty($coverPhoto)) {
 $deleteCoverPhotoUrl = $backend."/web/index.php?r=university/delete-coverphoto&university_id=".$model->id."&key=".$coverPhoto;	?>
<a class="btn btn-danger" onclick="deleteCoverPhoto('<?php echo $deleteCoverPhotoUrl; ?>');">Remove Cover Photo</a>

<?php }	 ?>

    </div>
    <div class="col-xs-6 col-sm-3">
	<div id="deleteLogoImage">
        <?= $form->field($upload, 'logoFile')->widget(FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'showUpload' => false,
                    'showPreview' => true,
					'showRemove' => false,
                    'intialPreviewAsData' => true,
                    'resizeImages' => true,
                    'minImageWidth' => 100,
                    'initialPreview' => $intialLogoPreview,
                    'minImageHeight' => 100,
                ]
            ]);?>
		</div>	
<?php
if (!empty($logo)) {
 $deleteLogoUrl = $backend."/web/index.php?r=university/delete-logo&university_id=".$model->id."&key=".$logo;	?>
<a class="btn btn-danger" onclick="deleteLogo('<?php echo $deleteLogoUrl; ?>');">Remove Logo</a>

<?php }	 ?>

    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Gallery</div>
            <div class="panel-body" id="gallery">
                <?= $form->field($upload, 'universityPhotos[]')->widget(FileInput::classname(), [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'deleteUrl' => Url::to(['/university/delete-photo']),
                            'showUpload' => false,
                            'showPreview' => true,
							'showRemove' => false,
                            'intialPreviewAsData' => true,
                            'resizeImages' => true,
                            'initialPreviewConfig' => $galleryPreviewConfig,
                            'initialPreview' => $initialGalleryPreview,
                            'deleteExtraData' => [
                                'university_id' => $model->id,  
                            ],
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
	
<button type="button" class="btn btn-blue" data-toggle="modal" data-target="#update_videos">
Update
</button>
<table class="table table-bordered" id="video-form">
<tr>
<th>URL</th> 
</tr>
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


<div class="modal fade" id="update_videos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog rankings-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Rankings</h4>
      </div>
      <div class="modal-body">
            
             <table class="table table-bordered" id="university-video-form">
                <tbody>
                    <tr>
                        <th>URL</th> 
                        <th></th>
                    </tr>
                    <?php
                        $i = 0;
                    ?>
					
					<?php
 
 foreach ($rankings as  $rank): 
 
 ?>
 
<?php if(isset($rank['url'])){  echo $rank['url'];
 }
else{ 
if (is_JSON($rank)) { 
	$jrankings = Json::decode($rank); 
	foreach ($jrankings as  $jrank){ ?>
<tr data-index="<?= $i; ?>">
<td><input id="url-<?= $i; ?>" class="form-control" value="<?php echo $jrank['url'];?>"/></td>
<td><button data-index="<?= $i++; ?>" class="btn btn-danger" onclick="onDeleteVideoButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td> 
</tr>
<?php
	}
} else {
   // $error = json_last_error_msg(); ?>
<tr data-index="<?= $i; ?>">
<td><input id="url-<?= $i; ?>" class="form-control" value="<?php echo $rank;?>"/></td> 
 <td><button data-index="<?= $i++; ?>" class="btn btn-danger" onclick="onDeleteVideoButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td> 
</tr>
	<?php 
}
 } ?>
 
 
<?php  
endforeach; ?>
 
                </tbody>
            </table>
			  <button type="button" class="btn btn-success" onclick="onAddVideoButtonClick(this)"><span class="glyphicon glyphicon-plus"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="video-modal-close">Close</button>
        <button type="button" class="btn btn-blue" onclick="onSaveVideoChangesClick(this)">Save changes</button>
      </div>
    </div>
  </div>
</div>