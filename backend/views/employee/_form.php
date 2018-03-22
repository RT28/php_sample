<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $state_data = []; 
    if (isset($model->state)) {
        $state_data = [$model->state => $model->state0->name];
    }
?>
<div class="employees-form">

    <?php $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"\">
                        {input}</div>\n<div class=\"\">
                        {error}</div>",
            'labelOptions'=>['class'=>''],
        ],
    ]); ?>


    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Personal Details</h3>
                </div>
                <div class="panel-body">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(),[
                        'name' => 'date_of_birth',
                         'type' => DatePicker::TYPE_INPUT,
                         'pluginOptions' => [
                         'autoClose' => true,
                         'format' => 'yyyy-mm-dd'
                     ]
                    ]);?>                  
<?php $genderList = array(['M' => 'Male', 'F' => 'Female']);?>
                    <?= $form->field($model, 'gender')->dropDownList($genderList, ['id' => 'gender']); ?>                    

                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'city')->textInput() ?>

                    <?= $form->field($model, 'country')->dropDownList($countries, ['id' => 'country','prompt'=>'Select Country']); ?>                   

                    <?= $form->field($model, 'state')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'state'],
                        'data' => $state_data,
                        'type' => DepDrop::TYPE_SELECT2,
                        'pluginOptions' => [
                            'depends' => ['country'],
                            'placeholder' => 'Select State',
                            'url' => Url::to(['/employee/dependent-states'])
                        ]
                        ]);
                    ?>           
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Authentication</h3>
                </div>
                <div class="panel-body">
                    <?= $form->field($loginmodel, 'email')->textInput() ?>
                   
					   <?= $form->field($loginmodel, 'username',['inputOptions'=>['placeholder'=>'Enter Username','class' => 'form-control']])->textInput(['maxlength' => true]) ?>					   
					    <?php if($loginmodel->isNewRecord){ ?>
                        
                        <?= $form->field($loginmodel, 'password',['inputOptions'=>['placeholder'=>'Enter Password','class' => 'form-control']])->passwordInput(['maxlength' => true]) ?>
                    <?php }?>
					
                        <?= $form->field($loginmodel, 'role_id')->dropDownList([ '1' => 'Admin', '2' => 'Editor'], ['prompt' => '----Select Role of Employee----']) ?>
					    
                </div>
            </div>
        </div>
    </div>
    <div class="form-group buttons">
        <div class="gtd_form">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
