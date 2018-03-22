<?php
use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use common\components\ConnectionSettings;
use common\models\Consultant;
use frontend\models\EmailenquirySearch;
use common\models\Emailenquiry;
    $this->context->layout = 'profile';
    $this->title = 'Inbox';
    $path= ConnectionSettings::BASE_URL.'frontend/';

?>
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-inbox col-xs-12">
        	<div class="new-msg-search">
			<div class="row">
            	<div class="col-sm-4">
              <a href="#" data-toggle="modal" 
                data-target="#addInvoiceModal" onclick="loadEmailenquiryform('/emailenquiry/create');" >
                	<button class="btn btn-blue new-msg" ><i class="fa fa-paper-plane-o" aria-hidden="true"></i> New Message</button>
              </a>    
                </div>
            	<div class="col-sm-8">
                <form class="search-in-inbox">
                	<input type="text" id="search_mail" name="search_mail" class="form-control" placeholder="Search Messages or Name.." onchange="loadEmailenquirysearch('/emailenquiry/search');" />
                </form>
                </div>
            </div>
            </div>
            <div class="inbox-main-tabs">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active col-sm-4 pad-left-0"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
    <li role="presentation" class="col-sm-4 pad-0 text-center"><a href="#sent-message" aria-controls="sent-message" role="tab" data-toggle="tab" onclick="fnGetmail('/emailenquiry/sentitem','sent-message');">Sent Message</a></li>
    <li role="presentation"  class="col-sm-4 pad-right-0 text-right"><a href="#draft" aria-controls="draft" role="tab" data-toggle="tab" onclick="fnGetmail('/emailenquiry/draft','draft');">Draft</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="inbox">
    <div class="row manage-left-margin">
    <?php if(!empty($emailenquiries)){ ?>
     	<div class="col-sm-4 pad-left-0 pad-right-0 resent-email">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
              <?php $i = 0; $active = ''; foreach($emailenquiries as $emailenquiry) { if($i==0) {$active = 'active'; } else {$active = '';} ?>
                <li role="presentation" class="<?php echo $active; ?>"><a href="#inbox<?php echo $i; ?>" aria-controls="1" role="tab" data-toggle="tab">
                <div class="sender-name">
                    <?php 
                    $consultantProfile = Consultant::find()->where(['=', 'consultant_id', $emailenquiry['consultant_id']])->one();
                    echo  $consultantProfile->first_name." ".$consultantProfile->last_name;
                    ?>
                </div>
                <div class="sub-in-tab"><?php echo $emailenquiry['subject']; ?></div>
                <div class="mail-content-short"><?php echo substr($emailenquiry['consultant_message'],0,35); ?>
                <?php if(strlen($emailenquiry['consultant_message']) > 35){ echo '...'; } ?></div>
                
                <div class="date-time"><?php echo date("d-M h:i:a",strtotime($emailenquiry['created_at'])); ?></div>
                </a></li>
                <?php $i ++; } ?>
              </ul>
	   </div>
     <?php } else { ?>
     <div class="col-sm-4 pad-left-0 pad-right-0"><p> Inbox is Empty! </p></div>
     <?php } ?>
       <div class="col-sm-8 pad-tight-0">
          <!-- Tab panes -->
          <div class="tab-content">
          <?php $j = 0; $active = ''; foreach($emailenquiries as $emailenquiry) { if($j==0) {$active = 'active'; } else {$active = '';} ?>
            <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="inbox<?php echo $j; ?>">
            	<div class="subject-sender-details">
                    <div class="sender-detail">
                    	<div class="sender-image">
                            <?php
                            $profile_path = "./../../partner/web/uploads/consultant/".$emailenquiry['consultant_id']."/profile_photo/consultant_image_228X228";
                            if(glob($profile_path.'.jpg')){
                              $src = $profile_path.'.jpg';
                            } else if(glob($profile_path.'.png')){
                              $src = $profile_path.'.png';
                            } else if(glob($profile_path.'.gif')){
                              $src = $profile_path.'.gif';
                            } else if(glob($profile_path.'.jpeg')){
                              $src = $profile_path.'.jpeg';
                            } else if(glob($profile_path.'.JPG')){
                              $src = $profile_path.'.JPG';
                            } else if(glob($profile_path.'.PNG')){
                              $src = $profile_path.'.PNG';
                            } else if(glob($profile_path.'.GIF')){
                              $src = $profile_path.'.GIF';
                            } else if(glob($profile_path.'.JPEG')){
                              $src = $profile_path.'.JPEG';
                            }
                            else {
                                $src = './../../partner/web/noprofile.gif';
                            }
                            ?>
                        	<img src="<?php echo $src; ?>"/>
                        </div>
            			<div class="sender-name-msg">
                            <?php 
                            $consultantProfile = Consultant::find()->where(['=', 'consultant_id', $emailenquiry['consultant_id']])->one();
                            echo  $consultantProfile->first_name." ".$consultantProfile->last_name;
                            ?>         
                        </div>
                    </div>
            		<p class="msg-subject"><?php echo $emailenquiry['subject']; ?></p>
                </div>
                <div class="msg-text">
                	<p>
                      <?php if($emailenquiry['email_source'] == 1){ ?>
                      <div class="col-sm-14 text-left" style="width:100px;" >
                      <?php $recipients = '';
                      if($emailenquiry['is_to_student']==1) { $recipients.= "student";}
                      if($emailenquiry['is_to_father']==1) { $recipients.= ",father";}
                      if($emailenquiry['is_to_mother']==1) { $recipients.= ",mother";} ?>
                      <label>Mail Recipients</label>
                      <p><?= $recipients; ?></p>
                      </div>

                      <?php if(!empty($emailenquiry['consultant_message'])){ ?>
                      
                      <label>Message by consultant</label>
                      <p><?= $emailenquiry['consultant_message']; ?></p>
                      <?php } ?>

                      <?php if(!empty($emailenquiry['student_message'])){ ?>
                      <label>Message by Student</label>
                      <p><?= $emailenquiry['student_message']; ?></p>
                      <?php } ?>

                      <?php if(!empty($emailenquiry['father_message'])){ ?>
                      <label>Message by Student Father</label>
                      <p><?= $emailenquiry['father_message']; ?></p>
                      <?php } ?>

                      <?php if(!empty($emailenquiry['mother_message'])){ ?>
                      <label>Message by Student Mother</label>
                      <p><?= $emailenquiry['mother_message']; ?></p>
                      <?php } ?>

                      <?php } else { ?>
                      
                      <?php if(!empty($emailenquiry['student_message'])){ ?>
                      <label>Message by Student</label>
                      <p><?= $emailenquiry['student_message']; ?></p>
                      <?php } ?>

                      <?php if(!empty($emailenquiry['consultant_message'])){ ?>
                      <label>Message by consultant</label>
                      <p><?= $emailenquiry['consultant_message']; ?></p>
                      <?php } ?>

                      <?php } ?> 
                  </p>
                </div>
                <div class="pull-right">
                <?php if($emailenquiry['email_source'] == 1){ ?>
                <a href="#" class="btn btn-blue " data-toggle="modal" 
                    data-target="#invoiceUpdateModal" onclick="loadEmailenquiryupdate('<?= $emailenquiry['id'] ?>')" ><span class="glyphicon glyphicon-pencil"></span> Reply</a>
                <?php } ?>
                </div>    
            </div> 
          <?php $j ++; } ?>     
          </div>
        </div>
    </div>
    </div>



    <div role="tabpanel" class="tab-pane" id="sent-message"></div>
    <div role="tabpanel" class="tab-pane" id="draft"></div>
  </div>

</div>
        </div>
    </div>
</div>
</div>
</div>
    <div id="addInvoiceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" id="AddInvoicePreview" style="height:800px; overflow:scroll;">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
    </div>

    <div id="invoiceUpdateModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="invoiceUpdate" style="height:800px; overflow:scroll;">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
    </div> 

    <div id="myModal2" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="taskPreview" style="height:800px; overflow:scroll;">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
    </div>
<script type="text/javascript">
function fnGetmail(url,id) {
  $('#search_mail').val('');
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {
                $('#'+id).html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
  function loadEmailenquiryform(url) {
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadEmailenquirysearch(url) {
  var content = $('#search_mail').val();
    $.ajax({
            url: url,
            method: 'POST',
            data: {
                content: content
            },
            success: function( data) {
                $('.tab-pane').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadEmailenquiryupdate(id) {
    $.ajax({
             url: '/emailenquiry/update?id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#invoiceUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
</script>
<?php
    $this->registerJsFile('js/student.js');
?>