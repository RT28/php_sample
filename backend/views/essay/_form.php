<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Status;

use yii\helpers\FileHelper;
use kartik\file\FileInput; 
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Essay */
/* @var $form yii\widgets\ActiveForm */

$status = Status::getStatus();
$model->documentupload= 0;
?>
<?php
    $path = []; 
    if (is_dir("../web/uploads/essays/$model->id/")) {
		
        $path = FileHelper::findFiles("../web/uploads/essays/$model->id/", [
            'caseSensitive' => false,
            'recursive' => false, 
        ]);       
     
    }

   
 
?>
<div class="essay-form">

    <?php $form = ActiveForm::begin(['id'=>'EssayForm', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'documentupload')->radioList( [0 => 'Write Description',
	1 => 'Upload Document'],['onchange' => 'menuTypeChange(this);'])->label('Choose Option');?>
	 
	
	
    <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Copy/Paste or Write Essay'); ?>
 
 <div id="uploadessaydoc" style="display:none;">
 <?= $form->field($upload, 'uploadessay')->widget(FileInput::classname(), [
                   'options' => ['multiple' => true,'id' => 'uploadessay'],
                    'pluginOptions' => [
                        'showUpload' => false,
                        'showPreview' => true, 
                    ] 
            ]); 
        ?>
		</div>
	<div class="row">
<?php foreach($path as $file): ?>
<div class="col-sm-6 col-md-4">
<div class="thumbnail"><?php
					$fileName = pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION);
				 ?> 
  <div class="caption">
	<h3><?= $fileName; ?></h3> 
	<p><span class="label label-success">Uploaded</span></p>
	<p><a href="?r=essay/download&name=<?= $fileName; ?>&id=<?= $model->id; ?>" class="btn btn-primary" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download</a></p>
  </div>
</div>
</div>
<?php endforeach; ?>
</div>
	  <?= $form->field($model, "status")->dropDownList($status) ?> 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script language="javascript">
function menuTypeChange(radioButtonList){
var rates = document.getElementsByName('Essay[documentupload]');
var rate_value;
for(var i = 0; i < rates.length; i++){
    if(rates[i].checked){
        rate_value = rates[i].value;		
    }
}
if(rate_value==0){
	document.getElementById("uploadessaydoc").style = "display:none";
	document.getElementById("essay-description").disabled = false;
}
if(rate_value==1){
	document.getElementById("uploadessaydoc").style = "display:block";
	document.getElementById("essay-description").disabled = true;
}
}
  </script>