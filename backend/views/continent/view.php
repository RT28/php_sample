<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\Models\Continent */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Continents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar'; 
?>
<div class="continent-view">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?php $form = ActiveForm::begin(); ?>
 
	<?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly' => true]) ?>
	<?php 
	 /******* updated multiple select functionality *****/
	$countries= explode(",",$model->countries);
	 ?>
	 
	<select id="continent-countries" class="form-control" name="Continent[countries][]" selected="selected" multiple="true"  readonly="readonly"> 
		<?php foreach($countriesList as $key => $getres):?>
			<option value="<?php echo $key?>" <?php if(in_array($key, $countries)){?> selected="selected"<?php }?> ><?php echo $getres?></option>
			<?php
			endforeach;
			?>
		</select>
		
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>