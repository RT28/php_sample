<?php

namespace backend\controllers;

use Yii;
use common\models\UniversityCommonAdmission;
use partner\models\UniversityCommonAdmissionSearch;
use common\models\StandardTests;
use common\models\University;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\DegreeLevel;

use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;


/**
 * CommonAdmissionController implements the CRUD actions for UniversityCommonAdmission model.
 */
class CommonAdmissionController extends Controller
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
     * Lists all UniversityCommonAdmission models.
     * @return mixed
     */
    public function actionIndex()
    {
        
$searchModel = new UniversityCommonAdmissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);		
		 
       
    }

    /**
     * Displays a single UniversityCommonAdmission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    { 
        return $this->render('view', [
            'model' => $this->findModel($id),
			'standardTests' => $this->getStandardTestsList(),
        ]);
    }

    /**
     * Creates a new UniversityCommonAdmission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    { 
        $model = new UniversityCommonAdmission();  
        if ($model->load(Yii::$app->request->post())) { 
			$model->degree_level_id = $model->degree_level_id ;
			$model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'universities' => $this->getUniversitiesList(),
				'standardTests' => $this->getStandardTestsList(),
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
            ]);
        }
    }

    /**
     * Updates an existing UniversityCommonAdmission model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 
        $model = $this->findModel($id); 
        if ($model->load(Yii::$app->request->post())) {
			$model->degree_level_id = $model->degree_level_id ;
			$model->save();			
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'universities' => $this->getUniversitiesList(),
				'standardTests' => $this->getStandardTestsList(),
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
            ]);
        }
    }

	
	 private function getStandardTestsList() {
        $standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        return $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
    }
	
	 private function getUniversitiesList() {
        $Universities = University::find()->orderBy(['name' => 'ASC'])->all();
        return $Universities = ArrayHelper::map($Universities, 'id', 'name');
    }
	
    /**
     * Deletes an existing UniversityCommonAdmission model.
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
     * Finds the UniversityCommonAdmission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UniversityCommonAdmission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UniversityCommonAdmission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
