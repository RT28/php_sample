<?php

namespace partner\modules\university\controllers;

use Yii;
use common\models\UniversityCommonAdmission;
use partner\models\UniversityCommonAdmissionSearch;
use common\models\StandardTests;
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
                        'actions' => ['index', 'view', 'create', 'update'],
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
     * Lists all UniversityCommonAdmission models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'commonadmission';
		$partner_id = Yii::$app->user->identity->partner_id;   
		 
        $searchModel = new UniversityCommonAdmissionSearch();	
		$query = UniversityCommonAdmissionSearch::find()->where(['university_id'=>$partner_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider = new ActiveDataProvider([ 'query' => $query]);
		 

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
		Yii::$app->view->params['activeTab'] = 'commonadmission';
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
		Yii::$app->view->params['activeTab'] = 'commonadmission';
		$partner_id = Yii::$app->user->identity->partner_id;    
        $model = new UniversityCommonAdmission();  
        if ($model->load(Yii::$app->request->post())) {
			$model->university_id = $partner_id;
			$model->degree_level_id = $model->degree_level_id ;
			$model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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
		Yii::$app->view->params['activeTab'] = 'commonadmission';
        $model = $this->findModel($id);
		$partner_id = Yii::$app->user->identity->partner_id;    
        
        if ($model->load(Yii::$app->request->post())) {
			$model->degree_level_id = $model->degree_level_id ;
			$model->university_id = $partner_id;
			$model->save();			
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'standardTests' => $this->getStandardTestsList(),
				'degreeLevels' => DegreeLevel::getAllDegreeLevels(), 
            ]);
        }
    }

	
	 private function getStandardTestsList() {
        $standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        return $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
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
