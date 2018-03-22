<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GtuBugs */

$this->title = 'Create Gtu Bugs';
$this->params['breadcrumbs'][] = ['label' => 'Gtu Bugs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gtu-bugs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
