<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TestCategory */

$this->title = 'Create Test Category';
$this->params['breadcrumbs'][] = ['label' => 'Test Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="test-category-create">
  <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
        </div>
    </div>
</div>
