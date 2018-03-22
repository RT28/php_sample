<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Faq */

$this->title = 'Create Faq';
$this->params['breadcrumbs'][] = ['label' => 'Faqs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';

?>

<div class="faq-create">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
			    <h1><?= Html::encode($this->title) ?></h1>

			    <?= $this->render('_form', [
			        'model' => $model,
			        'faqCategory' => $faqCategory,
			    ]) ?>
			 </div>
		</div>
	</div>
</div>
