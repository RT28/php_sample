<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel partner\modules\university\models\UniversityCourseListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programs';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-course-list-index">
<div class="row" >
<div class="col-sm-9" >
 <h1 class="mtop-0"><?= Html::encode($this->title) ?></h1>
	 </div>
<div class="col-sm-3 text-right">
  <?= Html::a('Create Program', ['create'], ['class' => 'btn btn-blue']) ?>
</div>
</div>
   <div class="row" >
<div class="col-sm-12" >

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'program_code',
			'name',
			[ 'attribute' => 'degree_id',
			'value' => 'degree.name',
			],
			[ 'attribute' => 'major_id',
			'value' => 'major.name',
			],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
