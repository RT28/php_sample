<?php

namespace backend\controllers;

use Yii;
use common\models\PackageOfferings;
use backend\models\PackageOfferingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use yii\helpers\FileHelper;
use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl;

/**
 * PackageOfferingsController implements the CRUD actions for PackageOfferings model.
 */
class PackageOfferingsController extends Controller
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
     * Lists all PackageOfferings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageOfferingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageOfferings model.
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
     * Creates a new PackageOfferings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PackageOfferings();
        $status = Status::getActiveInactiveStatus();
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->save();
            if($model->save() && $this->saveIcon($model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'status' => $status
        ]);
    }

    private function saveIcon($id) {
        if(!isset($_FILES['icon']['name']) || empty($_FILES['icon']['name'])) {
            return true;
        }
        $icon = $_FILES['icon'];
        if($icon['error'] == 0) {
            $sourcePath = $icon['tmp_name'];
            $ext = pathinfo($icon['name'], PATHINFO_EXTENSION);
            $targetPath = './../web/package-offerings-uploads/' . $id . '/icon' . '.' . $ext;
            $failed_files = [];
            $result = is_dir('./../web/package-offerings-uploads/' . $id);
            if (!$result) {
                $result = FileHelper::createDirectory('./../web/package-offerings-uploads/' . $id);
            }
            if (move_uploaded_file($sourcePath,$targetPath)) {
                return true;
            }
            return false;
        }
    }

    /**
     * Updates an existing PackageOfferings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $status = Status::getActiveInactiveStatus();
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            if($model->save() && $this->saveIcon($model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'status' => $status
        ]);
    }

    /**
     * Deletes an existing PackageOfferings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Status::STATUS_INACTIVE;
        if ($model->save()) {
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the PackageOfferings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageOfferings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageOfferings::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}