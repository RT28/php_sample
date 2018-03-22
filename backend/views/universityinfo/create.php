<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Universityinfo */

$this->title = 'Create Universityinfo';
$this->params['breadcrumbs'][] = ['label' => 'Universityinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="universityinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>