<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\FaqCategory;

/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="faq-view">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

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

                        [
                            'label' => 'Category',
                            'value' => function($searchModel){  
                            $category_id = $searchModel->category_id;    
                            $category_name = FaqCategory::find()->where(['=', 'id', $category_id])->one();
                            return $category_name->category;
                            },
                        ],
                        'question:ntext',
                        'answer:ntext',
                    ],
                ]) ?>
             </div>
        </div>
    </div>
</div>
