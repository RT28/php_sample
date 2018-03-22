<?php

use yii\helpers\Html;
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

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
\yii\web\JqueryAsset::register($this);
\yii\bootstrap\BootstrapPluginAsset::register($this);
$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';

$js = <<< 'SCRIPT'
    $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    $('body').popover({selector: '[data-toggle="popover"]'});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
$course = ArrayHelper::map(Favorites::find()->all(), 'id', 'course.name');
$consultants = ArrayHelper::map(Consultant::find()->orderBy('first_name')->all(), 'consultant_id', 'first_name');
$packages = PackageType::getPackageType();
$accessStatus = array(1=>'New Entry/ Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');

?>
<div class="student-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-16 col-md-16">
                <h1><?= Html::encode($this->title) ?></h1>
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
      //  $dataProvider->sort->attributes['id'];
        return Yii::$app->controller->renderPartial('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
        ]);
                }
        ], 
                        [
                            'label' => 'Date Joined',
                            'attribute' => 'created_at',
                            
                        ],
                         [
                            'label'=>'Student Name',
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
                        ],*/
                        [
                            'label'=>'Status',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                 $status = $model->status;
                                 if($status==1) {
                                            $exist_followup = StudentLeadFollowup:: getlastfollowup($model->id);
                                            if(empty($exist_followup)) {
                                                return 'New Entry';
                                            } else { return 'Active'; }   
                                 }
                                 else if($status==2) { return 'Inactive/Closed'; }
                                 else if($status==3) { return 'Access Sent'; }
                                 else if($status==4) { return 'Subscribed'; }
                                
                            },
                            'filter'=>Html::dropDownList('LeadsSearch[status]',isset($_REQUEST['LeadsSearch']['status']) ? $_REQUEST['LeadsSearch']['status'] : null,$accessStatus,['class' => 'form-control', 'prompt' => 'Select status'])
                        ],
                        [
                            'label' => 'Consultant',
                            'attribute' => 'consultantdetails',
                            'value' => function ($model) {
                                $info = StudentConsultantRelation::findOne(['student_id' => $model->id]);
                                if(!empty($info->consultant_id)){
                                $consultant = Consultant::findOne(['consultant_id' => $info->consultant_id]);
                                    if(isset($consultant)){
                                        return $consultant->first_name." ".$consultant->last_name;
                                    }
                                }else{
                                     return 'not assigned';
                                }
                            },
                            'filter'=>Html::dropDownList('LeadsSearch[consultant_id]',isset($_REQUEST['LeadsSearch']['consultant_id']) ? $_REQUEST['LeadsSearch']['consultant_id'] : null,$consultants,['class' => 'form-control', 'prompt' => 'Select Consultant'])
                            
                        ],
                        [
                            'label'=>'Package',
                            //'attribute' => 'first_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $packagesName = array();
                                  
                                    $activePackages =  StudentPackageDetails::find()->where(['=', 'student_id', $model->id])->all(); 
                                    /*foreach ($activePackages  as $row){ 
                                            $packagesName[] = $row->package_type_id; 
                                        }*/

                                    foreach ($activePackages  as $row){ 
                                        $pname =  PackageType::find()->where(['=', 'id', $row->package_type_id])->all(); 
                                        foreach ($pname  as $row1){
                                            return $row1->name;
                                        }
                                    }
                            },
                            /*'filter'=>Html::dropDownList('LeadsSearch[package_type]',isset($_REQUEST['LeadsSearch']['package_type']) ? $_REQUEST['LeadsSearch']['package_type'] : null,$packages,['class' => 'form-control', 'prompt' => 'Select Package'])*/
                        ],
                        /*[
                            'label'=>'Package Interested',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if(!empty($model->package_type)) {  
                                    $Pname = array();
                                    $package_type = $model->package_type;
                                    $StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();

                                    foreach ($StudentPD  as $row){ 
                                    $Pname[] = $row->id; 
                                    }

                                    return implode(',',$Pname);

                                    }else{
                                    return "NA";
                                    } 
                            },
                            'filter'=>Html::dropDownList('LeadsSearch[package_type]',isset($_REQUEST['LeadsSearch']['package_type']) ? $_REQUEST['LeadsSearch']['package_type'] : null,$packages,['class' => 'form-control', 'prompt' => 'Select Package'])
                        ],*/
                        [
                            'label' => 'Last comment Date',
                            //'attribute' => 'packagedetails',
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
                            //'attribute' => 'packagedetails',
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
                            //'attribute' => 'packagedetails',
                            'value' => function ($model) {
                                $next_follow_date = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($next_follow_date as $nextflp) {
                                   $next_follow_date = $nextflp['next_followup'];
                                }
                                if(empty($next_follow_date) OR $next_follow_date =='0000-00-00 00:00:00' ) {
                                    return 'NA';
                                }
                                //$next_follow_date = $next_follow_date;
                                                  
                                return isset($next_follow_date) ? $next_follow_date : 'not assigned';
                            },
                            'filter' => false,
                        ],
                        [
                            'label' => 'Next followup Comment',
                            //'attribute' => 'packagedetails',
                            'value' => function ($model) {
                                $next_follow_comment = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($next_follow_comment as $nextflp) {
                                   $next_follow_comment = $nextflp['next_follow_comment'];
                                }
                                if(empty($next_follow_comment)) {
                                    return 'NA';
                                }
                                //$next_follow_date = $next_follow_date;
                                                  
                                return isset($next_follow_comment) ? $next_follow_comment : 'not assigned';
                            },
                            'filter' => false,
                        ],
                        /*[
                            'label' => 'Packages',
                            //'attribute' => 'packagedetails',
                            'value' => function ($model) {
                                $next_follow_comment = StudentLeadFollowup:: getlastfollowup($model->id);
                                foreach ($next_follow_comment as $nextflp) {
                                   $next_follow_comment = $nextflp['next_follow_comment'];
                                }
                                if(empty($next_follow_comment)) {
                                    return 'NA';
                                }
                                //$next_follow_date = $next_follow_date;
                                                  
                                return isset($next_follow_comment) ? $next_follow_comment : 'not assigned';
                            },
                            'filter' => false,
                        ],*/
                        
                        

                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
