<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\City */

$this->title = 'Create City';
$this->params['breadcrumbs'][] = ['label' => 'Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="city-create">
    <div class="container">
     <h1><?= Html::encode($this->title) ?></h1>   
<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>	 
        <div class="row">
        <div class="col-xs-12 col-md-12">  
        <?php $form = ActiveForm::begin(['id' => 'add-city-form']); ?>
            <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <div class="panel panel-default" style="width:90%">
                            <div class="panel-heading">State</div>
                            <div class="panel-body">
                            	<?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id']); ?>
                            	<?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
                            		'options' => ['id' => 'state_id'],
                            		'pluginOptions' => [
                            			'depends' => ['country_id'],
                            			'placeholder' => 'Select State',
                            			'url' => Url::to(['/city/dependent-states'])
                            		]
                            	]); ?>            	
                                <?= $form->field($model, 'name')->textInput() ?>               

                                <div class="form-group">
                                    <?= Html::submitButton('Create', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
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
