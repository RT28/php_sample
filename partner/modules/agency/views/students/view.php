<?php
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\models\StudentConsultantRelation;
use common\models\StudentPartneremployeeRelation;
use yii\widgets\Pjax;
$this->context->layout = 'main'; 

$this->title = $model->first_name . ' ' . $model->last_name;
$consultant_id =  Yii::$app->user->identity->id;

$associates = StudentConsultantRelation::find()->where(['AND',['=','parent_consultant_id', $consultant_id],
['=','is_sub_consultant', 1],
['=','student_id', $model->student_id]])->all();
$showAssociates = false;
if(isset($associates) && count($associates)>0){
	$showAssociates = true;
}

$employeesList = StudentPartneremployeeRelation::find()->where(['=','consultant_id',$consultant_id])->all();
$showEmployees = false;
if(isset($employeesList) && count($employeesList)>0){
	$showEmployees = true;
}

?>

<div class="consultant-student-view col-sm-12">
    <h1><?= $this->title; ?></h1>

    <div>
<ul class="nav nav-tabs" role="tablist">
<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
<li role="presentation"><a href="#tests" aria-controls="tests" role="tab" data-toggle="tab">Test Scores</a></li>
<li role="presentation"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li> 
<li role="presentation"><a href="#packages" aria-controls="packages" role="tab" data-toggle="tab">Packages</a></li>
<li role="presentation"><a href="#programs" aria-controls="programs" role="tab" data-toggle="tab">Shortlisted Programs</a></li>
<li role="presentation"><a href="#universities" aria-controls="universities" role="tab" data-toggle="tab">Shortlisted Universities</a></li>
<li role="presentation"><a href="#tasklist" aria-controls="tasklist" role="tab" data-toggle="tab">Task List</a></li>
<li role="presentation"><a href="#meeting" aria-controls="meeting" role="tab" data-toggle="tab">Meeting History</a></li>

<?php if($showAssociates==true){ ?>
<li role="presentation"><a href="#associates" aria-controls="associates" role="tab" data-toggle="tab">Sub Consultants</a></li>
<?php }?>
<?php if($showEmployees==true){ ?>
<li role="presentation"><a href="#employees" aria-controls="employees" role="tab" data-toggle="tab">Trainer/Employee</a></li>
<?php }?>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="profile">
		<?= $this->render('_profile', [
			'model' => $model
		]); ?>
	</div>
	<div role="tabpanel" class="tab-pane" id="tests">
		<?= $this->render('_tests', [
			'model' => $model,
			'englishTests' => $englishTests,
			'standardTests' => $standardTests,
		]); ?>
	</div>
	<div role="tabpanel" class="tab-pane" id="documents">
		<?= $this->render('_documents', [
			'model' => $model,
		]); ?>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="packages">
		<?= $this->render('_packages', [
			'model' => $model,
			'packages' => $packages
		]); ?>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="programs">
		<?= $this->render('_programs', [
			'model' => $model,
			'shortlistedCourses' => $shortlistedCourses
		]); ?>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="universities">
		<?= $this->render('_universities', [
			'model' => $model,
			'shortlistedUni' => $shortlistedUni
		]); ?>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="tasklist">
		<?= $this->render('_tasklist', [
			'model' => $model,
			'taskModel' => $taskModel,
			'taskdataProvider' => $taskdataProvider,
		]); ?>
	</div>
	
	<div role="tabpanel" class="tab-pane" id="meeting">
		<?= $this->render('_meeting', [
			'model' => $model,
			'meetings' => $meeting
		]); ?>
	</div>
	
	<?php if($showAssociates==true){ ?>
	<div role="tabpanel" class="tab-pane" id="associates">
		<?= $this->render('_associates', [
			'model' => $model,
			'associates' => $associates, 
		]); ?>
	</div>
	<?php }?>
	<?php if($showEmployees==true){ ?>
	<div role="tabpanel" class="tab-pane" id="employees">
		<?= $this->render('_employees', [
			'model' => $model,
			'employees' => $employees, 
		]); ?>
	</div>
	<?php }?>
</div>
    </div>
</div>
