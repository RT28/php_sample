<?php
namespace partner\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use partner\models\PartnerForm;
use partner\models\PartnerLoginForm;
use common\components\Roles;
use backend\models\GeneralEnquiry;  
use common\models\Country;
use backend\models\SiteConfig; 
use yii\helpers\ArrayHelper;
use common\components\Commondata;  
use common\models\TermsPolicy;
use common\models\Consultant;
use common\models\PartnerEmployee;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'index','general', 'message', 'term',  'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		if (!Yii::$app->user->isGuest) {
		if (Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
                return $this->redirect(['consultant/students/index']);
            }
            if (Yii::$app->user->identity->role_id == Roles::ROLE_ASSOCIATE_CONSULTANT) {
                return $this->redirect(['consultant/associate-consultant/index']);
            } 
			if (Yii::$app->user->identity->role_id == Roles::ROLE_AGENCY) {
                return $this->redirect(['agency/agency/index']);
            }
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_EMPLOYEE) {
                return $this->redirect(['employee/employee/index']);
            }
			if (Yii::$app->user->identity->role_id == Roles::ROLE_TRAINER) {
                return $this->redirect(['employee/employee/index']);
            }
			 
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_UNIVERSITY) {
                return $this->redirect(['university/dashboard']);
            }
		}   
        return Yii::$app->response->redirect('https://gotouniversity.com');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    { 
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 
 
		if (!Yii::$app->user->isGuest) {
		if (Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
                return $this->redirect(['consultant/students/index']);
            }
            if (Yii::$app->user->identity->role_id == Roles::ROLE_ASSOCIATE_CONSULTANT) {
                return $this->redirect(['consultant/associate-consultant/index']);
            } 
			if (Yii::$app->user->identity->role_id == Roles::ROLE_AGENCY) {
                return $this->redirect(['agency/agency/index']);
            }
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_EMPLOYEE) {
                return $this->redirect(['employee/employee/index']);
            }
			if (Yii::$app->user->identity->role_id == Roles::ROLE_TRAINER) {
                return $this->redirect(['employee/employee/index']);
            }
			 
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_UNIVERSITY) {
                return $this->redirect(['university/dashboard']);
            }
		} 
		
        $model = new PartnerLoginForm();
		
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			 
            if (Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
                return $this->redirect(['consultant/students/index']);
            }
            /*if (Yii::$app->user->identity->role_id == Roles::ROLE_ASSOCIATE_CONSULTANT) {
                return $this->redirect(['consultant/associate-consultant/index']);
            }
			if (Yii::$app->user->identity->role_id == Roles::ROLE_SRM) {
                return $this->redirect(['counselor/students/index']);
            }*/
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_AGENCY) {
                return $this->redirect(['agency/agency/index']);
            }
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_EMPLOYEE) {
                return $this->redirect(['employee/employee/index']);
            }
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_TRAINER) {
                return $this->redirect(['employee/employee/index']);
            } 
			
			if (Yii::$app->user->identity->role_id == Roles::ROLE_UNIVERSITY) {
                return $this->redirect(['university/dashboard']);
            }
            else {
                return $this->goBack();
            }
        } else {
            return $this->render('login', [
                'model' => $model, 
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    { 
        $id = Yii::$app->user->identity->id;
        $role = Yii::$app->user->identity->role_id;
        if($role == Roles::ROLE_CONSULTANT) {
            $consultant_logged = Consultant::find()->where(['consultant_id'=>$id])->one();
            $consultant_logged->logged_status = 0;                
            $consultant_logged->save(false);
        } /*else if($role == Roles::ROLE_EMPLOYEE OR $role == Roles::ROLE_TRAINER) {
            $trem_logged = PartnerEmployee::find()->where(['partner_login_id'=>$id])->one();
            $trem_logged->logged_status = 0;                
            $trem_logged->save(false);
        }*/
        Yii::$app->user->logout();

        return Yii::$app->response->redirect('https://gotouniversity.com');
    }

    public function actionEmployeeForm()
    {
        $model = new EmployeeForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                return;
            }
        }

        return $this->render('employeeForm', [
            'model' => $model,
        ]);
    }
	public function actionMessage()
    {
		 return $this->render('message');
	}
	
	public function actionTerm()
    {
		 $terms = TermsPolicy::find()->one();
        return $this->renderAjax('term',['terms' => $terms->terms , 'policy' => $terms->policy]);
	}
	
	public function actionGeneral()
    {
		$helpemail = SiteConfig::getConfigHelpEmail();
		   
        $model = new GeneralEnquiry(); 
		$message = '';
        if(Yii::$app->request->post()) {
			$model->load(Yii::$app->request->post());
            $exists = GeneralEnquiry::find()->where(['=', 'email', $model->email])->all();
			
            $count = count($exists); 
            if($count>=3) {  
			
				Yii::$app->getSession()->setFlash('Error', 'We have already received your queries and our team is working on it and we will revert back to you shortly.');  
			
			}else{
				
				if($model->save(false)) {   
						
					$to = $model->email;
					$user = $model->name; 		
					$subject = 'Leave Message To GoToUniversity';
                    $template = 'leaveus_message';  
					$data = array('user' => $user);

					//$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
                    $mailsent = Commondata::sendContactQuery($to,$subject,$data,$template);

                    /*mail details to gtu*/
                    $enquiry_from = $to;
                    $subject = 'General Eenquiry Received';
                    $first_name = $user;
                    $template = 'leaveus_message_details';
                    $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->phone ,'message' => $model->message);
                    $maildetails = Commondata::sendContactQueryDetails($enquiry_from,$subject,$data,$template);

					if($mailsent==true AND $maildetails==true){
						
					Yii::$app->getSession()->setFlash('Success', 'Thanks for submitting your query. A GTU team member will contact you shortly.');
                     
                } else { 
					
					Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please send email to '.$helpemail);  
                } 
				
				}
            } 
			return $this->redirect(['/site/message']);
        }       
		 
		return $this->render('general_enquiry', [
			'model' => $model, 			 
		]);
        
    }
	
    public function actionTest()
    {
        return 'Hello';
    }
}
