<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\AdmissionWorkflow;
use common\models\Student;
use common\models\UniversityCourseList;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\StudentUniversityApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Univeristy Applications';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-univeristy-application-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>


    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'student_id',
            //'srm_id',
            //'consultant_id',
            [
                'label' => 'Student',
                'attribute'=>'studentDetails',
                'value' => 
                function ($model) {
                    $student = Student::findOne(['student.student_id'=>$model->student_id]);
                    $name = $student->first_name . ' ' .$student->last_name ;
                    return isset($name) ? $name : 'not assigned';
                },
            ],
            [
                'label' => 'University',
                'attribute' => 'university_id',
                'value' => 'university.name'
            ],
            [  
                'label' => 'Course',
                'attribute' => 'course_id',
                'value' =>'course.name'
            ],
            'start_term',
             [
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function($model) {
                    return AdmissionWorkflow::getStateName($model->status);
                },
                'filter'=>Html::dropDownList('StudentApplicationSearch[status]',isset($_REQUEST['StudentApplicationSearch']['status']) ? $_REQUEST['StudentApplicationSearch']['status'] : null,AdmissionWorkflow::getStates(),['class' => 'form-control', 'prompt' => 'Select status'])
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
                'template' => '{actions}{view}',
                'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            return Url::toRoute(['admin-university/university-applications-view', 'id' => $model->id ]);
                        } 
                        else if($action === 'update') {
                            return Url::toRoute(['admin-university/university-applications-update', 'id' => $model->id ]);
                        } 
                },
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
