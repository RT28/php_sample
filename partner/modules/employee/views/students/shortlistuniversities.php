<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use kartik\select2\Select2; 
/**
 * var @standardTests array of students school details
 * var @form is active form.
*/


 if (isset($favuniversities)) {
        $favuni->universities = $favuniversities;
    }
	
?>
<?php $form = ActiveForm::begin( ); ?>
    <div class="col-xs-6">
       
<?= $form->field($favuni, 'universities')->widget(Select2::classname(), [
'name' => 'universities', 'data' => $universitiesList, 'maintainOrder' => true,
'options' => ['placeholder' => 'Select Universities', 'multiple' => true], ])->label('Universities List'); ?>

       
    </div>
    <div class="form-group text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-blue']) ?>
    </div>
<?php ActiveForm::end(); ?>