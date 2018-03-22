<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\AdmissionWorkflow;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentUniversityApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Univeristy Applications';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-univeristy-application-index">
<div class="employee-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Student Univeristy Application', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Student',
                        'value' => function($model) {
                            return $model->student->student->first_name . ' ' . $model->student->student->last_name;
                        } 
                    ],            
                    [
                        'label' => 'University',
                        'attribute' => 'university.name' 
                    ],
                    [
                        'label' => 'Course',
                        'attribute' => 'course.name'
                    ],
                    'start_term',
                    [
                        'label' => 'Status',
                        'value' => function($model) {
                            return AdmissionWorkflow::getStateName($model->status);
                        }
                    ],
                    'remarks',            
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'actions' => function ($url, $model, $key) {
                                $state_details = AdmissionWorkflow::getStateDetails($model->status);
                                if($state_details) {
                                    $html = '';
                                    if (array_search(Yii::$app->user->identity->role_id, $state_details['roles']) !== false) {                            
                                        $actions = $state_details['actions'];                            
                                        foreach($actions as $action) {
                                            $html = $html . '<button type="button" class="btn btn-info action-buttons" data-toggle="modal" data-target="#remarks" data-model="'.$key.'" data-state="'.$model->status.'">'.$action.'</button>';
                                        }
                                    }
                                    return $html;
                                }
                            },
                        ],
                        'template' => '{actions}{view}{update}'
                    ],
                ],
            ]); ?>
            </div>
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