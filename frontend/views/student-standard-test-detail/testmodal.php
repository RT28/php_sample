<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StudentStandardTestDetail */

$this->title = 'Test Modal';
$this->params['breadcrumbs'][] = ['label' => 'Test Modal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-standard-test-detail-create">
    <div class="col-md-12">
    	<?= Html::a('Add Score', ['', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
</div>