<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\Commondata;  
use common\models\Degree;

$days = Commondata::getDay();
 
$this->title = $model->first_name;
$this->context->layout = 'admin-dashboard-sidebar';
	
	
$degrees = '';
if($model->speciality){
	  $temp = $model->speciality;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
$arr = Degree::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $degree) {
            $degrees[]= $degree['name'];
        }
	$degrees = implode(',', $degrees);
}

if($model->work_days){
	  $temp = $model->work_days;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        } 
        
        foreach($arr as $degree) {
            $getdays[]= $days[$degree];
        }
	$getdays = implode(',', $getdays);
}

/* @var $this yii\web\View */
/* @var $model common\models\consultant */

$this->title = $model->first_name.' '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Employee', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile'; 
?>
<div class="consultant-view">

    <h1><?= Html::encode($this->title) ?></h1>

   	   	     
<div class="row">
<div class="col-sm-12"> 
<div class="row">
<div class="col-sm-6" > 
<p><strong>Agency Name :</strong> <?php echo $agencies[$model->parent_partner_login_id];?></p> 
 
<p><strong>Name :</strong> <?php echo Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;?></p> 
<p><strong>Gender :</strong> <?php echo Commondata::getGenderName($model->gender);?></p> 
<p><strong>Address :</strong> <?php if($model->address) { echo $model->address;  } ?></p>
<p><strong>Pincode :</strong> <?php if($model->pincode) { echo $model->pincode;  } ?></p>
<p><strong>City  :</strong> <?php if($model->city->name) { echo $model->city->name;  } ?></p>
<p><strong>State :</strong> <?php if($model->state->name) { echo $model->state->name;  } ?></p>
<p><strong>Country  :</strong> <?php if($model->country->name) { echo $model->country->name;  } ?></p>
<p><strong>Description : </strong> <?php if($model->description) { echo $model->description;  } ?></p>
</div>
<div class="col-sm-6" > 
<p><strong>Phone Number :</strong> +<?php if($model->mobile) { echo $model->code;?>-<?= $model->mobile; } ?></p>
<p><strong>Status :</strong> <?php if($model->employee->status) { echo Status::getStatusName($model->employee->status); } ?></p>
<p><strong>Speciality :</strong> <?php if(isset($degrees)) {echo $degrees;  } ?></p>
<p><strong>Experience :</strong> <?php echo $model->experience_years.' Years '.$model->experience_months.' Months';?></p>
<p><strong>Working Hours :</strong> <?php echo $model->work_hours_start.' to '.$model->work_hours_end;?></p>
<p><strong>Working Days :</strong> <?php if(isset($getdays)) { echo $getdays;  } ?></p>
</div> 			
</div> 
</div>
</div>

</div>
