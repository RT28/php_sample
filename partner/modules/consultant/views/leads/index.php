<?php use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu; 
use common\models\StudentSrmRelation;
use common\models\StudentConsultantRelation;
use common\models\SRM;
use common\models\StudentPackageDetails;
use common\models\StudentUniveristyApplication;
use common\models\StudentLeadFollowup;
use backend\models\LeadsFollowupSearch;
use frontend\models\Favorites;
use common\models\PackageType;
use common\models\Consultant;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\components\ConnectionSettings;
use common\components\Commondata;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$course = ArrayHelper::map(Favorites::find()->all(), 'id', 'course.name');
$consultants = ArrayHelper::map(Consultant::find()->where(['=', 'parent_partner_login_id', 1])->orderBy('first_name')->all(), 'consultant_id', 'first_name');
$packages = PackageType::getPackageType();
$accessStatus = array(0=>'New Entry',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');

?>
<div class="consultant-dashboard-index col-sm-12">

        <div class="row">
            <div class="col-xs-16 col-md-16">
                <h1><?= Html::encode($this->title) ?></h1>
                <div class="row">
<div class="col-sm-12 ">

<?php if(Yii::$app->session->getFlash('Error')): ?>
    <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
        
<div id='content' style="display: none;" class="">
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
</div>
<?php //if($dataProvider->getTotalCount() != 0): ?>
<div class="col-sm-12 text-right">
<input type='button' id='hideshow' value='Filters'>
</div>
 <?php //endif; ?>
</div>
<?php $status = Yii::$app->request->get('status'); ?>
<input type="hidden" name="tab_id" id="tab_id" value="<?php echo $status; ?>">
<script type="text/javascript">
    $(document).ready(function(){
        var tab_id = $('#tab_id').val();
        $('#tab_'+tab_id).addClass('active-tab');
        
    });
</script>
<div class="row">
    <ul class="nav nav-tabs" role="tablist" >
            
            <li id="act_0" class="act_common" role="presentation"><a id='tab_0' href="index.php?r=consultant/leads/index&status=0" role="tab">New Entry
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentnew; ?></span>)</b>
            </a></li>
            <li id="act_5" class="act_common" role="presentation"><a id='tab_7' href="index.php?r=consultant/leads/index&status=7" role="tab">Today's Follow up 
            <b style="color: red;">(<span id="cnt_0"><?php echo $studenttoday; ?></span>)</b>    
            </a></li>
            <li id="act_1" class="act_common" role="presentation"><a id='tab_1' href="index.php?r=consultant/leads/index&status=1" role="tab">Active Follow up
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentactive; ?></span>)</b>    
            </a></li>
            <li id="act_2" class="act_common" role="presentation"><a id='tab_2' href="index.php?r=consultant/leads/index&status=2" role="tab">Inactive Follow up
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentinactive; ?></span>)</b>    
            </a></li>
            <li id="act_3" class="act_common" role="presentation"><a id='tab_3' href="index.php?r=consultant/leads/index&status=3" role="tab" >Access sent
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentaccesssend; ?></span>)</b>    
            </a></li>
            <li id="act_4" class="act_common" role="presentation"><a id='tab_4' href="index.php?r=consultant/leads/index&status=4" role="tab">Subscribed
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentsubscribed; ?></span>)</b>    
            </a></li>
            <li id="act_6" class="act_common" role="presentation"><a id='tab_6' href="index.php?r=consultant/leads/index&status=6" role="tab">Closed
            <b style="color: red;">(<span id="cnt_0"><?php echo $studentclosed; ?></span>)</b>    
            </a></li>
        </ul>
</div>
<p>&nbsp;</p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                     'export' => false,
                     'pjax' => true,
                    'columns' => [
                            ['class' => 'kartik\grid\ExpandRowColumn',
                              'value' => function ($model, $key, $index) { 
                                            return GridView::ROW_COLLAPSED;
                                    },
                            'detail' => function ($model, $key, $index) { 
                            $searchModel = new LeadsFollowupSearch();         
                            $searchModel->student_id = $model->id; 
                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                            return Yii::$app->controller->renderPartial('view', [
                                'searchModel' => $searchModel,
                                'dataProvider' => $dataProvider, 
                            ]);
                                    }
                            ],  
                        [
                            'label' => 'Date Joined',
                            'attribute' => 'created_at',
                            'value' => function($model){  
                                    $created_at = $model->created_at;
                                    $newdt = strtotime($created_at); 
                                    return date('d-M-Y', $newdt);  
                                },
                            
                        ],
                        ['attribute' => 'first_name',
                            'format' => 'raw',
                            'label' => 'Student',
                            'value' => function($model){  
                                $name = $model->first_name . ' ' .$model->last_name ;
                                if (isset($name)) {
                                    $id = Commondata::encrypt_decrypt('encrypt', $model->id);
                                    $temp = Html::a($name,'?r=consultant/students/view&id='.$id);
                                    return $temp; 
                                } else{ 
                                    return 'not assigned'; 
                                }
                            }, 
                            ], 

                        /*[
                            'label'=>'Status',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                 $status = $model->follow_status;
                                 if($status==0) { return 'New Entry'; }
                                 else if($status==1) { return 'Active'; }
                                 else if($status==2) { return 'Inactive'; }
                                 else if($status==3) { return 'Access Sent'; }
                                 else if($status==4) { return 'Subscribed'; }
                                
                            },
                            'filter'=>Html::dropDownList('LeadsSearch[status]',isset($_REQUEST['LeadsSearch']['status']) ? $_REQUEST['LeadsSearch']['status'] : null,$accessStatus,['class' => 'form-control', 'prompt' => 'Select status'])
                        ],*/
                        
                        [
                            'label'=>'Package Subscribed',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $packagetypeVal = "NA";
                                if(!empty($model->package_type)) {  
                                $Pname = array();
                                $packages = PackageType::getPackageType();
                                $package_type = $model->package_type;
                                if(!empty($package_type)){
                                    $package_type = explode(',',$package_type);
                                }
                                $StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();
                                foreach ($StudentPD  as $row){ 
                                    $Pname[] = $packages[$row->id]; 
                                } 
                                $packagetypeVal = implode(',',$Pname);
                                }  
                                 return $packagetypeVal;
                                /*$packagesName = array();
                                  
                                    $activePackages =  StudentPackageDetails::find()->where(['=', 'student_id', $model->id])->all(); 

                                    foreach ($activePackages  as $row){ 
                                        $pname =  PackageType::find()->where(['=', 'id', $row->package_type_id])->all(); 
                                        foreach ($pname  as $row1){
                                            return $row1->name;
                                        }
                                    }*/
                            },
                      
                        ],
                        
                        [
                            'label' => 'Last comment Date',
                            'value' => function ($model) {
                                $last_flcomment = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($last_flcomment as $lst) {
                                   $last_flcomment = $lst['comment_date'];
                                }
                                if(empty($last_flcomment)) {
                                    return 'NA';
                                }
                                $last_comment = $last_flcomment;
                                                  
                                return isset($last_comment) ? $last_comment : 'not assigned';
                            },
                            'filter' => false,
                        ],
                        [
                            'label' => 'Last comment',
                            'value' => function ($model) {
                                $last_flcomment = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($last_flcomment as $lst) {
                                   $last_flcomment = $lst['comment'];
                                }
                                if(empty($last_flcomment)) {
                                    return 'NA';
                                }
                                $last_comment = $last_flcomment;
                                                  
                                return isset($last_comment) ? $last_comment : 'not assigned';
                            },
                            'filter' => false,
                        ],

                        [
                            'label' => 'Next followup date',
                            'value' => function ($model) {
                                $next_follow_date = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($next_follow_date as $nextflp) {
                                   $next_follow_date = $nextflp['next_followup'];
                                }
                                if(empty($next_follow_date) OR $next_follow_date =='0000-00-00 00:00:00' ) {
                                    return 'NA';
                                }
                                                  
                                return isset($next_follow_date) ? $next_follow_date : 'not assigned';
                            },
                            'filter' => false,
                        ],

                        [
                            'label' => 'Next followup Comment',
                            'value' => function ($model) {
                                $next_follow_comment = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($next_follow_comment as $nextflp) {
                                   $next_follow_comment = $nextflp['next_follow_comment'];
                                }
                                if(empty($next_follow_comment)) {
                                    return 'NA';
                                }
                                                  
                                return isset($next_follow_comment) ? $next_follow_comment : 'not assigned';
                            },
                            'filter' => false,
                        ],
                        
                        ['class' => 'yii\grid\ActionColumn',
                            'buttons' => [   
                            'assignConsultant' => function ($url, $searchModel, $key) {
                                
                            $path = '?r=consultant/lead-followup/create&id='.$searchModel->id;
                            return  '<a href="#" class="btn btn-success" data-toggle="modal"
                            data-target="#addInvoiceModal" onclick=loadFollowupAdd("'.$path.'"); >Follow up</a> <br/>';
                            },   
                            ],
                            'template' => '{assignConsultant} '], 

                    ],
                ]); ?>

            </div>

        </div>

    </div>

<div id="addInvoiceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" id="AddInvoicePreview" style="height:800px; overflow:scroll;">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
    </div>
<?php
    $this->registerJsFile('js/chatnotification.js');
?>
<script> 
jQuery(document).ready(function(){ 
jQuery('#hideshow').on('click', function(event) {  
jQuery('#content').toggle('show');
});
}); 
</script>
