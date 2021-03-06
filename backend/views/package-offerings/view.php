<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Status;
use backend\models\EmployeeLogin;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\PackageOfferings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Package Offerings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
$employee =ArrayHelper::map(EmployeeLogin::find()->asArray()->all(),'id','username');

?>
<div class="package-offerings-view">
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
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'description',
                            [
                                'label' => 'Status',
                                'value' => Status::getStatusName($model->status)
                            ],
                            'time',
                            'created_at',
                            'updated_at',
                             [
                            'label'=>'Created by',
                            'attribute'=>'created_by',
                            'value'=>$employee[$model->created_by],
                            ],
                             [
                            'label'=>'Updated by',
                            'attribute'=>'updated_by',
                            'value'=>$employee[$model->updated_by],
                            ],
                        ],
                    ]) ?>
            </div>
        </div>
    </div>
</div>
