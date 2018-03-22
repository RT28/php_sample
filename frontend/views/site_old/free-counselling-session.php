<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->context->layout = 'index';
use common\models\FreeCounsellingSessions;
use common\models\Consultant;
use common\components\Status;
use kartik\date\DatePicker;
use common\components\Commondata;
use common\models\Degree;   

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Free Counselling session';
 
$days = Commondata::getDay();
$degrees = '';

?>


<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <!-- PROGRESS BARS-->
			  <div class="row">
<div class="col-sm-6">
			<h1>Book your free session </h1>
			</div>
			</div>
			
<?php if(empty($model)): ?>
    <div class="student-create container">
        <?php foreach($consultants as $consultant): 
		$consultantName =  Commondata::getTitleName($consultant->title). ' '.$consultant->first_name.' '.$consultant->last_name;

 
 

?>
		<?php
			$src = './../../partner/web/noprofile.gif';

			if(is_dir('./../../partner/web/uploads/consultant/' . $consultant->consultant_id . '/profile_photo')) {
			$cover_photo_path = "./../../partner/web/uploads/consultant/".$consultant->consultant_id."/profile_photo/logo_170X115";
			if(glob($cover_photo_path.'.jpg')){
			$src = $cover_photo_path.'.jpg';
			} else if(glob($cover_photo_path.'.png')){
			$src = $cover_photo_path.'.png';
			} else if(glob($cover_photo_path.'.gif')){
			$src = $cover_photo_path.'.gif';
			} 
			} 
			?>
               
			   
            <ul class="list-group">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?=$src; ?>" alt="<?= $consultantName; ?>" />
                        </div>
                        <div class="col-sm-10">
						<button class="btn btn-blue counselling-required" type="button" data-consultant="<?= $consultant->consultant_id; ?>">Book</button>
             
						<div class="row">
<div class="col-sm-12"> 
   <h4> <?php echo $consultantName;?></h4>
<div class="row">
<div class="col-sm-6" >  
<p><strong>Address :</strong> <?php if($consultant->address) { echo $consultant->address;  } ?></p>
<p><strong>Pincode :</strong> <?php if($consultant->pincode) { echo $consultant->pincode;  } ?></p>
<p><strong>City  :</strong> <?php //if($consultant->city->name) { echo $consultant->city->name;  } ?></p>
<p><strong>State :</strong> <?php //if($consultant->state->name) { echo $consultant->state->name;  } ?></p>
<p><strong>Country  :</strong> <?php if($consultant->country->name) { echo $consultant->country->name;  } ?></p>
<p><strong>Phone Number :</strong> +<?php if($consultant->mobile) { echo $consultant->code;?>-<?= $consultant->mobile; } ?></p>
<p><strong>Status :</strong> <?php if($consultant->consultant->status) { echo Status::getStatusName($consultant->consultant->status); } ?></p>
<p><strong>Description : </strong> <?php if($consultant->description) { echo $consultant->description;  } ?></p>
</div>
<div class="col-sm-6" > 
<p><strong>Speciality :</strong> <ul class="detail-list">
<?php
$degrees = '';
if($consultant->speciality){
	  $temp = $consultant->speciality;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
$arr = Degree::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $degree) {
            $degrees[]= $degree['name'];
        }
	$degrees = implode(',', $degrees);
}
$skills = explode(',', $degrees);
?>
<?php foreach($skills as $skill): ?>
<li><?= $skill; ?></li>
<?php endforeach; ?>
</ul> 

 
 
</p>
<p><strong>Experience :</strong> <?php echo $consultant->experience_years.' Years '.$consultant->experience_months.' Months';?></p>
<p><strong>Working Hours :</strong> <?php echo $consultant->work_hours_start.' to '.$consultant->work_hours_end;?></p>
<p><strong>Working Days :</strong> 
<?php 
$i=0;
$getdays = array();
if(isset($consultant->work_days)){ 
	   $arr = explode(',', $consultant->work_days);
     
	foreach($arr as $key) { 
		if (array_key_exists ($key, $days)) {
			$getdays[] = $days[$key];
		} 
	} 
	$getdays = implode(', ', $getdays);
	if(isset($getdays)) { echo $getdays;  }
}
 
 ?></p>
</div> 			
</div> 
</div>
</div>
                         
                                           </div>
                    </div>
                </li>
            </ul>
        <?php endforeach;?>
    </div>

<?php elseif($model->status == Status::STATUS_INACTIVE): ?>
    <div class="alert alert-success">Congratulations, you are enrolled for a free counselling session. Our counsellors will soon get in touch with you!</div>    

<?php elseif($model->status == Status::STATUS_COMPLETE): ?>
    <div class="alert alert-info">You have already used your free session!</div>    
<?php endif; ?>
</div>
</div>
</div>


<div class="modal fade" id="consellor-modal" tabindex="-1" role="dialog" aria-labelledby="choose-counsellor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="choose-counsellor">Choose date and time</h4>
      </div>
      <div class="modal-body" style="min-height: 300px;">
        <?php 
            $consultants = Consultant::find()->orderBy(['first_name' => 'ASC'],['last_name' => 'ASC'])->all();
        ?>
        <form>
            <div class="form-group">
                <label for="skype-id">Skype id</label>
                <input name="skype-id" id="skype-id" value="" class="form-control"/>
                <input type="hidden" name="consultant-id" id="consultant-id" value="" class="form-control"/>
            </div>
            <div class="form-group">
                <label class="control-label">Date<span style="color:red;">*</span></label>
                <?= DatePicker::widget([
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => [
                        'id' => 'counsellor-date'
                    ],
                    'value' => date('d-M-Y'),
                    'name' => 'counsellor_date',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-M-yyyy'
                    ],
                    'pluginEvents' => [
                        'changeDate' => 'onCounsellorChange'
                    ]
                ]);?>
            </div>
            <div class="form-group" id="counsellor-time-slots" style="display:none;">
                <label for="counsellor-time">Select time</label>
                <p id="counsellor-time">
                    Loading Please wait...
                </p>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-grey" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-blue btn-book">Book</button>
      </div>
    </div>
  </div>
</div>