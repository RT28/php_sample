<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RankingType */
/* @var $form yii\widgets\ActiveForm */
$type = array('source'=>'Source','subject'=>'Subject',);
?>

<div class="ranking-type-form">

    <?php $form = ActiveForm::begin(); ?>
    	<div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Ranking Type</div>
                <div class="panel-body">
				    <?= $form->field($model, 'type')->dropDownList($type, ['prompt' => 'Select Type...']) ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				    <div class="form-group">
				        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				    </div>
				</div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
