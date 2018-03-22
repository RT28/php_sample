<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City; 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner Universities List';
$this->params['breadcrumbs'][] = $this->title;
$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
$states = ArrayHelper::map(State::find()->orderBy('name')->all(), 'id', 'name');
$cities = ArrayHelper::map(City::find()->orderBy('name')->all(), 'id', 'name');

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-index">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                 
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        'name',
                        //'establishment_date',
                        //'address',
                        [
                            'label' => 'City',
                            'attribute' => 'city_id',
                            'value'=>'city.name',
                            'filter'=>Html::dropDownList('UniversitySearch[city_id]',isset($_REQUEST['UniversitySearch']['city_id']) ? $_REQUEST['UniversitySearch']['city_id'] : null,$cities,['class' => 'form-control', 'prompt' => 'Select City'])
                        ],
                        [
                            'label' => 'State',
                            'attribute' => 'state_id',
                            'value'=>'state.name',
                            'filter'=>Html::dropDownList('UniversitySearch[state_id]',isset($_REQUEST['UniversitySearch']['state_id']) ? $_REQUEST['UniversitySearch']['state_id'] : null,$states,['class' => 'form-control', 'prompt' => 'Select State'])                
                        ],
                        [
                            'label' => 'Country',
                            'attribute' => 'country_id',
                            'value'=>'country.name',
                            'filter'=>Html::dropDownList('UniversitySearch[country_id]',isset($_REQUEST['UniversitySearch']['country_id']) ? $_REQUEST['UniversitySearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
                        ],
                        
                        ['class' => 'yii\grid\ActionColumn',
                         'template' => '{view}',
						  'buttons' => [
                            'verify' => function ($url, $model, $key) {
                                return Html::a('Verify', ['newunivserities/verify', 'id' => $model->id] , ['class' => 'btn btn-primary']);
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
