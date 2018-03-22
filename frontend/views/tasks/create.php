<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\StudentTasks */

$this->title = 'Add Task';
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="student-profile-main">
   
    <div class="dashboard-detail"> 

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
 
