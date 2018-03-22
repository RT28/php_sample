<?php
namespace partner\modules\consultant\controllers;

use Yii;
use partner\models\PartnerLogin;
use partner\models\PartnerSignup;
use partner\models\PartnerLoginForm;
use common\models\Consultant;
use common\models\ConsultantEnquiry;
use common\models\Country;
use common\models\Degree;
use yii\helpers\ArrayHelper;
use common\components\Status;
use common\components\Roles;
use common\models\FileUpload;
use yii\web\UploadedFile;
use common\models\Others;
use yii\helpers\Json;
use common\models\ConsultantCalendar;
use frontend\models\StudentCalendar;
use common\models\CalendarSessionTokenRelation;
use common\components\CalendarEvents;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use common\components\ConnectionSettings; 
use common\components\Commondata; 
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\SiteConfig; 
use yii\helpers\FileHelper; 
use common\models\ChatHistory;
use common\models\ChatvideoNotificarion;
use common\models\User;
use frontend\models\StudentNotifications;

class ConsultantController extends \yii\web\Controller
{

   
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
							'actions' => ['index', 'view', 'update', 'get-event-types',
							'get-consultant-calendar', 'add-event', 'update-event',
							 'saveprofileajax','removeprofileajax','delete-event','chatnotification','getchatcount','get-invities','get-eventdetails','get-consultant-allmeetings','change-eventstatus'],
							'allow' => true, 
							'roles' => [Roles::ROLE_CONSULTANT]
					],
					[  
						'actions' => ['create', 'login'],
						'allow' => true, 
						'roles' => ['?'],
					],
					[
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_CONSULTANT]
                    ]
							
                    ],
                   
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    } 
	 
    public function actionIndex() {
		 Yii::$app->view->params['activeTab'] = 'dashboard';
        $model = Yii::$app->user->identity->consultant;
        return $this->render('index', [
            'model' => $model
        ]);
    }

	public function actionLogin($id,$timestamp)
    {
		$partnerLogin = new PartnerLogin();
		$PartnerSignup = new PartnerSignup(); 
		
		$timestamp = Commondata::encrypt_decrypt('decrypt',$timestamp);
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		
		$consultant = Consultant::find()->where(['=', 'id', $id])->one();
		$name =  $consultant->first_name. " " .$consultant->last_name; 
		$exists = PartnerLogin::find()
				  ->where(['=', 'partner_id', $consultant->id])
				  ->andWhere(['=', 'role_id', Roles::ROLE_CONSULTANT])
				  ->one();
	  
		if($exists) { 
			$partnerLogin = $exists; 
			if($exists->status==PartnerLogin::STATUS_ACTIVE) {
				Yii::$app->getSession()->setFlash('Error', 'You are already activated. Please login with your credentials or contact to Administrator.');	
				return $this->redirect('?r=site/login');  
			}	 
		} 
			
	    if($PartnerSignup->load(Yii::$app->request->post()) &&  $PartnerSignup->validate()) { 
		  
			$password = $PartnerSignup->password;
			$partnerLogin->username = $PartnerSignup->username;
			$partnerLogin->email = $consultant->email; 
			$partnerLogin->setPassword($password);
			$partnerLogin->status = PartnerLogin::STATUS_ACTIVE;
			$partnerLogin->role_id = Roles::ROLE_CONSULTANT;
			$partnerLogin->partner_id =  $consultant->id;
			$partnerLogin->generatePasswordResetToken();
			$partnerLogin->generateAuthKey(); 
			$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
			$partnerLogin->updated_at = gmdate('Y-m-d H:i:s');
			
			 
			if($partnerLogin->save(false)) { 
 
				$to = $consultant->email;;
				$user = $name;
				$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=site/login';				
				$subject = $name.' created credentials successfully.';
				$template = 'welcome_email_consultant';  
				
				$data = array('name' => $user, 'link' => $link,'username' => $partnerLogin->username, 'password' => $password);		
				$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);

				if($mailsent==true){  
					Yii::$app->getSession()->setFlash('Success', 'Your login credentials has been created successfully. Please login here.'); 
					return $this->redirect('?r=site/login');
				
				}else{
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
				}
			  
			}else {
				Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact to Administrator.'); 
			}  
			 
		}
		
		return $this->render('login', [ 
			'partnerSignup' => $PartnerSignup,   
        ]);
	}
	
    public function actionCreate()
    {
		$helpemail = SiteConfig::getConfigHelpEmail();
		
        $model = new ConsultantEnquiry(); 
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
        $message = '';
        if(Yii::$app->request->post()) { 
			$model->load(Yii::$app->request->post());
            $exists = ConsultantEnquiry::find()->where(['=', 'email', $model->email])->all();
            
			$count = count($exists); 
            if($count>=3) {  
			
				Yii::$app->getSession()->setFlash('Error', 'We have already received your queries and our team is working on it and we will revert back to you shortly.');  
			
			}else{ 
					$model->status = Status::STATUS_NEW; 
                    $model->created_at = gmdate('Y-m-d H:i:s');
                    $model->updated_at = gmdate('Y-m-d H:i:s');
				 
                    if($model->save(false)) {
						
					$to = $model->email;
					$user = $model->title.''.$model->first_name.' '.$model->last_name; 			
					$subject = $user.', Thanks for your query.';
					$template = 'consultant_enquiry';  

					$data = array('name' => $user);		
					//$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
                    $mailsent = Commondata::sendConsultantQuery($to,$subject,$data,$template);
					/*mail details to gtu*/
                    $enquiry_from = $to;
                    $subject = 'Consultant Enquiry Received';
                    $first_name = $user;
                    $template = 'consultant_enquiry_details';
                    $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->mobile ,'message' => $model->description,'country' => $model->country_id);
                    //$data = array('user' => $user , 'model' => $model);
                    $maildetails = Commondata::sendConsultantQueryDetails($enquiry_from,$subject,$data,$template);

                    if($mailsent==true AND $maildetails==true){
					
						Yii::$app->getSession()->setFlash('Success', 'Consultant Enquiry successfull. Our administrator will verify you and get back to you shortly.'); 
						
                    } else {
                        Yii::$app->getSession()->setFlash('Error', 'Error in processing your request. Please send email to '.$helpemail);
                    } 
				}
            }  
			return $this->redirect(['/site/message']);
        }
        return $this->render('create', [
            'model' => $model, 
            'countries' => $countries,
			'degrees' => Degree::getAllDegrees(), 
        ]);
    }
 

    public function actionUpdate()
    {
		Yii::$app->view->params['activeTab'] = 'profile';
		
        $model = Yii::$app->user->identity->consultant;
        $upload = new FileUpload();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
       
	   $message = '';
        if($model->load(Yii::$app->request->post())) {
			if($model->speciality){
						$model->speciality = implode(',',$model->speciality); 
			}
			if(!empty($model->work_days)){
				$model->work_days = implode(',',$model->work_days);
			}
			if($model->languages){
				$model->languages = implode(',',$model->languages); 
			}
			
			
            if ($model->save()) {
                if($this->saveProfilePicture($upload, Yii::$app->user->identity)) {
                    return $this->redirect(['consultant/index']);
                }
                $message = 'Error updating profile picture.';
            }
            $message = 'Error updating profile.';
        }
        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'upload' => $upload,			
			'degrees' => Degree::getAllDegrees(),
			'languages' => $this->getOthers('languages'),
            'message' => $message
        ]);
    }

    private function saveProfilePicture($image, $consultant) {
        $newFile = UploadedFile::getInstance($image, 'consultantImage');
        if (isset($newFile)) {
            $image->consultantImage = UploadedFile::getInstance($image, 'consultantImage');
            if ($image->uploadConsultantImage($consultant)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

	public function actionSaveprofileajax() {
        $consultant = Yii::$app->request->post('consultant_id');
        $result = is_dir("./../web/uploads/consultant/$consultant/profile_photo");
        if (!$result) {
            $result = FileHelper::createDirectory("./../web/uploads/consultant/$consultant/profile_photo");
        }
        $sourcePath = $_FILES['profile_photo']['tmp_name'];
        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/consultant/$consultant/profile_photo/" . date_timestamp_get(date_create()) . '.' . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            $path = Yii::getAlias('@partner'); 
            $path = $path."/web/uploads/consultant/$consultant/profile_photo/"; 
            //$file = explode('.',$sourcePath);
            $filname = date_timestamp_get(date_create()).'.'.$ext; 
                $this->ak_img_resize($path, $filname,'consultant_image');
 
                /*deleting other logo images*/
                $dir = $path; 
                if($ext=='jpg'){
                $leave_files = array('consultant_image_228X228.jpg');
                } else if($ext=='png'){
                $leave_files = array('consultant_image_228X228.png');
                } else if($ext=='jpeg'){
                $leave_files = array('consultant_image_228X228.jpeg');
                } else if($ext=='gif'){
                $leave_files = array('consultant_image_228X228.gif');
                } else if($ext=='JPG'){
                $leave_files = array('consultant_image_228X228.JPG');
                } else if($ext=='PNG'){
                $leave_files = array('consultant_image_228X228.PNG');
                } else if($ext=='JPEG'){
                $leave_files = array('consultant_image_228X228.JPEG');
                } else if($ext=='GIF'){
                $leave_files = array('consultant_image_228X228.GIF');
                }

                foreach( glob("$dir/*") as $file ) {
                    if( !in_array(basename($file), $leave_files) )
                        unlink($file);
                }
                /*end deleting other logo images*/
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request']);
        }
    }  
	
	public function actionRemoveprofileajax() {
        $consultant = Yii::$app->user->identity->consultant->consultant_id; 
        $result = is_dir("./../web/uploads/consultant/$consultant/profile_photo");
        if ($result) {
            array_map('unlink', glob("./../web/uploads/consultant/$consultant/profile_photo/*"));
            echo json_encode(['error' => 'Processing request']);
            }
    }

	private function ak_img_resize($path, $filname, $img_type){
                $fileExt = explode(".", $filname);
                $ext = end($fileExt);
                $data = getimagesize($path.$filname);
                $width_1  = $data[0];
                $height_1 = $data[1];
                $target = $path.$filname;
                $w=array(); $h=array();
                if($img_type=='cover_photo'){ $w=['1500']; $h=['500']; }
                else if($img_type=='logo'){ $w=['170']; $h=['115']; }
                else if($img_type=='univ_gallery'){ $w=['1500']; $h=['1000'];}
                else if($img_type=='consultant_image'){ $w=['228']; $h=['228'];}
                
                list($w_orig, $h_orig) = getimagesize($target);
                $length = count($w);
                for ($i = 0; $i < $length; $i++) {
                    if($length==1){ $newcopy = $path.$img_type.'_'.$w[$i].'X'.$h[$i].'.'.$ext; }
                    else { $newcopy = $path.$w[$i].'X'.$h[$i].'.'.$ext; }

                    if($width_1>$w[$i] OR $height_1>$h[$i]){
                            $w[$i] = $w[$i]; $h[$i] = $h[$i];
                        } else{
                            $w[$i] = $width_1; $h[$i] = $height_1;
                        }
                        $scale_ratio = $w_orig / $h_orig; 
                        if (($w[$i] / $h[$i]) > $scale_ratio) {
                               $w[$i] = $h[$i] * $scale_ratio;
                        } else {
                               $h[$i] = $w[$i] / $scale_ratio;
                        }
                        $img = "";
                        $ext = strtolower($ext);
                        if ($ext == "gif"){ 
                          $img = imagecreatefromgif($target);
                        } else if($ext =="png"){ 
                          $img = imagecreatefrompng($target);
                        } else { 
                          $img = imagecreatefromjpeg($target);
                        }
                        $tci = imagecreatetruecolor($w[$i], $h[$i]);
                        imagealphablending($tci, false);
                        imagesavealpha($tci, true);
                        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w[$i], $h[$i], $w_orig, $h_orig);
                        if ($ext == "png"){ 
                        imagepng($tci, $newcopy, 5);
                        }
                        else{ 
                        imagejpeg($tci, $newcopy, 80);
                        }
            }
    }

	
    public function actionGetEventTypes() {
        $name = 'event_type';
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return Json::encode(['status' => 'success', 'response' => $model]);
        }
        return Json::encode(['status' => 'error', 'response' => 'Error fetching others']);
    }

    public function actionGetConsultantCalendar() {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $id = Yii::$app->user->identity->id;
        $role_consultant = Roles::ROLE_CONSULTANT;

        $events = ConsultantCalendar::find()->where(['and', "start >= '$start'", "end <= '$end'", "consultant_id=$id", "status!=2"])->all();

        return Json::encode(['status' => 'success' ,'response' => $events]);
    }
    public function actionGetConsultantAllmeetings(){
        $id = Yii::$app->user->identity->id;
        $role_consultant = Roles::ROLE_CONSULTANT;
        //$events = ConsultantCalendar::find()->where(['and', "consultant_id >= $id","role_id=$role_consultant"])->orderBy(['id' => SORT_DESC])->all();
        $events = ConsultantCalendar::find()->where(['=', 'consultant_id', Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
        
        return $this->renderAjax('all_meetings', [
            'events' => $events
        ]);
       
    }    
    public function actionGetInvities(){
        $events = ConsultantCalendar::find()->where(['=', 'id', $_POST['id']])->one();
        return $this->renderAjax('invities_list', [
            'events' => $events
        ]);
       
    }
    public function actionGetEventdetails(){
        $events = ConsultantCalendar::find()->where(['=', 'id', $_POST['id']])->one();
        return $this->renderAjax('event_details', [
            'events' => $events
        ]);
       
    }
    public function actionChangeEventstatus(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        Yii::$app->db->createCommand()
           ->update('consultant_calendar', ['status' => $status], ['consultant_id' => Yii::$app->user->identity->id, 'id' => $id])
           ->execute();
        $e_count = ConsultantCalendar::find()
        ->where('consultant_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
        ->andWhere('created_by_role != '.Roles::ROLE_CONSULTANT)
        ->andWhere('status = 0')
        ->all();
        $e_count =  count($e_count);   
        return Json::encode(['status' => 'success' , 'e_count' => $e_count]);   
       
    }
    public function actionAddEvent() {
        $event = new ConsultantCalendar();
        $val = $_POST['event'];
        $appointment = null;
        $role = null;
        $invitees_list = array();
        if(isset($_POST['ids_students']) AND $_POST['ids_students']!='') {
            $student_ids = implode(', ', $_POST['ids_students']);
            foreach ($_POST['ids_students'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_STUDENT]);
            }
        } else { $student_ids = '0'; }
      
        $event->consultant_id = Yii::$app->user->identity->id;
        $event->title = $val['title'];
        $event->role_id = Roles::ROLE_CONSULTANT;
        $event->student_appointment_id = $appointment;
        $event->start = $val['start'];
        $event->end = $val['end'];
        $event->event_type = 1;
		$event->meetingtype = 1;
		$event->mode = $val['mode'];
        $event->alert = $val['alert'];
        $event->consultant_ids = 0;
        $event->trainer_ids = 0;
        $event->employee_ids = 0;
        $event->student_ids = $student_ids;
        $event->created_by_role = Roles::ROLE_CONSULTANT;
        $event->created_by = Yii::$app->user->identity->id;
        $event->updated_by = Yii::$app->user->identity->id;
        $event->updated_at = gmdate('Y-m-d H:i:s');
        $event->created_at = gmdate('Y-m-d H:i:s');
        $event->time_stamp = gmdate('U');
    
        if(isset($val['remarks'])) {
            $event->remarks = $val['remarks'];
        }
        if(isset($val['location'])) {
            $event->location = $val['location'];
        }

        if($event->save(false)) {
            foreach ($invitees_list as $key => $value) {
                   
                    $student_event = new StudentCalendar();
                    $student_event->student_id = $value[0];
                    $student_event->role_id = $value[1];
                    $student_event->consultant_appointment_id = $event->id;
                    $student_event->event_type = $event->event_type;
                    $student_event->appointment_status = $event->appointment_status;
                    $student_event->meetingtype =  $event->meetingtype; 
                    $student_event->mode = $event->mode;
                    $student_event->title = $event->title;
                    $student_event->location = $event->location;
                    $student_event->remarks = $event->remarks;
                    $student_event->start = $event->start;
                    $student_event->end = $event->end;
                    $student_event->time_stamp = $event->time_stamp;
                    $student_event->consultant_ids = 0;
                    $student_event->trainer_ids = 0;
                    $student_event->employee_ids = 0;
                    $student_event->student_ids = $event->student_ids;
                    $student_event->created_by_role = Roles::ROLE_CONSULTANT;
                    $student_event->created_by = $event->created_by;
                    $student_event->created_at = $event->created_at;
                    $student_event->updated_by = $event->updated_by;
                    $student_event->updated_at = $event->updated_at;  
                    $student_event->save(false);


                    /*notification for student*/
                    $message = 'New event added to your calendar';
                    $notification = new StudentNotifications(); 
                    $notification->student_id = $value[0];
                    $notification->from_id = Yii::$app->user->identity->id;
                    $notification->from_role = Roles::ROLE_CONSULTANT;
                    $notification->message = $message;
                    $notification->timestamp =  gmdate('Y-m-d H:i:s');
                    $notification->created_by = Yii::$app->user->identity->username;
                    $notification->updated_by = Yii::$app->user->identity->username;
                    $notification->created_at = gmdate('Y-m-d H:i:s');
                    $notification->updated_at = gmdate('Y-m-d H:i:s');
                    $notification->save(false); 

                    }
                    if($student_event->save(false)) {
                        $event->student_appointment_id = $student_event->id;
                        if($event->save()) {
                            return Json::encode(['status' => 'success' ,'response' => $event]);
                        } else {
                            return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving consultant appointment in student calendar.']);
                        }
                    } else {
                        return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving consultant appointment in consultant calendar.']);
                    }
               
        }
        return Json::encode(['status' => 'failure' ,'response' => $event,'message' => 'Error while saving student appointment.']);

        /*if($event->save(false)) {
            if(isset($role)) {
                if($role == Roles::ROLE_STUDENT) {
                    $student_event = new StudentCalendar();
                    $student_event->student_id = $appointment;
                    $student_event->consultant_appointment_id = $event->id;
                    $student_event->event_type = $event->event_type;
                    $student_event->appointment_status = $event->appointment_status;
					$student_event->meetingtype =  $event->meetingtype; 
					$student_event->mode = $event->mode;
                    $student_event->title = $event->title;
                    $student_event->location = $event->location;
                    $student_event->remarks = $event->remarks;
                    $student_event->start = $event->start;
                    $student_event->end = $event->end;
                    $student_event->time_stamp = $event->time_stamp;
                    $student_event->created_by = $event->created_by;
                    $student_event->created_at = $event->created_at;
                    $student_event->updated_by = $event->updated_by;
                    $student_event->updated_at = $event->updated_at; 
                    if($student_event->save()) {
                        $event->student_appointment_id = $student_event->id;
                        if($event->save()) {
                            return Json::encode(['status' => 'success' ,'response' => $event]);
                        } else {
                            return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving student appointment in student calendar.']);
                        }
                    } else {
                        return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving student appointment in consultant calendar.']);
                    }
                }
            } else {
                return Json::encode(['status' => 'success' ,'response' => $event]);
            }
        }
        return Json::encode(['status' => 'failure' ,'response' => $event,'message' => 'Error while saving student appointment.']);*/
    }

    public function actionUpdateEvent() {
        $val = $_POST['event'];
        $id = $val['id'];

        $event = ConsultantCalendar::findOne($id);
        $event_availablity = 1;
        $event_appointment = 2;
        $appointment = null;
        $role = null;
        $invitees_list = array();
        
        $student_event =  StudentCalendar::find()->where('consultant_appointment_id  ='.$id)->all();
            foreach($student_event as $s_event)
            {
                $s_event->delete();
            }
        if(isset($_POST['ids_students']) AND $_POST['ids_students']!='') {
            $student_ids = implode(', ', $_POST['ids_students']);
            foreach ($_POST['ids_students'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_STUDENT]);
            }
        } else { $student_ids = '0'; }

        $event->consultant_id = Yii::$app->user->identity->id;
        $event->title = $val['title'];
        $event->role_id = Roles::ROLE_CONSULTANT;
        $event->student_appointment_id = $appointment;
        $event->start = $val['start'];
        $event->end = $val['end'];
        $event->event_type = 1;
        $event->meetingtype = 1;
        $event->mode = $val['mode'];
        $event->alert = $val['alert'];
        $event->consultant_ids = 0;
        $event->trainer_ids = 0;
        $event->employee_ids = 0;
        $event->student_ids = $student_ids;
        $event->created_by_role = Roles::ROLE_CONSULTANT;
        $event->created_by = Yii::$app->user->identity->id;
        $event->updated_by = Yii::$app->user->identity->id;
        $event->updated_at = gmdate('Y-m-d H:i:s');
        $event->created_at = gmdate('Y-m-d H:i:s');
        $event->time_stamp = gmdate('U');
        
        if(isset($val['remarks'])) {
            $event->remarks = $val['remarks'];
        }
        if(isset($val['location'])) {
            $event->location = $val['location'];
        }


        if($event->save(false)) {
            foreach ($invitees_list as $key => $value) {
                   
                    $student_event = new StudentCalendar();
                    $student_event->student_id = $value[0];
                    $student_event->role_id = $value[1];
                    $student_event->consultant_appointment_id = $event->id;
                    $student_event->event_type = $event->event_type;
                    $student_event->appointment_status = $event->appointment_status;
                    $student_event->meetingtype =  $event->meetingtype; 
                    $student_event->mode = $event->mode;
                    $student_event->title = $event->title;
                    $student_event->location = $event->location;
                    $student_event->remarks = $event->remarks;
                    $student_event->start = $event->start;
                    $student_event->end = $event->end;
                    $student_event->time_stamp = $event->time_stamp;
                    $student_event->consultant_ids = 0;
                    $student_event->trainer_ids = 0;
                    $student_event->employee_ids = 0;
                    $student_event->student_ids = $event->student_ids;
                    $student_event->created_by_role = Roles::ROLE_CONSULTANT;
                    $student_event->created_by = $event->created_by;
                    $student_event->created_at = $event->created_at;
                    $student_event->updated_by = $event->updated_by;
                    $student_event->updated_at = $event->updated_at;  
                    $student_event->save(false);


                    /*notification for student*/
                    $message = 'New event added to your calendar';
                    $notification = new StudentNotifications(); 
                    $notification->student_id = $value[0];
                    $notification->from_id = Yii::$app->user->identity->id;
                    $notification->from_role = Roles::ROLE_CONSULTANT;
                    $notification->message = $message;
                    $notification->timestamp =  gmdate('Y-m-d H:i:s');
                    $notification->created_by = Yii::$app->user->identity->username;
                    $notification->updated_by = Yii::$app->user->identity->username;
                    $notification->created_at = gmdate('Y-m-d H:i:s');
                    $notification->updated_at = gmdate('Y-m-d H:i:s');
                    $notification->save(false); 

                    }
                    if($student_event->save(false)) {
                        $event->student_appointment_id = $student_event->id;
                        if($event->save()) {
                            return Json::encode(['status' => 'success' ,'response' => $event]);
                        } else {
                            return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving consultant appointment in student calendar.']);
                        }
                    } else {
                        return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving consultant appointment in consultant calendar.']);
                    }
               
        }
        return Json::encode(['status' => 'failure' ,'response' => $event,'message' => 'Error while saving student appointment.']);
    }

    public function actionDeleteEvent() {
        $transaction = \Yii::$app->db->beginTransaction();
        $id = $_POST['id'];
        $event = ConsultantCalendar::findOne($id);
        if($event->delete()) {
            $transaction->commit();
            $student_event =  StudentCalendar::find()->where('consultant_appointment_id  ='.$id)->all();
            foreach($student_event as $s_event)
            {
                $s_event->delete();
            }
            return Json::encode(['status' => 'success' ,'response' => '']);    
            }
        
    }

    private function getOthers($name) {
        $model = [];
		$stringarray = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
			$i = 0;
			foreach($model as $key=>$value){
				$stringarray[$i]['id'] = $value; 
				$stringarray[$i]['name'] = $value; 
				$i++;
			}			
			
			$languages = ArrayHelper::map($stringarray , 'id', 'name');
			
            return $languages;
        }
    }

    private function validateEventBeforeAdd($start, $end, $event_type, $appointment, $role) {
        $event_availablity = CalendarEvents::EVENT_UNAVAILABILITY;
        $event_appointment = CalendarEvents::EVENT_MEETING;
        if($event_type != $event_appointment && $event_type != $event_availablity) {
            return true;
        }
        /**
            * condition 1: new event starts after the event and ends after event.
            * condition 2: new event starts before event and ends before event ends. *
            * condition 3: new event starts before event and ends after event.
            * condition 4: new event starts before start and ends in between. *
        */
        $consultant_id = Yii::$app->user->identity->id;
        $query = "SELECT * FROM consultant_calendar WHERE consultant_id=$consultant_id AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
        $models = ConsultantCalendar::findBySql($query);
        
        if(!$models->exists()) {
            if($event_type == $event_appointment) {
                if ($role == Roles::ROLE_STUDENT) {
                    $query = "SELECT * FROM student_calendar WHERE student_id=$appointment AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
                    $models = StudentCalendar::findBySql($query);

                    if(!$models->exists()) {
                        return true;
                    } else {
                        foreach($models->each() as $model) {
                            if ($model->event_type == $event_availablity) {
                                return ['status' => 'error', 'message' => ['You\'r student is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                            if ($model->event_type == $event_appointment) {
                                return ['status' => 'error', 'message' => ['You\'r student is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                        }
                    }
                }
            }
            return true;
        }
        else {
            foreach($models->each() as $model) {
                if ($model->event_type == $event_availablity) {
                    return ['status' => 'error', 'message' => ['You\'ve marked yourself unavailable for from ' . $model->start . ' to ' . $model->end . '.']];
                }
                if ($model->event_type == $event_appointment) {
                    return ['status' => 'error', 'message' => ['You have a appointment scheduled between ' . $model->start . ' to ' . $model->end . '.']];
                }
            }
        }
    }

    private function validateEventBeforeUpdate($start, $end, $event_type, $appointment, $role, $current_event) {
        $event_availablity = CalendarEvents::EVENT_UNAVAILABILITY;
        $event_appointment = CalendarEvents::EVENT_MEETING;
        
        $consultant_id = Yii::$app->user->identity->id;
        $query = "SELECT * FROM consultant_calendar WHERE id <> $current_event->consultant_id AND consultant_id=$consultant_id AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";

        $models = ConsultantCalendar::findBySql($query);

        if(!$models->exists()) {
            if($event_type == $event_appointment) {
                if ($role == Roles::ROLE_STUDENT) {
                    $query = "SELECT * FROM student_calendar WHERE id <> $current_event->student_appointment_id AND student_id=$appointment AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
                    $models = StudentCalendar::findBySql($query);

                    if(!$models->exists()) {
                        return true;
                    } else {
                        foreach($models->each() as $model) {
                            if ($model->event_type == $event_availablity) {
                                return ['status' => 'error', 'message' => ['You\'r student is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                            if ($model->event_type == $event_appointment) {
                                return ['status' => 'error', 'message' => ['You\'r student is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                        }
                    }
                }
            }
            return true;
        }
        else {            
            foreach($models->each() as $model) {
                if ($model->event_type == $event_availablity) {
                    return ['status' => 'error', 'message' => ['You\'ve marked yourself unavailable for from ' . $model->start . ' to ' . $model->end . '.']];
                }
                if ($model->event_type == $event_appointment) {
                    return ['status' => 'error', 'message' => ['You have a appointment scheduled between ' . $model->start . ' to ' . $model->end . '.']];
                }
            }
        }
    }
    public function actionGetchatcount(){
        $id = Yii::$app->user->identity->id;

        
        $m_count = ChatHistory::find()
        ->where('partner_login_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_CONSULTANT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('PARTNER_read_status = 0')
        ->all();
        $m_count =  count($m_count);              
        return json_encode(['unread_total' => $m_count]);
        
    }
    public function actionChatnotification() {
        $student_chats = array();
        $notify_user = ChatHistory::find()
        ->where('partner_login_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_CONSULTANT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('partner_read_status = 0')
        ->andWhere('parent_notification = 0')
        ->distinct()
        ->all();
        //$notify_user =  count($notify_user);
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_STUDENT){
            $chat_name = User::find()->where(['=', 'id', $notify['student_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['student_id']);
            array_push($student_chats, [$notify['student_id'],$name,$ids]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_history', ['parent_notification' => 1], ['partner_login_id' => Yii::$app->user->identity->id])
       ->execute();

        $student_calls = array();
        $notify_user = ChatvideoNotificarion::find()
        ->where('partner_login_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_CONSULTANT)
        ->andWhere('call_partner = 0')
        ->distinct()
        ->all();
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_STUDENT){
            $chat_name = User::find()->where(['=', 'id', $notify['student_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['student_id']);
            array_push($student_calls, [$notify['student_id'],$name,$ids]);
            //array_push($student_calls, [$notify['partner_login_id'],$name]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_call_notification', ['call_partner' => 1], ['partner_login_id' => Yii::$app->user->identity->id])
       ->execute();

        return json_encode(['student_calls' => $student_calls ,'student_chats' => $student_chats]);

        
        }
    public function actionGetcallnotify() {
        $student_calls = array();
        $notify_user = ChatvideoNotificarion::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('call_student = 1')
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
            array_push($student_calls, [$notify['partner_login_id'],$name]);
        }

        return json_encode(['student_calls' => $student_calls]);   
        } 
   
}
