

Dear <?= $user; ?>,<br/> <br/>  

Hope you are doing well.<br/> <br/> 

<br/> <br/> 
You got an Inquiry from <?= $student_name; ?>,<br/>

<p>Subject : <?= $subject; ?></p>

<?php if($model->consultant_message !=''){ ?>
<p>Consultant message : <?= $consultant_message; ?></p>
<?php } ?>

<?php if($model->student_message !=''){ ?>
<p>Student message : <?= $student_message; ?></p>
<?php } ?>

<?php if($model->father_message !=''){ ?>
<p>Father message : <?= $father_message; ?></p>
<?php } ?>
<?php if($model->mother_message !=''){ ?>
<p>Mother message : <?= $mother_message; ?></p>
<?php } ?>



<br/><br/><br/> 
Thank you,<br/>  
GTU Team<br/>  
