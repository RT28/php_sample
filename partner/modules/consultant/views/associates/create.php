<?php
    use yii\helpers\Html;
    $this->context->layout = 'main';
    $this->title = 'Create Associates';
?>

<div class="consultant-associates-create col-sm-10">
    <div class="row">
        <h1><?= Html::encode($this->title) ?> </h1>

        <?= $this->render('_form', [
            'model' => $model,
            'partnerLogin' => $partnerLogin,
            'countries' => $countries,
			'degrees' => $degrees,
            'message' => $message
        ]); ?>
    </div>
</div>
