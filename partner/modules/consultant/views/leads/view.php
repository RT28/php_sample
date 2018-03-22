<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use common\models\StudentLeadFollowup;
use common\models\User;

use common\models\DegreeLevel;
use common\models\Degree; 
use common\models\Country; 
use common\models\PackageType;
use common\components\Commondata;
use common\models\StudentConsultantRelation; 
use common\models\Consultant; 
use common\models\StudentPartneremployeeRelation;
use common\models\PartnerEmployee; 


$title_1 = 'Student Details';
$title_2 = 'Follow up Details';

$status = array(1=>'FollowUp Again',2=>'Not Interested',3=>'Send Access Link',4=>'Other');
//$reason_code = array(1=>'Not Interested',2=>'Price Not Reasonable',3=>'Not Now');
?>
<div class="employee-view">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h4><?= Html::encode($title_1) ?></h4>

 <?php
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
	$studentData = User::find()->where(['=', 'id', $searchModel->student_id])->one();
	$degree_preference = $studentData->degree_preference;
	$degree_preference = DegreeLevel::find()->where(['=', 'id',$degree_preference])->one();
	if(isset($degree_preference)){
		$degreeVal =  $degree_preference->name; 
	} 
	$content.= $degreeVal;
	$content.='</div>
	<div class="col-sm-4 text-left">';
	 $majVal = "NA"; 							
	if(!empty($studentData->majors_preference)){
	$majors =  array();
	$majors_preference = explode(',',$studentData->majors_preference);
	$arr = Degree::find()->select('name') ->where(['in', 'id', $majors_preference]) 
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
	if(!empty($studentData->country_preference)){
	$country_p = array();
	$country_preference = explode(',',$studentData->country_preference);
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
	<div class="col-sm-4 text-left"> <strong>Package Interested </strong></div>
	<div class="col-sm-4 text-left"> <strong>Highest  Qualification</strong></div>
	</div>
		';
	$content.= '<div class="row " style="margin-bottom: 10px;"> 
		<div class="col-sm-4 text-left">';
		$beginVal =  "NA";
	  if(!empty($studentData->begin)){
			$begin = Commondata::wanttobegin();
			$beginVal = $begin[$studentData->begin];
		} 
		$content.= $beginVal;
		$content.= '	
		</div>
		<div class="col-sm-4 text-left">';
		$packagetypeVal = "NA";
		if(!empty($studentData->package_type)) {  
		$Pname = array();
		$packages = PackageType::getPackageType();
		$package_type = $studentData->package_type;
		if(!empty($package_type)){
		$package_type = explode(',',$package_type);
		}
		$StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();
		foreach ($StudentPD  as $row){ 
			$Pname[] = $packages[$row->id]; 
		} 
		$packagetypeVal = implode(',',$Pname);
		}  
		/*$packagetypeVal = "NA";
		if(!empty($studentData->package_type)) {  
		$Pname = array();
		$packages = PackageType::getPackageType();
		$package_type = $studentData->package_type;
		if(!empty($package_type)){
			$package_type = explode(',',$package_type);
		}
		$StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();
		foreach ($StudentPD  as $row){ 
			$Pname[] = $packages[$row->id]; 
		} 
		$packagetypeVal = implode(',',$Pname);
		}  */
		$content.= $packagetypeVal;
		$content.='</div>
		<div class="col-sm-4 text-left">';
		 $qualificationVal = "NA";
			if(!empty($studentData->qualification) || $studentData->qualification!=0) { 
			if($studentData->qualification!=6){
				$qualification = Commondata::qualificationList();
				$qualificationVal = $qualification[$studentData->qualification];  
			}else{
			$qualificationVal = $studentData->others; 
			}
			} 
			$content.= $qualificationVal;
		    $content.='	 </div> 
			</div>';
			$content.='
			<div class="row ">
			<div class="col-sm-4 text-left"> <strong>Country of Residence </strong></div>
			<div class="col-sm-4 text-left"> <strong>Contact Number </strong></div>
			<div class="col-sm-4 text-left"> <strong>How did you come to know about GTU? </strong></div>
			</div>';
			$content.='<div class="row " style="margin-bottom: 10px;"> 
			<div class="col-sm-4 text-left">';
			$countryname = 'NA';
			$countryname = Country::find()->select('name')
			->where(['=','id', $studentData->country]) 
			->one();
			$content.= $countryname->name;
			$content.='	</div> 
			<div class="col-sm-4 text-left">
			';
			$content.= "+".$studentData->code.$studentData->phone; 
			$content.='</div>   
			<div class="col-sm-4 text-left">';
			  $diduknowVal = 'NA';
			if(!empty($studentData->knowus)){
				if($studentData->knowus!=8){
					$diduknow = Commondata::diduknow();
					 $diduknowVal =$diduknow[$studentData->knowus];
				}else{
					 $diduknowVal = $studentData->knowus_others;
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


	echo $content;
 ?>   
<div class="student-profile-main">
    
    <div class="dashboard-detail"> 
 	<h4><?= Html::encode($title_2) ?></h4>
	 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'columns' => [
		 ['class' => 'yii\grid\SerialColumn'], 
		 
	[	'attribute' => 'status',		 
		'label' => 'Response',
		'value' => function ($model) {
                                $status = $model->status;
                                if($status==0) { return 'New Entry'; }
                                else if($status==1) { return 'Active'; }
                                else if($status==2) { return 'Inactive'; }
                                else if($status==3) { return 'Access Sent'; }
                                else if($status==4) { return 'Subscribed'; }
                                else if($status==5) { return 'Other Followup'; }
                                else if($status==6) { return 'Closed'; }
                                
                            },
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],	
	[	'attribute' => 'created_at',		 
		'label' => 'Created Date', 
		'value' => function($model){  
                                    $created_at = $model->created_at;
                                    $newdt = strtotime($created_at); 
                                    return date('d-M-Y', $newdt);  
                                }, 		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],	 
	[	'attribute' => 'comment',		 
		'label' => 'Followup Comments',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:500px; white-space: normal; ']
		 
	],
	[	'attribute' => 'comment_date',		 
		'label' => 'Comment Date',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],

	[	'attribute' => 'mode',		 
		'label' => 'Mode of contact',  
		'value' => function ($model) {
                                 $mode = $model->mode;
                                 if($mode==1) { return 'Telephone'; }
                                 else if($mode==2) { return 'Email'; }
                                 else if($mode==3) { return 'Face to face'; }
                            },		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	
	[	'attribute' => 'next_followup',		 
		'label' => 'Next followup date',
		'value' => function ($model) {
                                  $next_followup = $model->next_followup;
                                 if($next_followup=='') { return 'NA'; }
                                 else { return $next_followup; }
                                
                            },  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	[	'attribute' => 'next_follow_comment',		 
		'label' => 'Next Followup Comment',  		
		 'filter'=>false,
		 'value' => function ($model) {
                                  $next_follow_comment = $model->next_follow_comment;
                                 if($next_follow_comment=='') { return 'NA'; }
                                 else { return $next_follow_comment; }
                                
                            },
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],

	
	[	'attribute' => 'reason_code',		 
		'label' => 'Reason code',  
		'value' => function ($model) {
                                  $reason_code = $model->reason_code;
                                 if($reason_code==1) { return 'Not Interested'; }
                                 else if($reason_code==2) { return 'Price not reasonable'; }
                                 else if($reason_code==3) { return 'Not Now'; }
                                 else { return 'NA'; }                                
                            },		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],

	[	'attribute' => 'other_follow',		 
		'label' => 'Other Followup',  
		'value' => function ($model) {
                                  $other_follow = $model->other_follow;
                                 if($other_follow) { return $other_follow; }
                                 else { return 'NA'; }                                
                            },		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],

	[	'attribute' => 'created_by',		 
		'label' => 'created by',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	
	 
	
 
	   ['class' => 'yii\grid\ActionColumn',
			'visible' => false,
			],
			  
			
        ],
    ]); ?>  
                
            </div>
        </div>
    </div>
</div>
</div>
</div>
