<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\State */

$this->title = 'Update State: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'States', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="state-update">   
    <div class="container">
    <h1><?= Html::encode($this->title) ?></h1> 
        <div class="row">
            <div class="col-xs-12 col-md-12">
            <?php $form = ActiveForm::begin(['id' => 'update-state-form']); ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="panel panel-default" style="width:90%">
                            <div class="panel-heading">State</div>
                            <div class="panel-body">
                				<?= $form->field($model, 'country_id')->widget(Select2::classname(),[
                                		'data' => $countries,
                                		'options' => ['placeholder' => 'Country'],
                                		'pluginOptions' => [
                                			'allowClear' => true
                                		]
                                	])->label('Country');
                            	?>
                                <?= $form->field($model, 'name')->textInput() ?>               

                                <div class="form-group">
                                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
