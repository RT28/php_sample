<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\PackageType;
use common\components\PackageLimitType;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PackageSubtypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Package Subtypes';
$this->params['breadcrumbs'][] = $this->title;
$packageTypes =ArrayHelper::map( PackageType::find()->asArray()->all(),'id','name');
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-subtype-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Package Subtype', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                    'label'=>'Package Type',
                    'attribute'=>'package_type_id',
                    'value'=>function($model){
                       return $model->packageType->name;
                    },
                    'filter'=>Html::dropDownList('PackageSubtypeSearch[package_type_id]',isset($_REQUEST['PackageSubtypeSearch']['package_type_id']) ? $_REQUEST['PackageSubtypeSearch']['package_type_id'] : null,$packageTypes,['class' => 'form-control', 'prompt' => 'Select Package Type']),
                    ],
                    //'package_type_id',
                    'name',
                    [
                    'label'=> 'Limit Count',
                    'attribute'=>'limit_count',
                    'value'=>function($model) {
                            $limit = PackageLimitType::getPackageLimitTypeName($model->limit_type);
                            if($model->limit_count == 1){
                                if($limit == 'Universities')
                                    $limit = 'University';                       
                                else{
                                    $limit = substr($limit, 0, -1); 
                                }
                            }
                            $limitCount = $model->limit_count." ".$limit;
                            return isset($limitCount)?$limitCount:'Not Set';
                        },
                    ],
                    //'limit_count',
                    'fees',
                    // 'description',
                    // 'currency',
                    // 'limit_type',
                    // 'status',
                    // 'rank',
                    // 'package_offerings',
                    // 'created_by',
                    // 'updated_by',
                    // 'created_at',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
