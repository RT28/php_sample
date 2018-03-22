<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->context->layout = 'index';
use common\models\FreeCounsellingSessions;


/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Create Student Profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload
    ]) ?>
</div>
