<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\AdmissionWorkflow;
use common\components\Roles;
use frontend\models\UserLogin;
use backend\models\EmployeeLogin;
use partner\models\PartnerLogin;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Univeristy Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-univeristy-application-view">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

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

                    <?php
                        $role = $model->updated_by_role;
                        $user = $model->updated_by;
                        $name = "";
                        $user_model;
                        if($role == Roles::ROLE_SRM) {
                            $user_model = EmployeeLogin::findOne($user);
                            $temp = $user_model->employee;
                            $name = $temp->first_name . ' ' . $temp->last_name;
                        } elseif($role ==  Roles::ROLE_STUDENT) {
                            $user_model = UserLogin::findOne($user);
                            $temp = $user_model->student;
                            $name = $temp->first_name . ' ' . $temp->last_name;
                        }elseif($role == Roles::ROLE_UNIVERSITY) {
                            $user_model = PartnerLogin::findOne($user);
                            $temp = $user_model->partner;
                            $name = $temp->first_name . ' ' . $temp->last_name;
                        } elseif($role == Roles::ROLE_CONSULTANT) {
                            $user_model = PartnerLogin::findOne($user);
                            $temp = $user_model->partner;
                            $name = $temp->first_name . ' ' . $temp->last_name;
                        }
                    ?>
                    <?php
                        $user = $model->student->student;
                        $user = $user->first_name . ' ' . $user->last_name;
                    ?>
                    
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'label' => 'Student',
                                'value' => $user
                            ],
                            [
                                'label' => 'University',
                                'value' => $model->university->name
                            ],
                            [
                                'label' => 'Course',
                                'value' => $model->course->name
                            ],
                            'start_term',
                            [
                                'label' => 'Status',
                                'value' => AdmissionWorkflow::getStateName($model->status)
                            ],
                            'remarks',
                            [
                                'label' => 'Updated By',
                                'value' => $name
                            ]            
                        ],
                    ]) ?>

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
