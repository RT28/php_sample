<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TaskCategory */

$this->title = 'Create Task Category';
$this->params['breadcrumbs'][] = ['label' => 'Task Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="task-category-create">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
        </div>
    </div>
</div>
