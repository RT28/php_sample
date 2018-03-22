<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\DegreeLevel */

$this->title = 'Create Degree Level';
$this->params['breadcrumbs'][] = ['label' => 'Degree Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="degree-level-create">
<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
			    <h1><?= Html::encode($this->title) ?></h1>

				<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

			    <?= $this->render('_form', [
			        'model' => $model,
			    ]) ?>
			</div>
		</div>
</div>
</div>
