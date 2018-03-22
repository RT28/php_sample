<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UniversityCourseList */

$this->title = 'Create Program';
$this->params['breadcrumbs'][] = ['label' => 'Program', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-course-list-create">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
        'model' => $model, 		
		'university' => $university,
        'degree' => $degree, 
        'majors' => $majors,          
        'courseType' => $courseType, 
        'degreeLevels' => $degreeLevels,
        'languages' => $languages,
        'intake' => $intake, 
        'durationType' =>$durationType,
        'standardTests' => $standardTests
    ]) ?>

</div>
</div>
</div>
</div>