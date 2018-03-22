<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UniversityCommonAdmission */

$this->title = 'Create Common Admission';
$this->params['breadcrumbs'][] = ['label' => 'Common Admissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-common-admission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'standardTests' =>$standardTests,
		'degreeLevels' => $degreeLevels,
    ]) ?>

</div>
