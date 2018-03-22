<?php

namespace backend\controllers;

use Yii;
use common\models\Degree;
use backend\models\DegreeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\DegreeTypes;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * DegreeController implements the CRUD actions for Degree model.
 */
class DegreeController extends Controller
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
     * Lists all Degree models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DegreeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Degree model.
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
     * Creates a new Degree model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Degree();

         $message = '';
        if(Yii::$app->request->post()) {
			$model->load(Yii::$app->request->post());
            $exists = Degree::find()->where(['=', 'name', $model->name])->one();
            if(empty($exists)) {  
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate("M d Y H:i:s");
				$model->updated_at = gmdate("M d Y H:i:s");
				$model->save();
				$message = 'Success! Degree added successfull.';
				return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = 'Error! Degree already exists.';
				return $this->render('create', [
                'model' => $model,
				'message' => $message, 
				 'degreeTypes' => DegreeTypes::$degreeTypes
            ]);
            }             
        } else {
            return $this->render('create', [
                'model' => $model,
                'degreeTypes' => DegreeTypes::$degreeTypes
            ]);
        }
    }

    /**
     * Updates an existing Degree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            $model->updated_by = Yii::$app->user->identity->id;            
            $model->updated_at = gmdate("M d Y H:i:s");
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);    
            }            
        } else {
            return $this->render('update', [
                'model' => $model,                
                'degreeTypes' => DegreeTypes::$degreeTypes
            ]);
        }
    }

    /**
     * Deletes an existing Degree model.
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
     * Finds the Degree model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Degree the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Degree::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
