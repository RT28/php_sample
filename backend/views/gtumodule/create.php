<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GtuModule */

$this->title = 'Create Gtu Module';
$this->params['breadcrumbs'][] = ['label' => 'Gtu Modules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="gtu-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
