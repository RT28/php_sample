<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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
                <?= FileInput::widget([
                    'name' => 'photos',
                    'options'=>[
                        'multiple'=>true
                    ],
                    'pluginOptions' => [
                        'uploadUrl' => Url::to(['/university/upload-photos']),
                        'deleteUrl' => Url::to(['/university/delete-photo']),
                        'intialPreviewAsData' => true,
                        'uploadExtraData' => [
                            'university_id' => $model->id
                        ],
                        'deleteExtraData' => [
                            'university_id' => $model->id
                        ],
                        'initialPreviewConfig' => $galleryPreviewConfig,
                        'initialPreview' => $initialGalleryPreview                       
                    ]
                ]);?>               
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
