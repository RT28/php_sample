<?php
use common\models\Country; 
use common\models\Majors; 
use common\models\StudentPackageDetails;
use common\models\PackageType;
use frontend\models\UserLogin;
use common\models\StudentLeadFollowup;

use yii\helpers\ArrayHelper;
$this->context->layout = 'main';
$this->title = 'My Students';


$accessStatus = array(0=>'Not Subscribed',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');
$currDate = date('Y');
$currDate1 = $currDate+1;
$currDate2 = $currDate1+1;
$begin = array($currDate,$currDate1,$currDate2);

$packages = PackageType::getPackageType();
 $time = time();

                
$qualification = array(1=>'High School',2=>'Intermediate',3=>'Diploma  or Certification',
                     4=>'Graduate',5=>'Post Graduate',6=>'Others',)
?>

<?php if($students){ ?>

<div class="row course-list-header text-center">
<div class="col-sm-2 text-left"><div class="list-title">Name </div></div>
    <div class="col-sm-2 text-center"><div class="list-title">Email </div></div>
    <div class="col-sm-2 text-center"><div class="list-title">Country</div></div>
    <div class="col-sm-2 text-left"><div class="list-title">Packages Subscribed</div></div>
    <!--<div class="col-sm-1 text-right"><div class="list-title">Status</div></div> -->
    <div class="col-sm-2 text-center"><div class="list-title">Contact Number</div></div>
    <div class="col-sm-2 text-right"><div class="list-title">Actions</div></div>

</div>  
<div class=" panel-group course-list-body mywrap" id="accordion-<?= $time; ?>" role="tablist" aria-multiselectable="true">
<?php  

$i= 1;
foreach($students as $student): 
$packagesName = array(); ?>
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
<!--     <div class="col-sm-1 text-left" ><?= $student->student->id; ?></div>
 -->    <div class="col-sm-2 text-left" >

 <a href="?r=consultant/students/view&id=<?= $studentProfile->id; ?>"><?= $studentProfile->first_name; ?> <?= $studentProfile->last_name; ?></a>
 &nbsp;<a onclick="fn_getfollowup(<?= $student->student->id; ?>);"><img src="images/Followup1.png" height="20px;" width="20px;"></a>

 </div>

    <div class="col-sm-2 text-center" ><?= $student->student->email; ?></div>
    <div class="col-sm-2 text-center" ><?php                            
                if(isset($student->student->country)){
                    echo $countries[$student->student->country];
                }   ?></div>
    <div class="col-sm-2 text-left" ><?php if(isset($packagesName)){ echo implode(',',$packagesName); } ?></div>
    <div class="col-sm-2 text-center" ><?php  echo "+".$student->student->code.$student->student->phone; ?></div>
    <div class="col-sm-2 text-right" > 
    <?php if($student->student->status!=UserLogin::STATUS_SUBSCRIBED){
         ?>
    <a href="?r=consultant/students/assign-package&id=<?= $studentProfile->id; ?>">Send Dashboard Link</a>
    <br/>
    <?php } ?>
    <?php if($student->student->status==UserLogin::STATUS_SUBSCRIBED){
         ?>
    <a href="?r=consultant/tasks/index">Add Task</a>
    <br/>
    <?php } ?>
    <a title="Expand" data-toggle="collapse" data-parent="#accordion" href="#" onclick="toggle('student-<?= $i?>-<?= $time; ?>');"  class="toggle-title ">Details...</a>
    </div>
</div>
</div>
<!-- follow up details//////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                      <?php if($status==5){  $today_flp = StudentLeadFollowup::gettodayfollowup($student->student->id);
                                if($today_flp){ ?>
                                <div class="col-sm-1 text-left">
                                <?php foreach ($today_flp as $today_det) {  $today_status = $today_det['today_status']; } ?>
                                <?php if($today_status==2){ ?>
                                    <img src="images/tick_green.png" height="20px;" width="20px;" title="This follow up is done">
                                <?php } else if($today_status==1){ ?>
                                    <img src="images/cross_follow.png" height="20px;" width="20px;" title="This follow up is pending">
                                <?php } ?></div> <?php }
                                 } ?>

                            <?php $last_fl_comment = StudentLeadFollowup::getlastfollowup($student->student->id); 
                            if($last_fl_comment){
                                foreach ($last_fl_comment as $vm) { ?>
                                <div class="col-sm-6 text-left">
                                <b>Latest comment:</b>&nbsp;<b style="color: red;"><?php echo $vm['comment']; ?></b>
                                <?php if($vm['status']=='1'){
                                    echo "<i style='color: black;'>(next followup on ".$vm['next_followup'].") </i>";
                                    } else {
                                    echo "<i style='color: black;'>(commented on ".$vm['comment_date'].") </i>";
                                    } ?>
                                </div>
                           
                            <?php } } else { ?>
                            <div class="col-sm-6 text-left">
                                <b>Sign up date:</b>&nbsp;<b style="color: red;"><?php echo $student->student->created_at; ?></b>
                            <?php } ?>
                            </div><br>
                        
<!-- end follow up details ////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="sfb_712330<?= $student->student->id; ?>"> </div>
    <div id="student-<?= $i?>-<?= $time; ?>" class="asd panel-collapse collapse" role="tabpanel" aria-labelledby="course-heading-<?= $i?>-<?= $time; ?>" style="border: 2px solid;padding: 5px; margin: 10px 0;">
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
    <div class="col-sm-4 text-left"> <strong>Packages Interested </strong></div>
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
    <div class="col-sm-4 text-left"> <strong>&nbsp; </strong></div>

    </div>
    <div class="row "> 
    <div class="col-sm-4 text-left">
    <?php 
    $phonetype = array('Home','Mobile','Work'); echo $student->student->phonetype;
    if(!empty($student->student->phonetype)){
    echo $phonetype[$student->student->phonetype];
    }   
    ?>
    </div> 
    <div class="col-sm-4 text-left">
    <?php  echo "+".$student->student->code.$student->student->phone; ?>
    </div>   


    </div>

    </div>
      
     
    </div>
    
     


    </div>
 
 
  
 
<?php $i++;
        endforeach; ?>
</div>

<?php } else echo "<h2>No records found!..</h2>";?>
<script>
 function toggle(id) {
     
    $('.collapse').hide();
    $('#'+id).show();
} 
</script>

<?php
    $this->registerJsFile('js/consultant.js');
?>
