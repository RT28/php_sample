<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GtSeofields */

$this->title = 'Create Seo fields';
$this->params['breadcrumbs'][] = ['label' => 'Gt Seofields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gt-seofields-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
