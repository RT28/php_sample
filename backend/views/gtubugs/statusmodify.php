<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Bugs;



/* @var $this yii\web\View */
/* @var $model backend\models\Bugs */

//$this->title = $model->gt_id;
//$this->params['breadcrumbs'][] = ['label' => 'Dev Dashboard', 'url' => ['devdashboard']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div  class="bugs-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php if ($this->context->action->id == 'resolved') {

            echo $form->field($model, 'gt_status')->dropDownList(
                          ['Resolved'=>'Resolved','Duplicate'=>'Duplicate'],['prompt'=> 'select'],['style'=>'width:110px']);
      }elseif($this->context->action->id == 'verified'){
            echo $form->field($model, 'gt_status')->dropDownList(
                          ['Verified'=>'Verified','Open'=>'Re-open'],['prompt'=> 'select'],['style'=>'width:110px']);     
    }elseif($this->context->action->id =='close'){
            echo $form->field($model, 'gt_status')->dropDownList(
                          ['Close'=>'Close','Duplicate'=>'Duplicate'],['prompt'=> 'select'],['style'=>'width:110px']);     
    }elseif($this->context->action->id =='admin'){
            echo $form->field($model, 'gt_status')->dropDownList(
                          ['Open'=>'Re-open','Resolved'=>'Resolved','Verified'=>'Verified','Close'=>'Close','Duplicate'=>'Duplicate'],['style'=>'width:110px']);     
    }
    echo $form->field($model, 'gt_summary')->textarea(['rows' => 3,'value'=>'','style'=>'width:400px']);
    ?>
 
 <div class="form-group">
    <?php if ($this->context->action->id == 'resolved'){
            echo Html::submitButton('Submit',[ 'action' => 'bugs/resolved','class' => 'btn btn-primary']);
      }elseif($this->context->action->id == 'verified'){
            echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);     
    }elseif($this->context->action->id =='close'){
            echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);     
    }elseif($this->context->action->id =='admin'){
            echo Html::submitButton('Submit', ['class' => 'btn btn-primary']);     
    }
      ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
