<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */

$this->title = 'Create Emailenquiry';
$this->params['breadcrumbs'][] = ['label' => 'Emailenquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailenquiry-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
