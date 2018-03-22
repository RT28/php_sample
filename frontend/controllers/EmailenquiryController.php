<?php

namespace frontend\controllers;

use Yii;
use common\models\Emailenquiry;
use frontend\models\EmailenquirySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Student;
use common\models\Consultant;
use common\models\University; 
use backend\models\SiteConfig;
use common\components\ConnectionSettings;
/**
 * EmailenquiryController implements the CRUD actions for Emailenquiry model.
 */
class EmailenquiryController extends Controller
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
     * Lists all Emailenquiry models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'inbox';
        $id = Yii::$app->user->identity->id;
        $searchModel = new EmailenquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $emailenquiry = Emailenquiry::find()->where(['=', 'student_id', $id])
        ->andWhere(['=', 'email_source', 1])
        ->orderBy(['id' => 'ASC'])->all();
        return $this->render('inbox', [
            'emailenquiries' => $emailenquiry,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionSentitem()
    { 
        Yii::$app->view->params['activeTab'] = 'enquiry';
        $id = Yii::$app->user->identity->id;
        $searchModel = new EmailenquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $emailenquiry = Emailenquiry::find()->where(['=', 'student_id', $id])
        ->andWhere(['=', 'email_source', 0])
        ->andWhere(['=', 'is_draft', 0])
        ->orderBy(['id' => 'ASC'])->all();
        return $this->renderAjax('message_template', [
            'emailenquiries' => $emailenquiry,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionDraft()
    { 
        Yii::$app->view->params['activeTab'] = 'draft';
        $id = Yii::$app->user->identity->id;
        $searchModel = new EmailenquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $emailenquiry = Emailenquiry::find()->where(['=', 'student_id', $id])
        ->andWhere(['=', 'email_source', 0])
        ->andWhere(['=', 'is_draft', 1])
        ->orderBy(['id' => 'ASC'])->all();
        return $this->renderAjax('message_template', [
            'emailenquiries' => $emailenquiry,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionSearch()
    { 
        Yii::$app->view->params['activeTab'] = 'enquiry';
        $id = Yii::$app->user->identity->id;
        $content = $_POST['content'];
        $searchModel = new EmailenquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $emailenquiry = Emailenquiry::find()->where(['=', 'student_id', $id])
        ->andWhere(['like', 'subject', $content])
        ->orderBy(['id' => 'ASC'])->all();
        return $this->renderAjax('message_template', [
            'emailenquiries' => $emailenquiry,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionIndexold()
    {
        Yii::$app->view->params['activeTab'] = 'enquiry';
        $id = Yii::$app->user->identity->id;
        $searchModel = new EmailenquirySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Emailenquiry model.
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
     * Creates a new Emailenquiry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Emailenquiry();

         $id = Yii::$app->user->identity->id; 

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        if ($model->load(Yii::$app->request->post())) {
                $model->student_id = Yii::$app->user->identity->id;
                $model->created_by = Yii::$app->user->identity->username;
                $model->updated_by = Yii::$app->user->identity->username;
                $model->email_source = 0;
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                    $id = $model->id;

                    $consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
                    $consultantemail = $consultantProfile->email;
                    $consultantname = $consultantProfile->first_name.' '.$consultantProfile->last_name;

                       /*if($this->sendreplyto_consultant($model,$consultantemail,$consultantname)) {
                        }*/
                }
                return $this->redirect(['index']);
                /*$link = "index.php?r=emailenquiry/index&status=". $model->email_source;
                return $this->redirect($link);*/
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Emailenquiry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         $id = Yii::$app->user->identity->id; 

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        if ($model->load(Yii::$app->request->post())) {
                $model->student_id = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->username;
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                    $id = $model->id;
                    $consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
                    $consultantemail = $consultantProfile->email;
                    $consultantname = $consultantProfile->first_name.' '.$consultantProfile->last_name;
                       if($this->sendreplyto_consultant($model,$consultantemail,$consultantname)) {
                        }
                }
                $link = "/emailenquiry/index?status=". $model->email_source;
                return $this->redirect($link);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                //'university' => $university,
            ]);
        }
    }

    public function actionReply($id,$tag)
    {
        $model = $this->findModel($id);

         //$id = Yii::$app->user->identity->id; 

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        if ($model->load(Yii::$app->request->post())) {
                $model->student_id = $model->student_id;
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                    $id = $model->id;

                       /*if($this->sendEnquiryLink($model)) {
                        }*/
                }
                   return $this->render('reply', [
                    'model' => $model,
                    'tag' => $tag,
                    'status' => 'success',
                ]);
        } else {
            return $this->render('reply', [
                'model' => $model,
                'tag' => $tag,
                'status' => '',
            ]);
        }
    }

    /**
     * Deletes an existing Emailenquiry model.
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
     * Finds the Emailenquiry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Emailenquiry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Emailenquiry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function sendreplyto_consultant($model, $email, $consultantname) {
        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail();   
        $path = Yii::getAlias('@frontend');        
        $time = time();
        $studentProfile = Student::find()->where(['=', 'student_id', $model->student_id])->one();
        $studentName = $studentProfile->first_name." ".$studentProfile->last_name;
        Yii::$app->mailer->compose(['html' => '@common/mail/enquiry_from_student_to_consultant'],[
            'model' =>$model,
                'user' => $consultantname,
                'student_name' => $studentName,
                'subject' =>$model->subject,
                'consultant_message' =>$model->consultant_message,
                'student_message' =>$model->student_message,
                'father_message' =>$model->father_message,
                'mother_message' =>$model->mother_message,
                
            ])
            ->setFrom($from)
            ->setTo($email)
            ->setCc($cc)
            ->setSubject('Enquiry Received')
            ->send();
        return true;
    }
    private function sendEnquiryLink($model) {

        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail(); 
        $path = Yii::getAlias('@frontend');
        $time = time();  
        $studentProfile = Student::find()->where(['=', 'student_id', $model->student_id])->one();
        
        if($model->is_to_student == 1){
            if(!empty($studentProfile->email)){
            $student_email = $studentProfile->email;
            Yii::$app->mailer->compose(['html' => '@common/mail/enquiry_from_consultant_to_student'],[
                'model' =>$model,
                'user' =>$studentProfile->first_name." ".$studentProfile->last_name,
                'message' =>$model->consultant_message,
                'link' => ConnectionSettings::BASE_URL . 'universityinfo/replay?id=' . $model->id . '&timestamp=' . strtotime('+2 days', $time),
            ])
            ->setFrom($from)
            ->setTo($student_email)
            ->setSubject($model->subject)
            ->send();
            }
        }
        if($model->is_to_father == 1){
            if(!empty($studentProfile->father_email)){
            $father_email = $studentProfile->father_email;
            Yii::$app->mailer->compose(['html' => '@common/mail/enquiry_from_consultant_to_student'],[
                'model' =>$model,
                'user' =>$studentProfile->father_name,
                'message' =>$model->consultant_message,
                'link' => ConnectionSettings::BASE_URL . '/universityinfo/replay?id=' . $model->id . '&timestamp=' . strtotime('+2 days', $time),
            ])
            ->setFrom($from)
            ->setTo($father_email)
            ->setSubject($model->subject)
            ->send(); 
            }
        }
        if($model->is_to_mother == 1){
            if(!empty($studentProfile->mother_email)){
            $mother_email = $studentProfile->mother_email;
            Yii::$app->mailer->compose(['html' => '@common/mail/enquiry_from_consultant_to_student'],[
                'model' =>$model,
                'user' =>$studentProfile->mother_name,
                'message' =>$model->consultant_message,
                'link' => ConnectionSettings::BASE_URL . '/universityinfo/replay?id=' . $model->id . '&timestamp=' . strtotime('+2 days', $time),
            ])
            ->setFrom($from)
            ->setTo($mother_email)
            ->setSubject($model->subject)
            ->send(); 
            }
        }
        
        


        return true;

    }


}
