<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Status;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Document Types';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="document-types-index">
<div class="container">
<div class="row">
<div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Document Types', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'document_id',
            'document_name',
            //'document_status',
			[
                        'label' => 'Status',
                        'attribute'=>'document_status',
                        'value' => function($model) {
                            return Status::getStatusName($model->document_status);
							//return Status::getActiveInactiveStatus();
							
                        },
                        'filter'=>Html::dropDownList('DocumentTypesSearch[document_status]',isset($_REQUEST['PackageTypeSearch']['document_status']) ? $_REQUEST['PackageTypeSearch']['document_status'] : null,Status::getActiveInactiveStatus(),['class' => 'form-control', 'prompt' => 'Select status'])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
</div>
</div>
</div>