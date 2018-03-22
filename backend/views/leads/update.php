<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = '' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update'; 
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload,        
        'courses' => $courses,
        'degree' => $degree,
        'currentTab' => $currentTab,
        'tabs' => $tabs,
        'majors' => $majors,        
        'univerityAdmisssions' => $univerityAdmisssions,
        'institutionType' => $institutionType,
        'establishment' => $establishment,
        'courseType' => $courseType,
        'id' => $id,
        'degreeLevels' => $degreeLevels,
        'languages' => $languages,
        'intake' => $intake,
        'currencies' => $currencies,
        'durationType' => $durationType,
        'standardTests' => $standardTests
    ]) ?>

</div>
