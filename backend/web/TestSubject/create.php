<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TestSubject */

$this->title = 'Create Test Subject';
$this->params['breadcrumbs'][] = ['label' => 'Test Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-subject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
