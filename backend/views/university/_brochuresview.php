<?php
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\widgets\Pjax;
use common\components\ConnectionSettings;

$uid =  $model->id;
$path= ConnectionSettings::BASE_URL.'backend';

 
    $path = [];
    if (is_dir("./../../backend/web/uploads/$uid/documents")) {
        $path = FileHelper::findFiles("./../../backend/web/uploads/$uid/documents", [
            'caseSensitive' => false,
            'recursive' => false,
        ]);
    }

?>

<div class="panel-body">

 <?php  if(count($documentlist)>0){?>
<div class="col-sm-12 text-center "><a class="btn btn-blue pull-right" href="?r=university/download-all&id=<?php echo $uid ;?>"> Download All</a></div>

<?php
foreach($doclist as $key=> $value):
	?>
	<div class="row">
<div  ><h3><?php echo $value; ?></h3></div>
	<?php
foreach($documentlist as $getdocument):
$documentType=$getdocument->document_type;
if($documentType==$key){
$document_name=$getdocument->title;
$document_file=$getdocument->filename;
$id=$getdocument->id;
$ext = pathinfo($document_file, PATHINFO_EXTENSION); 	
$uid = $getdocument->university_id;?>

<div class="col-sm-12 col-md-3">
<div class="thumbnail"> 
   
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

 

<?php }
endforeach; ?>
</div>
<?php  endforeach; ?>
<?php }else{
	?>
There are not any document uploaded here.

<?php

}?>

</div>


<?php
    $this->registerJsFile('js/brouchres.js');
?>
