<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StudentStandardTestDetail */

$this->title = 'Create Student Standard Test Detail';
$this->params['breadcrumbs'][] = ['label' => 'Student Standard Test Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-standard-test-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'subjects'=>isset($subjects)?$subjects:'',
        'marks_error'=>isset($marks_error)?$marks_error:'',
        'error1'=>isset($other_test)?$other_test:'',
        'error2'=>isset($test_authority)?$test_authority:'',
    ]) ?>

</div>