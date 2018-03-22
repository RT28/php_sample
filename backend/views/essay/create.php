<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Essay */

$this->title = 'Create Essay';
$this->params['breadcrumbs'][] = ['label' => 'Essays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-course-list-index">
 
    <div class="container">
        
            <div class="col-xs-10 col-md-10">
<div class="essay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
			'upload' => $upload
    ]) ?>

</div>
</div>
</div>
</div>