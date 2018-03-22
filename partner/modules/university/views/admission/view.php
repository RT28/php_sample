<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Others;
use common\models\DegreeLevel;
use common\models\UniversityCourseList;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityAdmission */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'University Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';

$Lvalue = "";

	$array = explode(',',$model->intake) ;
	$CModel = Others::find()->where(['=', 'name', 'intake'])->one();
	$temp = explode(',', $CModel->value);
	$Llist = array();
	$Lvalue = '';
	foreach($temp as $key => $d){
		if(in_array($key,$array)){
			 array_push($Llist, $d);
		}
	}
	if(count($Llist)>0){
		$Lvalue = implode(",",$Llist);
	}

 $DLVal= "";
	$DegreeLevel = DegreeLevel::find()->where(['id'=>$model->degree_level_id])->one();
	if(isset($DegreeLevel)){
		if(!empty($DegreeLevel->name)){
		  $DLVal = $DegreeLevel->name;
		}
	}

	$CVal = "";
	if($model->course_id==0){ $CVal = "All Programs";}else{
$UniversityCourseList = UniversityCourseList::find()->where(['id'=>$model->course_id])->one();
	if(isset($UniversityCourseList)){
		if(!empty($UniversityCourseList->name)){
		  $CVal = $UniversityCourseList->name;
		}
	}

	}

?>
<div class="university-admission-view">

    <h1><?= Html::encode($this->title) ?></h1>



	<div class="basic-details">
<div class="row address">
   <div class="col-sm-6">
   <p><strong>Degree Level:</strong> <?=   $DLVal?></p>
   <p><strong>Program:</strong> <?=  $CVal ?></p>
   <p><strong>Start Date:</strong> <?=  $model->start_date ?></p>
   <p><strong>End Date:</strong> <?=  $model->end_date ?></p>
   <p><strong>Term</strong>   <?= $Lvalue; ?></p>
   <p>
       <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-blue']) ?>
       <?= Html::a('Delete', ['delete', 'id' => $model->id], [
           'class' => 'btn btn-danger',
           'data' => [
               'confirm' => 'Are you sure you want to delete this item?',
               'method' => 'post',
           ],
       ]) ?>
   </p>
	</div>

	    <div class="col-sm-6">
	</div>

</div>
</div>


</div>
