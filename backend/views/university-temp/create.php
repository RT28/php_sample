<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UniversityTemp */

$this->title = 'Create University Temp';
$this->params['breadcrumbs'][] = ['label' => 'University Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-temp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
