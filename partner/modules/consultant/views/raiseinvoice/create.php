<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\StudentTasks */

$this->title = 'Add Task';
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 $this->context->layout = false;
?>
<div class="student-profile-main">
   
    <div class="dashboard-detail"> 

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="alert alert-danger error-container hidden"></div>
	
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
		'upload' => $upload,
		'student_id' => $student_id,
    ]) ?>

</div> 
    
</div>
</div>
</div>
 
