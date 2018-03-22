<?php
use common\models\Country;
$CountryVal = Country::find()->where(['id'=>$data['country']])->one();
if(!empty($CountryVal->name)){
					$CountryVal = $CountryVal->name;
				 }else{
					 $CountryVal = "";
				 }
?>
Hi,<br/><br/>

New consultant enquiry received,  <br/><br/>
 
Name :  <?= $data['user']; ?><br/>
Email :  <?= $data['email']; ?><br/>
Phone :  +<?= $data['code']; ?><?= $data['phone']; ?><br/>
Country : <?= $CountryVal; ?></br>
Message :  <?= $data['message']; ?><br/>
<br/><br/><br/>

Regards, <br/>
Gotouniversity