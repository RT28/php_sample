<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GtuEnvironment */

$this->title = 'Create Gtu Environment';
$this->params['breadcrumbs'][] = ['label' => 'Gtu Environments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="gtu-environment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
