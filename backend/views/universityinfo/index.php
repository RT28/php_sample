<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\University;
use common\models\Consultant;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversityinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universityinfos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="universityinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?= Html::a('Create Universityinfo', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'consultant_id',
            [   'attribute' => 'consultant_id',
                'value' => function($searchModel){  
                        $id = $searchModel->consultant_id;    
                        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one();
                                    if(isset($consultant)){
                                        return $consultant->first_name." ".$consultant->last_name;
                                    }
                        },
                'label' => 'Consultant',
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=> false,
                /*'filter'=>Html::dropDownList('InvoiceSearch[university_id]',isset($_REQUEST['InvoiceSearch']['university_id']) ? $_REQUEST['InvoiceSearch']['university_id'] : null,$universities,['class' => 'form-control', 'prompt' => 'Select University'])*/
            ],
            [   'attribute' => 'university_id',
                'value' => function($searchModel){  
                       $id = $searchModel->university_id;    
                        $university_name = University::find()->where(['=', 'id', $id])->one();
                        return $university_name->name;
                        },
                'label' => 'University',
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=>Html::dropDownList('UniversityinfoSearch[university_id]',isset($_REQUEST['UniversityinfoSearch']['university_id']) ? $_REQUEST['UniversityinfoSearch']['university_id'] : null,$universities,['class' => 'form-control', 'prompt' => 'Select University'])
            ],
            
            'question',
            'answer',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>