<?php

namespace backend\controllers;

use Yii;
use common\models\Advertisement;
use backend\models\AdvertisementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\FileUpload;
use yii\web\UploadedFile;
/**
 * AdvertisementController implements the CRUD actions for Advertisement model.
 */
class AdvertisementController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Advertisement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisement model.
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
     * Creates a new Advertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
			$model = new Advertisement();
			$upload = new FileUpload();
			
			
			
			if ($model->load(Yii::$app->request->post()) ) {
				$model->created_by =Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate('Y-m-d H:i:s');
				$model->updated_at = gmdate('Y-m-d H:i:s');
				 
			if($model->save()){
				 $this->saveUploadAdvertisement($upload, $model);
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
     * Updates an existing Advertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$upload = new FileUpload();
        if ($model->load(Yii::$app->request->post())) {
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_at = gmdate('Y-m-d H:i:s');
			if($model->save()){
				 $this->saveUploadAdvertisement($upload, $model);
			} 
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'upload' => $upload
            ]);
        }
    }

	private function saveUploadAdvertisement($upload, $model) {
        $newFile = UploadedFile::getInstance($upload, 'imageadvert');
	 
        if (isset($newFile)) {
            $upload->imageadvert = $newFile;
			$filename = $upload->uploadAdvertisement($model);			
         	 
			if(isset($filename)){
		
            if(!empty($model)) {			 
					$model->updated_by = Yii::$app->user->identity->id;
					$model->updated_at = gmdate('Y-m-d H:i:s'); 
					$model->imageadvert = $filename; 
					$model->save(false); 
			} 	    
					return true;
            } else {
                return false;
            }
        }
        return true;
    }

	
    /**
     * Deletes an existing Advertisement model.
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
     * Finds the Advertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertisement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
