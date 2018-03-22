<?php 
use yii\helpers\Html; 
use kartik\grid\GridView; 
use kartik\grid\ExportMenu; 
use common\models\Country;  
use common\models\Consultant; 
use common\models\StudentConsultantRelation;  
use common\models\StudentPackageDetails;
use common\models\PackageType;   
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;  
use common\models\TaskCategory; 
use common\models\Tasks; 
use common\components\Commondata;

$this->context->layout = 'main';
$this->title = 'My Students'; 
$countrieslist = Country::getAllCountries();
$countrieslist = ArrayHelper::map($countrieslist, 'id', 'name');
$parentConsultantId = Yii::$app->user->identity->id; 
?>
<div class="consultant-dashboard-index col-sm-12">
   <div class="row">
      <div class="col-sm-12 ">
         <?php if(Yii::$app->session->getFlash('Error')): ?>    
         <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
         <?php endif; ?><?php if(Yii::$app->session->getFlash('Success')): ?>    
         <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
         <?php endif; ?>		
         <div id='content' style="display:none;" class=""><?php  echo $this->render('_search', ['model' => $searchModel]); ?></div>
      </div>
      <div class="col-sm-12 text-right"><input type='button' id='hideshow' value='Advance Filters'></div>
   </div>
   <?php echo GridView::widget(['dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'export' => false, 'pjax' => true, 'columns' => [['attribute' => 'first_name', 'format' => 'raw', 'label' => 'Student', 'value' =>
function ($model)
	{
	$name = $model->first_name . ' ' . $model->last_name;
	if (isset($name))
		{
		$id = Commondata::encrypt_decrypt('encrypt', $model->id);
		$temp = Html::a($name, '?r=consultant/students/view&id=' . $id);
		return $temp;
		}
	  else
		{
		return 'not assigned';
		}
	}

, 'filter' => false, 'contentOptions' => ['style' => 'max-width:100px; white-space: normal; ']], ['attribute' => 'last_name', 'label' => 'Subscribed Plans', 'value' =>
function ($searchModel)
	{
	$packages = PackageType::getPackageType();
	$activePackages = StudentPackageDetails::find()->where(['=', 'student_id', $searchModel->student_id])->all();
	foreach($activePackages as $row)
		{
		$packagesName[] = $packages[$row->package_type_id];
		}

	if (isset($packagesName))
		{
		return implode(',', $packagesName);
		}
	}

, 'filter' => false, 'contentOptions' => ['style' => 'max-width:100px; white-space: normal; ']], ['attribute' => 'id', 'label' => 'Task Status', 'format' => 'raw', 'value' =>
function ($searchModel)
	{
	$id = $searchModel->id;
	$TaskStatus = Tasks::TaskStatus();
	$arr = TaskCategory::find()->select(['id', 'name'])->orderBy(['position' => 'ASC'])->all();
	$content = '';
	foreach($arr as $cnt)
		{
		$taskData = '';
		$tasks = Tasks::find()->select(['title', 'status'])->where(['AND', ['=', 'student_id', $id], ['=', 'task_category_id', $cnt['id']]])->orderBy(['title' => 'ASC'])->all();
		if (count($tasks) > 0)
			{
			foreach($tasks as $task)
				{
				$taskData.= $task['title'] . ' : <b>' . $TaskStatus[$task['status']] . '</b> <br /><br />';
				}
			}
		  else
			{
			$taskData = 'No Task assigned from this category.';
			}

		$content.= '<span style="padding-right:20px; max-width:100; width:100;"><a href="#" title="Tasks" data-toggle="popover" data-trigger="hover" data-content="' . $taskData . '"> ' . strtoupper($cnt['name']) . '  </a></span>';
		}

	return $content;
	}

, 'filter' => false, 'contentOptions' => ['style' => 'max-width:600px; white-space: normal; ']], ], ]); ?>
</div>
<script><?php    $this->registerJsFile('js/chatnotification.js');?>$(document).ready(function(){    $('[data-toggle="popover"]').popover({       html : true, 	  content: function() {          var content = $(this).attr("data-popover-content");          return $(content).children(".popover-body").html();        },           });   });</script><script> jQuery(document).ready(function(){ jQuery('#hideshow').on('click', function(event) {  jQuery('#content').toggle('show');});});function toggle(id) { $('.kv-expand-detail-row').hide();$('#'+id).show();$(this).attr('data-color')} </script>