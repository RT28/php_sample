<?php

namespace backend\controllers;

use Yii;
use common\models\Invoice;
use backend\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\University; 
use yii\helpers\ArrayHelper;
use backend\models\SiteConfig;
use common\components\ConnectionSettings;
use mPDF;
use frontend\models\UserLogin;
use common\models\FileUpload;
use yii\web\UploadedFile;
use common\models\StudentConsultantRelation;
use yii\helpers\FileHelper;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'universities' => $this->getUniversityList(),
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionRaiseinvoice($id)
    {
        return $this->render('raiseinvoice', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
         
        
        Yii::$app->view->params['activeTab'] = 'invoice';
        $model = $this->findModel($id);
        $upload = new FileUpload();

        $student_id= '';        
        if(isset($_REQUEST['id'])){
                  $student_id = $_REQUEST['id'];  
             }

         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }  
          
          if ($model->load(Yii::$app->request->post())) {
            
                
                if($model->save(false)){
                 
                    /*$comment = new TaskComment();
                    $comment->task_id =$model->id;
                    $comment->consultant_id =$model->consultant_id;
                    $comment->action =$model->action;
                    $comment->status =$model->status;
                    $comment->comment =$model->comments;
                    $comment->created_by = $model->updated_by;
                    $comment->created_at = $model->updated_at;
                    $comment->save(false);
             
                    $this->saveUploadAttachment($upload, $model);*/
                }
         
             
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'students' => $this->getAllAssignedStudent(),
                'student_id' => $student_id,
                'upload' => $upload
            ]);
        }
    }
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/
/*    public function actionUpdate($id)
    {
        Yii::$app->view->params['activeTab'] = 'invoice';
        $model = $this->findModel($id);
        $upload = new FileUpload();

        $student_id= '';        
        if(isset($_REQUEST['id'])){
                  $student_id = $_REQUEST['id'];  
             }

         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }  
          
          if ($model->load(Yii::$app->request->post())) {
            $model->consultant_id = Yii::$app->user->identity->id; 
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_at = gmdate('Y-m-d H:i:s');

            $model->consultant_id = Yii::$app->user->identity->id;
                $model->agency_id = 1; 
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){

                }
         
             
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'students' => $this->getAllAssignedStudent(),
                'student_id' => $student_id,
                'upload' => $upload
            ]);
        }
    }*/

    /**
     * Deletes an existing Invoice model.
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
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionEnable($id)
    {
        $model= $this->findModel($id);
        $model->status = 1;
        $model->save(false);

        if( $model->save(false)){
        $email = 'roanantony07@gmail.com';
        $user = 'Roan';
        if($this->sendActivationLink($model, $email, $user)) {
        } 
  
                        return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->status]);
            
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        } 
    }
    

/*public function  downloadPdf($id)
    { 
    $mpdf =new mPDF; 
   // $stylesheet  = '';
   // $stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'frontend/web/bootstrap/css/bootstrap.css');
    //$stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'partner/web/css/site.css'); 
    //$mpdf->WriteHTML($stylesheet, 1);   
    $mpdf->WriteHTML( $this->renderPartial('downloadapplication'));
    $mpdf->Output('filename.pdf','D');
    // $mpdf->Output('../pdfexport/filename1.pdf','F'); 
     
    //exit;
    }*/


        public function actionDownload($id)
    { 
    $mpdf =new mPDF; 
   // $stylesheet  = '';
   // $stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'frontend/web/bootstrap/css/bootstrap.css');
    //$stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'partner/web/css/site.css'); 
    //$mpdf->WriteHTML($stylesheet, 1);   
    $mpdf->WriteHTML( $this->renderPartial('downloadapplication'));
    $mpdf->Output('filename.pdf','D');
    // $mpdf->Output('../pdfexport/filename1.pdf','F'); 
    
    }

    public function actionDownloadattachment() {

        $path = Yii::getAlias('@frontend');
        ini_set('max_execution_time', 5*60); // 5 minutes
        $id = $_GET['id'];;
        $fileName = $_GET['name'];
        //$fileName = '242_Webinar Process1503821756.docx';
        if (is_dir($path."/web/uploads/invoice/$id")) {
            $path = FileHelper::findFiles($path."/web/uploads/invoice/$id", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
            //echo $path;
        }
    }

    private function sendActivationLink($model, $email, $user) {

     

        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail(); 
        $path = Yii::getAlias('@frontend');  
       //$path = $path."/web/uploads/invoice/32/";
        //$file = 'invoice_gtu.pdf'; 

        //$mpdf =new mPDF; 
	    //$mpdf->WriteHTML( $this->renderPartial('downloadapplication'));
	    //$mpdf->Output($path.'invoice_gtu.pdf','D');    

        $time = time();
        Yii::$app->mailer->compose(['html' => '@common/mail/invoice-confirmation'],[
                'model' =>$model,
            ])
            ->setFrom($from)
            ->setTo($email)
            //->setCc($cc)
            //->attachContent($path,['fileName' => $file,'contentType' => 'application/pdf'])
            ->setSubject('Invoice Received')
            ->send();


        return true;

    }
     private function getUniversityList() {
        return ArrayHelper::map(University::find()->orderBy('name')->all(), 'id', 'name');
    }
    private function getAllAssignedStudent() { 
        $id = Yii::$app->user->identity->id;  
        $students = StudentConsultantRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.$id . ' AND 
        user_login.status = 6')
        ->all();
     
        
        $studentData = array();     
        $i = 0;              
        foreach($students as $student){
    
        $studentProfile = $student->student->student;   
        $studentData[$i]['id'] = $studentProfile->student_id;   
        $studentData[$i]['name'] =  $studentProfile->first_name." ".$studentProfile->last_name;

        
        $i++;
        }
         
        $studentList = ArrayHelper::map($studentData, 'id', 'name');
        return $studentList;
    }
}
