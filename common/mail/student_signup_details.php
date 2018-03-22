<?php 
use yii\helpers\Url;   
use backend\models\SiteConfig; 
use common\models\Country;
$CountryVal = Country::find()->where(['id'=>$model->country])->one();
if(!empty($CountryVal->name)){
					$CountryVal = $CountryVal->name;
				 }else{
					 $CountryVal = "";
				 }
?>


Hi,

New student has signed up with gtu.<br>

Name  : <?= $model->first_name .' '. $model->last_name?> <br>
Email : <?= $model->email ?> <br>
Phone :  +<?= $model->code ?><?= $model->phone ?><br/>
Country :  <?= $CountryVal ?><br/>

 