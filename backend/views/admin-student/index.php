<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\StudentSrmRelation;
use common\models\StudentConsultantRelation; 
use common\models\StudentPackageDetails;
use common\models\StudentUniveristyApplication;
use frontend\models\Favorites;
use common\models\PackageType;
use common\models\Consultant;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
\yii\web\JqueryAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';

$js = <<< 'SCRIPT'
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    $('body').popover({selector: '[data-toggle="popover"]'});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
$course = ArrayHelper::map(Favorites::find()->all(), 'id', 'course.name');
?>
<div class="student-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>
				
				<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
						[
                            'label' => 'Date',
                            'attribute' => 'created_at',
                            
                        ],
                         [
                            'label'=>'Name',
                            'attribute' => 'first_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $name = $model->first_name . ' ' .$model->last_name ;
                                if (isset($name)) {
                                   return Html::a(Html::encode($name),['admin-student/view-profile', 'id' => $model->id]);
                                }
                                else{ return 'not assigned'; }
                            },
                        ],
                       /* [
                            'label'=>'SRM',
                            'attribute' => 'srmdetails',
                            'value' =>  function ($model) {
                                $info = StudentSrmRelation::findOne(['student_id' => $model->student_id]);
								if(!empty($info->srm_id)){
									$srm = SRM::findOne(['id' => $info->srm_id]);
									return $srm->name;
								}else{
									return 'not assigned';
								}
                            },
                        ], */
                        /*[ 
                            'format' => 'raw',
                            'label' => 'Total Fav Course',
                            'attribute' => 'course',
                            'value' => function ($model) {
                                $applications =Favorites::find()->where(['student_id' => $model->student_id])->all();
                                $arr = array();
                                foreach($applications as $application){
                                    if(isset($application->course->name))
                                    $search = $application->course->name;
                                    if (!(in_array($search, $arr))){
                                        array_push($arr, $search);
                                    }    
                                } 
                                $list = implode(",\n", $arr);
                                return Html::tag('div', count($arr), ['data-toggle'=>'tooltip','data-placement'=>'left','title'=>$list,'style'=>'cursor:default;']);
                            },
                        ],
                        [
                            'label' => 'Package',
                            'attribute' => 'packagedetails',
                            'value' => function ($model) {
                                $package = StudentPackageDetails:: findone(['student_id' => $model->student_id]);
                                if(empty($package)) {
                                    return 'NA';
                                }
                                $package_name = $package->packagetype->name;                  
                                return isset($package_name) ? $package_name : 'not assigned';
                            },
                        ],*/
                        [
                            'label' => 'Consultant',
                            'attribute' => 'consultantdetails',
                            'value' => function ($model) {
                                $info = StudentConsultantRelation::findOne(['student_id' => $model->student_id]);
								if(!empty($info->consultant_id)){
                                $consultant = Consultant::findOne(['consultant_id' => $info->consultant_id]);
								 
									 $name = $consultant->first_name . ' ' .$consultant->last_name ;
                                if (isset($name)) {
                                   return $name;
                                }
								}else{
									 return 'not assigned';
								}
                            },
                            
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{viewprofile}{application}{update}{disable}',
                              'buttons' => [
							  'viewprofile' => function ($url, $model, $key) {
                                    return Html::a(' ', ['admin-student/view-profile', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-eye-open', 'title' => 'View Profile']);
                                },
                                'application' => function ($url, $model, $key) {
                                    return Html::a(' ', ['admin-student/view-applications', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-th-list', 'title' => 'View Applications']);
                                }, 
                                'disable' => function ($url, $model, $key) {
                                    if($model->student->status == 0){
                                        return Html::button('Enable', ['id'=> $model->id,'class' => 'btn btn-success','onclick'=>'enable('.$model->id.');']);
                                    }else{
                                         return Html::button('Disable',['id'=> $model->id,'class' => 'btn btn-danger', 
                                        'onclick'=>'disable('.$model->id.');']);
                                    }
                                    
                                },
                                ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
$('body').tooltip({
    selector: '[data-toggle="tooltip"]'
});
 function disable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=admin-student/disable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Enable").removeClass('btn-primary btn-danger') .addClass("btn-primary btn-success");
                        $("#"+id).attr("onclick","enable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }

   function enable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=admin-student/enable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Disable").removeClass('btn-primary btn-success') .addClass("btn-primary btn-danger");
                        $("#"+id).attr("onclick","disable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }
</script>