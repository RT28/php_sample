<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use common\models\Agency;
use common\models\StudentConsultantRelation; 
use common\models\StudentPackageDetails;
use common\models\StudentUniveristyApplication;
use frontend\models\Favorites;
use common\models\PackageType;
use common\models\Consultant;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use common\components\Status; 

$agencies = Agency::getAllAgencies();

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
							'filter'=>false
                            
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
						
						 [
                            'label' => 'Agency',
                            'attribute' => 'consultantdetails',
                            'value' => function ($model) {
                                $ainfo = StudentConsultantRelation::findOne(['student_id' => $model->student_id]);
								if(!empty($ainfo->agency_id)){
                                $agency = Agency::findOne(['partner_login_id' => $ainfo->agency_id]);
									if(isset($agency)){
										return $agency->name;
									}
								}else{
									 return 'not assigned';
								}
                            },
							/*'filter'=>Html::dropDownList('StudentSearch[agency_id]',isset($_REQUEST['StudentSearch']['agency_id']) ? $_REQUEST['StudentSearch']['agency_id'] : null,$agencies,['class' => 'form-control', 'prompt' => 'Select Agency'])*/
                            
                        ],
                       
                         [
                            'label' => 'Consultant',
                            'attribute' => 'consultantdetails',
                            'value' => function ($model) {
                                $info = StudentConsultantRelation::findOne(['student_id' => $model->student_id]);
								if(!empty($info->consultant_id)){
                                $consultant = Consultant::findOne(['consultant_id' => $info->consultant_id]);
									if(isset($consultant)){
										return $consultant->first_name." ".$consultant->last_name;
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
                                'update' => function ($url, $model, $key) {
									
									 $info = StudentConsultantRelation::findOne(['student_id' => $model->student_id]);
								//if($info->agency_id==0){
									
                                    return Html::a(' ', ['admin-student/assign-agency', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-user', 'title' => 'Assign Counselor']);
								//}	
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