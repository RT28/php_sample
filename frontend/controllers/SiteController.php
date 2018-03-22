<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\UserLoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\ContactForm;
use common\components\Roles;
use frontend\models\UserLogin;
use common\models\Country;
use common\models\DegreeLevel;
use common\models\Majors;
use yii\helpers\ArrayHelper;
use backend\models\Employee;
use common\models\StudentConsultantRelation;
use common\models\NewsletterSubscription;
use common\models\ContactQuery;
use common\models\University;
use common\models\PackageType;
use common\models\UniversityCourseList;
use common\models\UniversityNotifications;
use common\models\Notifications;
use common\models\Student;
use common\models\Consultant;
use common\models\Agency;
use yii\helpers\Url;
use frontend\models\FeaturedUniversities;
use common\models\Services;
use common\models\FreeCounsellingSessions; 
use common\components\CalendarEvents;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use common\components\ConnectionSettings;
use backend\models\SiteConfig;
use common\models\Faq;
use common\models\FaqCategory;
use partner\models\PartnerLoginForm;
use common\components\Commondata;
use common\models\Articles;
use partner\models\PartnerLogin;
use common\models\TermsPolicy;
use common\models\User;
use common\models\ChatHistory;
use common\models\ChatvideoNotificarion;
use common\models\Degree;

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
                'only' => ['logout', 'signup', 'login','subscribe', 'contact-query','message', 'term'],
                'rules' => [
                    [
                        'actions' => ['signup','login', 'subscribe', 'contact-query','message', 'term'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'send-chat', 'activate-account', 'subscribe', 'contact-query'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {        
		Yii::$app->view->params['activeTab'] = 'home';
	
        $universities = University::find()->limit(5)->indexBy('id')->all();
        $packages = PackageType::find()->where(['status'=>1])->orderBy(['rank' => 'ASC'])->all();
        $universityCount = University::find()->where(['is_active'=>1])->count();
        $programmeCount = UniversityCourseList::find()->count();
        $studentCount = Student::find()->count();
        $consultantCount = Consultant::find()->count();
        $featuredUniversities = FeaturedUniversities::find()->orderBy(['rank' => 'ASC'])->all();
        $services = Services::find()->where(['active'=>1])->orderBy(['rank' => 'ASC'])->all();
        $consultants = Consultant::find()->leftJoin('partner_login', '`partner_login`.`id` = `consultant`.`consultant_id` AND `partner_login`.`role_id` = ' . Roles::ROLE_CONSULTANT)->where(
		['AND',['is_active'=>1],
		['is_featured'=>1],
		['partner_login.status'=>PartnerLogin::STATUS_ACTIVE]
		])->all();
		$UniversityNotifications = Notifications::find()->limit(5)->indexBy('id')->all();
		 
			 
        return $this->render('index', [
            'universities' => $universities,
            'packages' => $packages,
            'universityCount' => $universityCount,
            'programmeCount' => $programmeCount,
            'studentCount' => $studentCount,
            'consultantCount' => $consultantCount,
            'featuredUniversities' => $featuredUniversities,
            'services' => $services,
            'consultants' => $consultants,
			'UniversityNotifications' => $UniversityNotifications
        ]);
    }

    public function actionLanguage($id='en')
    {
        if(isset($_GET['id']))
        {
                setcookie("lang",  $_GET['id'], time() + 31104000, "/"); // 86400 = 1 day
                \Yii::$app->language =$_COOKIE['lang'];
        }
        else if(isset($_COOKIE['lang']))
        {
                \Yii::$app->language =$_COOKIE['lang'];
        }
        else
        {
                \Yii::$app->language ="en";
        }
        if(Yii::$app->request->referrer){
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->goHome();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new UserLoginForm();
		$partnerLoginForm = new PartnerLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $url_str = isset($_POST['url']) ? $_POST['url'] : '';
			
			//echo $url_str; 
			 
            if (!empty($url_str)) {
                /*$temp = explode('&', $url_str);
                $len = sizeof($temp);
                $url = [];
                
                for($i = 0; $i < $len; $i++) {
                    if($i == 0) {
                        array_push($url, $temp[$i]);
                        continue;
                    }
                    $param = explode('=', $temp[$i]);
                    $url[$param[0]] = $param[1];
                }*/
				//print_r( $url); 
				//die;
                //return $this->redirect($_SERVER['HTTP_REFERER']);
				 return $this->redirect($url_str);
            }
            return $this->redirect(['student/dashboard']);
        }
        else {
            if(Yii::$app->request->isAjax) {
                return $this->renderAjax('login', [
                    'model' => $model,
					'partnerLogin' => $partnerLoginForm
                ]);
            }else{
				return $this->render('login1', [
                    'model' => $model
                ]);
			}        
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $student_logged = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        $student_logged->logged_status = 0;                
        $student_logged->save(false);
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionDesktop()
    {
       
        return $this->render('desktop', [
            ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
		Yii::$app->view->params['activeTab'] = 'contact';
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
		Yii::$app->view->params['activeTab'] = 'about';
        return $this->render('about');
    }
	
	 /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionFaq()
    {
		Yii::$app->view->params['activeTab'] = 'faq';
		$faqylist = Faq::find()->orderBy('id')->all();
        $faqycategorylist = FaqCategory::find()->orderBy('id')->all();
        return $this->render('faq',['faq' => $faqylist,'faqcategory' => $faqycategorylist]);
    }

    /**
     * Displays our team page.
     *
     * @return mixed
     */
    public function actionTeam()
    {
        return $this->render('team');
    }

    /**
     * Displays portfolio page.
     *
     * @return mixed
     */
    public function actionPortfolio()
    {
        return $this->render('portfolio');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
		Yii::$app->view->params['activeTab'] = 'signup';
        $model = new UserLogin();
        $model->qualification = 0;
        $model->knowus = 0;

        if ($model->load(Yii::$app->request->post()) && $model->validate(['email', 'degree_preference', 'country'])) {
            if(!empty($model->country_preference)) {
                $model->country_preference = implode(',', $model->country_preference);
            }
			
            if(!empty($model->majors_preference)) {
                $model->majors_preference = implode(',', $model->majors_preference);
            }
			if(!empty($model->confirm_password)){
				
 
			}
			if(!empty($model->package_type)){
					$model->package_type = implode(',',$model->package_type);
			}
			//$model->qualification = 0;
			if(!empty($model->qualification)){
					$model->qualification = $model->qualification;
                    if(isset($model->others)){
                        $model->others = $model->others;
                    }else{
                        $model->others = '';
                    }
					
			}
			//$model->knowus = 0;
			if(!empty($model->knowus)){
					$model->knowus = $model->knowus;
                    if(isset($model->knowus_others)){
                        $model->knowus_others = $model->knowus_others;
                    }else{
                        $model->knowus_others = '';
                    }
					
			}
			
			$model->username = $model->email;
			$model->phonetype = $model->phonetype;
			$model->phone = $model->phone;
			$model->code = $model->code;
			$model->begin = $model->begin; 
			
			
			$model->source = $_SERVER['PHP_SELF'];
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->status = UserLogin::STATUS_INACTIVE;
            $model->role_id = Roles::ROLE_STUDENT;  
			if($_POST['UserLogin']['password']){
				$model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
			}
		
            if ($model->save()) {        

				$student = Student::find()->where(['AND',['=', 'email', $model->email],
				['=', 'student_id', $model->id]])->one();
				if(empty($student)){
					$student = new Student();		
				}
				$student->majors_preference = $model->majors_preference;
                $student->degree_preference = $model->degree_preference;			
				$student->first_name = $model->first_name;
				$student->last_name = $model->last_name;
				$student->email = $model->email;
				$student->phone = $model->phone;
                $student->code = $model->code;
				$student->country = $model->country;
				$student->student_id = $model->id; 
                $model->begin = $model->begin;         
				$student->created_at = gmdate('Y-m-d H:i:s');            
				$student->updated_at = gmdate('Y-m-d H:i:s');
				$student->save(false);
				
				
				
				$name = $model->first_name. ' '.  $model->last_name;

				$subject_1 = 'GoToUniversity New Signup';
				$template = 'student_signup_details'; 
				$mailsent = Commondata::sendStudentQuery($model,$subject_1,$template);
                if($this->sendActivationLink($model->id, $model->email, $name)) {
                    return $this->render('activate-account', ['status' => 'success', 'id' => $model->id]);
                }
            }
        }else{
            $model->agree = 0;
        }

        return $this->render('signup', [
            'model' => $model,
            'degree' => DegreeLevel::getAllDegreeLevels(),
            'countries' => ArrayHelper::map(Country::getAllCountries(), 'id', 'name'),
            'majors' => Degree::getAllDegrees()
        ]);
    }

    private function sendActivationLink($id, $email,$name) {
		 
		 
		$to = $email; 
		$subject = ' GoToUniversity Account Activation Link';
		$template = 'welcome_email';  
		$time = time();	
		$timestring = strtotime('+2 days', $time);
		$timestamp = Commondata::encrypt_decrypt('encrypt',$timestring);
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id);
	  
		$link = ConnectionSettings::BASE_URL . 'site/activate-account?id=' . $encryptedid . '&timestamp=' . $timestamp; 
		
		$data = array('name' => $name,'user' => $to, 'link' => $link);		
		$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		if($mailsent==true){ 
			Yii::$app->getSession()->setFlash('Success', 'Account Activation Link .'); 
		}else{
			Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
		}
		   
        return true;
    }

    public function actionResendActivationLink() {
        if (isset($_GET['id'])) {
            $user_id = $_GET['id'];
            $email = $_GET['email'];
            if ($this->sendActivationLink($user_id, $email)) {
                return $this->render('activate-account', ['status' => 'success', 'id' => $user_id, 'email' => $email]);
            }
        }
    }
	
	public function actionActivateDashboard() {        
        if (isset($_GET['id'])) {
            $user_id = $_GET['id']; 
			
			$userid = Commondata::encrypt_decrypt('decrypt', $user_id);
			$ptid = $_GET['ptid'];
            $model = UserLogin::findOne($user_id);
            if(empty($model)) {
                return $this->render('activate-dashboard', [
                    'status' => 'error',
                    'error' => 'User does not exist'
                ]);
            } 
            $timestamp = $_GET['timestamp'];
  
            $now = time();
            if($timestamp <= $now) {
                return $this->render('activate-dashboard', [
                    'status' => 'error',
                    'error' => 'Your email activation link has timed out',
                    'id' => $user_id,
                    'email' => $model->email
                ]);
            }else{ 
				if(Yii::$app->user->login($model, 3600 * 24 * 30)) {       
					return $this->redirect(['student/tnc', 'ptid' => $ptid]); 
				}  
			}   
        } 
        return $this->render('activate-dashboard');
    }

	
	  
    public function actionActivateAccount($id,$timestamp) { 
 
		$userid = Commondata::encrypt_decrypt('decrypt', $id);
		$decrypttimestamp = Commondata::encrypt_decrypt('decrypt',$timestamp);
		
		 
        if (isset($userid)) { 
            $user_id = $userid;
            $model = UserLogin::findOne($user_id);
			 
            if(empty($model)) {
                return $this->render('activate-account', [
                    'status' => 'error',
                    'error' => 'User does not exist'
                ]);
            } 
			
            //$now = gmmktime();
           $now = time(); 	
		    
            if($decrypttimestamp <= $now) {
                return $this->render('activate-account', [
                    'status' => 'error',
                    'error' => 'Your email activation link has timed out',
                    'id' => $user_id,
                    'email' => $model->email
                ]);
            }  
             $model->status = UserLogin::STATUS_ACTIVE;
			 
            if ($model->save(false)) { 
				//echo "i m in";
                if(Yii::$app->user->login($model, 3600 * 24 * 30)) {                    
                    $this->assignConsultant($model);	
 					 //return $this->redirect(['student/student-shortlisted-courses']);
					  return $this->redirect(['site/index']);

                }   
				
            }
        } 
        return $this->render('activate-account', []);
    }
	
	

    private function assignConsultant($model) {
		$consultantname = 'Not Assigned';
		//$agency = Agency::find()->where(['=', 'country_id', $model->country])->one();
        $agency = Agency::find()->where(['=', 'id', '2'])->one();// agency id is static to divert all the leads to gotouniversity
		if(!empty($agency) && count($agency) > 0) {
			$agency_id = $agency->partner_login_id;
			$consultantname = $agency->name;
            $leads_count = $agency->leads_count + 1;
            /*to increase leads count*/         
           Yii::$app->db->createCommand()
           ->update('agency', ['leads_count' => $leads_count], ['partner_login_id' => $agency_id])
           ->execute();
		
		$agencyRel = StudentConsultantRelation::find()->where(['=', 'student_id', $model->id])->one();
		
		if(!empty($agencyRel) && count($agencyRel) > 0) {  
			$relation = $agencyRel;	
		}else{
			$relation = new StudentConsultantRelation();  
		}
                                  
            $relation->student_id = Yii::$app->user->identity->id;            
            $relation->agency_id = $agency_id;            
            $relation->created_by = Yii::$app->user->identity->id;            
            $relation->updated_by = Yii::$app->user->identity->id;            
            $relation->created_at = gmdate('Y-m-d H:i:s');            
            $relation->updated_at = gmdate('Y-m-d H:i:s'); 
            if($relation->save(false)){
 
				$name =  $model->first_name.' '.$model->last_name;   
				$to = $model->email; 
				$user = $name;
				$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=site/login';				
				$subject = $name.' Agency Assigned to you.';
				$template = 'consultant_assignedto_student';  
				
				$data = array('name' => $name, 'agency' => $agency->name);		
				//$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);

				/*if($mailsent==true){  
					Yii::$app->getSession()->setFlash('Success', 'Agency Assigned to you.'); 
					  
				}else{
					 Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
				} */
				return $relation;
			}
		}
		 
        return false;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
		
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
		 
            if ($model->sendEmail()) {
                //Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect(['tockensent', 'message' => 'Check your email for further instructions.']);

            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'message' => 'hello',
        ]);
    }

    function actionTockensent($message){
    	return $this->render('passwordResetTokensent', [
		            'message' => $message,
		        ]);
    }
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            //Yii::$app->session->setFlash('success', 'New password was saved.');
        	return $this->redirect(['tockensent', 'message' => 'New password saved successfully!']);
            //return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionSubscribe() {
        $model = new NewsletterSubscription();
        $model->email = $_POST['email'];
        $model->source = $_POST['source'];
        $model->created_at = gmdate('Y-m-d H:i:s');

        $result = $model->save();
        if (isset($result) && $result == true) {
            return json_encode(['status' => 'success']);
        }
        if(isset($model->errors) && $model->errors['email']) {
            return json_encode(['status' => 'error', 'error' => $model->errors['email']]);
        } else {
            return json_encode(['status' => 'error', 'error' => $model->errors]);
        }        
    }

    public function actionContactQuery() {
		 
		
			$model = new ContactQuery();
			$model->name = $_POST['first_name']; 
			$model->email = $_POST['email'];
            $model->code = $_POST['code'];
			$model->phone = $_POST['phone'];
			$model->message = $_POST['message'];
			$model->source = $_POST['source'];
			$model->created_at = gmdate('Y-m-d H:i:s'); 
			
		if($model->save()) {
			$to = $_POST['email'];
			$user = $_POST['first_name']; 			
			$subject = 'Leave Message To GoToUniversity';
			$template = 'leaveus_message';   
			$data = array('user' => $user);	
			
			$mailsent = Commondata::sendContactQuery($to,$subject,$data,$template);
			
            $enquiry_from = $to;
            $subject = 'General Enquiry Received';
            $first_name = $user;
            $template = 'leaveus_message_details';
            $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->phone ,'message' => $model->message);
            $maildetails = Commondata::sendContactQueryDetails($enquiry_from,$subject,$data,$template);

			if($mailsent==true AND $maildetails==true){  
				return json_encode(['status' => 'success','message' => 'Your query has been submitted successfully.']);
			}else{
				return json_encode(['status' => 'error', 
									'message' => 'Mail Not sent.']);
			}
        }
		
		
		 
    }

	public function actionCountydata($code) {  
 
		$code= strtoupper($code);
		$model = Country::find()->where(['=', 'iso_code', $code])->one();

		if ($model) { 
			$name = $model->name;
			$unicount = University::find()
							->select('id')
							->where(['=', 'country_id', $model->id])->count();
			//	$unicount =  count($universities); 
			$coursecount =  UniversityCourseList::find()
						->select('university_course_list.id')
						->leftJoin('university', '`university`.`id` = `university_course_list`.`university_id`')
						->where(['=', 'university.country_id', $model->id])->count();
			//echo $courses->createCommand()->getRawSql();	
			//$coursecount =  count($courses); 
           // return json_encode(['status' => 'success','name' => $name, 'universities' => $unicount, 'courses' => $coursecount]);
			return json_encode(['status' => 'success','name' => $name, 'universities' => $unicount, 'courses' => $coursecount]);
        } else {
            return json_encode(['status' => 'error', 'error' => $model->errors]);
        } 
	}
	
    public function actionCouncellorTimes($consultant,$date) {
        $consultant = $_GET['consultant'];
        $date = $_GET['date'];
        $consultant = Consultant::find()->where(['=', 'consultant_id', $consultant])->one();
        if(empty($consultant)) {
            return 'failure';
        } else {
            $start = date_create($date);
            $temp = explode(':', $consultant->work_hours_start);
            date_time_set($start, $temp[0], $temp[1], $temp[2]);
            $start = date_format($start, 'Y-m-d H:i:s');
            $end = date_create($date);
            $temp = explode(':', $consultant->work_hours_end);
            date_time_set($end, $temp[0], $temp[1], $temp[2]);
            $end = date_format($end,'Y-m-d H:i:s');

            /*$query = "SELECT * FROM student_calendar WHERE ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end < '$end') OR (start < '$start' AND end > '$end') OR (start < '$start' AND end > '$start' AND end < '$end')) AND (event_type=$event_availablity OR event_type=$event_appointment)";*/

            
            $calendar = ConsultantCalendar::find()
                        ->where(['=', 'consultant_id', $consultant->id])
                        ->andWhere(['in', 'event_type', [CalendarEvents::EVENT_UNAVAILABILITY, CalendarEvents::EVENT_MEETING]])
                        ->andWhere(['AND', ['>', 'start', $start], ['>', 'end', $end]])
                        ->orWhere(['AND', ['>', 'start', $start],['<', 'end', $end]])
                        ->orWhere(['AND', ['<', 'start', $start],['>', 'end',  $end]])
                        ->orWhere(['AND', ['<', 'start', $start], ['>', 'end', $start], ['<', 'end', $end]])
                        ->all();
            $invalidTimes = [];
            foreach($calendar as $event) {
                array_push($invalidTimes, ['start' => $event->start, 'end' => $event->end]);
            }
            return json_encode(['start' => $consultant->work_hours_start, 'end' => $consultant->work_hours_end , 'status' => 'success', 'invalidTimes' => $invalidTimes]);
        }
        
        return json_encode(['consultant' => $consultant]);
    }

    public function actionRegisterForFreeCounsellingSession() {
        $consultants = Consultant::find()->orderBy(['first_name' => 'ASC'],['last_name' => 'ASC'])->all();
        $model = FreeCounsellingSessions::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
        if(Yii::$app->request->post()) {
            if(empty($model)) {
                $model = new FreeCounsellingSessions();
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->created_by = Yii::$app->user->identity->id;
            }

            if(isset($_POST['skype-id'])) {
                $model->skype_id = $_POST['skype-id'];
            }
            $model->student_id = Yii::$app->user->identity->id;
            $model->consultant_id = $_POST['consultant-id'];
            $model->status = 0;
            $model->start_time = $_POST['start'];
            $model->end_time = $_POST['end'];
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            if($model->save()) {
                return json_encode(['status' => 'success']);
            } else {
                return json_encode(['status' => 'failure', 'error' => $model->errors]);
            }
        }
        return $this->render('free-counselling-session',[
            'consultants' => $consultants,
            'model' => $model
        ]);
    }

    public function actionAccesstoken() {
        if(isset($_POST['access-token'])&&$_POST['access-token']=='univ@admin'){
              $session = Yii::$app->session;
              $session->set('passcode', 'univ@admin');
              return $this->redirect(['index']);
        }
        return $this->render('accesstoken');
    }


    public function actionValidateLogin() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = new UserLoginForm(Yii::$app->getRequest()->getBodyParams()['UserLoginForm']);

            if (!$model->validate()) {
                return ActiveForm::validate($model);
            }

            return [];
        }
    }

    public function actionPrivacyPolicy() {
        $policy = TermsPolicy::find()->one();
        return $this->render('privacy_policy',['policy' => $policy->policy]);
    }
	
	public function actionMessage()
    {
		 return $this->render('message');
	}
	
	public function actionTerm()
    {
        $terms = TermsPolicy::find()->one();
		return $this->render('term',['terms' => $terms->terms]);
	}
    public function actionTermandpolicy()
    {
        $terms = TermsPolicy::find()->one();
        return $this->renderAjax('termandpolicy',['terms' => $terms->terms , 'policy' => $terms->policy]);
    }
    public function actionArticleviewed() {
        if($_POST['article_id']){
            $article = Articles::find()->where(['id'=>trim($_POST['article_id'])])->one();
            $count = $article->view_count;
            $addView = $count+1;
            $article->view_count = $addView;                
            $article->save(false);
            return true;            
        }       
     }
	public function actionChatnotification() {
        $student_chats = array();
        $notify_user = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->andWhere('student_notification = 0')
        ->distinct()
        ->all();
        //$notify_user =  count($notify_user);
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_CONSULTANT){
            $chat_name = Consultant::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['partner_login_id']);
            array_push($student_chats, [$notify['partner_login_id'],$name,$ids]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_history', ['student_notification' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();

        $student_calls = array();
        $notify_user = ChatvideoNotificarion::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('call_student = 0')
        ->distinct()
        ->all();
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_CONSULTANT){
            $chat_name = Consultant::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['partner_login_id']);
            array_push($student_calls, [$notify['partner_login_id'],$name,$ids]);
            //array_push($student_calls, [$notify['partner_login_id'],$name]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_call_notification', ['call_student' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();

        return json_encode(['student_calls' => $student_calls ,'student_chats' => $student_chats]);

        /*call notification*/  
        
        }
    /*public function actionUniversityInfo() {        
        if (isset($_GET['id'])) {
            $user_id = $_GET['id']; 
            $ptid = $_GET['ptid'];
            $model = UserLogin::findOne($user_id);
            if(empty($model)) {
                return $this->render('activate-dashboard', [
                    'status' => 'error',
                    'error' => 'User does not exist'
                ]);
            } 
            $timestamp = $_GET['timestamp'];
  
            $now = time();
            if($timestamp <= $now) {
                return $this->render('activate-dashboard', [
                    'status' => 'error',
                    'error' => 'Your email activation link has timed out',
                    'id' => $user_id,
                    'email' => $model->email
                ]);
            }else{ 
                if(Yii::$app->user->login($model, 3600 * 24 * 30)) {       
                    return $this->redirect(['student/tnc', 'ptid' => $ptid]); 
                }  
            }   
        } 
        return $this->render('activate-dashboard');
    }*/
}