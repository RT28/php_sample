<?php
    use yii\helpers\Html;
    $this->context->layout = 'main';
    $this->title = $model->name;
    use yii\widgets\ActiveForm;
    use kartik\date\DatePicker;
?>

<div class="consultant-associates-create col-sm-10">
    <div class="row">
        <h1><?= Html::encode($this->title) ?> </h1>
        <?php if(isset($message) && strpos($message, 'Error') !== false): ?>
            <div class="alert alert-danger" role="alert"><?= $message ?></div>
        <?php endif; ?>
        <?php $form = ActiveForm::begin(['id' => 'consultant-registration-form']) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(),[
                'name' => 'date_of_birth',
                    'type' => DatePicker::TYPE_INPUT,
                    'pluginOptions' => [
                    'autoClose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);?>
            <?= $form->field($model, 'gender')->dropDownList(['M' => 'Male', 'F' => 'Female'], ['prompt' => 'Select']); ?>
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'country_id')->dropDownList($countries, ['prompt' => 'Select...']); ?>
            <?= $form->field($model, 'speciality')->textArea(['rows' => 4]) ?>
            <?= $form->field($model, 'description')->textArea(['rows' => 4]) ?>
            <?= $form->field($model, 'experience')->textInput(['maxlength' => true, 'placeholder' => 'Experience in Years...']) ?>
            <?= $form->field($model, 'skills')->textArea(['rows' => 4]) ?>
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'btn-update']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
