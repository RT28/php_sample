<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityTemp */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'University Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-temp-view">

<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'university_id',
            'name',
            'is_partner',
            'establishment_date',
            'address',
            'city_id',
            'state_id',
            'country_id',
            'pincode',
            'email:email',
            'website',
            'description:ntext',
            'fax',
            'phone_1',
            'phone_2',
            'contact_person',
            'contact_person_designation',
            'contact_mobile',
            'contact_email:email',
            'location',
            'institution_type',
            'establishment',
            'no_of_students',
            'no_of_undergraduate_students',
            'no_of_post_graduate_students',
            'no_of_international_students',
            'no_faculties',
            'no_of_international_faculty',
            'cost_of_living',
            'undergarduate_fees',
            'undergraduate_fees_international_students',
            'post_graduate_fees',
            'post_graduate_fees_international_students',
            'accomodation_available:boolean',
            'hostel_strength',
            'institution_ranking:ntext',
            'video',
            'virtual_tour',
            'avg_rating',
            'standard_tests_required:boolean',
            'standard_test_list',
            'achievements:ntext',
            'comments:ntext',
            'currency_id',
            'currency_international_id',
            'status',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'reviewed_by',
            'reviewed_at',
        ],
    ]) ?>

</div>
</div>
</div>
</div>
