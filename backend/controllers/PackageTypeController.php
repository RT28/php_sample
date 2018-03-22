<?php

namespace backend\controllers;

use Yii;
use common\models\PackageType;
use backend\models\PackageTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl;

/**
 * PackageTypeController implements the CRUD actions for PackageType model.
 */
class PackageTypeController extends Controller
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
     * Lists all PackageType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageType model.
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
     * Creates a new PackageType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PackageType();
        $status = Status::getStatus();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        return $this->render('create', [
            'model' => $model,
            'status' => $status
        ]);
    }

    /**
     * Updates an existing PackageType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $status = Status::getStatus();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;            
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        return $this->render('update', [
            'model' => $model,
            'status' => $status
        ]);
    }

    /**
     * Deletes an existing PackageType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Status::STATUS_INACTIVE;
        
        if($model->save()) {
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);       
    }

    /**
     * Finds the PackageType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}