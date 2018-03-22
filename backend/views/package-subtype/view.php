<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\Status;
use common\components\PackageLimitType;

/* @var $this yii\web\View */
/* @var $model common\models\PackageSubtype */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Package Subtypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-subtype-view">
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
                        [
                            'label' => 'Package Type',
                            'value' => $model->packageType->name
                        ],
                        'name',
                        'limit_count',
                        [
                            'label' => 'Limit Type',
                            'value' => PackageLimitType::getPackageLimitTypeName($model->limit_type)
                        ],
                        [
                            'label' => 'Currency',
                            'value' => $model->currency0->iso_code
                        ],
                        'fees',          
                        [
                            'label' => 'Status',
                            'value' => Status::getStatusName($model->status)
                        ],
                        'rank',
                        [
                            'label' => 'Package Offerings',
                            'value' => $offerings
                        ],
                        'description',
                    ],
                ]) ?>
             </div>
        </div>
    </div>
</div>
