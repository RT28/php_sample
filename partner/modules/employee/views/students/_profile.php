<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper;
use kartik\file\FileInput;   
use dosamigos\ckeditor\CKEditor;
use common\models\PackageType;
use common\models\Country;
use common\models\Degree;
use common\models\Majors;
use common\components\Status; 
use yii\helpers\ArrayHelper; 
use common\components\Commondata;  
use common\models\AccessList;
 

	
 
/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Assigning Counselor to '.$model->first_name. ' '.$model->last_name;
$this->params['breadcrumbs'][] = $this->title; 
$status = Status::getStatus();
  
$proficiency = Commondata::getProficiency();

$AllCountries = Country::getAllCountries();
$AllCountries = ArrayHelper::map($AllCountries, 'id', 'name');

$countryname = Country::find()->select('name')
->where(['=','id', $model->student->country]) 
->one();
$degree = Degree::find()->select('name')
->where(['=','id', $model->student->degree_preference]) 
->one();

    $majors = "";
    $countries = "";
	 
     $majors = "";
    $countries = "";
    if(!empty($model->student->country_preference))
    {          
        $temp = $model->student->country_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);            
        } else {
            $arr[] = $temp;
        }
        $arr = Country::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $country) {
            $countries .= $country['name'] . ', ';
        }
    }

    if(!empty($model->student->majors_preference))
    {
        $temp = $model->student->majors_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
        $arr = Majors::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $major) {
            $majors .= $major['name'] . ', ';
        }
    }
	
 
$accessStatus = array(0=>'Not Subscribed',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');
$currDate = date('Y');
$currDate1 = $currDate+1;
$currDate2 = $currDate1+1;
$begin = array($currDate,$currDate1,$currDate2);

$packages = PackageType::getPackageType();
 $time = time();

				
$qualification = array(1=>'High School',2=>'Intermediate',3=>'Diploma  or Certification',
					 4=>'Graduate',5=>'Post Graduate',6=>'Others');
$diduknow = array(1=>"Google Ad's Search/Display/Gmail",2=>"Google Organic Search",
				  3=>"Facebook / Google + / Social Media",
				  4=>"News paper / Magazine / print Media",
				  5=>"Friends / Reference/Teachers/Counsellors",
				  6=>"Events /Seminars / Work shops / School Fair",
				  7=>"Website",
				  8=>"Others"); 
			 
?>

<div class="student-profile-main">
    
    <div class="dashboard-detail">
        <div class="tab-content">
            <!-- PROFILE TAB -->
            <div role="tabpanel" class="tab-pane fade in active" id="d1">
                <div class="row" id="tab-profile">
                    <div class="col-sm-12">
                        <div class="basic-details">
<div class="row">
<div class="col-sm-9">
<h3>Basic Details</h3>
</div>
<div class="col-sm-3 text-center">
 

 
</div>
</div>
<div class="row">
<div class="col-sm-6">

<p><strong>Nationality:</strong>  <?php if($model->nationality){ echo $AllCountries[$model->nationality]; } ?></p>

<p><strong>Language Proficiency:</strong> <?php if(isset($model->language_proficiency)) { echo $proficiency[$model->language_proficiency]; }?></p>

<p><strong>Phone:</strong> +<?=  $model->code.$model->phone ?></p> 

<p><strong>Email:</strong> <?=  $model->email ?></p> 
					<div class="row">
							<div class="col-sm-6"> 
<h3>Father Details</h3>
<p><strong>Name:</strong><?=  $model->father_name ?> </p>  
<p><strong>Phone:</strong> <?php if($model->father_phone!=''){ ?> +<?=  $model->father_phonecode.$model->father_phone ?><?php }  ?></p> 
<p><strong>Email:</strong>  <?=  $model->father_email ?> </p>

</div>
<div class="col-sm-6"> 
<h3>Mother Details</h3>
<p><strong>Name:</strong>  <?=  $model->mother_name ?> </p>  
<p><strong>Phone:</strong> <?php if($model->mother_phone!=''){ ?>+<?=  $model->mother_phonecode.$model->mother_phone ?><?php }  ?></p> 
<p><strong>Email:</strong> <?=  $model->mother_email ?> </p> 
</div>
</div>
</div>
<div class="col-sm-6">
<p><strong>Majors Prefrences:</strong> <?= $majors ?> </p>
<p><strong>Country Prefrences:</strong> <?= $countries ?> </p>
<p><strong>I want to begin :</strong> <?php if(!empty($model->student->begin)){
		echo $begin[$model->student->begin]; }else{ 	echo "NA"; }  ?></p> 
		<p><strong>Package Type : </strong> <?php 
	if(!empty($model->student->package_type)) {  
	$Pname = array();
	$package_type = $model->student->package_type;
	$StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();

	foreach ($StudentPD  as $row){ 
	$Pname[] = $packages[$row->id]; 
	}

	echo implode(',',$Pname);

	}else{
	echo "NA";
	} 
	?></p>
		<p><strong>Highest  Qualification : </strong> <?php 
	if(!empty($model->student->qualification) || $model->student->qualification!=0) { 
	if($model->student->qualification!=6){
	echo $qualification[$model->student->qualification];  
	}else{
	echo $model->student->others; 
	}

	}else{
	echo "NA";
	} 
	?></p>
	<p><strong>How did you come to know about GTU?  : </strong> <?php  
	if(!empty($model->student->knowus)){
		if($model->student->knowus!=8){
			echo $diduknow[$model->student->knowus];
		}else{
			echo $model->student->knowus_others;
		}
	}   
	?></p>
</div>
</div>
  
                        </div>
						<div class="row">
                                <div class="col-sm-6">
                            <div class="address">
                                <h3>Address</h3>
                                <p><strong>Address:</strong> <?=  $model->address ?> </p>
                                <p><strong>Street:</strong> <?=  $model->street ?> </p>
                                <p><strong>City:</strong> <?=  $model->city ?> </p>
                                <p><strong>State:</strong> <?php  if(!empty($model->state0->name)){ echo $model->state0->name ; } ?> </p>
                                <p><strong>Country:</strong> <?=  $model->country0->name ?> </p>
                            </div>
                            </div>
                                 
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
 
