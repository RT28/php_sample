<?php

namespace partner\modules\university\controllers;

use Yii;
use partner\models\UniversityAdmission;
use partner\modules\university\models\UniversityAdmissionSearch;
use common\models\UniversityCourseList; 
use common\models\University; 
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Others;
use common\models\DegreeLevel;  
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * AdmissionController implements the CRUD actions for UniversityAdmission model.
 */
class AdmissionController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update','changestatus',
						'dependent-majors','subcat'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
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
     * Lists all UniversityAdmission models.
     * @return mixed
     */
    public function actionIndex()
    { 
		Yii::$app->view->params['activeTab'] = 'admission';
		echo $partner_id = Yii::$app->user->id;   
		 
        $searchModel = new UniversityAdmissionSearch();		
		$query = UniversityAdmissionSearch::find()->where(['university_id'=>$partner_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider = new ActiveDataProvider([ 'query' => $query]);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UniversityAdmission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UniversityAdmission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UniversityAdmission();
		$partner_id = Yii::$app->user->identity->partner_id; 
		
        if ($model->load(Yii::$app->request->post())) {
			$model->university_id = $partner_id;
			 
            if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);	
			}
            
        } else {
            return $this->render('create', [
                'model' => $model,
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 				
				'intake' => $this->getOthers('intake'),
				'programs' =>  $this->getUniversityCourseList(), 
            ]);
        }
    }

    /**
     * Updates an existing UniversityAdmission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$partner_id = Yii::$app->user->identity->partner_id;   
		

        if ($model->load(Yii::$app->request->post())) {
			$model->university_id = $partner_id;
            if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);	
			}
        } else {
			
			 
				
            return $this->render('update', [
                'model' => $model, 
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 				
				'intake' => $this->getOthers('intake'),
				'programs' =>  $this->getUniversityCourseList(), 
            ]);
        }
    }
	
	 private function getUniversityCourseList() {
	  $partner_id = Yii::$app->user->identity->partner_id; 
		$CourseList =  UniversityCourseList::find()->where(['=', 'university_id', $partner_id])->orderBy('name')->all();
		array_unshift($CourseList,['id'=>'0', 'name'=>'All Program']);
		return  ArrayHelper::map($CourseList, 'id', 'name');
    }
	
   public function actionDependentMajors() {
	   	$partner_id = Yii::$app->user->identity->partner_id;  
        if (isset($_POST['degree_level_id'])) {
           $degree_level_id = $_POST['degree_level_id']; 
            $course = UniversityCourseList::find()
			 ->where(['and',['degree_level_id'=>$cat_id],['university_id'=> $partner_id]])
			->all();
			
            return Json::encode(['result'=>$course, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }

	
    public function actionSubcat() {
        $out = [];
		
		$partner_id = Yii::$app->user->identity->partner_id;  
        if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $cat_id = $parents[0];
                $selected = '';

                $out = UniversityCourseList::find()
                ->where(['and',['degree_level_id'=>$cat_id],['university_id'=> $partner_id]])
                ->select(['id as id','name as name'])
                ->orderBy('name')
                ->asArray()->all();
				
				if(!empty($out)){
				array_unshift($out,['id'=>'0', 'name'=>'All Program']); 
				/*added for show all program statically */
				}
                echo Json::encode(['output'=>$out, 'selected'=>'selected']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

	  private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }
	
	
    /**
     * Deletes an existing UniversityAdmission model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UniversityAdmission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UniversityAdmission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UniversityAdmission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
