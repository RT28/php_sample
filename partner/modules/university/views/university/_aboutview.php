<?php
    use yii\helpers\Html;
    use dosamigos\ckeditor\CKEditor;
?>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>About Us:</h3>
<p> <?php  echo  strip_tags($model->description); ?></p>
</div>
</div>
</div>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>Application Requirements:</h3>
<p> <?php  	echo  strip_tags($model->application_requirement);?></p>
</div>
</div>
</div>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>Fees:</h3>
<p> <?php  	echo  strip_tags($model->fees);?></p>
</div>
</div>
</div>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>Deadlines:</h3>
<p> <?php  	echo  strip_tags($model->deadlines);?></p>
</div>
</div>
</div>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>Cost of Living:</h3>
<p> <?php  	echo  strip_tags($model->cost_of_living_text);?></p>
</div>
</div>
</div>

<div class="basic-details">
<div class="row address">
<div class="col-sm-12">
<h3>Accommodation:</h3>
<p> <?php  	echo  strip_tags($model->accommodation);?></p>
</div>
</div>
</div>
