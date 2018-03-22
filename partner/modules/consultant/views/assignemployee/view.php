<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StudentConsultantRelation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Consultant Relations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-consultant-relation-view col-sm-12">

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
            'is_sub_consultant',
            'verify_by_consultant',
            'comment_by_consultant:ntext',
            'assigned_work_satus',
            'comment_by_subconsultant:ntext',
            'created_by',
            'created_at',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
