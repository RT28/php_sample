<?php
    use yii\helpers\Html;                
    use dosamigos\ckeditor\CKEditor;
?>

<div class="row">
    <div class="col-xs-12">
        <?= Html::activeLabel($model, 'description'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->description);
        echo '<br><br>';
        ?>
    </div>
   
    <div class="col-xs-12">
         <?= Html::activeLabel($model, 'achievements'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->achievements);
		 echo '<br><br>';
		 ?>
    </div>
	 
	 <div class="col-xs-12">
         <?= Html::activeLabel($model, 'application_requirement'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->application_requirement);
		 echo '<br><br>';?>
    </div>
	
	 <div class="col-xs-12">
         <?= Html::activeLabel($model, 'fees'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->fees);
		 echo '<br><br>';?>
    </div>
	
	 <div class="col-xs-12">
         <?= Html::activeLabel($model, 'deadlines'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->deadlines);
		 echo '<br><br>';?>
    </div>
	
		 <div class="col-xs-12">
         <?= Html::activeLabel($model, 'cost_of_living_text'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->cost_of_living_text);
		 echo '<br><br>';?>
    </div>
	
	 <div class="col-xs-12">
         <?= Html::activeLabel($model, 'accommodation'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->accommodation);
		 echo '<br><br>';?>
    </div>
	<div class="col-xs-12">
         <?= Html::activeLabel($model, 'success_stories'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->success_stories);
		 echo '<br><br>';?>
    </div>
    <div class="col-xs-12">
         <?= Html::activeLabel($model, 'info_for_consultant'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->info_for_consultant);
         echo '<br><br>';?>
    </div>
	<div class="col-xs-12">
         <?= Html::activeLabel($model, 'application_web_link'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->application_web_link);
         echo '<br><br>';?>
    </div>
</div>