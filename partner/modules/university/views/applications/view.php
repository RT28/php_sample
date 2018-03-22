<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\AdmissionWorkflow; 


/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */


$name = $model->student->student->first_name . ' ' . $model->student->student->last_name;
$nationality = $model->student->student->nationality;
 
$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Student Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
    ?>
<div class="student-univeristy-application-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
            $state_details = AdmissionWorkflow::getStateDetails($model->status);
            if($state_details) {
                $html = '';
                if (array_search(Yii::$app->user->identity->role_id, $state_details['roles']) !== false) {                            
                    $actions = $state_details['actions'];                            
                    foreach($actions as $action) {
                        $html = $html . '<button type="button" class="btn btn-info action-buttons" data-toggle="modal" data-target="#remarks" data-model="'.$model->id.'" data-state="'.$model->status.'">'.$action.'</button>';
                    }
                }
                echo $html;
            }
        ?>
    </p>

<div class="basic-details"> 
<div class="row address"> 
<div class="col-sm-6">
<p><strong>Student : </strong><?php echo $name;?></p>
<p><strong>Nationality : </strong><?php echo $nationality;?> </p> 
<p><strong>Start Term : </strong><?php echo $model->start_term;?> </p> 
<p><strong>Status : </strong> <?php echo  AdmissionWorkflow::getStateName($model->status);?></p>
<p><strong>Remarks : </strong><?php echo $name;?> </p>
</div>
<div class="col-sm-6"> 
<p><strong>University : </strong><?php echo $model->university->name;?></p>
<p><strong>Course Name : </strong><?php echo $model->course->name;?></p>
 
<p><strong>Summary : </strong><?php echo $model->summary;?> </p></div>
</div>
</div>

    

    <!-- Modal -->
    <div class="modal fade" id="remarks" tabindex="-1" role="dialog" aria-labelledby="remarks">
        <div class="modal-dialog rankings-modal" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="remarks">Remarks</h4>
            </div>
            <div class="modal-body">           
                <textarea id="txt-remarks" rows="6" style="width: 100%;"></textarea>
            </div>
            <div class="modal-footer">        
                <button type="button" class="btn btn-primary" id="btn-ok">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Cancel</button>
            </div>
            </div>
        </div>
    </div>
</div>
