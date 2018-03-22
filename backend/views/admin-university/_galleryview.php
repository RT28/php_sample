<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
?>

<?php
    $initialPreview = [];
    $intialLogoPreview = [];
    $initialGalleryPreview = [];
    $galleryPreviewConfig = [];
    if (is_dir("./../web/uploads/$model->id/cover_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../web/uploads/$model->id/cover_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['cover.*']
        ]);       
    
        if (count($cover_photo_path) > 0) {
            $initialPreview = [Html::img($cover_photo_path[0], ['title' => $model->name, 'class' => 'cover-photo'])];
        }
    }

    if (is_dir("./../web/uploads/$model->id/logo")) {
        $logo_path = FileHelper::findFiles("./../web/uploads/$model->id/logo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['logo.*']
        ]);       
    
        if (count($logo_path) > 0) {
            $intialLogoPreview = [Html::img($logo_path[0], ['title' => $model->name, 'class' => 'cover-photo'])];
        }
    }

  
?>
   <?php        
        $rankings = Json::decode($model->institution_ranking);
        $i = 0;       
    ?>    
 

<div class="row">
    <div class="col-xs-12 col-sm-12">
       <?php    
        if(is_dir("./../web/uploads/$model->id/cover_photo")) {
            $cover_photo_path = FileHelper::findFiles("./../web/uploads/$model->id/cover_photo", [
                'caseSensitive' => true,
                'recursive' => false,
                'only' => ['cover.*']
            ]);       
            
            if (count($cover_photo_path) > 0) {
                echo Html::img($cover_photo_path[0], ['alt' => $model->name , 'class' => 'cover-photo']);
            }
        }
        
        if(is_dir("./../web/uploads/$model->id/logo")) {
            $logo_path = FileHelper::findFiles("./../web/uploads/$model->id/logo", [
                'caseSensitive' => true,
                'recursive' => false,
                'only' => ['logo.*']
            ]);       
            
            if (count($logo_path) > 0) {
                echo Html::img($logo_path[0], ['alt' => $model->name , 'class' => 'cover-photo']);
            }
        }        
    ?>

   
    </div>
    <div class="col-xs-6 col-sm-3">
     
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Gallery</div>
            <div class="panel-body" id="gallery">

             <?php
                       if (is_dir("./../web/uploads/$model->id/photos")) {
                $gallery_path = FileHelper::findFiles("./../web/uploads/$model->id/photos", [
                    'caseSensitive' => true,
                    'recursive' => false,
                ]);       
            
                if (count($gallery_path) > 0) {

                    foreach($gallery_path as $path) {
                      echo Html::img($path, ['alt' => $model->name ,'class' => 'photo-thumbnail']);
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
                <?= $form->field($model, 'video')->textInput(['readonly'=>true]) ?>                
            </div>
        </div>
    </div>
</div>
