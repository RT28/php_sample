<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\StudentPackageDetails */

$this->title = 'Create Student Package Details';
$this->params['breadcrumbs'][] = ['label' => 'Student Package Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-package-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'packageType' => $packageType
    ]) ?>

</div>
