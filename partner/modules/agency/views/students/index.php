<?php 
use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu; 
use common\models\Country; 
use common\models\DegreeLevel; 
use partner\modules\consultant\models\StudentDetailSearch;
use common\models\Majors; 
use common\models\Consultant; 
use common\models\StudentConsultantRelation; 
use common\models\PartnerEmployee; 
use common\models\StudentPartneremployeeRelation;
use common\models\StudentPackageDetails;
use common\models\PackageType;
use frontend\models\UserLogin;
use common\components\ConnectionSettings;
use common\components\Commondata;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;  
$this->context->layout = 'main';
$this->title = 'My Students'; 
$countrieslist = Country::getAllCountries();
$countrieslist = ArrayHelper::map($countrieslist, 'id', 'name');
$parentConsultantId = Yii::$app->user->identity->id; 
?>
<div class="consultant-dashboard-index col-sm-12">
<h1><?= $this->title; ?></h1> 
<div class="row">
<div class="col-sm-12 ">

<?php if(Yii::$app->session->getFlash('Error')): ?>
    <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
		
<div id='content' style="display:none;" class="">
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
</div>
<?php if($dataProvider->getTotalCount() != 0): ?>
<div class="col-sm-12 text-right">
<input type='button' id='hideshow' value='Filters'>
</div>
 <?php endif; ?>
</div>

 	  <?php  
	  if($dataProvider->getTotalCount() === 0): 
	 ?>
          <h2> You dont have any subscribed student.</h2>
           <div class="col-xs-12 text-center"> 
        </div>
    <?php else: ?>
	
    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
		'export' => false,
		'pjax' => true,
	'columns' => [
	['class' => 'kartik\grid\ExpandRowColumn',
	'value' => function ($searchModel, $key, $index) { 
	return GridView::ROW_COLLAPSED;
	},
	'expandOneOnly' => true,
	'detail' => function ($searchModel, $key, $index) { 
$content='<div class="kv-expanded-content"> 
<div class="row panel-body"> 
	<div class="row ">
	<div class="col-sm-4 text-left" > <strong>Degree Preference  </strong></div>
	<div class="col-sm-4 text-left"> <strong>Discipline  Preference </strong></div>
	<div class="col-sm-4 text-left"> <strong>Country Preference </strong></div>  
	</div>
<div class="row" style="margin-bottom: 10px;">
	<div class="col-sm-4 text-left" >';
	$degreeVal ="NA";
	$degree_preference = $searchModel->student->degree_preference;
	$degree_preference = DegreeLevel::find()->where(['=', 'id',$degree_preference])->one();
	if(isset($degree_preference)){
		$degreeVal =  $degree_preference->name; 
	} 
	$content.= $degreeVal;
	$content.='</div>
	<div class="col-sm-4 text-left">';
	 $majVal = "NA"; 							
	if(!empty($searchModel->student->majors_preference)){
	$majors =  array();
	$majors_preference = explode(',',$searchModel->student->majors_preference);
	$arr = Majors::find()->select('name') ->where(['in', 'id', $majors_preference]) 
	->orderBy(['name'=>'ASC'])->all();        
	foreach($arr as $maj) {
		$majors [] = $maj['name'];
	}
	if(isset($majors)){
		$majVal = implode('<br/>',$majors);
	}
	}  
	$content.= $majVal;
	$content.='</div> 
	<div class="col-sm-4 text-left">';
	 	$countryVal = "NA";						
	if(!empty($searchModel->student->country_preference)){
	$country_p = array();
	$country_preference = explode(',',$searchModel->student->country_preference);
	$arr = Country::find()->select('name')->where(['in', 'id', $country_preference]) 
	->orderBy(['name'=>'ASC'])->all();        
	foreach($arr as $cnt) {
		$country_p [] = $cnt['name'];
	}
		if(isset($country_p)){
			$countryVal = implode(', ',$country_p);
		}
	} 
$content.= $countryVal;	
$content.= '</div></div>
<div class="row ">
<div class="col-sm-4 text-left"> <strong>Student wants to  Begin </strong></div>
<div class="col-sm-4 text-left"> <strong>Package Type </strong></div>
<div class="col-sm-4 text-left"> <strong>Highest  Qualification</strong></div>
</div>
	';
$content.= '<div class="row " style="margin-bottom: 10px;"> 
	<div class="col-sm-4 text-left">';
	$beginVal =  "NA";
  if(!empty($searchModel->student->begin)){
		$begin = Commondata::wanttobegin();
		$beginVal = $begin[$searchModel->student->begin];
	} 
	$content.= $beginVal;
$content.= '	
	</div>
	<div class="col-sm-4 text-left">';
	$packagetypeVal = "NA";
	if(!empty($searchModel->student->package_type)) {  
	$Pname = array();
	$packages = PackageType::getPackageType();
	$package_type = $searchModel->student->package_type;
	if(!empty($package_type)){
		$package_type = explode(',',$package_type);
	}
	$StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();
	foreach ($StudentPD  as $row){ 
		$Pname[] = $packages[$row->id]; 
	} 
	$packagetypeVal = implode(',',$Pname);
	  
		
	}  
	$content.= $packagetypeVal;
	$content.='</div> 
	<div class="col-sm-4 text-left">';
 $qualificationVal = "NA";
	if(!empty($searchModel->student->qualification) || $searchModel->student->qualification!=0) { 
	if($searchModel->student->qualification!=6){
		$qualification = Commondata::qualificationList();
		$qualificationVal = $qualification[$searchModel->student->qualification];  
	}else{
	$qualificationVal = $searchModel->student->others; 
	}
	} 
	$content.= $qualificationVal;
$content.='	 </div> 
	</div>';
$content.='
	<div class="row ">
	<div class="col-sm-4 text-left"> <strong>Phone Type </strong></div>
	<div class="col-sm-4 text-left"> <strong>Contact Number </strong></div>
	<div class="col-sm-4 text-left"> <strong>How did you come to know about GTU? </strong></div>
	</div>';
	$content.='<div class="row " style="margin-bottom: 10px;"> 
	<div class="col-sm-4 text-left">';
	$phonetypeVal = 'NA';
	if(isset($searchModel->student->phonetype)){
		$phonetype = Commondata::phonetype();
		$phonetypeVal = $phonetype[$searchModel->student->phonetype];
	} 
	$content.= $phonetypeVal;
	$content.='	</div> 
	<div class="col-sm-4 text-left">
	';
	$content.= "+".$searchModel->student->code.$searchModel->student->phone; 
	$content.='</div>   
	<div class="col-sm-4 text-left">';
	  $diduknowVal = 'NA';
	if(!empty($searchModel->student->knowus)){
		if($searchModel->student->knowus!=8){
			$diduknow = Commondata::diduknow();
			 $diduknowVal =$diduknow[$searchModel->student->knowus];
		}else{
			 $diduknowVal = $searchModel->student->knowus_others;
		}
	}    
	$content.=  $diduknowVal;
$content.='	</div>
	</div>
	<div class="row ">
	<div class="col-sm-4 text-left"> <strong>Consultant </strong></div>
	<div class="col-sm-4 text-left"> <strong>Associates Consultant </strong></div>
	<div class="col-sm-4 text-left"> <strong>Associates Trainer/Employee </strong></div>
	<div class="col-sm-4 text-left"> &nbsp;</div>
	</div>
	<div class="row ">
	<div class="col-sm-4 text-left"> ';
	
		$mainconsultant = "Not Assigned";
			$consultant = StudentConsultantRelation::find()->where(['=','student_id', $searchModel->student_id])->one();
			if(isset($consultant)){ 
				$consultant = Consultant::find()->where(['=', 'consultant_id', $consultant->parent_consultant_id])->one();
				if(isset($consultant)){
					 $mainconsultantname = $consultant->first_name." ".$consultant->last_name; 
				} 
			}
			
			$content.=  $mainconsultantname;
		
		$content.=' </div>
	<div class="col-sm-4 text-left"> ';
	
		$subconsultant = "Not Assigned";
		$subconsultantname = array();
		$associates = StudentConsultantRelation::find()->where(['AND',
		['=','student_id', $searchModel->student_id], 
		['=','is_sub_consultant', 1],
		])->orderBy(['id' => 'DESC'])->all();
		if(isset($associates)){ 
		foreach($associates as $associate):
			$consultant = Consultant::find()->where(['=', 'consultant_id', $associate->consultant_id])->one();
			if(isset($consultant)){
				 $subconsultantname[] = $consultant->first_name." ".$consultant->last_name; 
			} 
		endforeach;
		}
		if(isset($subconsultantname)){
			 $subconsultant = implode(', ',$subconsultantname);
		}	
		$content.=  $subconsultant;
		$content.=' </div>
		<div class="col-sm-4 text-left">';
		$employee = "Not Assigned";
		$assoEmployees = array();
		$employees = '';
		  $employees = StudentPartneremployeeRelation::find()->where(['AND',
		['=','student_id', $searchModel->student_id],  
		])->orderBy(['id' => 'DESC'])->all();
		 
		
		if(isset($employees)){ 
		$assignedEmp = '';
		foreach($employees as $emp):
		
			  $assignedEmp = PartnerEmployee::find()->where(['=', 'partner_login_id', $emp->parent_employee_id])->one();
			 if(isset($assignedEmp)){
				  $assoEmployees[] = $assignedEmp->first_name." ".$assignedEmp->last_name; 
			 }  
		endforeach;
		} 
		if(isset($assoEmployees)){
		 $employee = implode(', ',$assoEmployees);
		}
		
		$content.=  $employee;	

	$content.='</div>
	<div class="col-sm-4 text-left"> &nbsp;</div>
	</div>
</div> 
</div>';
			 return $content;	
				}
	], 
	['attribute' => 'first_name',
	'format' => 'raw',
	'label' => 'Student',
	'value' => function($model){  
		$name = $model->first_name . ' ' .$model->last_name ;
		if (isset($name)) {
			$id = Commondata::encrypt_decrypt('encrypt', $model->id);
			$temp = Html::a($name,'?r=agency/students/view&id='.$id);
			return $temp; 
		} else{ 
			return 'not assigned'; 
		}
	}, 
	], 
	'email', 
	['attribute' => 'student.country',
	'label' => 'Country',
	'value' => function($searchModel){
		if(isset($searchModel->country)){
			$id = $searchModel->country;
			$Country = Country::find()->where(['=', 'id', $id ])->one();
			return  $Country->name;   
		}
		return "NA";
		
	}, 
	'filter'=>Html::dropDownList('StudentSearch[country]',isset($_REQUEST['StudentSearch']['country']) ? $_REQUEST['StudentSearch']['country'] : null,$countrieslist,['class' => 'form-control', 'prompt' => 'Select Country'])
	],
	['attribute' => 'student.country',
	'label' => 'Packages',
	'value' => function($searchModel){
		$packages = PackageType::getPackageType();
		$activePackages =  StudentPackageDetails::find()->where(['=', 'student_id', $searchModel->student_id])->all(); 
		foreach ($activePackages  as $row){ 
			$packagesName[] = $packages[$row->package_type_id]; 
		}
		if(isset($packagesName)){
		return implode(',',$packagesName); 
		}  
	},
	'contentOptions' => ['style' => '  max-width:300px; white-space: normal; ']	
	],	
	['attribute' => 'consultant.first_name',
	'label' => 'Consultant', 
	'value' => function($searchModel){  
	if(isset($searchModel->consultant))	 {
	 $name = $searchModel->consultant->first_name . ' ' .$searchModel->consultant->last_name ;
		if (isset($name)) {
			 	return $name; 
		} else{ 
			return 'not assigned'; 
		}
	}
	}, 
	],  
	['attribute' => 'student.phone',
	'label' => 'Contact  Number',
	'value' => function($searchModel){  
if(isset($searchModel->student->phone))	{
			  return  "+".$searchModel->student->code.$searchModel->student->phone; 
}
	}, 
	], 	
 	 	
	['class' => 'yii\grid\ActionColumn',
	'buttons' => [   
	'assignConsultant' => function ($url, $searchModel, $key) {
		
	//$path = '';
	//$path= ConnectionSettings::BASE_URL.'partner/';
	//$path = $path.'web/index.php?r=agency/students/assign-consultant&id='.$searchModel->student_id;
	return  '<a href="#" class="btn btn-success" data-toggle="modal"  
	data-target="#assignConsultantModal" onclick=assignConsultant("'.$searchModel->student_id.'"); >Assign Consultant</a> <br/>';
	},	 
	],
	'template' => '{assignConsultant} '], 
	],
	]); ?>
	 <?php endif; ?>
</div> 

<div id="assignConsultantModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="studentList" style="height:800px; overflow:scroll;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 

<script> 
jQuery(document).ready(function(){ 
jQuery('#hideshow').on('click', function(event) {  
jQuery('#content').toggle('show');
});
}); 
</script>
 
