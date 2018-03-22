<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentStandardTestDetail */

?>
<div class="student-standard-test-detail-update">

    <?= $this->render('_form', [
        'model' => $model,
        'subjects'=>$subjects,
    ]) ?>

</div>
