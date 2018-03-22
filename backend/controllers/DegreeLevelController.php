<?php

namespace backend\controllers;

use Yii;
use common\models\DegreeLevel;
use backend\models\DegreeLevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * DegreeLevelController implements the CRUD actions for DegreeLevel model.
 */
class DegreeLevelController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all DegreeLevel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DegreeLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DegreeLevel model.
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
     * Creates a new DegreeLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DegreeLevel(); 
		 
        $message = '';
        if(Yii::$app->request->post()) {
			$model->load(Yii::$app->request->post());
            $exists = DegreeLevel::find()->where(['=', 'name', $model->name])->one();
            if(empty($exists)) {  
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate("M d Y H:i:s");
				$model->updated_at = gmdate("M d Y H:i:s");
				$model->save();
				$message = 'Success! Degree Level added successfull.';
				return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = 'Error! Degree Level already exists.';
				return $this->render('create', [
                'model' => $model,
				'message' => $message,  
            ]);
            }  
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DegreeLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            $model->updated_by = Yii::$app->user->identity->id;        
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DegreeLevel model.
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
     * Finds the DegreeLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DegreeLevel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DegreeLevel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
