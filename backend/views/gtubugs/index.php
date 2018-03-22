<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\GtuEnvironment;
use backend\models\GtuModule;
use backend\models\EmployeeLogin;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\GtuBugsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gtu Bugs';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';


$status = array('Open'=>'Re-open','Resolved'=>'Resolved','Verified'=>'Verified','Close'=>'Close','Duplicate'=>'Duplicate' );
?>
<div class="gtu-bugs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gtu Bugs', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
          GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'gt_id',
		[	'attribute' => 'gt_subject', 
		'label' => 'Subject', 
		'contentOptions' => ['style' => '  max-width:250px; white-space: 	normal; ']
		], 			 
            'gt_type',
            [
                'attribute' => 'gt_envid',
                'value' => 'env.gt_name',
                'filter' => \yii\helpers\ArrayHelper::map(GtuEnvironment::find()->all(), 'gt_id', 'gt_name'),
            ],
            [
                'attribute' => 'gt_bugmoduleid',
                'value' => 'module.gt_name',
                'filter' => \yii\helpers\ArrayHelper::map(GtuModule::find()->all(), 'gt_id', 'gt_name'),
            ],
            //'gt_screenshot',
            // 'gt_platform',
            // 'gt_browser',
            // 'gt_url:url',
             'gt_severity',
            [
                'attribute' => 'gt_assignto',
                'value' => 'gt_assignto',
                'filter' => \yii\helpers\ArrayHelper::map(EmployeeLogin::find()->all(), 'username', 'username'),
				'contentOptions' => ['style' => '  max-width:100px; white-space: 	normal; ']
            ],
            'gt_deadline',
             'gt_createdby',
             'gt_createdon',
			 [
                'attribute' => 'gt_status',  
				'filter'=>Html::dropDownList('GtuBugsSearch[gt_status]',isset($_REQUEST['GtuBugsSearch']['gt_status']) ? $_REQUEST['GtuBugsSearch']['gt_status'] : null,$status,['class' => 'form-control', 'prompt' => 'Status']),
				'contentOptions' => ['style' => '  max-width:100px; white-space: 	normal; ']
            ], 
            // 'gt_verifiedby',
            // 'gt_verifiedon',
            // 'gt_resolvedby',
            // 'gt_resolvedon',
            // 'gt_modifiedby',
            // 'gt_lastmodified',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
