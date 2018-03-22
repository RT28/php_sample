<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Seofields;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeofieldsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seofields';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gt-seofields-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gt_id',
            'gt_title',
            'gt_desccontent',
            'gt_keycontent',
            'gt_linkurl',
            
        ],
    ]) ?>



</div>
