<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Institute */

$this->title = 'Create Institute';
$this->params['breadcrumbs'][] = ['label' => 'Institutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institute-create">
	<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
			    <h1><?= Html::encode($this->title) ?></h1>
			    <?= $this->render('institute_form', [
			    	'id'=>$id,
			        'model' => $model,
			        'countries' => $countries,
			    ]) ?>
			    
			</div>

		</div>
	</div>
</div>
