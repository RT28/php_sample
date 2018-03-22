Dear <?= $name; ?>,<br/><br/>

Thank you once again for choosing us as a partner in your journey for higher education. <br/><br/>
<?php if(isset($oldconsultant)){ ?>
Cosultant <b><?= $oldconsultant; ?></b> have been replaced with our new consultant <b><?= $consultant; ?></b>.
You will hear from your assigned consultant shortly. <br/><br/>
<?php }else{ ?>
You has been assigned to our <b><?= $agency; ?></b> Agency.<br/><br/>
<?php if(!empty($consultant)){ ?>
Please note that <b><?= $consultant; ?></b> has been assigned to you as your consultant. 
You will hear from your assigned consultant shortly. <br/><br/>
<?php } ?>
<?php }?>
To know more about <?= $consultant; ?> click on the link below:<br/><br/> 
<a href="<?= $link; ?>"><?= $consultant; ?></a>
<br/><br/><br/> 



Thank you,<br/><br/>

GTU Team 