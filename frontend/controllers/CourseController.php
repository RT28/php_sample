<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UniversityCourseList;
use common\models\StudentUniveristyApplication;
use common\components\AdmissionWorkflow;
use common\models\Student;
use frontend\models\Favorites;
use common\models\StudentConsultantRelations;
use backend\models\EmployeeLogin;
use yii\helpers\Json;
use common\models\University;
use common\models\Others;
use common\models\Degree;
use common\models\Majors;
use common\models\Country;
use common\models\State;
use common\models\DegreeLevel;
use common\models\StandardTests;
use common\models\TestCategory;
use yii\helpers\ArrayHelper;
use common\models\CourseReviewsRatings;
use common\models\StudentFavouriteCourses;
use yii\data\Pagination;
use frontend\models\StudentShortlistedCourse;

/**
 * CourseController
 */
class CourseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StudentUniveristyApplication models.
     * @return mixed
     */
    public function actionIndex($degreeLevel='', $region='All', $major='All')
    {
		 Yii::$app->view->params['activeTab'] = 'programs';
        
		  /* $selectquery1='university_course_list.*';
			if(($region !== 'All') {
				$selectquery1.=',university.country_id,university.state_id,university.city_id';
				->select(''.$selectquery1.'')
            }
			*/
		$models = UniversityCourseList::find();
        //$models = UniversityCourseList::find()->where(['=', 'university_course_list.university_id', '806']);
		$models = $models->leftJoin('most_viewed_courses', '`most_viewed_courses`.`university_id` = `university_course_list`.`university_id`');
		
        $degrees = Degree::find()->orderBy('name')->all();
        $countries = Country::find()->where(['=','status','1'])->orderBy('name')->all();
        $degreeLevels = DegreeLevel::find()->orderBy('position')->all();
        $types = $this-> getOthers('course_type');
        $languages = $this-> getOthers('languages');
        $durationType = $this->getOthers('duration_type');
		
		$universitylist = University::find()->where(['is_active'=>1])->orderBy('name')->all();
		
		//echo "<pre>";
		//print_r($university);die;
		
        $majors = [];
        $states = [];
        $shortlisted = [];
        if (isset(Yii::$app->user->identity->id)) {
            $courses = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->all();
            $shortlisted = ArrayHelper::map($courses, 'course_id', 'course_id');
        } 
		/*$degreeLevelMap = [
            'Bachelors' => DegreeLevel::find()->where(['like', 'name', 'Undergraduate'])->one(),
            'Masters' => DegreeLevel::find()->where(['like', 'name', 'Masters'])->one(),
            'Phd' => DegreeLevel::find()->where(['like', 'name', 'Phd'])->one(),
        ]; */
		
		$degreeLevelMap= array();
		$params= array();
		if(!empty($degreeLevel)){ 
			$degreeLevelMap[$degreeLevel] = DegreeLevel::find()->where(['like', 'name', $degreeLevel])->all();
			foreach($degreeLevelMap[$degreeLevel] as $key){ 
				$params[$degreeLevel][]  = $key->id ;  
			}  
		}

       /* $degreeLevelMap = [
            'Bachelors' => DegreeLevel::find()->where(['like', 'name', 'Undergraduate'])->all(),
            'Masters' => DegreeLevel::find()->where(['like', 'name', 'Masters'])->all(),
            'Phd' => DegreeLevel::find()->where(['like', 'name', 'Phd'])->all(),
        ]; */
		 
		 

        #set country filters
        if($region !== 'All' && $region!="") {
            $region = explode(',', $region);
            $len = sizeof($region);
			
			//print_r($region);
            # search only for country.            
            if($len === 1) {
                $country = Country::find()->where(['=', 'name', $region[0]])->one();                
                if(!empty($country)) {
                    $models = $models->leftJoin('university', '`university`.`id` = `university_course_list`.`university_id`');
                    $models = $models->where(['=', 'country_id', $country->id]);
                    $params['country'] = $country->id;
                    $states = State::find()->where(['=', 'country_id', $country->id])->orderBy(['name' => 'ASC'])->all();
                }                
            }
            if ($len === 2) {
                $country = Country::find()->where(['=', 'name', $region[1]])->one();
                
                if(!empty($country)) {
                    $models = $models->leftJoin('university', '`university`.`id` = `university_course_list`.`university_id`');                    
                    $params['country'] = $country->id;
                    $states = State::find()->where(['=', 'country_id', $country->id])->orderBy(['name' => 'ASC'])->all();
                    $temp = State::find()->where(['AND', ['=', 'name', $region[0]], ['=', 'id', $country->id]])->one();
                    if(!empty($temp)) {
                        $params['state'] = $temp->id;
                        $models = $models->where(['AND', ['=', 'country_id', $country->id],['=', 'state_id', $temp->id]]);
                    } else {
                        $models = $models->where(['=', 'country_id', $country->id]);
                    }
                }
            }
            if ($len === 3) {
                $country = Country::find()->where(['=', 'name', $region[2]])->one();                
                if(!empty($country)) {
                    $models = $models->leftJoin('university', '`university`.`id` = `university_course_list`.`university_id`');                    
					$params['country'] = $country->id;
                    $states = State::find()->where(['=', 'country_id', $country->id])->orderBy(['name' => 'ASC'])->all();
                    $temp = State::find()->where(['AND', ['=', 'name', $region[1]], ['=', 'country_id', $country->id]])->one();
                    
					//echo "<pre>";
					//print_r($temp);die;
					
					if(!empty($temp)) {
                        $params['state'] = $temp->id;
                        $university = University::find()->where(['AND', ['=', 'name', $region[0]], ['=', 'country_id', $country->id], ['=', 'state_id', $temp->id]])->one();
                        if(!empty($university)) {
                            $params['university'] = $university->id;
                            $models = $models->where(['AND', ['=', 'country_id', $country->id],['=', 'state_id', $temp->id],['=', 'university.id', $university->id]]);
                        } else {
                            $models = $models->where(['AND', ['=', 'country_id', $country->id],['=', 'state_id', $temp->id]]);
                        }                        
                    } else {
                        $models = $models->where(['=', 'country_id', $country->id]);
                    }
                }
            }
        }
		
	 
		
		 
       if(!empty($params[$degreeLevel])) {
			$params['degreeLevel'] = $params[$degreeLevel];
			$models = $models->andWhere(['degree_level_id'=> $params[$degreeLevel]]);
        }  
		
		
        # set major filters
		
		
        if ($major !== 'All' && $major!="") {
			
			$major = explode(',', $major);
            $length = sizeof($major);
			/*echo "Len".$length;
			echo "Majors= ".print_r($major);
			die;
			*/
			if($length==1){
				$degreeModel = Degree::find()->where(['=', 'name', $major[0]])->one();
				if(!empty($major)) {
					$params['degree'] = $degreeModel->id;
					$models = $models->andWhere(['=', 'degree_id', $params['degree']]);
					
				}
			}
			if($length==2){
				$majorModel = Majors::find()->where(['=', 'name', $major[0]])->one();
				$degreeModel = Degree::find()->where(['=', 'name', $major[1]])->one();
				if(!empty($major)) {
					$params['major'] = $majorModel->id;
					$models = $models->andWhere(['=', 'major_id', $params['major']]);
					
					$params['degree'] = $degreeModel->id;
					$models = $models->andWhere(['=', 'degree_id', $params['degree']]);
					
					$majors = Majors::find()->where(['=', 'degree_id', $params['degree']])
					->orderBy('name','ASC')->all();
				}
			}
        }
	//print_r($params);die;
	$currpage=0;
	if (isset($_REQUEST['page'])){	
		$currpage=$_REQUEST['page'];
	}
	//echo "outside of condition=".$currpage;
	
        if(isset($_POST['searchbykeyword']) || isset($_POST['country']) || isset($_POST['state']) || isset($_POST['level']) || isset($_POST['degree'])||isset($_POST['major']) ||isset($_POST['university'])) {
            
			$selectquery='university_course_list.*';
			if(isset($_POST['country']) || isset($_POST['state'])) {
				$selectquery.=',university.country_id,university.state_id,university.city_id';
            }
			$query = UniversityCourseList::find()->select(''.$selectquery.'')->leftJoin('most_viewed_courses', '`most_viewed_courses`.`university_id` = `university_course_list`.`university_id`');
		
            if(isset($_POST['country']) || isset($_POST['state'])) {
				$query = $query->leftJoin('university', 'university.id = university_course_list.university_id');
            }
			//echo "inside condition=". $currpage;
			/********************************
				@Created by Pankaj 
				@search by keyword filter. 
			*********************************/
            if (isset($_POST['searchbykeyword'])) {
				
				$keyword=$_POST['searchbykeyword'][0];
				
                //$query = $query->where(['like', 'university_course_list.name', '%'.$keyword.'%']);
				
				$query = $query->where('university_course_list.name LIKE :searchkeyword');
						 $query->addParams([':searchkeyword'=>'%'.$keyword.'%']);

            }
			
            // country filter.
            if (isset($_POST['country'])) {
                $temp = [];
                foreach($_POST['country'] as $country) {
                    array_push($temp, $country);
                }
                $query = $query->andWhere(['in', 'university.country_id', $temp]);
            }

            // state filter.
            if (isset($_POST['state'])) {
                $temp = [];
                foreach($_POST['state'] as $state) {
                    array_push($temp, $state);
                }
                $query = $query->andWhere(['in', 'university.state_id', $temp]);
            }
			
			// University  filter.
            if (isset($_POST['university'])) {
                $temp = [];
                foreach($_POST['university'] as $university) {
                    array_push($temp, $university);
                }
                $query = $query->andWhere(['in', 'university_course_list.university_id', $temp]);
            }
			
            // degree level filter
            if (isset($_POST['level'])) {
                $temp = [];
                foreach($_POST['level'] as $level) {
                    array_push($temp, $level);
                }
                $query = $query->andWhere(['in', 'university_course_list.degree_level_id', $temp]);
            }

            // degree filter
            if (isset($_POST['degree'])) {
                $temp = [];
                foreach($_POST['degree'] as $degree) {
                    array_push($temp, $degree);
                }
                $query = $query->andWhere(['in', 'university_course_list.degree_id', $temp]);
            }

            // major filter
            if (isset($_POST['major'])) {
                $temp = [];
                foreach($_POST['major'] as $major) {
                    array_push($temp, $major);
                }
                $query = $query->andWhere(['in', 'university_course_list.major_id', $temp]);
            }
            
            $query1 = $query->groupBy(['university_course_list.id']);
			
			//echo $query->createCommand()->sql;
			//echo $query->createCommand()->getRawSql();
			//die;
			
			
            $models = $query->orderBy(['most_viewed_courses.view' => SORT_DESC,'university_course_list.name' => SORT_DESC]);
			$count = $query1->count();

            $pages = new Pagination(['totalCount' => $count,'defaultPageSize' => 20,'forcePageParam' => false,'page'=>$currpage,]);
            $models = $models->offset($pages->offset-$pages->limit)
                ->limit($pages->limit)
                ->all();
		    //echo $models->createCommand()->getRawSql();	
			//print_r($params);die;
            return $this->renderAjax('course-list', [
                'courses' => $models,
                'types' => $types,
                'durationType' => $durationType, 
                'languages' => $languages,
                'pages' => $pages,
				'currpage' =>$currpage,
                'totalCourseCount' => $count,
                'shortlisted' => $shortlisted
            ]);
        }
	  
		$models = $models->groupBy(['university_course_list.id']);
        $models = $models->orderBy(['most_viewed_courses.view' => SORT_DESC,'university_course_list.name' => SORT_DESC]);
		
		//echo $models->createCommand()->getRawSql();
	   //die;
		
		$count = $models->count();
	 
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize' => 20,'forcePageParam' => false,'page'=>$currpage,]);
        $models = $models->offset($pages->offset-$pages->limit)
                ->limit($pages->limit)
                ->all();
		
		
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('course-list', [
                'courses' => $models,
                'types' => $types,
                'durationType' => $durationType, 
                'languages' => $languages,
                'pages' => $pages,
				'currpage' =>$currpage,
                'totalCourseCount' => $count,
                'shortlisted' => $shortlisted
            ]);
        }else{
            return $this->render('index', [
                'degrees' => $degrees,
                'degreeLevel' => $degreeLevels,
                'countries' => $countries,
                'totalCourseCount' => $count,
                'courses' => $models,
                'languages' => $languages,
                'types' => $types,
                'pages' => $pages,
				'currpage' =>$currpage,
                'durationType' => $durationType,
                'params' => $params,
                'majors' => $majors,
                'states' => $states,
                'university' => $universitylist,
                'shortlisted' => $shortlisted
            ]);
        }
    }

    public function actionApplyToCourse() {
        $course = $_POST['course'];

        $course = UniversityCourseList::findOne($course);
        $model = new StudentUniveristyApplication();
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_by_role = Yii::$app->user->identity->role_id;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->status = AdmissionWorkflow::STATE_DRAFT;
        $model->student_id = Yii::$app->user->identity->id;
        $model->consultant_id = Yii::$app->user->identity->studentConsultantRelations[0]->consultant_id;
        $model->course_id = $course->id;
        $model->university_id = $course->university_id;
        $model->start_term = 'Fall 2017';
        if ($model->save()) {
            return json_encode(['status' => 'success', 'message' => $model->id]);
        }
        return json_encode(['status' => 'error', 'message' => $model->id]);
    }

    /**
     * Renders details of a Course.
     * @return mixed
     */
    public function actionView($id) {
        $course = UniversityCourseList::find()->where(['id' => $id])->one();
        $university = $course->university;
        $country = $university->country->name;
        $type = $this-> getOthers('course_type');
        $lng = $this->getOthers('languages');
        $ctype =($type[$course->type]);
        $lang = $lng[$course->language];
        $tests = [];
        $rating = null;
        $application = null;
        $favourite = null;
        if(!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->id;
            $rating = CourseReviewsRatings::find()->where(['AND', ['=', 'university_id', $university->id], ['=', 'student_id', $user], ['=', 'course_id', $id]])->one();
            $favourite = StudentFavouriteCourses::find()->where(['AND', ['=', 'university_id', $university->id], ['=', 'student_id', $user], ['=', 'course_id', $id]])->one();
            $application = StudentUniveristyApplication::find()->where(['AND', ['=', 'student_id', $user], ['=', 'course_id', $id]])->one();
        }        
        $latestRatings = CourseReviewsRatings::find()->orderBy(['updated_at' => 'DESC'])->limit(5)->all();
        $latestReviews = CourseReviewsRatings::find()->where(['AND', ['<>', 'review', 'NULL'],['<>', 'review', '']])->orderBy(['updated_at' => 'DESC'])->limit(5)->all();        
        if(!empty($university->standard_test_list)) {
            $temp = explode(',', $university->standard_test_list);
            foreach($temp as $test) {
                $test_detail = StandardTests::findOne($test);
                if(!empty($test_detail)) {
                    $category = $test_detail->testCategory->name;
                    if(isset($tests[$category])) {
                        array_push($tests[$category], [
                            'name' => $test_detail->name,
                            'source' => $test_detail->source
                        ]);
                    } else {
                        $tests[$category] = [[
                            'name' => $test_detail->name,
                            'source' => $test_detail->source
                        ]];
                    }
                }
            }
        }
        return $this->render('view', [   
            'model' => $course,
            'type' =>$ctype,
            'language' =>$lang,
            'university' => $university,
            'country' => $country,
            'tests' => $tests,
            'rating' => $rating,
            'latestRatings' => $latestRatings,
            'latestReviews' => $latestReviews,
            'application' => $application,
            'favourite' => $favourite
        ]);
    }

    public function actionReview() {
        $user = Yii::$app->user->identity->id;
        $university = $_GET['university'];
        $course = $_GET['course'];
        $model = CourseReviewsRatings::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user], ['=', 'course_id', $course]])->one();
        if (empty($model)) {
            $model = new CourseReviewsRatings();
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('review', [
                'model' => $model
            ]);
        }
    }

    public function actionSubmitReview() {
        $user = Yii::$app->user->identity->id;
        $university = $_POST['university'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        $course = $_POST['course'];
        $model = CourseReviewsRatings::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user], ['=', 'course_id', $course]])->one();
        if (empty($model)) {
            $model = new CourseReviewsRatings();
            $model->created_by = $user;
            $model->created_at = gmdate('Y-m-d H:i:s');
        }
        $model->updated_by = $user;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->university_id = $university;
        $model->student_id = $user;
        $model->course_id = $course;
        $model->review = $review;
        $model->rating = $rating;

        if ($model->save()) {
            return json_encode(['status' => 'success']);
        } 
        return json_encode(['status' => 'failure']);
    }

    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {           
            $model = explode(',', $model->value);
            return $model;
        }
    }

    public function actionFavourite() {
        $user = Yii::$app->user->identity->id;
        $university = $_POST['university'];
        $favourite = $_POST['favourite'];
        $course = $_POST['course'];
        $model = StudentFavouriteCourses::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user], ['=', 'course_id', $course]])->one();
        if (empty($model)) {
            $model = new StudentFavouriteCourses();
            $model->created_by = $user;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->university_id = $university;
            $model->student_id = $user;
            $model->course_id = $course;
        }
        $model->updated_by = $user;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->favourite = $favourite;
        if ($model->save()) {
            return json_encode(['status' => 'success', 'favourite' => $model->favourite]);
        }
        return json_encode(['status' => 'failure']);
    }

    public function actionDependentMajors() {
        $degree = $_POST['degree'];

        $majors = Majors::find()->where(['=', 'degree_id', $degree])->orderBy('name','ASC')->all();

        return $this->renderAjax('majors-list', [
            'majors' => $majors,
        ]);
    }

    public function actionDependentStates() {
        $country_list = $_POST['countries'];
        $countries = [];

        foreach($country_list as $country) {
            array_push($countries, $country);
        }

        $states = State::find()->where(['in', 'country_id', $countries])->orderBy(['name' => 'ASC'])->all();
        return $this->renderAjax('state-list', [
            'states' => $states,
        ]);
    }

    public function actionShortlist() {
        $course = $_POST['course'];
        $university = $_POST['university'];
        $action_val = $_POST['action_val'];
        $user = Yii::$app->user->identity->id;

        $model = StudentShortlistedCourse::find()->where(['AND', ['=', 'student_id', $user], ['=', 'university_id', $university], ['=', 'course_id', $course]])->one();
        if($action_val == 0){
        if(empty($model)) {
            $model = new StudentShortlistedCourse();
            $model->student_id = $user;
            $model->university_id = $university;
            $model->course_id = $course;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->created_by = $user;
            $model->updated_by = $user;
            if($model->save()) {
                return json_encode([
                    'status' => 'success'
                ]);
            } else {
                return json_encode([
                    'status' => 'failure',
                    'message' => $model->errors
                ]);
            }
        } } else if($action_val == 1) {
            $x = Yii::$app->db->createCommand("
                DELETE FROM student_favourite_courses 
                WHERE student_id = '$user' 
                AND university_id = '$university' AND course_id = '$course'
            ")->execute();
            return json_encode([
                'status' => 'removed',
            ]);
        }
    }       
}
