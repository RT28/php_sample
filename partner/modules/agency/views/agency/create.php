<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Consultant Enquiry';
$this->params['breadcrumbs'][] = ['label' => 'Consultant', 'url' =>['create']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="create-consultant col-xs-12 col-sm-6">
  <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
        <h1><?= Html::encode($this->title) ?> </h1>

        <?= $this->render('_form', [
            'model' => $model, 
            'countries' => $countries,
			'degrees' => $degrees,
            'message' => $message,
			
        ]); ?>
    </div>   </div>
</div>
</div>

 <?php
    Modal::begin([
        'id' => 'myModal2',
		'header'=>'<h4>GTU Terms of Use and Policy</h4>',
    ]);

    echo " GTU Terms of Use and Policy are here...";

    Modal::end();
?>