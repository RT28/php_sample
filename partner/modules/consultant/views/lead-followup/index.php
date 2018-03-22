<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\LeadFollowupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lead Followups';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-followup-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Lead Followup', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'student_id',
            'consultant_id',
            'created_by',
            'created_at',
            // 'status',
            // 'next_followup',
            // 'next_follow_comment',
            // 'comment',
            // 'comment_date',
            // 'mode',
            // 'reason_code',
            // 'today_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
