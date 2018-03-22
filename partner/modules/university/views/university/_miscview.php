<?php
    use yii\helpers\Html;
    use kartik\select2\Select2;
    use yii\helpers\Json;
    use yii\web\JsExpression;
    use common\models\StandardTests;
    use yii\helpers\ArrayHelper;
?>

 <?php
    $location = $model->location;
    $location = str_replace([' ', ',,'], ',', $location);
    $location = str_replace(['POINT', 'GeomFromText(\'', '\')'], '', $location);
    $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
?>

<div class="basic-details"> 
<div class="row address">   
<div class="col-xs-12 col-sm-12">
<h3>University Rankings:</h3>  
<?= Html::hiddenInput('university-rankings', $model->institution_ranking, ['id' => 'university-rankings']); ?>
<?php
$rankings = [];        
$rankings = Json::decode($model->institution_ranking);
if(!is_array($rankings)){
	$rankings = [];
}
$i = 0;       
?>         
<table class="table table-bordered" id="institution-rankings">
<tr>
	<th>Rank</th>
	<th>Source</th>
	<th>Name</th>
</tr>
<?php foreach ($rankings as $rank): ?>
	<tr data-index="<?= $i++; ?>">
		<td><?= $rank['rank'] ?></td>
		<td><?= $rank['source'] ?></td>
		<td><?= $rank['name'] ?></td>
	</tr>
<?php endforeach; ?>
</table>    
</div> 
</div> 
</div> 

 
<div class="basic-details"> 
<div class="row address"> 

<div class="col-xs-12 col-sm-12">
<h3>Location:</h3>    
<?= $form->field($model, 'location')->hiddenInput(['id' => 'university-location','value' => $location])->label(false);
?>    
<div id="google-map-container"></div>

</div>
</div>
</div>
<?php
$script = <<< JS
initGoogleMap();
JS;
$this->registerJs($script);
?>