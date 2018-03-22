<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\AdmissionWorkflow;
use yii\helpers\Url;

$this->title = 'Univeristy Applications';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'index';
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
                <div class="container">
                    <div class="row">
                        <div class="student-univeristy-application-index">

                            <h1><?= Html::encode($this->title) ?></h1>
                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    //'id',
                                    //'student_id',
                                    //'consultant_id',
                                    //'consultant_id',
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
                                    // 'summary:ntext',
                                    // 'created_by',
                                    // 'created_at',
                                    // 'updated_by',
                                    // 'updated_at',

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>