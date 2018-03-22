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
use common\models\UniversityCommonAdmission;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use frontend\models\StudentShortlistedCourse;
use partner\models\UniversityNotifications;

 
class PartneruniversitiesController extends Controller
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
    public function actionIndex()
    {
		Yii::$app->view->params['activeTab'] = 'university';
		
        $states = [];
        $params = [];
        if(isset($_GET['region'])) {
            $temp = explode(',', $_GET['region']);
            $params = [];
            $size = sizeof($temp);

            if($size == 1) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[0]])->one()->id;
            }

            if($size == 2) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[1]])->one()->id;
                $params['state'] = State::find()->where(['=', 'name', $temp[0]])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $states = State::find()->where(['=', 'country_id', $params['country']])->all();
            }

            if($size == 3) {
                $params['country'] = Country::find()->where(['=', 'name', $temp[2]])->one()->id;
                $params['state'] = State::find()->where(['=', 'name', $temp[1]])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $params['city'] = City::find()->where(['=', 'name', $temp[0]])->andWhere(['=', 'state_id', $params['state']])->andWhere(['=', 'country_id', $params['country']])->one()->id;
                $states = State::find()->where(['=', 'country_id', $params['country']])->all();
            }
        }
        
        $models = [];
        $models = University::find()->where(['=', 'is_partner', '1']);
        if(isset($params['country'])) {
            $models = $models->andWhere(['=', 'country_id', $params['country']]);
        }
        if(isset($params['state'])) {
            $models = $models->andWhere(['=', 'state_id', $params['state']]);
        }
        if(isset($params['city'])) {
            $models = $models->andWhere(['=', 'city_id', $params['city']]);
        }        
        $models = $models->orderBy('name');
        $countQuery = clone $models;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => 10,'forcePageParam' => false,]);
        $models = $models->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $countries = Country::find()->orderBy('name')->all();
        $universityTotalCount = University::find()->where(['=', 'is_partner', '1'])->count();
        $degreeLevel = DegreeLevel::find()->indexBy('id')->all();
        $degrees = Degree::find()->orderBy('name')->all();        
        if(Yii::$app->request->isAjax) {
            $query = University::find()->where(['=', 'is_partner', '1']);

            if(isset($_POST['level']) || isset($_POST['degree']) || isset($_POST['major'])) {
                $query = $query->leftJoin('university_course_list', '`university_course_list`.`university_id` = `university`.`id`');
            }
            // country filter.
            if (isset($_POST['country'])) {
                $temp = [];
                foreach($_POST['country'] as $country) {
                    array_push($temp, $country);
                }
                $query = $query->where(['in', 'country_id', $temp]);
            }

            // state filter.
            if (isset($_POST['state'])) {
                $temp = [];
                foreach($_POST['state'] as $state) {
                    array_push($temp, $state);
                }
                $query = $query->andWhere(['in', 'state_id', $temp]);
            }

            // degree level filter
            if (isset($_POST['level'])) {
                $temp = [];
                foreach($_POST['level'] as $level) {
                    array_push($temp, $level);
                }
                $query = $query->andWhere(['in', 'degree_level_id', $temp]);
            }

            // degree filter
            if (isset($_POST['degree'])) {
                $temp = [];
                foreach($_POST['degree'] as $degree) {
                    array_push($temp, $degree);
                }
                $query = $query->andWhere(['in', 'degree_id', $temp]);
            }

            // major filter
            if (isset($_POST['major'])) {
                $temp = [];
                foreach($_POST['major'] as $major) {
                    array_push($temp, $major);
                }
                $query = $query->andWhere(['in', 'major_id', $temp]);
            }

        $models = $query->orderBy('name');
        $countQuery = clone $models;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize' => 10,'forcePageParam' => false,]);
            $models = $models->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            
            return $this->renderAjax('university-list', [
                'models' => $models,
                'pages'=>$pages,
                'universityTotalCount'=>$countQuery->count()
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
            'pages' => $pages        
        ]);
    }
 
	
}
