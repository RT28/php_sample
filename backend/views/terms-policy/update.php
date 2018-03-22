<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TermsPolicy */

$this->title = 'Update Terms Policy: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Terms Policies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="terms-policy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
