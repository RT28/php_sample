<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper; 
use kartik\depdrop\DepDrop;
use kartik\file\FileInput; 
use yii\helpers\Url;  
use dosamigos\ckeditor\CKEditor;
use common\models\PackageType;
use common\models\Country;
use common\models\Degree;
use common\models\Majors;  
use yii\helpers\ArrayHelper;
 

/* @var $this yii\web\View */
/* @var $model common\models\Student */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Assigning Consultant';
$this->params['breadcrumbs'][] = $this->title; 

 

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
<div class="student-index">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-10">
<?php //print_r($model);?>
<p> <h2><?= Html::encode($this->title) ?></h2> <br></p>

<?php $form = ActiveForm::begin([ 'options' => ['enctype' => 'multipart/form-data']]); ?>    
<div class="row">

<div class=" col-sm-6 border">
<h2>Consultant Details</h2>



<?php echo  $form->field($consultant, 'consultant_id')->dropDownList($consultant_name, ['prompt'=>'Select Consultant'])->label('Consultants')  ?> 



<?php
	$consultant_data = [];
	if(!empty($consultant->agency_id)) {
//$temp = $consultant->agency->consultants; 
if(!empty($temp)) {
$consultant_data = $consultant_name;
}
} 
?>

    	   
 
<div class="form-group">
<?= Html::submitButton( 'Update', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>



<div class="col-sm-6 border">
<h2>Student Details</h2>
<p><strong>Email:</strong> <?=  $model->email ?></p>
<p><strong>Country of Residence:</strong> <?= $countryname->name ?></p>
<p><strong>Degree Preference:</strong> <?=  $degree->name  ?></p>
<p><strong>Discipline Preference:</strong> <?= $majors ?> </p>
<p><strong>Country Prefrences:</strong> <?= $countries ?> </p>
<strong>Phone : </strong><?php  echo "+".$model->student->code.$model->student->phone; ?></p>
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
</div>
</div>
</div>
