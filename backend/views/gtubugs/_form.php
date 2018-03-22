<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\GtuBugs;
use backend\models\GtuEnvironment;
use backend\models\GtuModule;
use yii\web\UploadedFile;
use kartik\file\FileInput;
use yii\bootstrap\Modal; 
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use backend\models\EmployeeLogin;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\GtuBugs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bugs-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="panel panel-default">
      <div class="panel-heading text-center"><h4> <?=$pageTitle;?></h4></div>
        <div class="panel-body">
    
      <div class="container" style="width:960px">
        <div class="col-xs-6">
    <?= $form->field($model, 'gt_subject')->textInput(['maxlength' => true,'style'=>'width:400px']) ?>

    <?= $form->field($model, 'gt_description')->textarea(['rows' => 8,'style'=>'width:400px']) ?>

    <?= $form->field($model, 'gt_type')->checkboxList(['task'=>'Task', 'bug'=>'Bug']) ?>

    <?= $form->field($model, 'gt_steptoreproduce')->textarea(['rows' => 4,'style'=>'width:400px']) ?>
    

     <?php
                if(!$model->isNewRecord){
                    Modal::begin([
                        'header' =>'<h4>Image Gallery</h4>',
                        'id' => 'modal',
                        'size' => 'modal-lg'
                    ]);

                    echo "<div id='modalContent'></div>";

                    Modal::end();
                }
            ?>
            <div class="file-preview">

           <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
           <?php
                                        if(!$model->isNewRecord){
                                    ?>
                                        <div class="gtd_form form-group">
                                            <?= Html::button('View Screenshots',['value'=>Url::to(['gtubugs/displayimage','id'=>$model->gt_id]),'class'=>'gtd_form_button','id'=>'modalButton']) ?>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
            
               <div class="col-md-7">
                <?= $form->field($model, 'gt_envid')->dropDownList(ArrayHelper::map(GtuEnvironment::find()->all(), 'gt_id',
                'gt_name' ), ['id'=>'gt_envid','prompt' => '------Select Env-----',]); ?>

   </div>
    <div class="col-md-7">
                <?php if($model->isNewRecord){ ?>
                   <?= $form->field($model, 'gt_bugmoduleid')->widget(DepDrop::classname(), [
                       'type'=>DepDrop::TYPE_SELECT2,
                       'options'=>['id'=>'gt_bugmoduleid'],
                       'pluginOptions'=>[
                       'depends'=>['gt_envid'], // the id for cat attribute
                       'placeholder'=>'------Select Module-----',
                       'url'=>  \yii\helpers\Url::to(['/gtumodule/prod'])
                       ]
                       ]);
                   ?>
                <?php }else{ ?>
                    <?= $form->field($model, 'gt_bugmoduleid')->widget(DepDrop::classname(), [
                               'data' => ArrayHelper::map(GtuModule::find()->where(['gt_id'=>$model->gt_bugmoduleid])->all(),'gt_id','gt_name'),
                               'type'=>DepDrop::TYPE_SELECT2,
                               'options'=>['id'=>'gt_bugmoduleid','placeholder'=>'------Select Module-----',],
                               'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                               'pluginOptions'=>[
                                   'depends'=>['gt_envid'],
                                   'url'=>\yii\helpers\Url::to(['/gtumodule/prod']),
                               ]
                    ]);?>
                <?php } ?>

      </div>




    </div>
          <div class="col-xs-6">
            <?= $form->field($model, 'gt_platform')->checkboxList(['PC'=>'PC', 'Mobile'=>'Mobile', 'Tablet'=>'Tablet']) ?>
         
            <?=$form->field($model, 'gt_operatingsystem')->checkboxList(
                                  ['Windows'=>'Windows','Android'=>'Android','iOS'=>'iOS']);?>


            <?=$form->field($model, 'gt_browser')->checkboxList(
                                  ['Google Chrome'=>'Google Chrome','Mozilla Firefox'=>'Mozilla Firefox','Internet Explorer'=>'Internet Explorer','Safari'=>'Safari']);?>

                  
                    <div class="col-sm-14">
                      <?= $form->field($model, 'gt_url')->textInput(['maxlength' => true]) ?>
                    </div>
            <?=$form->field($model, 'gt_severity')->dropDownList(['Low'=>'Low','Medium'=>'Medium','High'=>'High'],['style'=>'width:100px']);?>
            <?= $form->field($model, 'gt_assignto')->dropDownList(ArrayHelper::map(EmployeeLogin::find()->all(), 'username','username' ), ['id'=>'gt_assignto','prompt' => '------Select Employee-----',]); ?>

            <?= $form->field($model, 'gt_deadline')->widget(kartik\date\DatePicker::classname(),['pluginOptions'=>[ 'autoclose' => true,'format' => 'yyyy-mm-dd','todayHighlight' => true]]); ?>
          </div>
        
         </div>
           <div>

        
      <div class="form-group text-center" >
          <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

