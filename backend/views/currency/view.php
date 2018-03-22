<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\EmployeeLogin;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Currency */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$employee =ArrayHelper::map(EmployeeLogin::find()->asArray()->all(),'id','username');
$this->context->layout = 'admin-dashboard-sidebar';

?>
<div class="currency-view">
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
                        'id',
                        'name',
                        'iso_code',
                        'country.name',
                        [
                            'label' => 'Symbol',
                            'value' => iconv("ISO-8859-1", "UTF-8//IGNORE", $model->symbol)
                        ],
                        'created_at',
                        'updated_at',
                        [
                        'label'=>'Created by',
                        'attribute'=>'created_by',
                        'value'=>isset($employee[$model->created_by])?$employee[$model->created_by]:'Not Assigned',
                        ],
                         [
                        'label'=>'Updated by',
                        'attribute'=>'updated_by',
                        'value'=>isset($employee[$model->updated_by])?$employee[$model->updated_by]:'Not Assigned',
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
