<?php

use yii\helpers\Html;

use yii\widgets\DetailView;
use yii\helpers\FileHelper;
/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = '' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update'; 
$this->context->layout = 'profile';
 
?>
                <div class="row" id="tab-profile">
                    <div class="col-sm-12">
                        <div class="basic-details"> 

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload,   
        'degree' => $degree,
        'currentTab' => $currentTab,
        'tabs' => $tabs,
        'majors' => $majors,         
        'institutionType' => $institutionType,
        'establishment' => $establishment,
        'courseType' => $courseType,
        'id' => $id,
        'degreeLevels' => $degreeLevels,
        'languages' => $languages,
        'intake' => $intake,
        'currencies' => $currencies,
        'durationType' => $durationType,
        'standardTests' => $standardTests,
		'documentlist'=> $documentlist,
		'doclist'=> $doclist
    ]) ?>
 
                        </div>
                    </div>
                </div>
 
 