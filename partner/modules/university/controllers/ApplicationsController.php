<?php

namespace partner\modules\university\controllers;

use Yii;
use common\models\StudentUniveristyApplication;
use common\models\Student;
use partner\modules\university\models\StudentUniversityApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\AdmissionWorkflow; 
use common\components\ConnectionSettings;
use common\components\Status;
use frontend\models\UserLogin;
use backend\models\EmployeeLogin;
use partner\models\PartnerLogin;
use frontend\models\StudentNotifications;
use partner\models\UniversityNotifications;
use partner\models\ConsultantNotifications; 
//use partner\models\Partner; 
use common\models\University;
use yii\data\ActiveDataProvider; 
use mPDF;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

use backend\models\SiteConfig;

/**
 * UniversityApplicationsController implements the CRUD actions for StudentUniveristyApplication model.
 */
class ApplicationsController extends Controller
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
                        'actions' => ['index', 'view', 'download', 'downloadapplication','changestatus'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
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
     * Lists all StudentUniveristyApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
		Yii::$app->view->params['activeTab'] = 'applications';
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
		Yii::$app->view->params['activeTab'] = 'applications';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionDownload($id)
    {
	Yii::$app->view->params['activeTab'] = 'applications';
	$mpdf =new mPDF; 
	$stylesheet  = '';
	$stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'frontend/web/bootstrap/css/bootstrap.css');
    $stylesheet .= file_get_contents(ConnectionSettings::BASE_URL . 'partner/web/css/site.css'); 
	//$mpdf->WriteHTML($stylesheet, 1);   
	$mpdf->WriteHTML( $this->renderPartial('downloadapplication',['model'=>$this->findModel($id)]),2);
	$mpdf->Output('filename.pdf','D');
	// $mpdf->Output('../pdfexport/filename1.pdf','F'); 
	 
	exit;
    }

	
	  public function actionDownloadapplication($id)
    {
		 
        return $this->render('downloadapplication', [
            'model' => $this->findModel($id),
        ]);
    }
	 public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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

 
 public function actionChangestatus($id)
    {
		
	Yii::$app->view->params['activeTab'] = 'applications';
	
        $model = $this->findModel($id);  
		$cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();
		  
		 $Student = Student::find()->where(['=', 'id',$model->student_id])->one();
        
		$email =  $Student->email;
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$time = time();
			    $mail = Yii::$app->mailer->compose(['html' => '@common/mail/application_status_change'],[
                'name' => $Student->first_name,
				'status' => AdmissionWorkflow::getStateName($model->status),
                'comment' =>  $model->remarks,
            ])
            ->setFrom($from)
            ->setTo($email)
			->setCc($cc)
            ->setSubject('University Application Status updated');
			$message = '';
            if($mail->send()){
				$message = "Success! We have updated status of your application. Please check your inbox";
	
			}else{
				$message = "Error! Email not sent.";
		 	}
		 
					 return $this->render('changestatus', [
                'model' => $model,
				 'message' => $message 
            ]);
        } else {
            return $this->render('changestatus', [
                'model' => $model,  
            ]);
        }
    }
}
