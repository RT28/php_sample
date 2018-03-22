<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RankingType */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ranking Type', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ranking-type-view">
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
                        'type',
                        'name',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

</div>
