<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use yii\helpers\ArrayHelper;
use common\models\TestCategory;
use common\models\TestSubject;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StandardTestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$tests = ArrayHelper::map(TestCategory::find()->asArray()->all(),'id','name');
$subjects = ArrayHelper::map(TestSubject::find()->asArray()->all(),'id','name');

$this->title = 'Standard Tests';
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="standard-tests-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Create Standard Tests', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                             //'address',
                        [
                            'label' => 'Category',
                            'attribute' => 'test_category_id',
                            'value'=>'testCategory.name'
                        ],
						[
                            'label' => 'Subject',
                            'attribute' => 'test_subject_id',
                            'value'=>'testSubject.name',
							'filter'=>Html::dropDownList('StandardTestsSearch[test_subject_id]',isset($_REQUEST['StandardTestsSearch']['test_subject_id']) ? $_REQUEST['StandardTestsSearch']['test_subject_id'] : null,$subjects,['class' => 'form-control', 'prompt' => 'Subject']),
		 
                        ], 
                        'name',
                        'source',
                        'created_at' ,

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
