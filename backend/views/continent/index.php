<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\Models\ContinentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Continents';
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar'; 
?>
<div class="continent-index">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-10">
<h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
 
<?= GridView::widget([
'dataProvider' => $dataProvider,
'filterModel' => $searchModel,
'columns' => [
['class' => 'yii\grid\SerialColumn'],

'id',
'name', 

['class' => 'yii\grid\ActionColumn',
 'template' => '{view}{update}'],
],
]); ?>
</div>
</div>
</div>
</div>
