<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\Models\Continent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="continent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
 
	<?php $id = isset($_GET['id']);
	if($id!=""){
	 /******* updated multiple select functionality *****/
	 $countries= explode(",",$model->countries);
	 //print_r( $countriesList);
	 ?>
		<div class="form-group field-continent-countries">
		<label class="control-label" for="continent-countries">Countries</label>
		
		<select id="continent-countries" class="form-control" name="Continent[countries][]" selected="selected" multiple="true" > 
		<?php foreach($countriesList as $key => $getres):?>
			<option value="<?php echo $key?>" <?php if(in_array($key, $countries)){?> selected="selected"<?php }?> ><?php echo $getres?></option>
			<?php
			endforeach;
			?>
		</select>  
		</div>
	  <?php }else {?>
	<?= $form->field($model, "countries")->dropDownList($countriesList,['multiple' => 'true','selected' => 'selected']);
	  } ?>
	  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
