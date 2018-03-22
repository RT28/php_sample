<?php
	use yii\helpers\Html;
    use yii\helpers\FileHelper;
	use yii\widgets\Pjax;
    $this->title = 'My Documents';
    $this->context->layout = 'profile';
?>
<?php
    $model = Yii::$app->user->identity;
    $path = [];
    if (is_dir("../frontend/web/uploads/$model->id/documents")) {
        $path = FileHelper::findFiles("./../web/uploads/$model->id/documents", [
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
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <h2><?= $this->title; ?> <span style="float:right;"><button class="btn btn-blue btn-upload btn-add-document"><i class="fa fa-cloud-upload" aria-hidden="true"></i> upload</button></span></h2>
    <div class="row">
        <div class="col-sm-12">
            <div class="course-table">
                <div class="outer-container">
                    <div class="inner-container">
					
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
                          <div class="col-sm-6 col-md-4" style="min-height: 340px;">
                            <div class="thumbnail document-grid">
                            <div class="img-block">
							<?php //$fileName = pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION);?>
							
							<?php if($ext=="pdf"){ ?>
							 <img src="../frontend/web/images/pdficon.jpg" alt="document">
								 
							<?php }else if($ext=="docx" || $ext=="doc" ){ ?>
								<img src="../frontend/web/images/docxicon.jpg" alt="document">
							<?php } else { ?>
							<img src="download?name=<?= $document_file; ?>" alt="document">
							<?php } ?>
                             
							 </div>
                              <div class="caption">
                                <h3><?= $document_name; //pathinfo($file, PATHINFO_FILENAME); ?></h3>
                                <p><?= $document_name; ?></p>
                                <p><span class="label label-success">Uploaded</span></p>
                                <p><a href="download?name=<?= $document_file; ?>" class="btn btn-blue" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download</a>
								<!--<a href="?r=student-document/deletedocument&name=<?= $document_file; ?>&studocuid=<?php echo $student_document_id;?>" class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span> </a> -->
								
								<a data-toggle="modal" data-target="#deleteStudDocument<?php echo $student_document_id;?>" class="btn btn-danger">Delete</a>
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
                         <!-- <div class=" col-sm-6 col-md-4 text-center">
                          	<button class="btn btn-upload btn-add-document"><i class="fa fa-cloud-upload" aria-hidden="true"></i> upload</button>
                          </div>-->
                        </div>
						<?php  endforeach; ?>
						<?php if(count($stud_documentlist)>0){?>
                        <div class="text-center"><a class="btn btn-blue" href="/student-document/download-all"> Download All</a></div>
                    <?php } ?>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade bs-example-modal-lg" id="transcripts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transcripts</h4>
      </div>
	  <form method="post" enctype="multipart/form-data" id="docs">
      <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfParam ?>" />
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

<?php
    $this->registerJsFile('../frontend/web/js/student.js?ver=1.23');
?>
