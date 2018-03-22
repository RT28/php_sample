<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Student */
$this->context->layout = 'profile';
$this->title = 'Update Student Profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
        if(!$model->isNewRecord) {
            echo Html::a('View', Url::to(['student/view', 'id' => $model->id]), ['class'=>'btn btn-primary']); 
        }
    ?>

    <?= $this->render('_form', [
        'model' => $model,        
        'countries' => $countries,
        'upload' => $upload
    ]) ?>

</div>
