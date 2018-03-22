<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
$this->title = 'Reviews & Ratings';
$this->context->layout = 'index';
?>
<script>
$('.login-header-title').text('Reviews & Ratings');
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <?php $form = ActiveForm::begin(['id'=> 'review-form']); ?>
                <div class="row">
                    <div class="form-group">
                        <?= $form->field($model, 'rating')->widget(StarRating::classname(), [
                            'options' => ['id' => 'rating'],
                            'pluginOptions' => [
                                'min' => 0,
                                'max' => 5,
                                'step' => 1,
                                'showClear' => false,
                                'showCaption' => true,
                                'starCaptions' => [
                                    1 => 'Very Poor',
                                    2 => 'Poor',
                                    3 => 'Ok',
                                    4 => 'Good',
                                    5 => 'Extremely Good',
                                ],
                                'starCaptionClasses' => [
                                    1 => 'text-danger',
                                    2 => 'text-danger',
                                    3 => 'text-warning',
                                    4 => 'text-info',
                                    5 => 'text-primary',
                                ],
                                ]
                        ]); ?>
                    </div>
                </div>

                <?= $form->field($model, 'review')->textArea(['rows' => 6, 'id' => 'review']) ?>

                <div class="form-group">
                    <button type="button" class="btn btn-blue btn-submit-review">Submit</button>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
