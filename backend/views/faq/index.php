<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\FaqCategory;
use common\components\ConnectionSettings;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faqs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="faq-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Faq', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'category_id',
                [   
                'attribute' => 'category_id',
                'value' => function($searchModel){  
                        $category_id = $searchModel->category_id;    
                        $category_name = FaqCategory::find()->where(['=', 'id', $category_id])->one();
                        return $category_name->category;
                        },
                'label' => 'Category',
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=> false
                ],
                //'question:ntext',
                //'answer:ntext',
                [   
                'attribute' => 'question',
                'label' => 'question', 
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                ],
                [   'attribute' => 'answer',
                    'label' => 'answer', 
                    'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                ],

                ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
