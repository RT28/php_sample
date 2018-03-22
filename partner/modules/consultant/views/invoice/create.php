<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model common\models\Invoice */

$this->title = 'Invoice Requisition';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';

?>
<div class="webinar-create-request-create">
<div class="container">
<div class="col-xs-10 col-md-10">
<div class="invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'students' => $students,
        'student_id' => $student_id,
        'task_id' => $task_id,
        'upload' => $upload
    ]) ?>

</div>
</div>
</div>
</div>
