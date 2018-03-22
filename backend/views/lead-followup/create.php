<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LeadFollowup */

$this->title = 'Create Lead Followup';
$this->params['breadcrumbs'][] = ['label' => 'Lead Followups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-followup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
