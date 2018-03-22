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
        echo  strip_tags($model->achievements);?>
    </div>
</div>