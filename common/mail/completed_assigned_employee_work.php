<?php 
use yii\helpers\Url; 
?>
Dear <?= $data['mainconsultant']; ?>,<br/><br/>

The following task assigned by you to <?= $data['studentname']; ?> for the student has been completed.<br/>
 
<a href="<?=Url::to(['partner/web/index.php?r=consultant/tasks/index', true])?>"> Please click here to visit your dashboard for further details. </a>
 
 
<br/><br/>
Thank you,<br/><br/>
GoToUniversity Team