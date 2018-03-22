<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\widgets\DetailView;
use common\components\Status; 
use common\models\Country;
use common\models\Degree;

$this->title = 'Agency Profile';
$this->context->layout = 'main';
 
$degrees = '';
if(!empty($model->speciality)){
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
?>


<div class="agency-index col-xs-12">
    <div class="row">
		<div class="col-sm-6">
        <h1><?= Html::encode($this->title) ?> </h1> 
        </div>
		<div class="col-sm-6 text-right">
        <a href="?r=agency/agency/update" class="btn btn-blue">Update</a>
        </div>
		</div>
<div class="row">
<div class="col-sm-12"> 
<div class="row">
<div class="col-sm-6" > 
<p><strong>Name :</strong> <?php if($model->name) { echo $model->name;  } ?></p>
<p><strong>Establishment Year :</strong> <?php if($model->establishment_year) { echo $model->establishment_year;  } ?></p> 
<p><strong>Phone Number :</strong> +<?php if($model->mobile) { echo $model->code;?><?= $model->mobile; } ?></p>
<p><strong>Status :</strong> <?php if($model->status) { echo Status::getStatusName($model->status); } ?></p>
<p><strong>Speciality :</strong> <?php if(isset($degrees)) {echo $degrees;  } ?></p>
<p><strong>Description :</strong> <?php if($model->description) { echo $model->description;  } ?></p>
</div>
<div class="col-sm-6" > 
<p><strong>Country  :</strong> <?php if($model->country->name) { echo $model->country->name;  } ?></p>
<p><strong>State :</strong> <?php if($model->state->name) { echo $model->state->name;  } ?></p>
<p><strong>City  :</strong> <?php if($model->city->name) { echo $model->city->name;  } ?></p>
<p><strong>Zip Code :</strong> <?php if($model->pincode) { echo $model->pincode;  } ?></p>
<p><strong>Address :</strong> <?php if($model->address) { echo $model->address;  } ?></p>
</div> 
			
</div> 
</div></div>

         
</div>