<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\University;

/* @var $this yii\web\View */
/* @var $searchModel partner\models\UniversityNotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-notifications-index">

<div class="row" >
<div class="col-sm-9" >
 <h1 class="mtop-0"><?= Html::encode($this->title) ?></h1>
	 </div>
<div class="col-sm-3 text-right">
<?= Html::a('Create Notifications', ['create'], ['class' => 'btn btn-blue']) ?>
</div>
</div>

   <div class="row" >
<div class="col-sm-12" >
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
				'title',
				'message:ntext',
				'created_at',
				'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
