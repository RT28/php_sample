<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Country;
use common\models\Majors;

/* @var $this yii\web\View */
/* @var $model common\models\Student */


$this->title = 'Profile';

$this->context->layout = 'profile';
$this->params['breadcrumbs'][] = ['label' => 'University', 'url' => ['view']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="student-profile-main">
       <?= $this->render('_student_common_details');  ?>
    <div class="dashboard-detail">
        <div class="tab-content">
            <!-- PROFILE TAB -->
            <div role="tabpanel" class="tab-pane fade in active" id="d1">
                <div class="row" id="tab-profile">
                    <div class="col-sm-12">
                        <div class="basic-details">
                            <div class="row">
                                <div class="col-sm-9">
                                <h3>Basic Address</h3>
                                    <p><strong>Nationality:</strong> <?= $model->name ?></p>
                                </div>
                                <div class="col-sm-3">
                                    <?php
                                        $url = '?r=university/university/update';
                                    ?>
                                    <a class="btn btn-primary btn-blue btn-update" href="<?= $url; ?>" data-container="tab-profile">UPDATE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
