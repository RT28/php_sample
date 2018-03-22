<?php
use yii\helpers\Html; 
use common\models\Country;
use common\models\City;
use common\models\State;
use common\models\Others;
use yii\helpers\Json;
use yii\web\JsExpression;
use common\models\StandardTests;
 use yii\helpers\ArrayHelper;
	
$institutionModel = Others::find()->where(['=', 'name', 'institution_type'])->one();
$temp1 = array();
if($institutionModel->value!=''){
	trim($institutionModel->value);	
	$temp1 = explode(',', $institutionModel->value);
} 
$institutionType = explode(',',$model->institution_type);
$types =  array_intersect_key($temp1,$institutionType);	  				 
$types = implode(',', $types); 

$establishmentModel = Others::find()->where(['=', 'name', 'establishment'])->one();
$temp = array();
if($establishmentModel->value!=''){
	trim($establishmentModel->value);	
	$temp = explode(',', $establishmentModel->value);
} 
$establishment = explode(',',$model->establishment);
$est =  array_intersect_key($temp,$establishment);	  				 
$est = implode(',', $est); 

$Country = Country::find()->where(['=', 'id', $model->country_id])->one();
$State = State::find()->where(['=', 'id', $model->state_id])->one();
$city = City::find()->where(['=', 'id', $model->city_id])->one();
$symbol = $Currency->symbol;
?>

<div class="row"> 
   <div class="col-sm-12" style="margin:20px 0px 50px 0px !important">
 <div class="basic-details"> 
<div class="row address"> 
   <div class="col-sm-6">
   <h3><?=  $model->name ?></h3> 
   <p><strong>Establishment Yate:</strong> <?=  $model->establishment_date ?></p>
   <p><strong>Institution Type:</strong> <?= $types ?></p>
   <p><strong>Establishment:</strong> <?= $est ?></p>
   <p><strong>Email:</strong> <?=  $model->email ?></p>
 
   <p><strong>Phone 1:</strong> <?=  $model->phone_1 ?></p>
   <p><strong>Phone 2:</strong> <?=  $model->phone_2 ?></p>
      <p><strong>Standard Tests & Requirements:</strong> 
 <?php if($model->standard_tests_required == 1){ 
 echo "Yes";
 }
 else{ 
 echo "No"; 
 } ?>
 </p>
     
	</div>
	<div class=" col-sm-6">
	  <h3>Address</h3>
	  
   <p><strong>Address:</strong> <?=  $model->address ?></p>
   <p><strong>Country:</strong> <?= $Country->name;  ?></p>
   <p><strong>State:</strong> <?=  $State->name; ?></p>
   <p><strong>City:</strong> <?=  $city->name ?></p>
   <p><strong>Zip Code:</strong> <?=  $model->pincode ?></p>   
   <p><strong>Website:</strong> <?=  $model->website ?></p>
</div>
</div>
</div>
<div class="basic-details"> 
<div class="row address"> 
<div class="col-sm-6">
<h3>Student & Faculty (Number)</h3>
   <p><strong>Students:</strong> <?=  $model->no_of_students ?></p>
   <p><strong>International Students:</strong> <?=  $model->no_of_international_students ?></p>
   <p><strong>Undergarduate Students:</strong> <?=  $model->no_of_undergraduate_students ?></p>
   <p><strong>Post Graduate Students:</strong> <?=  $model->no_of_post_graduate_students ?></p>
   <p><strong>Total Faculties :</strong> <?=  $model->no_faculties ?></p> 
   <p><strong>International Faculties:</strong> <?=  $model->no_of_international_faculty; ?></p>
</div>  

   <div class="col-sm-6">
   <h3>Contact Person:</h3>  
   <p><strong>Name:</strong> <?=  $model->contact_person ?></p>
   <p><strong>Designation:</strong> <?=  $model->contact_person_designation ?></p>
   <p><strong>Email:</strong> <?=  $model->contact_email ?></p>
   <p><strong>Mobile:</strong> <?=  $model->contact_mobile ?></p>
   <p><strong>Fax:</strong> <?=  $model->fax ?></p>  
	</div> 
	  
 
</div>
</div>

<!--<div class="basic-details"> 
<div class="row address"> 
<div class="col-sm-6">
<h3>Cost of Living & Accomodation</h3>
   <p><strong>Accomodation available:</strong> <?=  $model->accomodation_available ?></p>
   <p><strong>Hostel Strength:</strong> <?=  $model->hostel_strength ?></p>
   <p><strong>Cost of Living:</strong> <?=  $model->cost_of_living ?></p>
   <p><strong>Undergarduate Fees:</strong> <?php if(!empty($model->undergarduate_fees)){
   echo $symbol.$model->undergarduate_fees; }
   ?></p>
   <p><strong>Undergarduate Fees for International Students:</strong> 
<?php if(!empty($model->undergraduate_fees_international_students)){   
echo $symbol.$model->undergraduate_fees_international_students;
  } ?></p>
   <p><strong>Post Graduate Fees:</strong> <?php if(!empty($model->post_graduate_fees)){
	 echo  $symbol.$model->post_graduate_fees ;
	     }?></p>
   <p><strong>Post Graduate Fees for International Students:</strong> <?php if(!empty($model->post_graduate_fees_international_students)){
	echo   $symbol.$model->post_graduate_fees_international_students ;
	  }?></p>
</div>
 
</div></div> -->
     
</div>
</div> 
