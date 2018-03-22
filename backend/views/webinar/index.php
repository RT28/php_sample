<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Status;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WebinarCreateRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Webinar';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
$js = <<< 'SCRIPT'
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    $('body').popover({selector: '[data-toggle="popover"]'});
SCRIPT;
?>
<div class="webinar-create-request-index">

<div class="container">
<div class="col-xs-10 col-md-10">
<div class="webinar-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webinar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'topic',
            'date_time',
            'author_name',
            'institution_name',
            'email:email',
            // 'phone',
            // 'logo_image',
            // 'duration',
            // 'country',
            // 'disciplines',
            // 'degreelevels',
            // 'university_admission',
            // 'test_preperation',
            // 'status',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            /*['class' => 'yii\grid\ActionColumn'],*/
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}{disable}',
            'buttons' => [
                             'disable' => function ($url, $model, $key) {
                                        if($model->status == 0){
                                            return Html::button('Enable', ['id'=> $model->id,'class' => 'btn btn-success','onclick'=>'enable('.$model->id.');']);
                                        }else{
                                             return Html::button('Disable',['id'=> $model->id,'class' => 'btn btn-danger', 
                                            'onclick'=>'disable('.$model->id.');']);
                                        }
                                    },
                                    
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
                        url: "index.php?r=webinar/disable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Enable").removeClass('btn-primary btn-danger') .addClass("btn-primary btn-success");
                        $("#"+id).attr("onclick","enable(id)");
                        $('.msg').remove();
                        $("#"+id).after("<span class='msg' style='color: red;'>Success!</span>");
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
                        url: "index.php?r=webinar/enable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Disable").removeClass('btn-primary btn-success') .addClass("btn-primary btn-danger");
                        $("#"+id).attr("onclick","disable(id)");
                        $('.msg').remove();
                        $("#"+id).after("<span class='msg' style='color: red;'>Success!</span>");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }
</script>