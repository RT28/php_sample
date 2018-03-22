<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Country;
use common\models\Majors;
use yii\helpers\ArrayHelper;
use common\components\Commondata;


	$this->context->layout = 'profile';

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Update Student Profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view']];
$this->params['breadcrumbs'][] = 'Update';
?>
 <?php

    $cover_photo_path = [];
    $src = './noprofile.gif';
    $user = $model->student->id;
    if(is_dir("./../web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);
    }
    if (count($cover_photo_path) > 0) {
        $src = $cover_photo_path[0];
    }
?>


<div class="student-profile-main">
    <?= $this->render('_student_common_details');
    ?>
    <h3 class="update-profile-title"><?= Html::encode($this->title) ?></h3>

    <?php 
        if(!$model->isNewRecord) {
            echo Html::a('View', Url::to(['student/view']), ['class'=>'btn btn-blue pull-right']); 
        }
    ?>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload
    ]) ?>
 </div>
