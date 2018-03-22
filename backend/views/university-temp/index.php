<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversityTempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities list for Approval from GTU';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-temp-index">
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

'name',   
[ 'label'=>'Status',
		  'value' => function($searchModel){ 
		 
					if($searchModel->status==1){
						return 'Approved';
					}
					if($searchModel->status==2){
						return 'Pending';
					}
				 
                 }
		], 


['class' => 'yii\grid\ActionColumn',
'template' => '{approved}{preview}',
'buttons' => [  'approved' => function ($url, $model, $key) {
		$btnclass= 'btn btn-primary';
		if($model->status==1){
		$btnclass= 'btn btn-success';
		}
		if($model->status==2){
		$btnclass= 'btn btn-danger';
		}
		return Html::a('Approved', ['approved', 'id' => $model->id], [ 
		'class' => $btnclass,
		'data' => [ 'confirm' => 'Did you see preview?', 'method' => 'post',],
	]) ;
},
'preview' => function ($url, $model, $key) {
return  ' <button type="button" class="btn btn-primary btn-blue btn-login" data-toggle="modal" 
data-target="#myModal2" onclick="loadPreviewInfoOfPartner('.$model->university_id.')" >Preview</button>';
},
	   ],
],
],
]); ?>
	
	 
</div>
</div></div></div> 
<div id="myModal2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Partner University Page Preview</h4>
		
      </div>
      <div class="modal-body" id="partnerPagePreview" style="height:700px; overflow:scroll;">
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> 
