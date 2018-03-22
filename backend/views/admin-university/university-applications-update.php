<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

$this->title = 'Update Student Univeristy Application: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Univeristy Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-univeristy-application-update">


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('application_form', [
        'model' => $model,
        'srm_name' => $srm_name,
        'consultant_name' => $consultant_name,
    ]) ?>

</div>
