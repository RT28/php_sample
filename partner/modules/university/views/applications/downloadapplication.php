<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\AdmissionWorkflow; 


/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

 
$nationality = $model->student->student->nationality;

$this->title = $name; 
$this->context->layout = 'profile';
?>
<div class="student-univeristy-application-view">


<?php
$state_details = AdmissionWorkflow::getStateDetails($model->status);
if($state_details) {
$html = '';
if (array_search(Yii::$app->user->identity->role_id, $state_details['roles']) !== false) {                            
$actions = $state_details['actions'];                            
foreach($actions as $action) {
$html = $html . '<button type="button" class="btn btn-info action-buttons" data-toggle="modal" data-target="#remarks" data-model="'.$model->id.'" data-state="'.$model->status.'">'.$action.'</button>';
}
}
echo $html;
}
?>



<div class="basic-details"> 
<div class="row address"> 
<div class="col-sm-12">

<h3>About You</h3>
<label>Your Name : </label>
<label>Suffix : </label>
<label>First Name : </label><?php echo $model->student->student->first_name;?>
<label>Middle Name : </label> 
<label>Last Name : </label><?php echo $model->student->student->first_name;?> <br/>

Have you used any other names on your records or documents?	<br/>
Yes<br/>
<label>Name : </label> <br/>

Where were you born? <br/>
<label>DOB : </label> 
<label>Country : </label><?php echo $nationality;?>  <br/> 
<label>City : </label> <br/>
Which term are you applying for?<br/> 
<label>Start Term : </label><?php echo $model->start_term;?>  <br/> 
<label>Status : </label> <?php echo  AdmissionWorkflow::getStateName($model->status);?> <br/>
<label>Remarks : </label><?php echo $name;?>   <br/>
<label>University : </label><?php echo $model->university->name;?> <br/>
<label>Course Name : </label><?php echo $model->course->name;?>  <br/>
<label>Summary : </label><?php echo $model->summary;?>  <br/>
 
 
<label>Level</label>	<br/>
<label>Are you applying as a : </label> 
<label>Freshman:</label>  	<br/>
<label>Confirm Your Choice	<br/></label> 

<label>Transfer:  	</label><br/>
<label>Select the statement that best describes you. </label> <br/>

<label>Your Address:  	</label><br/>
<label>What is your current mailing address?</label><br/>	
<label>Country</label><br/>
<label>State/Union Territory</label><br/>
<label>City</label><br/>
<label>Street Address</label><br/>
<label>Apt/Suite/Unit/Bldg/Route # (optional)</label><br/>
<label>Postal Code</label><br/>

<label>If you have a different permanent address, please enter it below.</label><br/>
<label>Your Address:</label>
<label>What is your current mailing address?</label><br/> 	
<label>Country</label><br/>
<label>State/Union Territory</label><br/>
<label>City</label><br/>
<label>Street Address</label><br/>
<label>Apt/Suite/Unit/Bldg/Route # (optional)</label><br/>
<label>Postal Code</label><br/> 

<label>Your Phone Number</label><br/> 
<label>What is your phone number?</label><br/>
<label>United States</label><br/>	
<label>International</label><br/>
<label>Primary Phone</label><br/>
<label>Phone Type</label><br/>	
<label>Cell/Mobile --- Home/Other</label><br/>
<label>United States</label><br/>
<label>International</label><br/>
<label>Alternate Phone</label><br/>
<label>Phone Type<label><br/>
<label>Cell/Mobile --- Home/Other</label><br/> 
<label>Citizenship : </label> 
<label> Country</label><br/>  
<label>Visa Staus : </label><br/>	  
<label>Current Visa status 	</label><br/> 
<label>Visa for which you have applied or plan to apply:</label><br/>  
<label>Social Security Number</label><br/>
<label>If you have a Social Security Number (SSN) or Individual Taxpayer Identification Number (ITIN), 
please enter it.</label>	
<label>Re-enter your Social Security Number (SSN) or Individual Taxpayer Identification Number (ITIN).	</label>
<label>What will your citizenship status be on the date you submit this application?</label><br/>

<h3>Personal Information :</h3>
<label>What language did you learn to speak first?</label> <br/> 
<label>Select Language	</label><br/>
<label>If you chose "Other", please specify</label><br/> 
<label>U.S. Military Service: </label><br/> 
<label>Select the statement that best describes you. </label><br/> 
<label>When I enroll at the University of California, I expect to be:</label><br/> 
<label>Check if you are a dependent of a U.S. military veteran or service member.</label>
<label>Foster Care </label><br/> 
<label>Check if you have ever been in foster care (e.g., foster home, group home or placed with a relative by the court).</label><br/> 

<h3>Parent Information :</h3>
<label>Parent 1/Father/Legal Guardian</label> <br/> 
<label>Family Size & Income	</label><br/>
<label>Do you receive financial support from a parent/legal guardian? For example, can a parent/legal guardian claim you as a dependent?</label>
<label>This Year (2016)</label><br/>	
<label>Yes   No</label><br/>
<label>Last Year (2015)</label><br/>	
<label>Yes   No</label><br/>

<label>To be considered an independent applicant, at least one of the following statements must be true:</label><br/>
<label>I will be at least 24 years old at the time the academic term begins.</label><br/>
<label>I am married, or I have dependents for whom I am legally responsible.</label><br/>	
<label>I was in foster care, or I was a dependent or ward of the Court, or both my parents were deceased, at any time since I turned 13.	
I am a veteran of a branch of the U.S. military</label><br/>

<label>How many people are in your family?</label><br/>
<label>Please include yourself, your spouse (if applicable), and any other dependents in your household.</label><br/>
<label>This Year (2016)</label><br/>

<label>Please include yourself, your parents, and any other dependents in your household.</label><br/>
<label>Last Year (2015)</label><br/>

<label>Are you a single parent?</label><br/>	
<label>This Year (2016)</label><br/>
<label>Yes   No</label>	

<label>Is your family headed by a single parent?</label><br/>	
<label>Last Year (2015)</label><br/>
<label>Yes   No</label><br/>

<label>What is your estimated total household income to support the family size above?</label><br/>
<label>This Year (2016)</label><br/>
<label>Last Year (2015)</label><br/>
 
<label>Current Job Category </label>
<label>Current Job Title</label><br/>   

<label># of Years</label>
<label>Previous Job Category</label><br/>  
<label>Previous Job Title</label><br/>  


<label># of Years</label>
<label>Highest Level of Formal Education</label><br/>    


 
<label>School/College Information</label><br/>
<label>Enter Your High School. (Multiple Entries)</label><br/>	
<label>In U.S.   Outside the U.S.</label><br/>	
<label>If Outside U.S - Mention Country	</label><br/>
<label>School Name</label><br/>	
<label>State	</label><br/>
<label>Curriculam</label><br/>	
<label>Grading System</label><br/>	

<label>During what dates did you attend this high school?</label><br/>	
<label>Start date:</label><br/>
<label>Month</label><br/>
<label>Year (yyyy)</label><br/>
<label>End date:</label><br/>
<label>Month</label><br/>
<label>Year (yyyy)</label><br/>	

<label>What grades did you attend here?</label><br/>	
<label>Select the academic year(s) and the grade(s) attended. If you repeated a grade, you must 
indicate each academic year(s) of attendance for the repeated grade level.</label><br/>	
<label>Subject</label><br/>	
<label>Academic Year (2017-18)</label><br/>	
<label>Grades (9th, 10th, 11th, 12th)</label><br/>	
<label>Marks/Grades</label><br/>	
<label>Term</label><br/>
<label>Language</label><br/>	

<label>Colleges Attended</label><br/>	
<label>Have you ever attended university/college.</label><br/>	
<label>Yes   No	</label><br/>
<label>If Yes, Repeat the same Structure as school info	</label><br/>

<label>Other Academic History</label><br/>	
<label>Provide a box for writing free text</label><br/>	

<label>Activities</label><br/>	
<label>Activity Category - Educational Prep Programs, Volunteer & Community Service, Awards & Honors, Extracurricular Activities	
<label>Name of the Activity</label><br/>	
<label>Description - 150 words</label><br/>	
<label>Year</label><br/>
<label>Grade</label><br/>	
<label>For how many hours</label><br/>	
<label>For how many weeks</label><br/>	


<label>Test Scores</label><br/>	
<label>ACT, SAT, UKCAT, BMAT, LNAT, GRE, GMAT,MCAT etc</label><br/>	
<label>College Board Advance Placement (AP) Exams</label><br/>	
<label>TOEFL or IELTS</label><br/>	
<label>Expand and show a short form to fill in the details</label><br/> 	


<label>Verified Information</label><br/>	
<label>Demographic - Gender/Sexual Orientation & U.S. DOE Ethnicity</label><br/>	
<label>Sexual Orientation:Heterosexual or straight</label><br/>	
<label>Gender Identity:Female</label><br/>	
<label>Birth Gender:Female</label><br/>	
<label>Hispanic/Latino? No</label><br/>	
<label>USDOE Ethnicity: Asian</label><br/>	
<label>Demographic - UC Ethnicity/Ancestry</label><br/>	
<label>UC Ethnicity/Ancestry: Asian Indian</label><br/>	
<label>State of Legal Residence	</label><br/>
<label>Father/Parent 1 U.S. Citizen: No  Yes</label><br/>	
<label>Mother/Parent 2 U.S. Citizen: No  Yes</label><br/>	
 

</div>
</div>
</div>
</div> 