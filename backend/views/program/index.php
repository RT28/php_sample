<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use common\models\StandardTests;
use common\models\Others;
use common\models\City;
use common\models\State;
use common\models\Country;
use common\models\University;
use common\models\UniversityAdmission;

/* @var $this yii\web\View */
/* @var $searchModel partner\modules\university\models\UniversityCourseListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programs';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';


?>

<div class="university-course-list-index">
 
    <div class="container">
        
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p> 
					
  <?= Html::a('Create Program', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
				
				<div id="export-report">
    <?php
        $gridColumns = '';
        echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],		
        'columns' => [
		'program_code',
		[ 'attribute' => 'university_id',
		  'value' => 'university.name'],
		  
		[ 'label'=>'City',
		  'value' => function($searchModel){ 
		 
				$CityModel = University::find()->where(['id'=>$searchModel->university_id])->one();
				if(isset($CityModel)){
				$CityVal = City::find()->where(['id'=>$CityModel->city_id])->one();	
				 if(!empty($CityVal->name)){
					return $CityVal->name;
				 }else{
					 return "";
				 }					
				 }
				 
                 }
		],
		[ 'label'=>'State',
		  'value' => function($searchModel){ 
				$StateModel = University::find()->where(['id'=>$searchModel->university_id])->one();	
				if(isset($StateModel)){
				$StateVal = State::find()->where(['id'=>$StateModel->state_id])->one();					 
				if(!empty($StateVal->name)){
					return $StateVal->name;
				 }else{
					 return "";
				 }
				}	
                },
		],
		[ 'label'=>'Country',
		  'value' =>function($searchModel){ 
				$CountryModel = University::find()->where(['id'=>$searchModel->university_id])->one();	
			if(isset($CountryModel)){
				$CountryVal = Country::find()->where(['id'=>$CountryModel->country_id])->one();	
								  					 
				if(!empty($CountryVal->name)){
					return $CountryVal->name;
				 }else{
					 return "";
				 }
				}					
				
                },
		],		
		[ 'attribute' => 'degree_id',
		  'value' => 'degree.name',
		],
		[ 'attribute' => 'major_id',
		  'value' => 'major.name',
		],
		[ 'attribute' => 'degree_level_id',
		  'value' => 'degreeLevel.name',
		],		
		'name',
		'description',
		'intake', 
		[ 'attribute' => 'language',
		  'value' => function($searchModel){
				$array = explode(',',$searchModel->language) ; 
				$languageModel = Others::find()->where(['=', 'name', 'languages'])->one();
                $temp = explode(',', $languageModel->value); 
				$Llist = array();
				$Lvalue = '';
				foreach($temp as $key => $d){
					if(in_array($key,$array)){
						  
						 array_push($Llist, $d);
					}
				} 
				if(count($Llist)>0){
					 $Lvalue = implode(",",$Llist);	
				}  
				 
                     return $Lvalue;
					  
                }
		],
		'fees',
		'fees_international_students',
		'duration',		
		[ 'attribute' => 'duration_type',
		  'value' => function($searchModel){
		 
				$array = explode(',',$searchModel->duration_type) ; 
				$DModel = Others::find()->where(['=', 'name', 'duration_type'])->one();
                $temp = explode(',', $DModel->value); 
				$Llist = array();
				$Lvalue = '';
				foreach($temp as $key => $d){
					if(in_array($key,$array)){					 
						 array_push($Llist, $d);
					}
				} 
				if(count($Llist)>0){
					$Lvalue = implode(",",$Llist);	
				}  
				 
                     return $Lvalue;
                }
		],
		[ 'attribute' => 'type',
		  'value' => function($searchModel){
				$array = explode(',',$searchModel->type) ; 
				$CModel = Others::find()->where(['=', 'name', 'course_type'])->one();
                $temp = explode(',', $CModel->value); 
				$Llist = array();
				$Lvalue = '';
				foreach($temp as $key => $d){
					if(in_array($key,$array)){						
						 array_push($Llist, $d);
					}
				} 
				if(count($Llist)>0){
					$Lvalue = implode(",",$Llist);	
				}  
				 
                     return $Lvalue;
                }
		],
		'careers',
		'eligibility_criteria',		
		[ 
		'attribute' => 'standard_test_list',
		  'value' => function($searchModel){
				$array = explode(',',$searchModel->standard_test_list) ;
				 	$standardTestList = '';
                   $standard_test_list = StandardTests::find() 
                            ->where(['id'=>$array])->select('name')
                            ->asArray()->all();							
					if(count($standard_test_list)>0){
							foreach($standard_test_list as $key => $test ){
								$list[] = $test['name']; 
							}
							if(!empty($list))
							$standardTestList = implode(",",$list); 						
                    return $standardTestList;
					}else{
						  return "";
					}	
                }
		], 
		[ 'label'=>'Deadline (Open)',
		 // 'format'=>['datetime', 'php:d-M-Y'], 
		  'value' =>function($searchModel){ 
					$admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $searchModel->university_id], ['=', 'degree_level_id', $searchModel->degree_level_id],['=', 'course_id', $searchModel->id]])->one();
					
					if(isset($admission)){
						if( $admission->start_date =='0000-00-00' || $admission->start_date =='1969-12-31'){
							$startDate = "";
						}else{
							$startDate = $admission->start_date;	
						}
						return $startDate;
					}else{
						  return "";
					}					
           }
		],
		[ 'label'=>'Deadline (Closing)',
		  //'format'=>['datetime', 'php:d-M-Y'], 
		  'value' =>function($searchModel){ 
					$admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $searchModel->university_id], ['=', 'degree_level_id', $searchModel->degree_level_id],['=', 'course_id', $searchModel->id]])->one();
					if(isset($admission)){
						if( $admission->end_date =='0000-00-00' || $admission->end_date =='1969-12-31'){
							$startDate = "";
						}else{
							$startDate = $admission->end_date;	
						}
						return $startDate;
					}else{
						  return "";
					}
           }
		], 
		'application_fees',
		'application_fees_international',
		[ 'label'=>'Website',
		  'value' =>function($searchModel){  
					$admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $searchModel->university_id], ['=', 'degree_level_id', $searchModel->degree_level_id],['=', 'course_id', $searchModel->id]])->one();
					 if(isset($admission)){
					return $admission->admission_link;
						}else{
						  return "";
					}
           }
		], 		
		[ 'label'=>'Term',
		  'value' => function($searchModel){
				$admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $searchModel->university_id], ['=', 'degree_level_id', $searchModel->degree_level_id],['=', 'course_id', $searchModel->id]])->one();
				if(isset($admission)){
				$array = explode(',',$admission->intake) ; 
				$DModel = Others::find()->where(['=', 'name', 'intake'])->one();
                $temp = explode(',', $DModel->value); 
				$Llist = array();
				$Lvalue = '';
				foreach($temp as $key => $d){
					if(in_array($key,$array)){					 
						 array_push($Llist, $d);
					}
				} 
				if(count($Llist)>0){
					$Lvalue = implode(",",$Llist);	
				}  				 
                     return $Lvalue;
					 }else{
						  return "";
					}
                }
				
		],
		'program_website', 
		],
		
		'clearBuffers' => true ,
		'target' => ExportMenu::TARGET_SELF,
		'showConfirmAlert' => false,
		'batchSize' => 500,
        'fontAwesome' => true,
        'initProvider' => true,
        'columnSelectorOptions'=>[
            'class' => 'btn btn-default'
        ],
        'dropdownOptions' => [
            'label' => 'Export',
            'class' => 'btn btn-default'
        ],
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
           
        ],
        'filename' => 'programs_report',
        ]);
    ?>
    </div>
                
				<?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn' ,
						 'options'=>[ 'style'=>'max-width:200px; white-space: normal;'], 
						 ], 
						'program_code',
                        ['attribute' => 'name', 
						'contentOptions' => ['style' => '  max-width:200px; white-space: normal; ']
						],  
						
                        [ 'attribute' => 'degree_level_id',
						'contentOptions' => ['style' => '  max-width:200px; white-space: normal; '],
						  'value' => 'degreeLevel.name',
						   'filter'=>Html::dropDownList('UniversityCourseListSearch[degree_level_id]',isset($_REQUEST['UniversityCourseListSearch']['degree_level_id']) ? $_REQUEST['UniversityCourseListSearch']['degree_level_id'] : null,$dLevel,['class' => 'form-control', 'prompt' => 'Select Degree'])
						],
						[ 'attribute' => 'degree_id',
						'contentOptions' => ['style' => '  max-width:200px; white-space: normal; '],
						  'value' => 'degree.name',
						  'filter'=>Html::dropDownList('UniversityCourseListSearch[degree_id]',isset($_REQUEST['UniversityCourseListSearch']['degree_id']) ? $_REQUEST['UniversityCourseListSearch']['degree_id'] : null,$degrees,['class' => 'form-control', 'prompt' => 'Select Discipline'])
						],
                        [ 'attribute' => 'major_id',
						'contentOptions' => ['style' => '  max-width:200px; white-space: normal; '],
						  'value' => 'major.name',
						  'filter'=>Html::dropDownList('UniversityCourseListSearch[major_id]',isset($_REQUEST['UniversityCourseListSearch']['major_id']) ? $_REQUEST['UniversityCourseListSearch']['major_id'] : null,$majors,['class' => 'form-control', 'prompt' => 'Select Sub Discipline'])
						],
						[ 'attribute' => 'university_id',
						'contentOptions' => ['style' => '  max-width:300px; white-space: normal; '],
						  'value' => 'university.name',
						  'filter'=>Html::dropDownList('UniversityCourseListSearch[university_id]',isset($_REQUEST['UniversityCourseListSearch']['university_id']) ? $_REQUEST['UniversityCourseListSearch']['university_id'] : null,$universities,['class' => 'form-control', 'prompt' => 'Select University'])
						],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                </div> 
    </div>
 