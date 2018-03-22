<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WebinarCreateRequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Webinar Create Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-create-request-view">
<div class="container">
<div class="col-xs-10 col-md-10">
<div class="webinar-create">

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
            //'id',
            'topic',
            'date_time',
            'author_name',
            'email:email',
            'phone',
            //'logo_image',
            //'duration',
            'country',
            'disciplines',
            'degreelevels',
            'university_admission',
            'test_preperation',
            'status',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

</div>
</div>
</div>
</div>