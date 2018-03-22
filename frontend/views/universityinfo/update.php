

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WebinarCreateRequest */

$this->title = 'Please send your answer for the following question';
$this->params['breadcrumbs'][] = ['label' => 'Universityinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'index';
?>
<div class="universityinfo-update">
<div class="container">
<div class="col-xs-10 col-md-10">
<div class="webinar-create">
 <?php 
	if(isset($status)) {
		if ($status === 'success') {
			echo '<div class="alert alert-success" role="alert">';
				echo 'Your request has been sent successfully!!. Thank you for your interest.';
			echo '</div>';
		}
		elseif($status === 'error') {
			echo '<div class="alert alert-danger" role="alert">';
				echo $error;
			echo '</div>';
		}
		if(isset($id) && isset($email)) {
			//echo Html::a('Resend Activation Link', ['resend-activation-link', 'id' => $id, 'email' => $email], ['class' => 'btn btn-primary']);
		}
	} else { ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <?php } ?>

</div>
</div>
</div>
</div>