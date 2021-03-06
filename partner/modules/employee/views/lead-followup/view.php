<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LeadFollowup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lead Followups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-followup-view">

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
            'student_id',
            'consultant_id',
            'created_by',
            'created_at',
            'status',
            'next_followup',
            'next_follow_comment',
            'comment',
            'comment_date',
            'mode',
            'reason_code',
            'today_status',
        ],
    ]) ?>

</div>
