<?php 
use common\models\PackageType;
$packages = PackageType::getPackageType(); 
?>

Dear <?= $user; ?>,<br/> <br/>  

You were contacted by our GoToUniversity consultant <?= $consultantname; ?>. 
To move ahead with admission process, please subscribe to our <?= $packages[$packagestype];?> 
and interact with your assigned consultant who is committed to help you get into your dream university. <?= $link; ?>
<br/> <br/> 
Please click on the following link to subscribe  
<a href="<?= $link; ?>"><?= $packages[$packagestype];?></a> Package.
<br/><br/><br/> 
Regards,<br/>
GoToUniversity Team  
