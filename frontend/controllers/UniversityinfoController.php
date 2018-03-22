<?php

namespace frontend\controllers;

use Yii;
use common\models\Universityinfo;
use common\models\Consultant;
use frontend\models\UniversityinfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\University; 
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\helpers\FileHelper;
use backend\models\SiteConfig;
use common\components\ConnectionSettings;

/**
 * UniversityinfoController implements the CRUD actions for Universityinfo model.
 */
class UniversityinfoController extends Controller
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
     * Lists all Universityinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UniversityinfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'universities' => $this->getUniversityList(),
        ]);
    }

    /**
     * Displays a single Universityinfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        $id=$_GET['id'];
        $model = $this->findModel($id); 
        return $this->render('view', [
            'model' => $model, 
        ]);
    }

    /**
     * Creates a new Universityinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Universityinfo();
        $id = Yii::$app->user->identity->id; 

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        if ($model->load(Yii::$app->request->post())) {
                $model->consultant_id = Yii::$app->user->identity->id;
                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                    $id = $model->id;
                   $email = University::find()->where(['=', 'id', $model->university_id])->one();
                  // $email = $email['email'];
                   $email = 'roan@brighter-prep.com';
                   $user = 'Roan';
                   if($this->sendActivationLink($model, $email, $user, $id)) {
                    }
                }
                 
                return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                //'university' => $university,
            ]);
        }
    }

    /**
     * Updates an existing Universityinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       /* $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }*/
        Yii::$app->view->params['activeTab'] = 'invoice';
        $model = $this->findModel($id);


         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }  
          
          if ($model->load(Yii::$app->request->post())) {
            $model->consultant_id = Yii::$app->user->identity->id; 
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_at = gmdate('Y-m-d H:i:s');

                $model->consultant_id = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                 
                    $id = $model->id;
                    $consultant_id = $model->consultant_id;
                   $email = Consultant::find()->where(['=', 'id', $model->consultant_id])->one();
                  // $email = $email['email'];
                   $email = 'roan@brighter-prep.com';
                   $user = 'Roan';
                   if($this->sendActivationLink($model, $email, $user, $id)) {
                    }
                }
         
             
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionReplay($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }  
          
          if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                 
                    $id = $model->id;
                    $consultant_id = $model->consultant_id;
                   $email = Consultant::find()->where(['=', 'id', $model->consultant_id])->one();
                   $email = $email['email'];
                   $user = '';
                   if($this->sendActivationLink($model, $email, $user, $id)) {
                    }
                }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }} else {
            return $this->render('update', [
                //'status' => 'success',
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Universityinfo model.
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
     * Finds the Universityinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Universityinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Universityinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
     private function getUniversityList() {
        //return ArrayHelper::map(University::find()->orderBy('name')->all(), 'id', 'name');
        return ArrayHelper::map(University::find()->where(['=', 'is_partner', 1])->orderBy('name')->all(), 'id', 'name');
    }
    private function sendActivationLink($model, $email, $user, $id) {

        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail(); 
        $path = Yii::getAlias('@frontend');  
        //$path = $path."/web/uploads/invoice/32/";
        //$file = 'invoice_gtu.pdf'; 

        /*$mpdf =new mPDF; 
        $mpdf->WriteHTML( $this->renderPartial('downloadapplication'));
        $mpdf->Output($path.'invoice_gtu.pdf','D'); */   

        $time = time();
        Yii::$app->mailer->compose(['html' => '@common/mail/replayto_question'],[
                'model' =>$model,
            ])
            ->setFrom($from)
            ->setTo($email)

            //->setCc($cc)
            //->attachContent($path,['fileName' => $file,'contentType' => 'application/pdf'])
            ->setSubject('Enquiry Received')
            ->send();


        return true;

    }
}