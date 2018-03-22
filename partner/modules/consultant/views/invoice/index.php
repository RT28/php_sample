<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\ConnectionSettings;
use common\models\Student;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Currency;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->context->layout = 'main';
$this->title = 'Invoice Requisition'; 
$this->params['breadcrumbs'][] = $this->title;
$path= ConnectionSettings::BASE_URL.'partner/';
$accessStatus = array(0=>'Pending',1=>'Approved');


?>

<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <!-- <p > 
    <a href="#" class="btn btn-success" data-toggle="modal" 
    data-target="#addInvoiceModal" onclick="loadInvoiceAdd('<?php echo $path; ?>web/index.php?r=consultant/invoice/create');" >Create Invoice</a>
    </p> -->
<?php Pjax::begin(); ?>    
<script type="text/javascript">
       /* $(document).ready(function(){
            $('#titleee').find('a').trigger('click');
                });*/
</script>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [   'attribute' => 'student_id',
                'value' => function($searchModel){  
                        $id = $searchModel->student_id;    
                        $studentProfile = Student::find()->where(['=', 'id', $id])->one();
                        return  $studentProfile->first_name." ".$studentProfile->last_name;
                        },
                'label' => 'Student', 
            ],
            'refer_number',
            [   'attribute' => 'created_at',
                'value' => function($searchModel){  
                        $date = $searchModel->created_at;    
                        return  date("d-M-Y", strtotime($date));
                        },
                'label' => 'Created At', 
                'filter' => false,

            ],
            [   'attribute' => 'payment_date',
                'value' => function($searchModel){  
                        $date = $searchModel->payment_date;    
                        return  date("d-M-Y", strtotime($date));
                        },
                'label' => 'Payment Date', 
                'filter' => false,
            ],
            [   'attribute' => 'gross_tution_fee',
                'value' => function($searchModel){  
                        $id = $searchModel->currency;    
                        $currency = Currency::find()->where(['=', 'id', $id])->one();
                        return $searchModel->gross_tution_fee.$currency->iso_code;
                        },
                'label' => 'Gross Tution Fee', 
                'filter' => false,
            ],
            [   'attribute' => 'university',
                'value' => function($searchModel){  
                        $id = $searchModel->university;    
                        $university_name = University::find()->where(['=', 'id', $id])->one();
                        return $university_name->name;
                        },
                'label' => 'University',
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=>Html::dropDownList('InvoiceSearch[university]',isset($_REQUEST['InvoiceSearch']['university']) ? $_REQUEST['InvoiceSearch']['university'] : null,$universities,['class' => 'form-control', 'prompt' => 'Select University'])
            ],
            [   'attribute' => 'programme',
                'value' => function($searchModel){  
                        $id = $searchModel->programme;
                        if($id == 0){
                            return $searchModel->custom_programme;
                        } else {    
                        $programe_name = UniversityCourseList::find()->where(['=', 'id', $id])->one();
                        return $programe_name->name; }
                        },
                'label' => 'Programme', 
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter' => false,
            ],
            'scholarship',
            //'intake',
            [   'attribute' => 'intake',
                'value' => function($searchModel){  
                        return $searchModel->intake;
                        },
                'label' => 'Intake', 
                //'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=> false,
                /*'filter'=>Html::dropDownList('InvoiceSearch[intake]',isset($_REQUEST['InvoiceSearch']['intake']) ? $_REQUEST['InvoiceSearch']['intake'] : null,$intake,['class' => 'form-control', 'prompt' => 'Intake'])*/
            ],
            /*[   'attribute' => 'intake',
                'value' => function($searchModel){  
                        if($searchModel->intake==1){
                            return 'Month';
                        } else if($searchModel->intake==2){
                            return 'Year';
                        }    
                        },
                'label' => 'Intake', 
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=>Html::dropDownList('InvoiceSearch[intake]',isset($_REQUEST['InvoiceSearch']['intake']) ? $_REQUEST['InvoiceSearch']['intake'] : null,$intake,['class' => 'form-control', 'prompt' => 'Intake'])
            ],*/

            // 'gross_tution_fee',
            // 'discount',
            // 'scholarship',
            // 'net_fee_paid',
            // 'invoice_attachment',
            // 'status',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'approved',
            // 'approved_by',
            [   'attribute' => 'status',
                'value' => function($searchModel){  
                        if($searchModel->status==0){
                            return 'Pending';
                        } else if($searchModel->status==1){
                            return 'Approved';
                        }    
                        },
                'label' => 'status', 
                'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=>Html::dropDownList('InvoiceSearch[status]',isset($_REQUEST['InvoiceSearch']['status']) ? $_REQUEST['InvoiceSearch']['status'] : null,$accessStatus,['class' => 'form-control', 'prompt' => 'Select status'])
            ],

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
            'update' => function ($url, $model, $key) {
                        if($model->status==0){
            return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
                    data-target="#invoiceUpdateModal" onclick="loadInvoiceUpdate('.$model->id.')" ></a>';
                    ; }
                    ;
            },
            'preview' => function ($url, $model, $key) {
            return  '<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" 
                    data-target="#myModal2" onclick="loadInvoiceView('.$model->id.')" ></a>';
                     ;
            },  
            
            ],

            'template' => '{preview}{update}{delete}'],
            ],
    ]); ?>
    <div id="pendingInvoiceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" id="pendingInvoicePreview" style="height:800px; overflow:scroll;">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
    </div>
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