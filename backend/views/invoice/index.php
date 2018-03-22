<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\ConnectionSettings;
use common\models\Student;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Currency;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$accessStatus = array(0=>'Pending',1=>'Approved');
$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php //Pjax::begin(); ?>    
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
            [   'attribute' => 'net_fee_paid',
                'value' => function($searchModel){  
                        $id = $searchModel->currency;    
                        $currency = Currency::find()->where(['=', 'id', $id])->one();
                        if($searchModel->net_fee_paid==''){
                            return '--';
                        } else {
                        return $searchModel->net_fee_paid.$currency->iso_code;
                        }
                        },
                'label' => 'Final Net Amount', 
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
            'comment',
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
            [   'attribute' => 'intake',
                'value' => function($searchModel){  
                        return $searchModel->intake;
                        },
                'label' => 'Intake', 
                //'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
                'filter'=> false,
                /*'filter'=>Html::dropDownList('InvoiceSearch[intake]',isset($_REQUEST['InvoiceSearch']['intake']) ? $_REQUEST['InvoiceSearch']['intake'] : null,$intake,['class' => 'form-control', 'prompt' => 'Intake'])*/
            ],
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
            // 'intake',
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

            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}{download}{disable}',
            'buttons' => [
                             'disable' => function ($url, $model, $key) {
                                        /*if($model->status == 0){
                                            return Html::button('Approve', ['id'=> $model->id,'class' => 'btn btn-success','onclick'=>'enable('.$model->id.');']);
                                        }*//*else{
                                             return Html::button('Disable',['id'=> $model->id,'class' => 'btn btn-danger', 
                                            'onclick'=>'disable('.$model->id.');']);
                                        }*/
                                    },
            /*'download' => function ($url, $model, $key) {
            return Html::a('', ['download', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-download-alt','title' => 'Download Application']);
            }*/
            'download' => function ($url, $model, $key) {
                if($model->net_fee_paid != ''){
                return '<a href="?r=invoice/raiseinvoice&id='.$model->id.'" class="btn btn-success" role="button"> Approve</a>';
                }
            }
                                    
                                ],
            ],
            ],
    ]); ?>
<?php //Pjax::end(); ?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
/*$('body').tooltip({
    selector: '[data-toggle="tooltip"]'
});*/

   function enable(id){
    $('#'+id).before('<img id="load_12" src="../../frontend/web/images/loading.gif" height="80px" width="80"  />'); 
    $("#"+id).remove();
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=invoice/enable",
                        data : data,
                        success: function(data){ 
                        $("#load_12").after("<div style='color: red;'>Invoice Raised Succesfully!</div>");
                        $("#load_12").remove();
                        //$("#"+id).attr("onclick","disable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }
</script>
