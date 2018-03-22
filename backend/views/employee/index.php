<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="employee-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'first_name',
                            'last_name',
                            'date_of_birth',
                            'gender',
                            // 'address',
                            // 'street',
                            // 'city',
                            // 'state',
                            // 'country',

                            [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}{update}{delete}{disable}',

                             'buttons' => [
                             'disable' => function ($url, $model, $key) {
                                        if($model->employeeLogins->status == 0){
                                            return Html::button('Enable', ['id'=> $model->id,'class' => 'btn btn-success','onclick'=>'enable('.$model->id.');']);
                                        }else{
                                             return Html::button('Disable',['id'=> $model->id,'class' => 'btn btn-danger', 
                                            'onclick'=>'disable('.$model->id.');']);
                                        }
                                    },
                             'delete' => function ($url, $model, $key) {
                                            return ($model->employeeLogins->role_id==1) ? '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url) ;
                                        }
                                ],
                            ],

                        ],
                    ]); ?>
                </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$('body').tooltip({
    selector: '[data-toggle="tooltip"]'
});
 function disable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=employee/disable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Enable").removeClass('btn-primary btn-danger') .addClass("btn-primary btn-success");
                        $("#"+id).attr("onclick","enable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }

   function enable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=employee/enable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Disable").removeClass('btn-primary btn-success') .addClass("btn-primary btn-danger");
                        $("#"+id).attr("onclick","disable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }
</script>
