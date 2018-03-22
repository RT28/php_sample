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
    $activetab = Yii::$app->view->params['activeTab'];
?>
<div id="inbox">
    <div class="row manage-left-margin">
    <?php if(!empty($emailenquiries)){ ?>
     	      <div class="col-sm-4 pad-left-0 pad-right-0 resent-email">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
              <?php $i = 0; $active = ''; foreach($emailenquiries as $emailenquiry) { if($i==0) {$active = 'active'; } else {$active = '';} ?>
                <li role="presentation" class="<?php echo $active; ?>"><a href="#<?= $activetab.$i ?>" aria-controls="1" role="tab" data-toggle="tab">
                <div class="sender-name">
                    <?php 
                    $consultantProfile = Consultant::find()->where(['=', 'consultant_id', $emailenquiry['consultant_id']])->one();
                    echo  $consultantProfile->first_name." ".$consultantProfile->last_name;
                    ?>
                </div>
                <div class="sub-in-tab"><?php echo $emailenquiry['subject']; ?></div>
                <div class="mail-content-short"><?php echo substr($emailenquiry['student_message'],0,35); ?>
                <?php if(strlen($emailenquiry['student_message']) > 35){ echo '...'; } ?></div>
                <div class="date-time"><?php echo date("d-M h:i:a",strtotime($emailenquiry['created_at'])); ?></div>
                </a></li>
                <?php $i ++; } ?>
              </ul>
	   </div>
     <?php } else { ?>
     <div class="col-sm-4 pad-left-0 pad-right-0"><p> No emails available! </p></div>
     <?php } ?>
       <div class="col-sm-8 pad-tight-0">
          <!-- Tab panes -->
          <div class="tab-content">
          <?php $j = 0; $active = ''; foreach($emailenquiries as $emailenquiry) { if($j==0) {$active = 'active'; } else {$active = '';} ?>
            <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="<?= $activetab.$j; ?>">
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
                <div style="float: right;">
                <?php if($emailenquiry['email_source'] == 1){ ?>
                <a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
                    data-target="#invoiceUpdateModal" onclick="loadEmailenquiryupdate('<?= $emailenquiry['id'] ?>')" >Reply</a>
                <?php } ?>
                </div> 
            </div> 
          <?php $j ++; } ?>     
          </div>
        </div>
    </div>
    </div>