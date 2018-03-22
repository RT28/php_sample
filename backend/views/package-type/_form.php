<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PackageType */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="package-type-form col-xs-12 col-sm-6">-->
<div class="package-type-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Package Type</div>
                <div class="panel-body">

				    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				    <?= $form->field($model, 'description')->textArea(['rows' => 6]) ?>
                    <?= $form->field($model, 'name_fa')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description_fa')->textArea(['rows' => 6]) ?>
					<?= $form->field($model, 'tnc')->textArea(['rows' => 6]) ?>

				    <?= $form->field($model, 'status')->dropDownList($status, ['id' => 'package_type_status']) ?>

				    <?= $form->field($model, 'rank')->textInput() ?>

				    <div class="form-group">
				        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				    </div>
				    </div>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

</div>
