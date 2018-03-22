<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */

$this->title = 'Reply to the enquiry';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
?>
<div class="emailenquiry-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form2', [
        'model' => $model,
        'tag' => $tag,
        'status' => $status,
    ]) ?>

</div>
