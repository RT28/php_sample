<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\models\StudentPackageDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-package-details-form col-xs-12 col-sm-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package_type_id')->dropDownList($packageType, ['prompt' => 'Select Package Type...', 'id' => 'package-type']) ?>
    
    <?= $form->field($model, 'package_subtype_id')->widget(DepDrop::classname(), [
        'options' => ['id' => 'package-subtype'],        
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'depends' => ['package-type'],
            'placeholder' => 'Select Package Sub-type...',
            'url' => Url::to(['/student-package/dependent-package-subtypes'])
        ]
        ]);
    ?>
    
    <?= $form->field($model, 'package_offerings')->widget(DepDrop::classname(), [
        'options' => ['id' => 'package-offerings', 'multiple' => true],        
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'depends' => ['package-type', 'package-subtype'],
            'tags' => true,
            'placeholder' => 'Select Package Offerings...',
            'url' => Url::to(['/student-package/dependent-package-offerings'])
        ]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Buy', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
