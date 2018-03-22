<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use common\models\StandardTests;

/* @var $this yii\web\View */
/* @var $model common\models\Institute */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Institutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
$tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
$StandardTests  =  explode(',', $model->tests_offered);
$tests_offered = [];
foreach ($StandardTests as $key => $value) {
   array_push($tests_offered, $tests[$value]);
}
$tests_offered  = implode(',', $tests_offered);
?>
<div class="institute-view">
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
                        'email:email',
                        'adress',
                        [
                         'label'=>'country',
                        'attribute'=>'country.name',
                        ],
                        [
                         'label'=>'state',
                        'attribute'=>'state.name',
                        ],
                        'city_id',
                        [
                        'label'=>'Tests Offered',
                        'attribute'=> 'tests_offered',
                        'value'=>$tests_offered,
                        ],
                        'contact_details',
                        'website',
                        'description',
                        'created_at',
                        'created_by',
                        'updated_at',
                        'updated_by',
                    ],
                ]) ?>

            </div>
         </div>
    </div>
</div>