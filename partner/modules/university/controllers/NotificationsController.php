<?php

namespace partner\modules\university\controllers;

use Yii;

use backend\models\Notifications;
use common\models\UniversityNotifications;
use partner\models\UniversityNotificationsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * NotificationsController implements the CRUD actions for UniversityNotifications model.
 */
class NotificationsController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update','gtu'],
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
     * Lists all UniversityNotifications models.
     * @return mixed
     */
    public function actionIndex()
    {
		Yii::$app->view->params['activeTab'] = 'notifications'; 
        $searchModel = new UniversityNotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$university_id = Yii::$app->user->identity->partner_id;   
		$query = UniversityNotificationsSearch::find()->where(['university_id'=>$university_id]); 	 
		$dataProvider = new ActiveDataProvider([ 'query' => $query]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UniversityNotifications model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		Yii::$app->view->params['activeTab'] = 'notifications'; 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UniversityNotifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UniversityNotifications(); 
		Yii::$app->view->params['activeTab'] = 'notifications'; 
		        

        if ($model->load(Yii::$app->request->post())) {
			$university_id = Yii::$app->user->identity->partner_id; 
			$model->university_id =$university_id;	
			$model->created_at = gmdate('Y-m-d H:i:s');
			$model->updated_at = gmdate('Y-m-d H:i:s'); 
 
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			} 
			
        } else { 
            return $this->render('create', [
                'model' => $model,
            ]);
        }
		 
         
    }

    /**
     * Updates an existing UniversityNotifications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		
		Yii::$app->view->params['activeTab'] = 'notifications';  
        $model = $this->findModel($id); 

        if ($model->load(Yii::$app->request->post())) {			
			$university_id = Yii::$app->user->identity->partner_id; 
			$model->university_id =$university_id;	
			$model->created_at = gmdate('Y-m-d H:i:s');
			$model->updated_at = gmdate('Y-m-d H:i:s'); 				
			if($model->save()){
				return $this->redirect(['view', 'id' => $model->id]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing UniversityNotifications model.
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
     * Finds the UniversityNotifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UniversityNotifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	 
	   public function actionGtu($id)
    { 
        return $this->render('gtu', [
            'model' => Notifications::findOne($id),
        ]);
    }
    protected function findModel($id)
    {
        if (($model = UniversityNotifications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
