<?phpuse yii\helpers\Html;use kartik\grid\GridView; use kartik\grid\ExportMenu; use common\models\StudentSrmRelation;use common\models\StudentConsultantRelation;use common\models\SRM;use common\models\StudentPackageDetails;use common\models\StudentUniveristyApplication;use common\models\StudentLeadFollowup;use backend\models\LeadsFollowupSearch;use frontend\models\Favorites;use common\models\PackageType;use common\models\Consultant;use yii\helpers\ArrayHelper;use kartik\select2\Select2;use yii\widgets\Pjax;use yii\helpers\Url;use common\components\ConnectionSettings;use kartik\date\DatePicker;/* @var $this yii\web\View *//* @var $searchModel backend\models\StudentSearch *//* @var $dataProvider yii\data\ActiveDataProvider */$this->title = 'Leads';$this->params['breadcrumbs'][] = $this->title;$this->context->layout = 'main';$js = <<< 'SCRIPT'    $('body').tooltip({selector: '[data-toggle="tooltip"]'});    $('body').popover({selector: '[data-toggle="popover"]'});SCRIPT;// Register tooltip/popover initialization javascript$this->registerJs($js);$course = ArrayHelper::map(Favorites::find()->all(), 'id', 'course.name');$consultants = ArrayHelper::map(Consultant::find()->where(['=', 'parent_partner_login_id', 1])->orderBy('first_name')->all(), 'consultant_id', 'first_name');$packages = PackageType::getPackageType();$accessStatus = array(0=>'New Entry',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');?><div class="consultant-dashboard-index col-sm-12">        <div class="row">            <div class="col-xs-16 col-md-16">                <h1><?= Html::encode($this->title) ?></h1>                <?= GridView::widget([                    'dataProvider' => $dataProvider,                    'filterModel' => $searchModel,                     'export' => false,        			 'pjax' => true,                    'columns' => [	                        ['class' => 'kartik\grid\ExpandRowColumn',					          'value' => function ($model, $key, $index) { 					                        return GridView::ROW_COLLAPSED;					                },					        'detail' => function ($model, $key, $index) { 					        $searchModel = new LeadsFollowupSearch();         					        $searchModel->student_id = $model->id; 					        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);					      //  $dataProvider->sort->attributes['id'];					        return Yii::$app->controller->renderPartial('view', [					            'searchModel' => $searchModel,					            'dataProvider' => $dataProvider, 					        ]);					                }					        ],                         [                            'label' => 'Date Joined',                            'attribute' => 'created_at',                            'value' => function($model){                                      $created_at = $model->created_at;                                    $newdt = strtotime($created_at);                                     return date('d-M-Y', $newdt);                                  },                                                             /*'filter' => DatePicker::widget([                            'model'=>$searchModel,                            'attribute'=>'created_at',                            'pluginOptions' => [                            'autoclose'=>true,                            'format' => 'yyyy-mm-dd',                            ]                            ]),*/                        'format' => 'html',                                                    ],                        ['attribute' => 'first_name',	'format' => 'raw',	'label' => 'Student',	'value' => function($model){  		$name = $model->first_name . ' ' .$model->last_name ;		if (isset($name)) {			$temp = Html::a($name,'?r=agency/students/view&id='.$model->id);			return $temp; 		} else{ 			return 'not assigned'; 		}	}, 	],                         [                            'label'=>'Status',                            'attribute' => 'status',                            'format' => 'raw',                            'value' => function ($model) {                                 $status = $model->follow_status;                                 if($status==0) { return 'New Entry'; }                                 else if($status==1) { return 'Active'; }                                 else if($status==2) { return 'Inactive'; }                                 else if($status==3) { return 'Access Sent'; }                                 else if($status==4) { return 'Subscribed'; }                                                            },                            'filter'=>Html::dropDownList('LeadsSearch[status]',isset($_REQUEST['LeadsSearch']['status']) ? $_REQUEST['LeadsSearch']['status'] : null,$accessStatus,['class' => 'form-control', 'prompt' => 'Select status'])                        ],                        [                            'label' => 'Consultant',                            'attribute' => 'consultantdetails',                            'value' => function ($model) {                                $info = StudentConsultantRelation::findOne(['student_id' => $model->id]);                                if(!empty($info->consultant_id)){                                $consultant = Consultant::findOne(['consultant_id' => $info->consultant_id]);                                    if(isset($consultant)){                                        return $consultant->first_name." ".$consultant->last_name;                                    }                                }else{                                     return 'not assigned';                                }                            },                            'filter'=>Html::dropDownList('LeadsSearch[consultant_id]',isset($_REQUEST['LeadsSearch']['consultant_id']) ? $_REQUEST['LeadsSearch']['consultant_id'] : null,$consultants,['class' => 'form-control', 'prompt' => 'Select Consultant'])                                                    ],                        [                            'label'=>'Package Subscribed',                            //'attribute' => 'first_name',                            'format' => 'raw',                            'value' => function ($model) {                                $packagesName = array();                                                                      $activePackages =  StudentPackageDetails::find()->where(['=', 'student_id', $model->id])->all();                                     /*foreach ($activePackages  as $row){                                             $packagesName[] = $row->package_type_id;                                         }*/                                    foreach ($activePackages  as $row){                                         $pname =  PackageType::find()->where(['=', 'id', $row->package_type_id])->all();                                         foreach ($pname  as $row1){                                            return $row1->name;                                        }                                    }                            },                            /*'filter'=>Html::dropDownList('LeadsSearch[package_type]',isset($_REQUEST['LeadsSearch']['package_type']) ? $_REQUEST['LeadsSearch']['package_type'] : null,$packages,['class' => 'form-control', 'prompt' => 'Select Package'])*/                        ],                       /* [                            'label'=>'Package Interested',                            'format' => 'raw',                            'value' => function ($model) {                                if(!empty($model->package_type)) {                                  $Pname = array();                                $packages = PackageType::getPackageType();                                $package_type = $model->package_type;                                $StudentPD = PackageType::find()->where(['IN', 'id', $package_type])->all();                                foreach ($StudentPD  as $row){                                     $Pname[] = $packages[$row->id];                                 }                                 $packagetypeVal = implode(',',$Pname); return $packagetypeVal;                                    }else{                                    return "NA";                                    }                             },                            'filter'=>Html::dropDownList('LeadsSearch[package_type]',isset($_REQUEST['LeadsSearch']['package_type']) ? $_REQUEST['LeadsSearch']['package_type'] : null,$packages,['class' => 'form-control', 'prompt' => 'Select Package'])                        ],*/                        [                            'label' => 'Last comment Date',                            //'attribute' => 'packagedetails',                            'value' => function ($model) {                                $last_flcomment = StudentLeadFollowup:: getlastfollowup($model->id);                                foreach ($last_flcomment as $lst) {                                   $last_flcomment = $lst['comment_date'];                                }                                if(empty($last_flcomment)) {                                    return 'NA';                                }                                $last_comment = $last_flcomment;                                                                                  return isset($last_comment) ? $last_comment : 'not assigned';                            },                            'filter' => false,                        ],                        [                            'label' => 'Last comment',                            //'attribute' => 'packagedetails',                            'value' => function ($model) {                                $last_flcomment = StudentLeadFollowup:: getlastfollowup($model->id);                                foreach ($last_flcomment as $lst) {                                   $last_flcomment = $lst['comment'];                                }                                if(empty($last_flcomment)) {                                    return 'NA';                                }                                $last_comment = $last_flcomment;                                                                                  return isset($last_comment) ? $last_comment : 'not assigned';                            },                            'filter' => false,                        ],                        [                            'label' => 'Next followup date',                            //'attribute' => 'packagedetails',                            'value' => function ($model) {                                $next_follow_date = StudentLeadFollowup:: getlastfollowup($model->id);                                foreach ($next_follow_date as $nextflp) {                                   $next_follow_date = $nextflp['next_followup'];                                }                                if(empty($next_follow_date) OR $next_follow_date =='0000-00-00 00:00:00' ) {                                    return 'NA';                                }                                //$next_follow_date = $next_follow_date;                                                                                  return isset($next_follow_date) ? $next_follow_date : 'not assigned';                            },                            'filter' => false,                        ],                        [                            'label' => 'Next followup Comment',                            //'attribute' => 'packagedetails',                            'value' => function ($model) {                                $next_follow_comment = StudentLeadFollowup:: getlastfollowup($model->id);                                foreach ($next_follow_comment as $nextflp) {                                   $next_follow_comment = $nextflp['next_follow_comment'];                                }                                if(empty($next_follow_comment)) {                                    return 'NA';                                }                                //$next_follow_date = $next_follow_date;                                                                                  return isset($next_follow_comment) ? $next_follow_comment : 'not assigned';                            },                            'filter' => false,                        ],                       	['class' => 'yii\grid\ActionColumn',							'buttons' => [   							'assignConsultant' => function ($url, $searchModel, $key) {															$path = '';							$path= ConnectionSettings::BASE_URL.'partner/';							$path = $path.'web/index.php?r=agency/lead-followup/create&id='.$searchModel->id;							return  '<a href="#" class="btn btn-success" data-toggle="modal"							data-target="#addInvoiceModal" onclick=loadFollowupAdd("'.$path.'"); >Follow up</a> <br/>';							},	 							],							'template' => '{assignConsultant} '],                     ],                ]); ?>            </div>        </div>    </div><div id="addInvoiceModal" class="modal fade" role="dialog">            <div class="modal-dialog modal-lg">                <!-- Modal content-->                <div class="modal-content">                  <div class="modal-header">                    <button type="button" class="close" data-dismiss="modal">&times;</button>                  </div>                  <div class="modal-body" id="AddInvoicePreview" style="height:800px; overflow:scroll;">                                    </div>                  <div class="modal-footer">                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                  </div>                </div>            </div>    </div><script> jQuery(document).ready(function(){ jQuery('#hideshow').on('click', function(event) {  jQuery('#content').toggle('show');});}); </script>