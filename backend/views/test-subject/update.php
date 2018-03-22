<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TestSubject */

$this->title = 'Update Test Subject: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Test Subjects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="test-subject-update">
<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
	</div>
</div>

</div>
