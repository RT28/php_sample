<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\PackageLimitType;


/* @var $this yii\web\View */
/* @var $model common\models\StudentPackageDetails */
$this->context->layout = 'profile';
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Package Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-package-details-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'student_id',
        [
            'label'=>'Package Type',
            'attribute' => 'package_type_id',
            'value'=> $model->packagetype->name,
        ],
        [
            'label'=>'Package Subtype',
            'attribute' => 'package_subtype_id',
            'value'=> $model->packageSubtype->name,
        ],
        [
            'label'=>'Package Offerings',
            'attribute' => 'package_offerings',
            'value'=> $packageOfferings,
        ],
        [
            'label'=>'Limit Pending',
            'attribute' => 'limit_pending',
            'value' =>  $model->limit_type.' '.PackageLimitType::getPackageLimitTypeName($model->limit_pending),
        ],
        ],
    ]) ?>

</div>
