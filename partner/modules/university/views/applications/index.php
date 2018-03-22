<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\AdmissionWorkflow;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel partner\modules\university\models\StudentUniversityApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Applications';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
  
?>
     
<div class="student-univeristy-application-index">

       
    <h1><?= Html::encode($this->title) ?></h1>
  
        
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Student',
                'value' => function($model) {
                    return $model->student->student->first_name . ' ' . $model->student->student->last_name;
                } 
            ],
			[
                'label' => 'Nationality',
                'value' => function($model) {
                    return $model->student->student->nationality;
                } 
            ],
            [
                'label' => 'Program',
                'attribute' => 'course.name'
            ],
			[
                'label' => 'Session',
                'attribute' => 'start_term'
            ],			
            [
                'label' => 'Status',
                'value' => function($model) {
                    return AdmissionWorkflow::getStateName($model->status);
                }
            ],
			[
                'label' => 'Comments',
                'attribute' => 'remarks'
            ],          
            [
                'class' => 'yii\grid\ActionColumn',
				'template' => '{view}{changestatus}{download}',
                'buttons' => [ 
				'changestatus' => function ($url, $model, $key) {
			return Html::a('Change Status', ['changestatus', 'id' => $model->id] , ['class' => '','title' => 'Change Status']);
			},
			'download' => function ($url, $model, $key) {
			return Html::a('', ['download', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-download-alt','title' => 'Download Application']);
			}
                ], 
                
				  
            ],
        ],
    ]); ?>
     
</div>

                        