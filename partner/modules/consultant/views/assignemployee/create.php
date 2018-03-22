<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentConsultantRelation */

$this->title = 'Assign Trainer/Employee';
$this->params['breadcrumbs'][] = ['label' => 'Assign Trainer/Employee', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-consultant-relation-create col-sm-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'students' => $students, 
		'employees' => $employees, 
		'student_id' => $student_id,
    ]) ?>

</div>
