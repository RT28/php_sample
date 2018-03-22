<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use yii\widgets\Pjax;
use common\components\ConnectionSettings;
use common\models\Student;
use partner\modules\consultant\models\EmailenquirySearch;
use common\models\Emailenquiry;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmailenquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Email Enquiries';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$path= ConnectionSettings::BASE_URL.'partner/';

?>
<div class="emailenquiry-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
<style type="text/css">
    .active-tab{
    border-color: #00a4b6;
    background-color: #00a4b6;
    border-bottom: 3px solid #01a4b7;
    color: #ffffff;
    }
</style>
<?php $status = Yii::$app->request->get('status'); ?>
<input type="hidden" name="tab_id" id="tab_id" value="<?php echo $status; ?>">
<script type="text/javascript">
    $(document).ready(function(){
        var tab_id = $('#tab_id').val();
        $('#tab_'+tab_id).addClass('active-tab');
        
    });
</script>
<p style="float: right;"> 
    <a href="#" class="btn btn-success" data-toggle="modal" 
    data-target="#addInvoiceModal" onclick="loadEmailenquiryform('?r=consultant/emailenquiry/create');" >Send Email</a>
    </p>
<div class="row">
    <ul class="nav nav-tabs" role="tablist" >
            
            <li id="act_0" class="act_common" role="presentation"><a id='tab_0' href="index.php?r=consultant/emailenquiry/index&status=0" role="tab">Inbox
            <b style="color: red;"></b>
            </a></li>
            <li id="act_5" class="act_common" role="presentation"><a id='tab_1' href="index.php?r=consultant/emailenquiry/index&status=1" role="tab">Send Items
            <b style="color: red;"></b>    
            </a></li>
      
        </ul>
</div>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'export' => false,
          'pjax' => true,
        'columns' => [
            ['class' => 'kartik\grid\ExpandRowColumn',
                              'value' => function ($model, $key, $index) { 
                                            return GridView::ROW_COLLAPSED;
                                    },
                            'detail' => function ($model, $key, $index) { 
                            $id = $model->id;
                            return Yii::$app->controller->renderPartial('view', [
                                'model' => $model,
                            ]);
                                    }
                            ],

            [   'attribute' => 'student_id',
                'value' => function($searchModel){  
                        $id = $searchModel->student_id;    
                        $studentProfile = Student::find()->where(['=', 'id', $id])->one();
                        return  $studentProfile->first_name." ".$studentProfile->last_name;
                        },
                'label' => 'Student', 
            ],
            //'consultant_id',
            'subject',
            //'consultant_message:ntext',
            // 'is_to_student',
            // 'is_to_father',
            // 'is_to_mother',
             'created_by',
            // 'updated_by',
             'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
            'reply' => function ($url, $model, $key) {
            if($model->email_source == 0){            
            return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
                    data-target="#invoiceUpdateModal" onclick="loadEmailenquiryupdate('.$model->id.')" >Reply</a>';
                    ; 
                    ;
                  }
            },
            ],

            'template' => '{reply}{delete}'],
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
<?php
    $this->registerJsFile('js/chatnotification.js');
?>