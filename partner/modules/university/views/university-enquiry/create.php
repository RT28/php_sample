<?php

use yii\helpers\Html;
 

/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */

$this->title = 'University/Agency Enquiry';
$this->params['breadcrumbs'][] = ['label' => 'University Enquiry', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="university-enquiry-create">
<div class="container">
<div class="row">
  <div class="group-title-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
    <?= $this->render('_form', [
        'model' => $model,
		'institutionType' => $institutionType,
        'countries' => $countries,
		'message' => $message
    ]) ?>

</div>
</div>
</div>

   

