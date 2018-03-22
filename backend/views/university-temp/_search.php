<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UniversityTempSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-temp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'university_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'is_partner') ?>

    <?= $form->field($model, 'establishment_date') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'state_id') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'pincode') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'phone_1') ?>

    <?php // echo $form->field($model, 'phone_2') ?>

    <?php // echo $form->field($model, 'contact_person') ?>

    <?php // echo $form->field($model, 'contact_person_designation') ?>

    <?php // echo $form->field($model, 'contact_mobile') ?>

    <?php // echo $form->field($model, 'contact_email') ?>

    <?php // echo $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'institution_type') ?>

    <?php // echo $form->field($model, 'establishment') ?>

    <?php // echo $form->field($model, 'no_of_students') ?>

    <?php // echo $form->field($model, 'no_of_undergraduate_students') ?>

    <?php // echo $form->field($model, 'no_of_post_graduate_students') ?>

    <?php // echo $form->field($model, 'no_of_international_students') ?>

    <?php // echo $form->field($model, 'no_faculties') ?>

    <?php // echo $form->field($model, 'no_of_international_faculty') ?>

    <?php // echo $form->field($model, 'cost_of_living') ?>

    <?php // echo $form->field($model, 'undergarduate_fees') ?>

    <?php // echo $form->field($model, 'undergraduate_fees_international_students') ?>

    <?php // echo $form->field($model, 'post_graduate_fees') ?>

    <?php // echo $form->field($model, 'post_graduate_fees_international_students') ?>

    <?php // echo $form->field($model, 'accomodation_available')->checkbox() ?>

    <?php // echo $form->field($model, 'hostel_strength') ?>

    <?php // echo $form->field($model, 'institution_ranking') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'virtual_tour') ?>

    <?php // echo $form->field($model, 'avg_rating') ?>

    <?php // echo $form->field($model, 'standard_tests_required')->checkbox() ?>

    <?php // echo $form->field($model, 'standard_test_list') ?>

    <?php // echo $form->field($model, 'achievements') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'currency_id') ?>

    <?php // echo $form->field($model, 'currency_international_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'reviewed_by') ?>

    <?php // echo $form->field($model, 'reviewed_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
