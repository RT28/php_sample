<?php

namespace backend\controllers;

use Yii;
use backend\models\Essay;
use backend\models\EssaySearch;
use common\models\FileUpload;

use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * EssayController implements the CRUD actions for Essay model.
 */
class EssayController extends Controller
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
     * Lists all Essay models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EssaySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Essay model.
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
     * Creates a new Essay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Essay();

		 $upload = new FileUpload();
        if ($model->load(Yii::$app->request->post()) ) {
			if($model->save()){
				 $this->saveUploadEssay($upload, $model);
			}
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'upload' => $upload
            ]);
        }
		 
    }

    /**
     * Updates an existing Essay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = new FileUpload();
        if ($model->load(Yii::$app->request->post()) ) {
			if($model->save()){
				 $this->saveUploadEssay($upload, $model);
			}
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'upload' => $upload
            ]);
        }
    }

	private function saveUploadEssay($upload, $model) {
        $newFile = UploadedFile::getInstance($upload, 'uploadessay');
	 
        if (isset($newFile)) {
            $upload->uploadessay = UploadedFile::getInstance($upload, 'uploadessay');
            if ($upload->uploadEssay($model)) {				 
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

	    public function actionDownload($name) {
        $id = Yii::$app->request->get('id');
        if (is_dir("../web/uploads/essays/$id/")) {
            $downloadDoc = FileHelper::findFiles("../web/uploads/essays/$id/", [
                'caseSensitive' => false,
                'recursive' => false, 
            ]);
            if (count($downloadDoc) > 0) {
                Yii::$app->response->sendFile($downloadDoc[0]);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }
	
    /**
     * Deletes an existing Essay model.
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
     * Finds the Essay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Essay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Essay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
