<?php

namespace backend\controllers;

use Yii;
use common\models\Majors;
use backend\models\MajorsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Degree;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * MajorsController implements the CRUD actions for Majors model.
 */
class MajorsController extends Controller
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
     * Lists all Majors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MajorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Majors model.
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
     * Creates a new Majors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Majors();
        $degree = Degree::getAllDegrees();

		$message = '';
		if(Yii::$app->request->post()) {
		$model->load(Yii::$app->request->post());
		$exists = Majors::find()->where(['=', 'name', $model->name])->one();
		if(empty($exists)) {  
			$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->created_at = gmdate("M d Y H:i:s");
			$model->updated_at = gmdate("M d Y H:i:s");
			$model->save();
			$message = 'Success! Sub-Discipline added successfull.';
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			$message = 'Error! Sub-Discipline already exists.';
			return $this->render('create', [
			'model' => $model,
			'message' => $message, 
			'degree' => $degree,
		]);
		}
			
       } else {
            return $this->render('create', [
                'model' => $model,
                'degree' => $degree,
            ]);
        }
    }

    /**
     * Updates an existing Majors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $degree = Degree::getAllDegrees();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            $model->updated_by = Yii::$app->user->identity->id;            
            $model->created_at = gmdate("M d Y H:i:s");
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);    
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'degree' => $degree,
            ]);
        }
    }

    /**
     * Deletes an existing Majors model.
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
     * Finds the Majors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Majors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Majors::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
