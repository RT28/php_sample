<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\PackageLimitType;

/* @var $this yii\web\View */
/* @var $model frontend\models\StudentPackageDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Package Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-package-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            [
                'label' => 'Package Type',
                'value' => $model->packageType->name
            ],
            [
                'label' => 'Package Sub-Type',
                'value' => $model->packageSubtype->name
            ],
            [
                'label' => 'Package Offerings',
                'value' => $offerings
            ],
            [
                'label' => 'Package Sub-Type',
                'value' => PackageLimitType::getPackageLimitTypeName($model->packageSubtype->limit_type)
            ],
            'limit_pending'            
        ],
    ]) ?>

</div>
