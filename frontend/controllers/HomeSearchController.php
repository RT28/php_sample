<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors;
use common\models\University;

/**
 * HomeSearchController
 */
class HomeSearchController extends Controller
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
     * Get all countries that match the given query string.
     * @return mixed
     */
    public function actionSearchRegions()
    {
        $region = $_GET['query'];
        $countries = Country::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $result = [];
        $len = sizeof($countries);
        for($i = 0; $i < $len; $i++) {
            array_push($result, [
                'id' => $countries[$i]->name,
                'name' => $countries[$i]->name
            ]);
        }

        $states = State::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $len = sizeof($states);
        for($i = 0; $i < $len; $i++) {
            $state = $states[$i];
            array_push($result, [
                'id' => $state->name . ','. $state->country->name,
                'name' => $state->name . ','. $state->country->name
            ]);
        }

        $universities = University::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $len = sizeof($universities);
        for($i = 0; $i < $len; $i++) {
            $university = $universities[$i];
            array_push($result, [
                'id' => $university->name . ',' . $university->state->name . ','. $university->country->name,
                'name' => $university->name . ',' . $university->state->name . ','. $university->country->name
            ]);
        }
        return json_encode($result);
    }
    public function actionSearchUniversity()
    {
        $region = $_GET['query'];
        $countries = Country::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $result = [];
        $len = sizeof($countries);
        for($i = 0; $i < $len; $i++) {
            array_push($result, [
                'id' => $countries[$i]->name,
                'name' => $countries[$i]->name
            ]);
        }

        $states = State::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $len = sizeof($states);
        for($i = 0; $i < $len; $i++) {
            $state = $states[$i];
            array_push($result, [
                'id' => $state->name . ','. $state->country->name,
                'name' => $state->name . ','. $state->country->name
            ]);
        }

        $universities = University::find()->where(['like', 'name', $region])->orderBy(['name' => 'ASC'])->all();
        $len = sizeof($universities);
        for($i = 0; $i < $len; $i++) {
            $university = $universities[$i];
            array_push($result, [
                'id' => $university->id,
                'name' => $university->name 
            ]);
        }
        return json_encode($result);
    }

    /**
     * Get all degree levels that match the give query string.
     * @return mixed
     */
    public function actionSearchMajors()
    {
        $major = $_GET['query'];
        $result = [];

        $degrees = Degree::find()->where(['like', 'name', $major])->all();
        $len = sizeof($degrees);
        for($i = 0; $i < $len; $i++) {
            $degree = $degrees[$i];
            array_push($result, [
                'id' => $degree->name,
                'name' => $degree->name
            ]);
        }

        $majors = Majors::find()->where(['like', 'name', $major])->all();        
        $len = sizeof($majors);
        for($i = 0; $i < $len; $i++) {
            $major = $majors[$i];            
            array_push($result, [
                'id' => $major->name . ',' . $major->degree->name,
                'name' => $major->name . ',' . $major->degree->name
            ]);
        }
        return json_encode($result);
    }

    /**
     * Redirect to a relavant page.
     * @return mixed
     */
    public function actionSearch()
    {
        $major = 'All';
        $region = 'All';
        $degreeLevel = 'Bachelors';

        if (isset($_GET['major'])) {
            $major = $_GET['major'];
        }

        if (isset($_GET['region'])) {
            $region = $_GET['region'];
        }

        if (isset($_GET['degreeLevel'])) {
            $degreeLevel = $_GET['degreeLevel'];
        }

        if(empty($major) && empty($region)) {
            return $this->redirect(['course/index', 'degreeLevel' => $degreeLevel]);
        }

        if(empty($major) && !empty($region)) {
            return $this->redirect(['course/index', 'region' => $region, 'degreeLevel' => $degreeLevel]);
        }

        if(!empty($major) && empty($region)) {
            return $this->redirect(['course/index', 'major' => $major, 'degreeLevel' => $degreeLevel]);
        }

        return $this->redirect(['course/index', 'major' => $major, 'region' => $region, 'degreeLevel' => $degreeLevel]);
    }
}


