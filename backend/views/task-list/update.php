<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TaskList */

$this->title = 'Update Task List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="task-list-update">
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
