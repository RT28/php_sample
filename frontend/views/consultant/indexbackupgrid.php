<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\Commondata;  
use common\models\Degree; 
 use yii\grid\GridView;

$this->title = 'Consultant';
$this->context->layout = 'index';
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content"><!-- SLIDER BANNER-->
<div class="container">
<div class="section section-padding package">
<div class="group-title-index">
<h1>All Consultants </h1>
</div>
<div class="row">
 
 <div id='content' style="display:none;"  >
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</div>

<div class="col-sm-12 text-right">
<input type='button' id='hideshow' value='Advance Filters'>
</div>
<?= GridView::widget([
'dataProvider' => $dataProvider,
// 'filterModel' => $searchModel,
'columns' => [
['class' => 'yii\grid\SerialColumn',
'visible' =>false,
], 
[
'label'=> false,
'attribute' => 'first_name',
'format' => 'raw',
'value' => function ($model, $key, $index, $grid) {
$name = $model->first_name . ' ' .$model->last_name ;
 

$content = '<div class="col-sm-4 col-md-3">
<div class="thumbnail">';
 
$src = './../../partner/web/noprofile.gif';
 
$content.= ' 
 
<div class="caption">
<h3><a href="/consultant/view?id='.$model->consultant_id.'>'.$name.'</a></h3>
 </div> 
</div>
</div>
 ';





return  Html::decode($content);
},
], 
['class' => 'yii\grid\ActionColumn', 
'visible' =>false,
],
],
]); ?>

<?php /* foreach($models as $model): ?>
<div class="col-sm-4 col-md-3">
<div class="thumbnail">
<?php
$src = './../../partner/web/noprofile.gif';

if(is_dir('./../../partner/web/uploads/consultant/' . $model->consultant_id . '/profile_photo')) {
$cover_photo_path = "./../../partner/web/uploads/consultant/".$model->consultant_id."/profile_photo/logo_170X115";
if(glob($cover_photo_path.'.jpg')){
$src = $cover_photo_path.'.jpg';
} else if(glob($cover_photo_path.'.png')){
$src = $cover_photo_path.'.png';
} else if(glob($cover_photo_path.'.gif')){
$src = $cover_photo_path.'.gif';
} 
} 
?>
<img src="<?= $src; ?>" alt="<?= $model->first_name.' '.$model->last_name; ?>" />
<div class="caption">
<h3><a href="?r=consultant/view&id=<?= $model->consultant_id; ?>"><?php echo Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;?></a></h3>
<div><label>Country: </label><span> <?= $model->country->name; ?></span></div>
<div><label>Gender: </label><span><?php echo Commondata::getGenderName($model->gender);?></span></div>
<div><label>Description: </label><span> <?= $model->description; ?></span></div>
<div><label>Experience: </label><span><?php echo $model->experience_years.' Years '.$model->experience_months.' Months';?></span></div>

</div>
</div>
</div>

<?php endforeach;  */ ?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script> 
jQuery(document).ready(function(){ 
jQuery('#hideshow').on('click', function(event) {  
jQuery('#content').toggle('show');
 
});
});
 
</script>
