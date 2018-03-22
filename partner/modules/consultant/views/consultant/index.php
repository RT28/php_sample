<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\Commondata;  
use common\models\Country;
use common\models\Degree;
use common\models\DegreeLevel;
use common\models\StandardTests;
use yii\widgets\Pjax;   
$days = Commondata::getDay();

$this->title = $model->first_name; 
$this->context->layout = 'main';
	
	
$degrees = '';
if($model->speciality){
	  $temp = $model->speciality;
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

$degreelevel = '';
if($model->degree_level){
	  $dtemp = $model->degree_level;
        if (strpos($dtemp, ',')) {
            $darr = explode(',', $dtemp);
        } else {
            $darr[] = $dtemp;
        }
$darr = DegreeLevel::find()->select('name')
                              ->where(['in', 'id', $darr])
                              ->asArray()
                              ->all();
        
        foreach($darr as $dlevel) {
            $degreelevel[]= $dlevel['name'];
        }
	$degreelevel = implode(',', $degreelevel);
}

$country_level = '';
if($model->country_level){
	  $ctemp = $model->country_level;
        if (strpos($ctemp, ',')) {
            $carr = explode(',', $ctemp);
        } else {
            $carr[] = $ctemp;
        }
$carr = Country::find()->select('name')
                              ->where(['in', 'id', $carr])
                              ->asArray()
                              ->all();
        
        foreach($carr as $clevel) {
            $country_level[]= $clevel['name'];
        }
	$country_level = implode(',', $country_level);
}

$responsible = '';
if($model->responsible){
	  $rtemp = $model->responsible;
        if (strpos($rtemp, ',')) {
            $rarr = explode(',', $rtemp);
        } else {
            $rarr[] = $rtemp;
        }
$rarr = Country::find()->select('name')
                              ->where(['in', 'id', $rarr])
                              ->asArray()
                              ->all();
        
        foreach($rarr as $rlevel) {
            $responsible[]= $rlevel['name'];
        }
	$responsible = implode(',', $responsible);
}

$tests = '';
if($model->standard_test){
	  $stemp = $model->standard_test;
        if (strpos($stemp, ',')) {
            $tarr = explode(',', $stemp);
        } else {
            $tarr[] = $stemp;
        }
$tarr = StandardTests::find()->select('name')
                              ->where(['in', 'id', $tarr])
                              ->asArray()
                              ->all();
        
        foreach($tarr as $test) {
            $tests[]= $test['name'];
        }
	$tests = implode(',', $tests);
}

$getdays = array();
if(!empty($model->work_days)){
	  $temp = $model->work_days;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        } 
        
        foreach($arr as $day) {
            $getdays[]= $days[$day];
        }
	$getdays = implode(',', $getdays);
}
	
?>

<div class="consultant-index">
    <div class="row">
    
<div class="col-sm-12 mbot-20"> 
        <h1 class="profile-title"><?= Html::encode($this->title) ?> </h1>
          <a href="?r=consultant/consultant/update" class="btn btn-blue pull-right">Update</a>
             </div>
<div class="col-sm-12"> 
<div class="row">
<div class="col-sm-6" > 
<p><strong>Name :</strong> <?php echo Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;?></p> 
<p><strong>Gender :</strong> <?php echo Commondata::getGenderName($model->gender);?></p> 
<p><strong>Phone Number :</strong> +<?php if($model->mobile) { echo $model->code;?>-<?= $model->mobile; } ?></p>
<p><strong>Status :</strong> <?php if($model->consultant->status) { echo Status::getStatusName($model->consultant->status); } ?></p>
<p><strong>Address :</strong> <?php if($model->address) { echo $model->address;  } ?></p>
<p><strong>Zip Code :</strong> <?php if($model->pincode) { echo $model->pincode;  } ?></p>
<p><strong>City  :</strong> <?php if($model->city->name) { echo $model->city->name;  } ?></p>
<p><strong>State :</strong> <?php if($model->state->name) { echo $model->state->name;  } ?></p>
<p><strong>Country  :</strong> <?php if($model->country->name) { echo $model->country->name;  } ?></p>
<p><strong>Description : </strong> <?php if($model->description) { echo $model->description;  } ?></p>
</div>
<div class="col-sm-6" > 

<p><strong>College admission for :</strong> <?php if(isset($country_level)) {echo $country_level;  } ?></p>
<p><strong>Responsible for countries :</strong> <?php if(isset($responsible)) {echo $responsible;  } ?></p>
<p><strong>Degree Level :</strong> <?php if(isset($degreelevel)) {echo $degreelevel;  } ?></p>
<p><strong>Standard Tests :</strong> <?php if(isset($tests)) {echo $tests;  } ?></p>
<p><strong>Speciality :</strong> <?php if(isset($degrees)) {echo $degrees;  } ?></p>
<p><strong>Experience :</strong> <?php echo $model->experience_years.' Years '.$model->experience_months.' Months';?></p>
<p><strong>Working Hours :</strong> <?php echo $model->work_hours_start.' to '.$model->work_hours_end;?></p>
<p><strong>Working Days :</strong> <?php if(!empty($getdays)) { echo $getdays;  } ?></p>
</div> 			
</div> 
</div>
    </div>
</div>
<?php
    $this->registerJsFile('js/chatnotification.js');
?>