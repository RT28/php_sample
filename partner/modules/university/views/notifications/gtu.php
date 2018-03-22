<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityNotifications */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="university-notifications-view">

    <h1><?= Html::encode($this->title) ?></h1>
 

    <?= $model->message; ?>

</div>
