<?php	
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\widgets\Pjax;
use yii\widgets\DetailView; 
use common\models\AccessList; 
?>
<?php  

    $id = $model->student_id;
    $path = [];
    if (is_dir("./../../frontend/web/uploads/$id/documents")) {
        $path = FileHelper::findFiles("./../../frontend/web/uploads/$id/documents", [
            'caseSensitive' => false,
            'recursive' => false,
        ]);
    }
?>

<style>
.customiedFrom button.btnSave, .btnSave {
    background-color: #ff6600;
    padding: 7px 20px;
    border: 0;
    text-transform: uppercase;
    color: #fff;
}
</style>
<div>
<div class="row">
<div class="col-sm-9">
<h3>Documents </h3>
</div>
<div class="col-sm-3 text-center">
  <?php 
$accessAuth = AccessList::accessActions('upload-documents');  
if($accessAuth ==true){   
	 ?>
<button class="btn btn-upload  btn-add-document btn-blue" style="min-height:0px;"><i class="fa fa-cloud-upload" aria-hidden="true"></i> upload</button>
	 <?php
} 
?>

</div>
</div>

<div class="inner-container">
					<?php if(count($stud_documentlist)>0){?>
					<?php foreach($documenttype as $getresult):
					 $documentType=$getresult->document_type_id;
					// echo $documentType;
					?>
					<div style="padding-left:8px;"><h3><?php echo $getresult->document_name;?></h3></div>
                    	<div class="row">
                        <?php 
						foreach($stud_documentlist as $getdocument):
						$document_type=$getdocument->document_type_id;
						if($documentType==$document_type){
							$document_name=$getdocument->document_name;
							$document_file=$getdocument->document_file;
							$student_document_id=$getdocument->student_document_id;
							
							//echo $fileName = pathinfo($document_file, PATHINFO_FILENAME) . '.' . pathinfo($document_file, PATHINFO_EXTENSION);
						$ext = pathinfo($document_file, PATHINFO_EXTENSION);
//

						?>
                          <div class="col-sm-6 col-md-4" style="min-height: 100px;">
                            <div class="thumbnail">
						 
                             
							 
                              <div class="caption"> 
                                <p><?= $document_name; ?></p>
                                <p><?= $document_file; ?></p>
                                <p>
								<a href="?r=consultant/students/download&name=<?= $getdocument->document_file; ?>&id=<?= $getdocument->student_id; ?>" class="btn btn-primary"><i class="fa fa-cloud-download" aria-hidden="true"></i>Download</a>
								 
								 
								
								<a data-toggle="modal" data-target="#deleteStudDocument<?php echo $student_document_id;?>" class="btn btn-danger btn-lg">Delete</a>
								</p>
                              </div>
                            </div>
                          </div>
						  
						  <!-- Start alert-->
						  
						<div class="modal fade" id="deleteStudDocument<?php echo $student_document_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm deleteSensoreModel" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Confirm</h4>
                                </div>
                                <div class="modal-body">
                                    Are you sure want to delete?
                                </div>
                                <div class="modal-footer">
               <button type="button" class="btn btn-info btn-sm" data-dismiss="modal" onclick="deleteStudentDocument('<?php echo$document_file; ?>','<?php echo $student_document_id;?>')">Yes</button>
                    <button type="button" class="btn btn btn-sm" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
						  <!--End Alert -->
						  
						  
						<?php } endforeach; ?>
                       
                        </div>
					<?php  endforeach; 
					}
					?>
<?php if(count($stud_documentlist)>0){?>
						
						 <?php 
$accessAuth = AccessList::accessActions('download-all');  
if($accessAuth ==true){   
	 ?>
 <a href="?r=consultant/students/download-all&id=<?= $model->student_id; ?>" class="btn btn-success"/>Download All</a>
	 <?php
} 
?>

   
<?php }else{?>
<h3> Student hasn't uploaded any document yet.</h3>
<?php
	
} ?>
					</div>
    
    

</div>



<?php
    $this->registerJsFile('js/student.js');
?>

<!-- Modal -->
<div class="modal fade" id="transcripts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transcripts</h4>
      </div>
	  <form method="post" action="?r=consultant/students/upload-documents" enctype="multipart/form-data" id="docs">
      <div class="modal-body">
	  <div style="color:red" id="message_display"></div>
            
                <input type="hidden" name="student_id" value="<?= $model->id ?>" />
				<input type="hidden" id="currentrowid" value="101" />
                <table class="table table-bordered" id="documents-form">
                    <tbody>
                        <tr>
                            <th>Document Type</th>
							<th>Name</th>
                            <th>Document</th>
                        </tr>
						
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddDocumentClick('documents-form')"><span class="glyphicon glyphicon-plus"></button>
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal" id="modal-close">Close</button>
        <button type="submit" class="btn btn-primary" onclick="onUploadClick(this)">Upload</button>
      </div>
	   </form>
	  
    </div>
  </div>
</div>

