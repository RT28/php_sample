<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\University;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Others;
use common\models\DegreeLevel;
use common\models\Degree;
use common\models\Majors;
use common\models\UniversityCourseList;
use common\models\StandardTests;
use common\models\UniversityReviewsRatings;
use common\models\StudentFavouriteUniversities;
use common\models\MostViewedCourses;
//use common\models\UniversityCommonAdmission;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use frontend\models\StudentShortlistedCourse;
use partner\models\UniversityNotifications;
use common\models\UniversityTemp;
use common\models\UniversityBrochures;
use yii\helpers\FileHelper;
use common\models\Notifications;

use common\models\Faq;
use common\models\FaqCategory;
/**
 * CourseListController
 */
class UniversityController extends Controller
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
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex( $region='')
    {
		Yii::$app->view->params['activeTab'] = 'university';
		
		$sort = 'name';
		$order = 'ASC';
		if (isset($_GET['sort'])) {
		  $sort =	$_GET['sort']; 
		} 
		if (isset($_GET['order'])) {
			  $order = $_GET['order'];
		}  
		
		$universitylist = University::find()->where(['is_active'=>1])->orderBy('name')->all();
	
        $states = [];
        $params = [];
        if(isset($_GET['region']) || !empty($region)) {
			
			if(isset($_GET['region'])){
				$temp = explode(',', $_GET['region']);
			}
			
			if(!empty($region)){
				$temp[0] = $region;
			}
			
            $params = [];
            $size = sizeof($temp);

            if($size == 1) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[0]])->one()->id;
            }

            if($size == 2) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[1]])->one()->id;
                $params['state'] = State::find()->where(['=', 'name', $temp[0]])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $states = State::find()->where(['=', 'country_id', $params['country']])->orderBy('name','ASC')->all();
            }

            if($size == 3) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[2]])->one()->id;
                $params['state'] = State::find()->where(['=', 'name', $temp[1]])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $params['city'] = City::find()->where(['=', 'name', $temp[0]])->andWhere(['=', 'state_id', $params['state']])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $states = State::find()->where(['=', 'country_id', $params['country']])->orderBy('name','ASC')->all();
            }
        }
        
		$currpage=0;
		if (isset($_REQUEST['page'])){	
			$currpage=$_REQUEST['page'];
		}
		
        $models = [];
        $models = University::find()->where(['is_active'=>1]);
        if(isset($params['university'])) {
            $models = $models->where(['=', 'id', $params['university']]);
        }
        if(isset($params['country'])) {
            $models = $models->where(['=', 'country_id', $params['country']]);
        }
        if(isset($params['state'])) {
            $models = $models->andWhere(['=', 'state_id', $params['state']]);
        }
        if(isset($params['city'])) {
            $models = $models->andWhere(['=', 'city_id', $params['city']]);
        }
 
        $models = $models->orderBy("$sort $order");
        $countQuery = clone $models;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => 21,'forcePageParam' => false,'page'=>$currpage,]);
        $models = $models->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $countries = Country::find()->where(['=','status','1'])->orderBy('name','ASC')->all();
        $universityTotalCount = University::find()->where(['is_active'=>1])->count();
        $degreeLevel = DegreeLevel::find()->orderBy('position')->all();
        $degrees = Degree::find()->orderBy('name')->all();        
        
		if(Yii::$app->request->isAjax) {
			
			$query = University::find()->where(['is_active'=>1]);
            if(isset($_POST['level']) || isset($_POST['degree']) || isset($_POST['major'])) {
                $query = $query->leftJoin('university_course_list', '`university_course_list`.`university_id` = `university`.`id`');
            }
            
			/********************************
				@Created by Pankaj 
				@search by keyword filter. 
			*********************************/
            if (isset($_POST['searchbykeyword'])) {
				
				$keyword=$_POST['searchbykeyword'][0];

                /*university with country search keyword ----------------------------------*/
                $query_country = Country::find()->Where('name LIKE "%'.$keyword.'%"')->all();
                if($query_country){ 
                $temp = [];

                         foreach($query_country as $country)
                        { 
                           array_push($temp, $country['id']);
                            
                        }
                        $query = $query->andWhere(['in', 'university.country_id', $temp]);
                }  
                
                $query_state = State::find()->Where('name LIKE "%'.$keyword.'%"')->all();
                if($query_state){
                $temp = [];
                

                         foreach($query_state as $state)
                        { echo $state['id'];
                           array_push($temp, $state['id']);
                            
                        }
                        $query = $query->andWhere(['in', 'university.state_id', $temp]);
                }      
                
                /*end-----------------------------------------------------------------------------------*/

                /*university with state search keyword : ----------------------------------*/
                /*$query_country = State::find()->Where('name LIKE "%'.$keyword.'%"')->all();
                $temp = [];

                         foreach($query_country as $country)
                        {
                            echo $country['id'];
                           array_push($temp, $country['id']);
                            
                        }
                $query = $query->Where(['in', 'university.country_id', $temp]);*/
                /*end----------------------------------------------------------------------------------*/

				$query = $query->andWhere('university.name LIKE :searchkeyword');
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
            // university filter.
            if (isset($_POST['university'])) {
                $temp = [];
                foreach($_POST['university'] as $university) {
                    array_push($temp, $university);
                }
                $query = $query->andWhere(['in', 'university.id', $temp]);
            }
            //partner university
            if(isset($_POST['partner'])){
                $query = $query->andWhere(['university.is_partner'=>'1']);
            }
        $query = $query->groupBy(['university.id']);
		 
			
        $ajaxModels = $query->orderBy("$sort $order");
		$count = $query->count();
		
		//$models = $query->orderBy('university.name');
        //$countQuery = clone $models;
		
		//echo "count query = ".$countQuery->count() ."count " .$count;
		//echo $ajaxModels->createCommand()->getRawSql();
		//die;
		
		$pages = new Pagination(['totalCount' => $count,'defaultPageSize' => 21,'forcePageParam' => false,'page'=>$currpage,]);
		
			$ajaxModels = $ajaxModels->offset($pages->offset-$pages->limit)
				->limit($pages->limit)
				->all();
				//echo "Current Page".$currpage;
				//echo "Page offset=".$pages->offset;
				//echo "Page Limit=".$pages->limit;
			  
			return $this->renderAjax('university-list', [
				'models' => $ajaxModels,
				'pages'=>$pages,
				'currpage' =>$currpage,
				'universityTotalCount'=>$count
			]);
        }
        return $this->render('index',[
            'models' => $models,
            'countries' => $countries,
            'universityTotalCount' => $countQuery->count(),
            'degreeLevel' => $degreeLevel,
            'degrees' => $degrees,
            'params' => $params,         
            'states' => $states,
            'pages' => $pages,
			'currpage' =>$currpage,	
            'university' => $universitylist
        ]);
    }

    /**
     * Lists details of a University.
     * @return mixed
     */
    public function actionView($id)
    {   
		Yii::$app->view->params['activeTab'] = 'university';
        $u_name = str_replace("-", " ", $id);
		$university_id = University::find()->where('name ="'.$u_name.'"')->one();
        $id = $university_id->id;

        $model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one();
        $courses = UniversityCourseList::find()->where(['=', '`university_course_list`.`university_id`', $id])
		->leftJoin('most_viewed_courses', '`most_viewed_courses`.`course_id` = `university_course_list`.`id`');
		 

        $totalCourseCount = $courses->count();
        $pages = new Pagination(['totalCount' => $totalCourseCount,'defaultPageSize' => 5,'forcePageParam' => false,]);
        $courses = $courses->orderBy(['most_viewed_courses.view' => 'ASC','university_course_list.name' => 'ASC'])->offset($pages->offset)->limit($pages->limit)->all();
        $disciplineCount = UniversityCourseList::find()
		->select(['COUNT(university_course_list.id) AS id', 'university_course_list.degree_id as degree_id'])
		->where(['=', 'university_course_list.university_id', $id])
		->leftJoin('degree', '`degree`.`id` = `university_course_list`.`degree_id`')
		->groupBy(['university_course_list.degree_id'])
		->orderBy(['degree.name'  => SORT_ASC])
		->all();
        $disciplineCount = ArrayHelper::map($disciplineCount, 'degree_id', 'id');
		/*echo "<pre>";
		  print_r($disciplineCount);
		echo "</pre>";
		die; */
        $rating = null;
        $favourite = null;
        $shortlisted = [];
        if(!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity->id;
            $rating = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $id], ['=', 'student_id', $user]])->one();
            $favourite = StudentFavouriteUniversities::find()->where(['AND', ['=', 'university_id', $id], ['=', 'student_id', $user]])->one();
            $shortlisted = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->all();
            $shortlisted = ArrayHelper::map($shortlisted, 'course_id', 'course_id');
        }
        
       
	   $latestRatings = UniversityReviewsRatings::find()->where(['=', 'university_id', $id])->orderBy(['updated_at' => 'DESC'])->limit(5)->all();
	   
        $latestReviews = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $id], ['<>', 'review', 'NULL'],['<>', 'review', '']])->orderBy(['updated_at' => 'DESC'])->limit(5)->all();
		
        $UniversityNotifications = UniversityNotifications::find()->where(['AND', ['=', 'university_id', $id]])
		->orderBy(['id' => 'DESC'])->limit(5)->all();
     
		$types = $this-> getOthers('course_type');
        $languages = $this-> getOthers('languages');
        $durationType = $this->getOthers('duration_type');
		
		/*$UniversityCommonAdmission = UniversityCommonAdmission::find()
		->where(['=', 'university_id', $id])->all(); 
		$testlist = array(); 
		$testlist2 = array();
		foreach($UniversityCommonAdmission as $test): 			
		if(!in_array($test->degree_level_id,$testlist)){
			$testlist[$test->degree_level_id][$test->test_id] = $test->score;
			$degreename = $this->getDegreeLevel($test->degree_level_id);
			$testname = $this->getStandardTestsList($test->test_id);
			$testlist2[$degreename][$testname] = $test->score;		
		} 
		endforeach; */
		 
		$query = "SELECT * FROM university_brochures where university_id='$id' AND status = 1 AND active = 1";

		
		$DocumentModel = UniversityBrochures::findBySql($query)->all();
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
        $faqylist = Faq::find()->orderBy('id')->all();
        $faqycategorylist = FaqCategory::find()->orderBy('id')->all();

		
        return $this->render('view',[
            'model' => $model,
            'courses' => $courses,
            'disciplineCount' => $disciplineCount,
            'rating' => $rating,
            'latestRatings' => $latestRatings,
            'latestReviews' => $latestReviews,
            'favourite' => $favourite,
            'types' => $types,
            'languages' => $languages,
            'pages' => $pages,
            'totalCourseCount' => $totalCourseCount,
            'durationType' => $durationType,
            'shortlisted' => $shortlisted,
			 'UniversityNotifications' => $UniversityNotifications,
			//'UniversityCommonAdmission'  => $testlist2,			
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,
            'faq' => $faqylist,
            'faqcategory' => $faqycategorylist

        ]);
    }
	
	 public function actionCourses($university, $degree) {
		Yii::$app->view->params['activeTab'] = 'university';
		
        $id = $university ;  
		 
		 
		if (isset($_REQUEST['page'])){  
            $currpage=$_REQUEST['page'];
        } 
         
        $courses = UniversityCourseList::find();
        $courses = $courses->leftJoin('most_viewed_courses', '`most_viewed_courses`.`course_id` = `university_course_list`.`id`');
        if($degree != 'All') {  
            $courses = $courses->where(['AND',['=', '`university_course_list`.`university_id`', $id],
            ['=', '`university_course_list`.`degree_id`', $degree]]);

        }else{
            $courses = $courses->where(['=', '`university_course_list`.`university_id`', $id]);

        }
        
        $count = $courses->count();
        $pages = new Pagination(['totalCount' => $count,'defaultPageSize' => 5,'forcePageParam' => false,'page'=>$currpage]);
        $courses = $courses->orderBy(['`most_viewed_courses`.`view`' => 'ASC','university_course_list.name' => 'ASC'])->offset($pages->offset)->limit($pages->limit)->all();
        $shortlisted = [];
        $types = $this-> getOthers('course_type');
        $languages = $this-> getOthers('languages');
        $durationType = $this->getOthers('duration_type');
        
        return $this->renderAjax('course-list', [
            'courses' => $courses,
            'types' => $types,
            'languages' => $languages,
            'pages' => $pages,
            'totalCourseCount' => $count,
            'durationType' => $durationType,
            'shortlisted' => $shortlisted,
            'fromUniversity' => true
        ]);
    }
	

	/**@Updated By :- pankaj
     * @Preview details of a University.
     * @return mixed
     */
    public function actionPreview()
    {
		$id=$_POST['university_id'];
		Yii::$app->view->params['activeTab'] = 'university';
		
        $model = UniversityTemp::findBySql('SELECT *, AsText(location) AS location FROM university_temp WHERE university_id=' . $id)->one();
		
        $courses = UniversityCourseList::find()->where(['=', '`university_course_list`.`university_id`', $id])
		->leftJoin('most_viewed_courses', '`most_viewed_courses`.`university_id` = `university_course_list`.`university_id`');
		 

        $totalCourseCount = $courses->count();
        $pages = new Pagination(['totalCount' => $totalCourseCount,'defaultPageSize' => 5,'forcePageParam' => false,]);
        $courses = $courses->orderBy(['most_viewed_courses.view' => 'ASC','university_course_list.name' => 'ASC'])->offset($pages->offset)->limit($pages->limit)->all();
        $disciplineCount = UniversityCourseList::find()
                                                ->select(['COUNT(major_id) AS major_id', 'degree_id'])
                                                ->where(['=', 'university_id', $id])
                                                ->groupBy(['degree_id'])
                                                ->all();
        $disciplineCount = ArrayHelper::map($disciplineCount, 'degree_id', 'major_id');
        $rating = null;
        $favourite = null;
        $shortlisted = [];
        if(!Yii::$app->user->isGuest) {
			if(!empty(Yii::$app->user->identity->id)){
            $user = Yii::$app->user->identity->id;
            $rating = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $id], ['=', 'student_id', $user]])->one();
            $favourite = StudentFavouriteUniversities::find()->where(['AND', ['=', 'university_id', $id], ['=', 'student_id', $user]])->one();
            $shortlisted = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->all();
            $shortlisted = ArrayHelper::map($shortlisted, 'course_id', 'course_id');
			}
        }
        
       
	   $latestRatings = UniversityReviewsRatings::find()->where(['=', 'university_id', $id])->orderBy(['updated_at' => 'DESC'])->limit(5)->all();
        $latestReviews = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $id], ['<>', 'review', 'NULL'],['<>', 'review', '']])->orderBy(['updated_at' => 'DESC'])->limit(5)->all();
        $UniversityNotifications = UniversityNotifications::find()->where(['AND', ['=', 'university_id', $id]])
		->orderBy(['id' => 'DESC'])->limit(5)->all();
     
		$types = $this-> getOthers('course_type');
        $languages = $this-> getOthers('languages');
        $durationType = $this->getOthers('duration_type');
		
		/*$UniversityCommonAdmission = UniversityCommonAdmission::find()
		->where(['=', 'university_id', $id])->all(); 
		$testlist = array(); 
		$testlist2 = array();
		foreach($UniversityCommonAdmission as $test): 			
		if(!in_array($test->degree_level_id,$testlist)){
			$testlist[$test->degree_level_id][$test->test_id] = $test->score;
			$degreename = $this->getDegreeLevel($test->degree_level_id);
			$testname = $this->getStandardTestsList($test->test_id);
			$testlist2[$degreename][$testname] = $test->score;		
		} 
		endforeach;*/
		 
		$query = "SELECT * FROM university_brochures where university_id='$id' AND status = 1 AND active = 1";

		
		$DocumentModel = UniversityBrochures::findBySql($query)->all();
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		
        return $this->renderAjax('preview',[
            'model' => $model,
            'courses' => $courses,
            'disciplineCount' => $disciplineCount,
            'rating' => $rating,
            'latestRatings' => $latestRatings,
            'latestReviews' => $latestReviews,
            'favourite' => $favourite,
            'types' => $types,
            'languages' => $languages,
            'pages' => $pages,
            'totalCourseCount' => $totalCourseCount,
            'durationType' => $durationType,
            'shortlisted' => $shortlisted,
			'UniversityNotifications' => $UniversityNotifications,
			//'UniversityCommonAdmission'  => $testlist2,
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,

        ]);
			
    }
	
	 private function getDegreeLevel($id) {
        $DegreeLevel = DegreeLevel::find()->where(['=', 'id', $id])->one();
        return $DegreeLevel->name;
    }
	
	 private function getStandardTestsList($id) {
        $standardTests = StandardTests::find()->where(['=', 'id', $id])->one();
        return $standardTests->name;
    }
	
    public function actionReview() {
		Yii::$app->view->params['activeTab'] = 'university';
        $user = Yii::$app->user->identity->id;
        $university = $_GET['university'];
        $model = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user]])->one();
        if (empty($model)) {
            $model = new UniversityReviewsRatings();
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('review', [
                'model' => $model
            ]);
        }
    }

    public function actionSubmitReview() {
		Yii::$app->view->params['activeTab'] = 'university';
        $user = Yii::$app->user->identity->id;
        $university = $_POST['university'];
        $rating = $_POST['rating'];
        $review = $_POST['review'];
        $model = UniversityReviewsRatings::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user]])->one();
        if (empty($model)) {
            $model = new UniversityReviewsRatings();
            $model->created_by = $user;
            $model->created_at = gmdate('Y-m-d H:i:s');
        }
        $model->updated_by = $user;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->university_id = $university;
        $model->student_id = $user;
        $model->review = $review;
        $model->rating = $rating;

        if ($model->save()) {
            return json_encode(['status' => 'success']);
        } 
        return json_encode(['status' => 'failure']);
    }
	
	/* public function actionNews($id) {
		$model = UniversityNotifications::find()->where(['AND', ['=', 'id', $id]])->one();
		 
		return $this->render('news', [
		'model' => $model, 
		]);
	 }*/
     public function actionNews($id) {
        //$model = Notifications::find()->where(['AND', ['=', 'id', $id]])->one();
        $model = Notifications::find()->indexBy('id')->all();
         
        return $this->render('news', [
        'model' => $model, 
        ]);
     }
    public function actionFavourite() {
		
		Yii::$app->view->params['activeTab'] = 'university';
		
        $user = Yii::$app->user->identity->id;
        $university = $_POST['university'];
        $favourite = $_POST['favourite'];
        $model = StudentFavouriteUniversities::find()->where(['AND', ['=', 'university_id', $university], ['=', 'student_id', $user]])->one();
        if (empty($model)) {
            $model = new StudentFavouriteUniversities();
            $model->created_by = $user;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->university_id = $university;
            $model->student_id = $user;
        }
        $model->updated_by = $user;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        if(isset($favourite)){
            $model->favourite = $favourite;
        }
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

        $states = State::find()->where(['in', 'country_id', $countries])->all();        
        return $this->renderAjax('state-list', [
            'states' => $states,
        ]);
    }
    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {           
            $model = explode(',', $model->value);
            return $model;
        }
    }

   
	 public function actionMostviewed() {
		
		if($_POST['course_id'] && $_POST['university_id']){
			
			# find course if it exists;
                    $course = MostViewedCourses::find()->where(['AND', 
					['=', 'course_id', trim($_POST['course_id'])],
					['=', 'university_id',trim($_POST['university_id'])]])->one();
					 
                    if(empty($course)) {
                        $course = new MostViewedCourses(); 
						$course->course_id = $_POST['course_id'];
						$course->university_id = $_POST['university_id'];
						$course->view = '1';
						
                    }else{
						$count = $course->view;
						$addView = $count+1;
						$course->view = $addView;
					} 					
					$course->save();
				return true;
				
					
		}		
	 }
	 
	public function actionDownload($id) {
        ini_set('max_execution_time', 5*60); // 5 minutes
         
        $fileName = $_GET['name'];
        if (is_dir("./../../backend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../backend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
        }
    }
	
	 public function actionDownloadAll($id) {
         $id = $id;
        if (is_dir("./../../backend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../backend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => true,
            ]);
            if(count($path) > 0) {
                $files = $path;
                $result = is_dir("./../../backend/web/downloads");
                if (!$result) {
                    FileHelper::createDirectory("./../../backend/web/downloads");
                } 
                $zipname = './../../backend/web/downloads/documents'.$id.'.zip';
                $zip = new \ZipArchive();
                $zip->open($zipname, \ZipArchive::CREATE);
                $k = 0;
				 
                foreach ($files as $file) {
                    $normalized = FileHelper::normalizePath($file,'/');
                    $filename = explode($id.'/', $normalized);
					$zip->addFile($normalized,$filename[1]);
					$k++;
                }  
				 
                $zip->close();
                Yii::$app->response->sendFile($zipname);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }
	
	public function beforeAction($action)
    {            
        if ($action->id == 'preview' || $action->id== 'favourite' ) {
            Yii::$app->controller->enableCsrfValidation = false;        
			}
			
        return parent::beforeAction($action);
    }
	
}
