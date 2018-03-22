<?php
use common\models\Country; 
use common\models\Majors; 
use common\models\StudentPackageDetails;
use common\models\PackageType;
use frontend\models\UserLogin;
use common\components\ConnectionSettings;
use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;
$this->context->layout = 'main';
$this->title = 'My Students';

$path= ConnectionSettings::BASE_URL.'partner/';

$accessStatus = array(0=>'Not Subscribed',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');
$currDate = date('Y');
$currDate1 = $currDate+1;
$currDate2 = $currDate1+1;
$begin = array($currDate,$currDate1,$currDate2);


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

<div class="consultant-dashboard-index col-sm-12">
<h1><?= $this->title; ?></h1> 
  
 
<div class="row course-list-header text-center">
	 
	<div class="col-sm-2 text-left"><div class="list-title">Name </div></div>
	<div class="col-sm-2 text-center"><div class="list-title">Email </div></div>
	<div class="col-sm-2 text-center"><div class="list-title">Country</div></div>
	<div class="col-sm-2 text-left"><div class="list-title">Packages</div></div>
	<!--<div class="col-sm-1 text-right"><div class="list-title">Status</div></div> -->
	<div class="col-sm-2 text-center"><div class="list-title">Contact Number</div></div>
	<div class="col-sm-2 text-right"><div class="list-title">Actions</div></div>

</div>  



<div class=" panel-group course-list-body mywrap" id="accordion-<?= $time; ?>" role="tablist" aria-multiselectable="true">

<?php  

$i= 1;
foreach($students as $student): 
$packagesName = array();
if($student->student->status==UserLogin::STATUS_SUBSCRIBED){ ?>
<?php 
$studentProfile = $student->student->student;

//  $applications = StudentUniveristyApplication::find()->where(['=', 'student_id', $student->student_id])->count();
//  $associates = StudentAssociateConsultants::find()->where(['=', 'student_id', $student->student_id])->count();
//$activePackages = StudentPackageDetails::find()->where(['AND',  ['>', 'limit_pending', 0], ['=', 'student_id', $studentProfile->student_id]])->count();
 
$activePackages =  StudentPackageDetails::find()->where(['=', 'student_id', $studentProfile->student_id])->all(); 

foreach ($activePackages  as $row){ 
	$packagesName[] = $packages[$row->package_type_id]; 
}
?>
	
	<div class="row panel-heading" role="tab" id="course-heading-<?= $i?>-<?= $time; ?>">
	<div class="panel panel-default item">
		<div class="panel-title program-title">
			 
			
				<div class="col-sm-2 text-left" ><a href="?r=consultant/students/view&id=<?= $studentProfile->id; ?>"><?= $studentProfile->first_name; ?> <?= $studentProfile->last_name; ?></a></div>
	<div class="col-sm-2 text-center" ><?= $student->student->email; ?></div>
	<div class="col-sm-2 text-center" ><?php  							
				if(isset($student->student->country)){
					echo $countries[$student->student->country];
				}   ?></div>
	<div class="col-sm-2 text-left" ><?php if(isset($packagesName)){ echo implode(',',$packagesName); } ?></div>
	<div class="col-sm-2 text-center" ><?php  echo "+".$student->student->code.$student->student->phone; ?></div>
	<div class="col-sm-2 text-right" > 
	<a href="#" class="btn btn-success" data-toggle="modal"  
data-target="#addtaskModal" onclick="loadTaskAdd('<?php echo $path; ?>web/index.php?r=consultant/tasks/create&id=<?= $student->student_id; ?>');" >Add Task</a>

	<br/>
 
	<a title="Expand" data-toggle="collapse" data-parent="#accordion" href="#" onclick="toggle('student-<?= $i?>-<?= $time; ?>');"  class="toggle-title ">Details...</a>
	</div>
	 
			                
		 
		</div>
	</div>
	<div id="student-<?= $i?>-<?= $time; ?>" class="asd panel-collapse collapse" role="tabpanel" aria-labelledby="course-heading-<?= $i?>-<?= $time; ?>" style="border: 2px solid;padding: 5px; margin: 50px 0;">
		<div class="row panel-body"> 
	  
	<div class="row ">
	<div class="col-sm-4 text-left" > <strong>Discipline Preference  </strong></div>
	<div class="col-sm-4 text-left"> <strong>Sub Discipline  Preference </strong></div>
	<div class="col-sm-4 text-left"> <strong>Country Preference </strong></div>  
	</div> 

	<div class="row" style="margin-bottom: 10px;">
	<div class="col-sm-4 text-left" >
	<?php $degree_preference = $student->student->degree_preference;							
	if(isset($degrees[$degree_preference])){
	echo $degrees[$degree_preference];
	}else{
	echo "NA";
	}  
	?>
	</div>
	<div class="col-sm-4 text-left">
	<?php  							
	if(!empty($student->student->majors_preference)){
	$majors =  array();
	$majors_preference = explode(',',$student->student->majors_preference);
	$arr = Majors::find()->select('name')
	->where(['in', 'id', $majors_preference]) 
	->orderBy(['name'=>'ASC'])->all();        
	foreach($arr as $maj) {
	$majors [] = $maj['name'];
	}
	if(isset($majors)){
	echo implode('<br/>',$majors);
	}
	}else{
	echo "NA";
	} 
	?>
</div>
			
	<div class="col-sm-4 text-left">
	<?php 							
	if(!empty($student->student->country_preference)){
	$country_p = array();
	$country_preference = explode(',',$student->student->country_preference);
	$arr = Country::find()->select('name')
	->where(['in', 'id', $country_preference]) 
	->orderBy(['name'=>'ASC'])->all();        
	foreach($arr as $cnt) {
	$country_p [] = $cnt['name'];
	}
	if(isset($country_p)){
	echo implode(', ',$country_p);
	}
	}else{
	echo "NA";
	}  
	?></div>

	</div>

	<div class="row ">
	<div class="col-sm-4 text-left"> <strong>Student wants to  Begin </strong></div>
	<div class="col-sm-4 text-left"> <strong>Package Type </strong></div>
	<div class="col-sm-4 text-left"> <strong>Highest  Qualification</strong></div>
	</div>

	<div class="row " style="margin-bottom: 10px;"> 
	<div class="col-sm-4 text-left">
	<?php if(!empty($student->student->begin)){
	echo $begin[$student->student->begin];
					}else{
	echo "NA";
	}  ?>
	</div>
	<div class="col-sm-4 text-left">
	<?php 
	if(!empty($student->student->package_type)) {  
	$Pname = array();
	$package_type = $student->student->package_type;
	$StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();

	foreach ($StudentPD  as $row){ 
	$Pname[] = $packages[$row->id]; 
	}

	echo implode(',',$Pname);

	}else{
	echo "NA";
	} 
	?>
	</div>

	<div class="col-sm-4 text-left">
	<?php 
	if(!empty($student->student->qualification) || $student->student->qualification!=0) { 
	if($student->student->qualification!=6){
	echo $qualification[$student->student->qualification];  
	}else{
	echo $student->student->others; 
	}

	}else{
	echo "NA";
	} 
	?>
	</div>

	</div>


	<div class="row ">
	<div class="col-sm-4 text-left"> <strong>Phone Type </strong></div>
	<div class="col-sm-4 text-left"> <strong>Contact Number </strong></div>
	<div class="col-sm-4 text-left"> <strong>How did you come to know about GTU? </strong></div>
	</div>
	
	<div class="row "> 
	<div class="col-sm-4 text-left">
	<?php 
	$phonetype = array('Home','Mobile','Work');
	if(!empty($student->student->phonetype)){
	echo $phonetype[$student->student->phonetype];
	}   
	?>
	</div> 
	<div class="col-sm-4 text-left">
	<?php  echo "+".$student->student->code.$student->student->phone; ?>
	</div>   
	
	<div class="col-sm-4 text-left">
	<?php  
	if(!empty($student->student->knowus)){
		if($student->student->knowus!=8){
			echo $diduknow[$student->student->knowus];
		}else{
			echo $student->student->knowus_others;
		}
	}   
	?>
	</div>

	</div>

	</div>
	  
	 
	</div>
	</div>
 
 
  
 
<?php $i++;
} endforeach; ?>
</div>

</div>

  
   <div id="addtaskModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="AddTaskPreview" style="height:800px; overflow:scroll;">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> 

 <script>
 

function toggle(id) {
	 
	$('.collapse').hide();
	$('#'+id).show();
} 
</script>
 