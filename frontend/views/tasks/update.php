<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\StudentTasks */

$this->title =  'Update Task';
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'profile';
?>

<div class="student-profile-main">
    <div class="dashboard-detail">
        <div class="tab-content">
		 

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
      'model' => $model,
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
</div>
