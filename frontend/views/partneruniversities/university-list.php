<?php
    use yii\helpers\Html;
    use yii\widgets\LinkPager;
	use yii\helpers\Url; 
	
?>

<div class="group-title-index">
<div class="row">
<div class="col-sm-6">
    <h1><?= $universityTotalCount; ?> Partner Universities</h1>
</div>
<div class="col-sm-6">
    
	<a href ="<?=Url::to('partner/web/index.php?r=university/university-enquiry/create', true)?>" class= 'btn btn-primary pull-right' target="_blank" >Register with us<a/>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
<?php foreach($models as $model): ?>
    <div class="course-box">
        <h4><?= Html::a($model->name, ['university/view', 'id' => $model->id], ['class' => 'profile-link']) ?></h4>
        <p><?= $model->address ?></p>
        <p><?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->country->name ?></p>
    </div>
<?php endforeach ?>

<?= LinkPager::widget([
    'pagination' => $pages
]); ?>
</div>
</div>