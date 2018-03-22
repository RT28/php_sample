<?php

use yii\helpers\Html;
use yii\widgets\DetailView; 

/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-view">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'address',
            'city.name',
            'state.name',
            'country.name',
            'pincode',
            'email:email',
            'website',
            'description:ntext',            
            'phone_1',    
			  		
        ],
    ]) ?>

</div>
</div>
</div>
</div>