<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Univeristy Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-univeristy-application-view">

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
           // 'srm_id',
            'consultant_id',
            'university_id',
            'course_id',
            'start_term',
            'status',
            'remarks',
            'summary:ntext',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

</div>
