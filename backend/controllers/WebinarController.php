<?php

namespace backend\controllers;

use Yii;
use common\models\WebinarCreateRequest;
use backend\models\WebinarCreateRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use common\models\FileUpload;
use yii\web\UploadedFile;
use yii\helpers\Json;
use common\components\ConnectionSettings;
use backend\models\SiteConfig;
use yii\helpers\ArrayHelper;

/**
 * WebinarController implements the CRUD actions for WebinarCreateRequest model.
 */
class WebinarController extends Controller
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
     * Lists all WebinarCreateRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebinarCreateRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebinarCreateRequest model.
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
     * Creates a new WebinarCreateRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebinarCreateRequest();
        $upload = new FileUpload();
        if ($model->load(Yii::$app->request->post()) ) {
            $model->status = 0;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            if(!empty($model->disciplines)) {
                $model->disciplines = implode(',', $model->disciplines);
            }
            if(!empty($model->country)) {
                $model->country = implode(',', $model->country);
            }
            if(!empty($model->degreelevels)) {
                $model->degreelevels = implode(',', $model->degreelevels);
            }
            if(!empty($model->test_preperation)) {
                $model->test_preperation = implode(',', $model->test_preperation);
            }
            if($model->save(false)){
                 
                    $this->saveUploadAttachment($upload, $model);
                    $email = $model->email;
                    $user = $model->author_name;
                    if($this->sendActivationLink($model, $email, $user)) {
                    } 
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
     * Updates an existing WebinarCreateRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $upload = new FileUpload();
        if ($model->load(Yii::$app->request->post()) ) {
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            if(!empty($model->disciplines)) {
                $model->disciplines = implode(',', $model->disciplines);
            }
             if(!empty($model->country)) {
                $model->country = implode(',', $model->country);
            }
            if(!empty($model->degreelevels)) {
                $model->degreelevels = implode(',', $model->degreelevels);
            }
            if(!empty($model->test_preperation)) {
                $model->test_preperation = implode(',', $model->test_preperation);
            }
            if($model->save(false)){
                 
                    $this->saveUploadAttachment($upload, $model);

                }
 
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'upload' => $upload
            ]);
        }
    }
    private function sendActivationLink($id, $email, $user) {
        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail();   
                
        $time = time();
        Yii::$app->mailer->compose(['html' => '@common/mail/webinar-author-regis'],[
                'user' => $user,
                'consultantname' => 'consultantname',
                'packagestype' => 'df',
                'link' => 'dsd',
            ])
            ->setFrom($from)
            ->setTo($email)
            //->setCc($cc)
            ->setSubject('GoToUniversity Conduct a Webinar')
            ->send();
        return true;
    }
    /**
     * Deletes an existing WebinarCreateRequest model.
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
     * Finds the WebinarCreateRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebinarCreateRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebinarCreateRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

        private function saveUploadAttachment($upload, $model) { 
        $newFile = UploadedFile::getInstance($upload, 'logoFile');
     
        if (isset($newFile)) {
            $upload->logoFile = $newFile;
            $filename = $upload->uploadWebinarLogo($model);            
             
            if(isset($filename)){
        
            if(!empty($model)) {             
                    //$model->updated_by = Yii::$app->user->identity->id;
                   // $model->updated_at = gmdate('Y-m-d H:i:s'); 
                    $model->logo_image = $filename; 
                    $model->save(false); 
            }       
                    return true;
            } else {
                return false;
            }
        }
        return true;
    }
    public function actionDisable($id)
    {
        $model= $this->findModel($id);
        $model->status = 0;
        $model->save(false);
        $this->view->params['customParam'] = $id;
        if( $model->save(false)){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        }    
    }

    public function actionEnable($id)
    {
        $model= $this->findModel($id);
        $model->status = 1;
        $model->save(false);
        $this->view->params['customParam'] = $id;
        if( $model->save(false)){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        } 
    }
}
