<?php
    use kartik\file\FileInput;
    use yii\helpers\Url;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
	
	$this->title = 'Upload Programs';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>

<?php  
if(isset($modelerror)):
if(sizeof($modelerror) != 0) : ?>
<div class="alert alert-danger" role="alert"> 
<ul>
<?php 
//$totalcount = count($data); 
$count = 1;
foreach($modelerror as $value) {
   
   $data = $value->getErrors(); 	
   
	 foreach($data as $key => $value) {
		 ?>
		 <li>
	<?php
	echo $key. " : ". $value[0] . "";
	 ?>
	  </li>
	 <?php
		}
$count++;		
	} 
	 
?> 
<ul>
Total number of rows : <?php echo count($modelerror);?>
</div>

<?php

endif;
endif; ?>

<?php if(isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= $error; ?>
    </div>
<?php  endif; ?>

<?php if(isset($success)): ?>
    <div class="alert alert-success" role="alert">
        <?= $success; ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-11">
                <?=
                    FileInput::widget([
                        'name' => 'programs',
                    ]);
                ?>
            </div>
            <div class="col-xs-1">
                <div class="form-group text-center">
                    <?= Html::submitInput('Submit', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>