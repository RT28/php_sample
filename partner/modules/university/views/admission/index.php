<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Others;

/* @var $this yii\web\View */
/* @var $searchModel partner\modules\university\models\UniversityAdmissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'University Admissions';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-admission-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?= Html::a('Create University Admission', ['create'], ['class' => 'btn btn-blue pull-rignt']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'university.name',
            'degreeLevel.name',
            'universityCourseList.name',
            'start_date',
             'end_date',
			 [ 'attribute' => 'intake',
		  'value' => function($searchModel){
				$array = explode(',',$searchModel->intake) ;
				$CModel = Others::find()->where(['=', 'name', 'intake'])->one();
                $temp = explode(',', $CModel->value);
				$Llist = array();
				$Lvalue = '';
				foreach($temp as $key => $d){
					if(in_array($key,$array)){
						 array_push($Llist, $d);
					}
				}
				if(count($Llist)>0){
					$Lvalue = implode(",",$Llist);
				}

                     return $Lvalue;
                }
		],
            // 'admission_link',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
