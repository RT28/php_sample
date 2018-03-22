<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityTemp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-temp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'university_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_partner')->textInput() ?>

    <?= $form->field($model, 'establishment_date')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_id')->textInput() ?>

    <?= $form->field($model, 'state_id')->textInput() ?>

    <?= $form->field($model, 'country_id')->textInput() ?>

    <?= $form->field($model, 'pincode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person_designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput() ?>

    <?= $form->field($model, 'institution_type')->textInput() ?>

    <?= $form->field($model, 'establishment')->textInput() ?>

    <?= $form->field($model, 'no_of_students')->textInput() ?>

    <?= $form->field($model, 'no_of_undergraduate_students')->textInput() ?>

    <?= $form->field($model, 'no_of_post_graduate_students')->textInput() ?>

    <?= $form->field($model, 'no_of_international_students')->textInput() ?>

    <?= $form->field($model, 'no_faculties')->textInput() ?>

    <?= $form->field($model, 'no_of_international_faculty')->textInput() ?>

    <?= $form->field($model, 'cost_of_living')->textInput() ?>

    <?= $form->field($model, 'undergarduate_fees')->textInput() ?>

    <?= $form->field($model, 'undergraduate_fees_international_students')->textInput() ?>

    <?= $form->field($model, 'post_graduate_fees')->textInput() ?>

    <?= $form->field($model, 'post_graduate_fees_international_students')->textInput() ?>

    <?= $form->field($model, 'accomodation_available')->checkbox() ?>

    <?= $form->field($model, 'hostel_strength')->textInput() ?>

    <?= $form->field($model, 'institution_ranking')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'virtual_tour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avg_rating')->textInput() ?>

    <?= $form->field($model, 'standard_tests_required')->checkbox() ?>

    <?= $form->field($model, 'standard_test_list')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'achievements')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'currency_id')->textInput() ?>

    <?= $form->field($model, 'currency_international_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'reviewed_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reviewed_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
