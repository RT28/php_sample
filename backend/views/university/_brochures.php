<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use common\components\ConnectionSettings;
use common\models\UniversityBrochures;

?>

<?php
	//$path = Yii::getAlias('@backend');
	$path= ConnectionSettings::BASE_URL.'backend';
 
		$uid =$model->id;
	 
	 
   
    if (is_dir("./../../backend/web/uploads/$uid/documents")) {
        $path = FileHelper::findFiles("./../../backend/web/uploads/$uid/documents", [
            'caseSensitive' => false,
            'recursive' => false,
        ]);
    }
	

?>
<div class="row">
<div class="col-xs-12">
<div class="panel panel-default">
<div class="panel-heading">Upload Documents</div>

<div class="modal-body">
<div style="color:red" id="message_display"></div>
<input type="hidden" name="university_id" value="<?= $uid?>" />
<input type="hidden" id="currentrowid" value="0" />
<input type="hidden" id="currentrowid" value="0" />
<table class="table table-bordered" id="documents-form">
	<tbody>
		<tr>
			<th>Document Type</th>
			<th>Name</th>
			<th>Document</th>
		</tr>
 
	</tbody>


</table>
<button type="button" class="btn btn-blue" onclick="onAddDocumentClick('documents-form')">
<span class="glyphicon glyphicon-plus"></button>
</div>
</div>
</div>
</div>


<div class="panel-body" id="doclist">

 <?php  if(count($documentlist)>0){?>
<div class="col-sm-12 text-center "><a class="btn btn-blue pull-right" href="?r=university/download-all&id=<?php echo $uid ;?>"> Download All</a></div>

<?php
foreach($doclist as $key=> $value):
	?>
	<div class="row">
<div  ><h3><?php echo $value; ?></h3></div>
	<?php
 
foreach($documentlist as $getdocument):
if(isset($getdocument)){
$documentType=$getdocument->document_type;
if($documentType==$key){
$document_name=$getdocument->title;
$document_file=$getdocument->filename;
$id=$getdocument->id;
$ext = pathinfo($document_file, PATHINFO_EXTENSION); 	?>

<div class="col-sm-12 col-md-3">
<div class="thumbnail" id="thumbnail<?php echo $id;?>">
  <a data-toggle="modal" data-target="#deleteStudDocument<?php echo $id;?>" class="delete-doc"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i> </a>
<?php
if($ext=="pdf"){ ?>
<img src="http://gotouniversity.com/frontend/web/images/pdf.png" alt="document" height="150">

<?php }else if($ext=="docx" || $ext=="doc" ){ ?>
<img src="http://gotouniversity.com/frontend/web/images/docx.png" alt="document" height="150">
<?php } else { ?>
<img src="?r=university/download&id=<?php echo $getdocument->university_id;?>&name=<?= $document_file; ?>" alt="document" height="150">
<?php } ?>
<div class="caption">
<p><?= $document_name; ?> <a href="?r=university/download&id=<?php echo $getdocument->university_id;?>&name=<?= $document_file; ?>" role="button">
  <i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i> </a></p>
</div>
</div>
</div>

<div class="modal fade" id="deleteStudDocument<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog modal-sm deleteSensoreModel" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Confirm</h4>
</div>
<div class="modal-body">Are you sure want to delete?</div>
<div class="modal-footer">
<button type="button" class="btn btn-info btn-sm" data-dismiss="modal" onclick="deleteDocument('<?php echo$document_file; ?>','<?php echo $id;?>')">Yes</button>
<button type="button" class="btn btn btn-sm" data-dismiss="modal">Cancel</button>
</div>
</div>
</div>
</div>

<?php }
}
endforeach; ?>
</div>
<?php  endforeach; ?>
<?php }else{
	?>
None Available.

<?php

}?>

</div>

<?php
    $this->registerJsFile('js/brouchres.js');
?>
