<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\ConnectionSettings;
use common\models\University;
use common\models\Consultant;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversityinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My previous Question & Answer history';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$path= ConnectionSettings::BASE_URL.'partner/';


?>
<div class="universityinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p> 
    <a href="#" class="btn btn-success" data-toggle="modal" 
    data-target="#addInvoiceModal" onclick="loadQuestionAdd('?r=consultant/universityinfo/create');" >New Questions</a>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
            'update' => function ($url, $model, $key) {
                        
            return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
                    data-target="#invoiceUpdateModal" onclick="loadQuestionUpdate('.$model->id.')" ></a>';
                    ; 
                    ;
            },
            'preview' => function ($url, $model, $key) {
            return  '<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" 
                    data-target="#myModal2" onclick="loadQuestionView('.$model->id.')" ></a>';
                     ;
            },  
            ],

            'template' => '{delete}'],
            ],
    ]); ?>
    <div id="addInvoiceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" id="AddInvoicePreview" style="height:800px; overflow:scroll;">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
    </div>

    <div id="invoiceUpdateModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="invoiceUpdate" style="height:800px; overflow:scroll;">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
    </div> 

    <div id="myModal2" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="taskPreview" style="height:800px; overflow:scroll;">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
    </div>  
<?php Pjax::end(); ?></div>