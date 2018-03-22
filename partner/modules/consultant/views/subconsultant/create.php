<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentConsultantRelation */

$this->title = 'Assign Sub Consultant';
$this->params['breadcrumbs'][] = ['label' => 'Assign Sub Consultant', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-consultant-relation-create col-sm-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'students' => $students, 
		'Subconsultants' => $Subconsultants, 
		'student_id' => $student_id,
    ]) ?>

</div>
