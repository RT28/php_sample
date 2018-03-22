<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

$this->title = 'Create Student Univeristy Application';
$this->params['breadcrumbs'][] = ['label' => 'Student Univeristy Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-univeristy-application-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
