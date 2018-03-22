<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */
$name = $model->student->student->first_name . ' ' . $model->student->student->last_name;
$nationality = $model->student->student->nationality;
 
 
$this->title = 'Update: ' . $name;
$this->params['breadcrumbs'][] = ['label' => 'Student Univeristy Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'profile';


?>
<div class="student-univeristy-application-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
