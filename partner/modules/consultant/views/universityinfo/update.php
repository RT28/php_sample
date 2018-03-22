<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Universityinfo */

$this->title = 'If you have any doubts, ask your questions to the university';
$this->params['breadcrumbs'][] = ['label' => 'Universityinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="universityinfo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>