<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\University */
$this->title = '' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'View';
$this->context->layout = 'profile';

?>
<div class="university-update">
   <div class="buttons-block">

<?= Html::a('Edit', ['update'], ['class' => 'btn btn-blue']) ?>

 
<button type="button" class="btn btn-blue btn-login" data-toggle="modal"
data-target="#myModal2" onclick="loadPreviewInfoOfPartner(<?php echo $model->id;?>, '../../frontend/web/index.php?r=university/preview')"   >Preview</button>

	 </div>
	 <div class="row" >
<div class="col-sm-12">
    <?= $this->render('view_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload,
        'degree' => $degree,
        'currentTab' => $currentTab,
        'tabs' => $tabs,
        'majors' => $majors,
        'institutionType' => $institutionType,
        'establishment' => $establishment,
        'courseType' => $courseType,
        'id' => $id,
        'degreeLevels' => $degreeLevels,
        'languages' => $languages,
        'intake' => $intake,
        'currencies' => $currencies,
		'Currency' => $Currency,
		'documentlist'=> $documentlist,
		'doclist'=> $doclist
    ]) ?>
</div>
</div>
</div>
 <?php
    /*Modal::begin([
        'id' => 'myModal2',
		'header' => '<h3>Preview</h3>',
    ]);?>
    <iframe src="http://localhost/gotouniversity/frontend/web/index.php?r=university%2Fpreview&id=58" height="800px" width="900px" scroll="auto"></iframe>
   <?php Modal::end();*/?>

 <!-- Modal -->
<div id="myModal2" class="modal fade" role="dialog" >
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
