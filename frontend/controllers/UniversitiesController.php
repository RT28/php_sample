<?php

namespace frontend\controllers;

use Yii;
use common\models\University;
use frontend\models\UniversitySearch;
use backend\models\SiteConfig;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors; 
use common\models\UniversityCourseList;
use yii\db\Expression; 
use common\components\Model; 
use common\models\DegreeLevel;
use yii\helpers\FileHelper;  
use yii\base\ErrorException;

use common\components\ConnectionSettings;
use yii\db\IntegrityException;
use yii\data\ActiveDataProvider; 
use common\models\Others;
use yii\data\Pagination;
use frontend\models\StudentShortlistedCourse;
use common\models\UniversityAdmission;
use common\models\StandardTests;
use yii\widgets\LinkPager;
use yii\helpers\Html;
/**
 * UniversityController implements the CRUD actions for University model.
 */
class UniversitiesController extends Controller
{
    /**
     * @inheritdoc
     */  

    /**
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
	{
		
       /* Get disciple id and name from degree table */
		/*$discipline = Degree::find('id','name')
							->orderBy('name')
							->all();*/
							
	   /* Get degrees id and and from degree_level table */
		
      /*  $degrees = DegreeLevel::find('id','name')
								->orderBy('name')
								->all();*/
								
		/* Get countries list id and and from country table */
		
		$countries = Country::find('id','name')
					->orderBy('name')
					->all();
		
		/* Get university list id and and from university table */
		
		$university = University::find('id','name')
					//->select('id','name')
					->orderBy('name')
					->all();

		
        return $this->render('index', [
               // 'discipline' => $discipline,
				//'degrees' => $degrees,
				'countries' => $countries,
				'university' => $university
				//'universityTotalCount'=>$countQuery->count()
				
        ]);
    }
	
	public function actionMagorlist(){
		
	$degree_id = Yii::$app->request->post('degree_id');
	$majorOptionText='';
		if($degree_id){	
			$query = (new \yii\db\Query())
			->select('id,degree_id,name')
			->from('majors')
			//->groupBy('university_course_list.id')
			//->leftJoin('')
			->where(['degree_id' => $degree_id])
			->orderBy('name ASC')
			//->limit($limit)
			->all();
			$majorOptionText.='<option value="">Select Majors</option>';
			foreach($query as $getmajorData){
				
				$majorId=$getmajorData['id'];
				$name=$getmajorData['name'];
				
				$majorOptionText.='<option value="'.$majorId.'">'.$name.'</option>';
			}
			
		}
	echo $majorOptionText;exit;	
	}
	
	public function actionProgramlist(){
	
	Yii::$app->controller->enableCsrfValidation = false;
	
	//$decipline_id = Yii::$app->request->post('decipline_id'); // degree id 
	//$major_id = Yii::$app->request->post('major_id'); // 
	//$degreelevelId = Yii::$app->request->post('degree_id'); // degreelevel
	//$country = Yii::$app->request->post('country');
	//$universityId = Yii::$app->request->post('universityId');
	//$obytype = Yii::$app->request->post('obytype');
	//$sortorder = Yii::$app->request->post('sortorder');
	
	
	$page = Yii::$app->request->post('page');
	$cur_page = $page;
	$page -= 1;
	$per_page = 25; // Per page records
	$previous_btn = true;
	$next_btn = true;
	$first_btn = true;
	$last_btn = true;
	$start = $page * $per_page;
	$end = $cur_page * $per_page;

	//echo "Current Page=".$page;
	
	//echo "Start page = ".$start;
		
	//echo "End page = ".$end;
	
		
		$types = $this-> getOthers('course_type');
        $languages = $this-> getOthers('languages');
        $durationType = $this->getOthers('duration_type');
	
		$limit ="".intval($start).", ".intval($per_page)." ";

 //echo "Limit ". $limit;
	//$where='';
	/*if($decipline_id!=""){
		$where='degree_id='.$decipline_id.'';
	}*/
	
  $query = (new \yii\db\Query())
    ->select('*')
    ->from('university')
	->leftJoin('university_course_list', 'university_course_list.university_id = university.id')
	->groupBy('university.id')
	->orderBy('university.name ASC')
	// ->where($where)
	->limit(intval($per_page))->offset(intval($start))
	//->limit(50)
    ->all();

  $query_pag_num = (new \yii\db\Query())
	->select('COUNT(DISTINCT (university.id)) as total')
	//->select('COUNT(*),university_course_list.id')->distinct();
    ->from('university')
	->leftJoin('university_course_list', 'university_course_list.university_id = university.id')
	//->where($where)
	//->groupBy('university_course_list.id')
	->all();
	
$count = $query_pag_num[0]['total'];
if($count>0){
$no_of_paginations = ceil($count / $per_page);
}else{
	$no_of_paginations = 0;
}
//echo "count =".$count;
//echo "No of pagination =". $no_of_paginations;

	// print_r($query_pag_num);die;
		//$totalCourseCount = $models->count();

		 $time = time();
		 ?>
		
<?php foreach($query as $model): 

//print_r($model);die;
?>
    <div class="course-box">
        <h4><?= Html::a($model['name'], ['university/view', 'id' => $model['id']], ['class' => 'profile-link']) ?></h4>
        <p><?= $model['address'] ?></p>
        <p><?= $model['city_id'] ?>, <?= $model['state_id'] ?>, <?= $model['country_id'] ?></p>
    </div>
<?php endforeach ?>

<?php 		
 /* Calculating the staring and ending value for paging */
        if ($cur_page >= 7) {
            $start_loop = $cur_page - 3;
            if ($no_of_paginations > $cur_page + 3) {
                $end_loop = $cur_page + 3;
                //echo "if no of pagination (end loop)= ". $end_loop;
            } else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                $start_loop = $no_of_paginations - 6;
                //echo "consultant (start loop)= ". $start_loop;
            } else {
                $end_loop = $no_of_paginations;

                //echo "consultant (end loop)= ". $end_loop;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 7)
                $end_loop = 7;
            consultant
                $end_loop = $no_of_paginations;
        }
		$displaymsg='';
        if ($cur_page == 1) {
            if ($count <= $end) {
                $end = $count;
            }
            $displaymsg = 'Showing 1 to ' . $end . ' of ' . $count . ' entries';
            if ($count == 0) {
                $displaymsg = 'No Records Found!';
            }
        } elseif ($cur_page > 1 && $cur_page <= $no_of_paginations) {
            if ($count <= $end) {
                $end = $count;
            }
            $displaymsg = 'Showing ' . $start . ' to ' . $end . ' of ' . $count . ' entries';
        }
		$msg='';
        $msg = "~~<div class='pagination'>";
        $msg .="<div style='float:left; height:14px; padding:8px' class='dataTables_info' id='example_info' role='status' aria-live='polite'>";
        $msg .= $displaymsg;
        $msg .= "</div>";
        $msg .="<div style='float:right;'><ul class='pagination'>";


        // for enabling the first button
//bug id:521 alertpopup date:08-june-2016
        if ($first_btn && $cur_page > 1) {
            $msg .='<li p="1" class="active" onClick="pagingcustom(1);">First</li>';
        } else if ($first_btn) {
            $msg .='<li p="1"><a>First</a></li>';
        }
        // for enabling the previous button 	

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $msg .="<li p='$pre' class='active' onClick='pagingcustom($pre);'><a>Previous</a></li>";
        } else if ($previous_btn) {
			$pre='';
            $msg .="<li p='$pre'><a>Previous</a></li>";
        }


        for ($i = $start_loop; $i <= $end_loop; $i++) {

            if ($cur_page == $i)
                $msg .="<li p='$i' class='active'><a onClick='pagingcustom($i);'>{$i}</a></li>";
            else
                $msg .="<li p='$i'  class='active'><a onClick='pagingcustom($i);'>{$i}</a></li>";
        }

        // for enabling the next button 	

        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $msg .="<li p='$nex' class='active'><a onClick='pagingcustom($nex);'>Next</a></li>";
        } else if ($next_btn) {
            $msg .="<li p='$nex'><a>Next</a></li>";
        }
        // for enabling the last button 	

        /*if ($last_btn && $cur_page < $no_of_paginations) {
            $msg .="<li p='$no_of_paginations' class='active'><a onClick='pagingcustom($no_of_paginations);'>Last</a></li>";
        } consultant if ($last_btn) {
            $msg .="<li p='$no_of_paginations' class='inactive'><a>Last</a></li>";
        }*/

        $msg = $msg . "</ul></div></div>";

        echo $msg;		
			
	 }
	
	private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {           
            $model = explode(',', $model->value);
            return $model;
        }
    }
	
	public static function getAllCourses() {
        $degrees = Degree::find()->groupBy('name')->all();
        return ArrayHelper::map($degrees, 'id', 'name');
    }

}
