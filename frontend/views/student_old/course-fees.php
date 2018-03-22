<?php if(!empty($model)): ?>

<p> Programme: <?= $model->name; ?></p>
<p> University: <?= $model->university->name; ?></p>
<?php
    $currency = $model->university->currency->iso_code;
    $fees = 'NA';
    if(isset($model->university->currency->symbol)) {
        $currency = $model->university->currency->symbol;
    }
    if (isset($model->application_fees)) {
        $fees = Yii::$app->formatter->asInteger($model->application_fees);
    }
?>
<p> Application Fees: <?= $currency; ?><?= $fees; ?></p>
<p> Admin Fees: $100</p>

<?php else: ?>
    <div class="alert alert-danger">Programme not found </div>
<?php endif; ?>