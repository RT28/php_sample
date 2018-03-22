<?php

namespace frontend\controllers;

use Yii;
use common\models\StudentUniveristyApplication;
use frontend\models\StudentUniversityApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AdmissionWorkflow;
use common\components\Roles;
use backend\models\EmployeeLogin;
use partner\models\PartnerLogin;
use frontend\models\StudentNotifications; 
use partner\models\UniversityNotifications;
use partner\models\ConsultantNotifications; 
use common\models\StudentConsultantRelation;
use common\components\ConnectionSettings;
use common\components\Notifications;

use partner\models\Partner;

/**
 * UniversityApplicationsController implements the CRUD actions for StudentUniveristyApplication model.
 */
class UniversityApplicationsController extends Controller
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
     * Lists all StudentUniveristyApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentUniversityApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentUniveristyApplication model.
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
     * Creates a new StudentUniveristyApplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentUniveristyApplication();
        $model->student_id = Yii::$app->user->identity->id;
        $consultant = StudentConsultantRelation::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
        $model->consultant_id = $consultant->consultant_id;
        if(!empty($consultant)) {
            $model->consultant_id = $consultant->consultant_id;
        }
        $model->course_id = $_POST['course'];
        $model->university_id = $_POST['university'];
        $model->start_term = $_POST['term'];
        $model->created_by = Yii::$app->user->identity->id;
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->status = AdmissionWorkflow::STATE_DRAFT;
        if ($model->save()) {
            $url = ConnectionSettings::BASE_URL . 'frontend/web/index.php?r=university-applications/view&id=' . $model->id;

            // send email
            Yii::$app->mailer->compose()
                ->setFrom('gotouniversity.super@gmail.com')
                ->setTo(Yii::$app->user->identity->email)
                ->setSubject('University Application created') 
                ->setTextBody('Your application has been created.')                   
                ->setHtmlBody('<a href="'.  $url .'">Your application has been created</a>')
                ->send();
            //send sendNotifications
            $key = Roles::ROLE_STUDENT . '_' . Yii::$app->user->identity->id;
            Notifications::sendNotification([
                $key => [
                    'message' => 'Your application has been created',
                    'url' => $url
                ]
            ]);

            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error', 'message' => $model->errors]);
        }
    }

    /**
     * Updates an existing StudentUniveristyApplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StudentUniveristyApplication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->active = 0;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the StudentUniveristyApplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentUniveristyApplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentUniveristyApplication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateState() {
        $id = $_POST['id'];
        $action = $_POST['action'];
        $status = $_POST['status'];
        $remarks = $_POST['remarks'];

        $model = $this->findModel($id);
        if(empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'No such document']);
        }

        $state = AdmissionWorkflow::getStateDetails($status);
        if ($model->validate()) {
            if($model->status != $status) {
                return json_encode(['status' => 'error', 'message' => 'The current status of this is application is '. $model->status . '.Refreshing your page.', 'code' => 100]);
            }
            $model->status = $state['next'][$action];

            $summary = empty($model->summary) ? [] : json_decode($model->summary);
            if(!empty($model->remarks)) {
                array_push($summary, [
                    'role' => $model->updated_by_role,
                    'id' => $model->updated_by,
                    'time' => gmdate('Y-m-d H:i:s'),
                    'comment' => $model->remarks
                ]);
            }
            $model->summary = json_encode($summary);
            $model->remarks = $remarks;
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_by_role = Roles::ROLE_STUDENT;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if($model->save()) {                                
                $this->sendMail($state, $model, $action);
                $this->sendNotifications($state, $model, $action);
                return json_encode(['status' => 'success']);
            }
            return json_encode(['status' => 'error', 'message' => 'Error saving application']);
        } else {
            return json_encode(['status' => 'error', 'message' => 'Please verify/complete your application before submitting']);
        }        
    }

    private function sendNotifications($state, $model, $action) {        
        $roles = $state['notifications'][$action];       
        foreach($roles as $role=>$role_details) {
            $email = "";
            $base = 'http://localhost/yii2/gotouniversity/';
            switch($role) {
                case Roles::ROLE_CONSULTANT: 
                    $notification = new ConsultantNotifications();
                    $notification->consultant_id = $model->consultant_id;
                    $notification->from_id = Yii::$app->user->identity->id;
                    $notification->from_role = Yii::$app->user->identity->role_id;
                    $notification->message = json_encode([
                        'message' => $role_details['message'],
                        'link' => $base . 'backend/web/index.php?r=university-applications/view&id=' . $model->id
                    ]);
                    $notification->save(false);
                    break;
                case Roles::ROLE_STUDENT: 
                    $notification = new StudentNotifications();
                    $notification->student_id = $model->student_id;
                    $notification->from_id = Yii::$app->user->identity->id;
                    $notification->from_role = Yii::$app->user->identity->role_id;
                    $notification->message = json_encode([
                        'message' => $role_details['message'],
                        'link' => $base . 'frontend/web/index.php?r=university-applications/view&id=' . $model->id
                    ]);
                    $notification->save(false);
                    break;
                case Roles::ROLE_UNIVERSITY: 
                    $notification = new UniversityNotifications();
                    $notification->university_id = $model->university_id;
                    $notification->from_id = Yii::$app->user->identity->id;
                    $notification->from_role = Yii::$app->user->identity->role_id;
                    $notification->message = json_encode([
                        'message' => $role_details['message'],
                        'link' => $base . 'partner/web/index.php?r=university/university-applications/view&id=' . $model->id
                    ]);
                    $notification->save(false);
                    break;

                 case Roles::ROLE_CONSULTANT:
                    if(isset($model->consultant_id)) {
                        $notification = new ConsultantNotifications();
                        $notification->consultant_id = $model->consultant_id;
                        $notification->from_id = Yii::$app->user->identity->id;
                        $notification->from_role = Yii::$app->user->identity->role_id;
                        $notification->message = json_encode([
                            'message' => $role_details['message'],
                            'link' => $base . 'partner/web/index.php?r=consultant/university-applications/view&id=' . $model->id
                        ]);
                        $notification->save(false);
                    }                    
                    break;                
            }                 
        }
    }

    private function sendMail($state, $model, $action) {        
        $roles = $state['messages'][$action];             
        foreach($roles as $role => $role_details) {
            $email = "";
            $base = 'http://localhost/gotouniversity/';
            $link = "";
            switch($role) { 
                case Roles::ROLE_STUDENT: $email = Yii::$app->user->identity->email;                
                $link= $base . 'frontend/web/index.php?r=university-applications/view&id=' . $model->id;                
                break;
                case Roles::ROLE_UNIVERSITY:$partner = Partner::find() ->where(['=', 'university_id', $model->university_id])->one();
                $partner_login = PartnerLogin::find()->where(['=', 'id', $partner->partner_id])->one();
                $email = $partner_login->email;
                $link= $base . 'partner/web/index.php?r=university/university-applications/view&id=' . $model->id;
                break;
                case Roles::ROLE_CONSULTANT: $email = (!empty($model->consultant_id)) ? PartnerLogin::findOne($model->consultant_id)->email: [];                
                $link= $base . 'partner/web/index.php?r=university/university-applications/view&id=' . $model->id;
                break;
            }
            if(!empty($email)) {
                Yii::$app->mailer->compose()
                ->setFrom('gotouniversity.super@gmail.com')
                ->setTo($email)
                ->setSubject('University Application Status Change') 
                ->setTextBody($role_details['message'])                   
                ->setHtmlBody('<a href="'.$link.'">' . $role_details['message'] . '</a>')
                ->send();
            }                       
        }
    }
}
