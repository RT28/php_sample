<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\StudentTasks */

$this->title = 'Update Task: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = false;
?>
<div class="student-profile-main">
     
    <div class="dashboard-detail">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
		'model' => $model,
		'student_id' => $student_id,
		'TaskCategories' => $TaskCategories,
		'TasksList' => $TasksList,
		'TaskStatus' => $TaskStatus,
		'TaskActions' => $TaskActions,
		'TaskResponsbility' => $TaskResponsbility,
		'TaskSpecificAlert' => $TaskSpecificAlert,
		'TaskResponsbility' => $TaskResponsbility,
		'VerificationByCounselor' => $VerificationByCounselor,
		'students' => $students,
		'upload' => $upload
    ]) ?>

</div> 
    
</div>
</div>
</div>
