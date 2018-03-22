<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Majors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="majors-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Majors</div>
                <div class="panel-body">
				    <?= $form->field($model, "degree_id")->dropDownList($degree, ['prompt' => 'Select Discipline...']) ?>

				    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				    <div class="form-group">
				        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				    </div>
				    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
