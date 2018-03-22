<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentConsultantRelation */

$this->title = 'Update Assigned work : ';
$this->params['breadcrumbs'][] = ['label' => 'Update Assigned work', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-consultant-relation-update col-sm-12">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,  
		'students' => $students, 
		'Subconsultants' => $Subconsultants, 
    ]) ?>

</div>
