<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Country; 
use common\models\DegreeLevel;
use common\models\Majors;
/* @var $this yii\web\View */
/* @var $model common\models\WebinarCreateRequest */

$this->title = 'Update Webinar: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Create Webinar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="webinar-create-request-update">

<div class="container">
<div class="col-xs-10 col-md-10">
<div class="webinar-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'upload' => $upload,
        'countries' => ArrayHelper::map(Country::getAllCountries(), 'id', 'name'),
        'degree' => DegreeLevel::getAllDegreeLevels(),
        'majors' => Majors::getAllMajors()
    ]) ?>

</div>
</div>
</div>
</div>
