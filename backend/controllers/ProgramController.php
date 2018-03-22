<?php

namespace backend\controllers;

use Yii;
use common\models\UniversityCourseList; 
use backend\models\UniversityCourseListSearch; 
use common\models\University; 
use common\models\Degree;
use common\models\Majors; 
use common\components\Status;
use common\components\Roles;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;  
use common\models\StandardTests;
use common\models\Country;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl; 
use common\components\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;
   

/**
 * ProgramController implements the CRUD actions for UniversityCourseList model.
 */
class ProgramController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update',],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_EDITOR]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all UniversityCourseList models.
     * @return mixed
     */
    public function actionIndex()
    { 
         $searchModel = new UniversityCourseListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'universities' => $this->getUniversityList(),
			'degrees' => Degree::getAllDegrees(),
			'dLevel' => DegreeLevel::getAllDegreeLevels(), 
			'majors' => Majors::getAllMajors(), 
        ]);
    }

    /**
     * Displays a single UniversityCourseList model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    { 
	
		$model = $this->findModel($id);   
		$standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');  
            return $this->render('view', [
                'model' => $model,  
				'courseType' => $this->getOthers('course_type'),
				'languages' => $this->getOthers('languages'),
				'intake' => $this->getOthers('intake'),
				'durationType' =>$this->getOthers('duration_type'), 
				'countries' => $countries,
				'university' => $this->getUniversityList(),
				'degree' => Degree::getAllDegrees(),
				'majors' =>  Majors::getAllMajors(), 
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
				'standardTests' => $standardTests
            ]);
         
    }

    /**
     * Creates a new UniversityCourseList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $model = new UniversityCourseList();
		$standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
		
        if ($model->load(Yii::$app->request->post())) { 
		
			$standard_test_list = implode(',',$model->standard_test_list);
			$model->standard_test_list = $standard_test_list;
			
			$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'courseType' => $this->getOthers('course_type'),
				'languages' => $this->getOthers('languages'),
				'intake' => $this->getOthers('intake'),
				'durationType' =>$this->getOthers('duration_type'),				
				'university' => $this->getUniversityList(),
				'countries' => $countries,
				'degree' => Degree::getAllDegrees(),
				'majors' => Majors::getAllMajors(),  
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
				'standardTests' => $standardTests
            ]);
        }
    }

    /**
     * Updates an existing UniversityCourseList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 
        $model = $this->findModel($id);   
		$standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
		
		
        if ($model->load(Yii::$app->request->post())) { 
			$standard_test_list = implode(',',$model->standard_test_list);
			$model->standard_test_list = $standard_test_list;
		
			$model->save();			 
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,  
				'courseType' => $this->getOthers('course_type'),
				'languages' => $this->getOthers('languages'),
				'intake' => $this->getOthers('intake'),
				'durationType' =>$this->getOthers('duration_type'), 
				'countries' => $countries,
				'university' => $this->getUniversityList(),
				'degree' => Degree::getAllDegrees(),
				'majors' => Majors::getAllMajors(), 
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
				'standardTests' => $standardTests
            ]);
        }
    }

	  private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }
	
	 private function getUniversityList() {
        return ArrayHelper::map(University::find()->orderBy('name')->all(), 'id', 'name');
    }
	 

    private function getMajorsList() {
        return ArrayHelper::map(Majors::find()->orderBy('name')->all(), 'id', 'name');
    }
    /**
     * Deletes an existing UniversityCourseList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	   public function actionDependentMajors() {
        if (isset($_POST['degree'])) {
           $degree_id = $_POST['degree']; 
            $majors = Majors::find()->where(['=', 'degree_id', $degree_id])->all();
            return Json::encode(['result'=>$majors, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $cat_id = $parents[0];
                $selected = '';

                $out = Majors::find()
                ->where(['degree_id'=>$cat_id])
                ->select(['id as id','name as name'])
                ->orderBy('name')
                ->asArray()->all();
                echo Json::encode(['output'=>$out, 'selected'=>'selected']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
	
    /**
     * Finds the UniversityCourseList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UniversityCourseList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UniversityCourseList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
