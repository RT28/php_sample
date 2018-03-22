<?php

namespace frontend\controllers;

use Yii;
use common\models\Student;
use backend\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\StudentSchoolDetail;
use common\models\StudentCollegeDetail;
use common\models\StudentSubjectDetail;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentStandardTestDetail;
use common\models\FileUpload;
use common\components\Model;
use common\components\Roles; 
use frontend\models\StudentCalendar; 
use partner\modules\consultant\models\Consultant\Calendar;
use common\models\Country;
use common\models\State;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\Others;
use common\components\CalendarEvents;
use frontend\models\StudentShortlistedCourse;
use common\models\PackageType;
use common\models\StudentPackageDetails;
use common\models\UniversityCourseList;
use common\models\ConsultantCalendar;
use common\models\CalendarSessionTokenRelation;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use common\components\ConnectionSettings; 
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\db\ActiveRecord;
use frontend\models\TncForm;
use frontend\models\UserLogin;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use frontend\models\UserLoginForm;
use common\models\User;
use common\models\ChatHistory;
use common\models\ChatvideoNotificarion;
use common\models\Consultant;
use common\components\Commondata;
use frontend\models\StudentNotifications;


/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    /**
     * @inheritdoc
     */
	 
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'=> ['index', 'view', 'update','changepassword', 'profile-picture','delete-photo','download-passport','upload-passport','download-visa-details','upload-visa-details','download-reference-letter','upload-reference-letter','download-resume',
						'upload-resume','download-standard-tests','download-all','upload-standard-tests','download-transcripts','upload-transcripts',
						'dependent-states','get-student-calendar','get-student-allmeetings','get-invities','get-eventdetails','add-event','update-event','delete-event','change-eventstatus','course-list','dashboard','remove-from-shortlist','buy-free-application-package','packages','get-application-fees',
						'student-shortlisted-courses','shortlisted-courses-not-subscribed',  'tnc','calendar'
						],
                'rules' => [
                    [
                        'actions' => ['index', 'update','view', 'changepassword', 'profile-picture','delete-photo','download-passport','upload-passport','download-visa-details','upload-visa-details','download-reference-letter','upload-reference-letter','download-resume',
						'upload-resume','download-standard-tests','download-all','upload-standard-tests','download-transcripts','upload-transcripts',
						'dependent-states','get-student-calendar','get-student-allmeetings','get-invities','get-eventdetails','add-event','update-event','delete-event','change-eventstatus','course-list','dashboard','remove-from-shortlist','buy-free-application-package','packages','get-application-fees',
						'student-shortlisted-courses', 'shortlisted-courses-not-subscribed',  'tnc','calendar'
						],
                        'allow' => true, 
                        'roles' => ['@'],
                    ],
                     
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
  /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    } */

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'dashboard';
        return $this->redirect(['dashboard']);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
        Yii::$app->view->params['activeTab'] = 'profile';
        $id = Yii::$app->user->identity->student->id;
        $model = $this->findModel($id);
        $schools = Yii::$app->user->identity->studentSchoolDetails;
        $colleges = Yii::$app->user->identity->studentCollegeDetails;
        $subjects = Yii::$app->user->identity->studentSubjectDetails;
        $englishProficiency = Yii::$app->user->identity->studentEnglishLanguageProficienceyDetails;
        $standardTests = Yii::$app->user->identity->studentStandardTestDetails;
        return $this->render('view', [
            'model' => $model,
            'schools' => $schools,
            'colleges' => $colleges,
            'subjects' => $subjects,
            'englishProficiency' => $englishProficiency,
            'standardTests' => $standardTests
        ]);
    }
	public function actionNotification()
    {
        Yii::$app->view->params['activeTab'] = 'notification';
        $id = Yii::$app->user->identity->student->id;
        $unreadNotifications = StudentNotifications::find()->where(['AND', ['=', 'student_id', $id], ['=', 'read', 0]])->orderBy(['created_at' => 'DESC'])->all();
        $readNotifications = StudentNotifications::find()->where(['AND', ['=', 'student_id', $id], ['=', 'read', 1]])->orderBy(['created_at'=>'DESC'])->all();
        $un_count = count($unreadNotifications);
        $rd_count = count($readNotifications);
        return $this->render('notification', [
            'unreadNotifications' => $unreadNotifications,
            'readNotifications' => $readNotifications,
            'un_count' => $un_count,
            'rd_count' => $rd_count
        ]);
    }
    public function actionUpdatenotification()
    {
        Yii::$app->db->createCommand()
       ->update('student_notifications', ['read' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();
       return json_encode(['success' => "success"]);
    }
	 public function actionChangepassword()
    {
        Yii::$app->view->params['activeTab'] = 'profile';
         $id = Yii::$app->user->identity->student->student_id;
	 
        $userLogin =UserLogin::findOne($id);
		 if ($userLogin->load(Yii::$app->request->post())) {
			// echo $userLogin->password_hash;
			$userLogin->setPassword($userLogin->password_hash); 
            if($userLogin->save(false)) { 
				$message = "Success! Your password has changed successfully.";	
				return $this->render('changepassword', [
				'userLogin' => $userLogin, 
				'message' => $message, 
				]);
            }else{
				$message = "Error! Your password has not changed.";	
				return $this->render('changepassword', [
				'userLogin' => $userLogin, 
				'message' => $message, 
				]);
			} 
        }
		return $this->render('changepassword', [
				'userLogin' => $userLogin, 
				]); 
    }
	
	public function actionTnc($ptid) {   
		$model =  new TncForm(); 
		$id = Yii::$app->user->identity->student->id; 
		$userLogin =UserLogin::findOne($id); 
	 
		if($userLogin->status!=4 && $userLogin->status!=1){
			if ($model->load(Yii::$app->request->post())) {			
			 
				 $userLogin->status = UserLogin::STATUS_SUBSCRIBED;
                 $userLogin->follow_status = UserLogin::STATUS_SUBSCRIBED;
				 $userLogin->tnc = 1;
				 $userLogin->save(false); 
									  
				 return $this->redirect(['student/dashboard']); 
			}
		} 
		return $this->render('tnc',['model' => $model,'ptid' => $ptid]);
	}
	  
    private function saveProfilePicture($image, $student) {
        $newFile = UploadedFile::getInstance($image, 'profilePhoto');
        if (isset($newFile)) {
            $image->profilePhoto = UploadedFile::getInstance($image, 'profilePhoto');
            if ($image->uploadProfilePicture($student)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
   public function actionSaveprofileajax() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/profile_photo");
        if (!$result) {
            $result = FileHelper::createDirectory("./../web/uploads/$student/profile_photo");
        }
        $sourcePath = $_FILES['profile_photo']['tmp_name'];
        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/profile_photo/" . date_timestamp_get(date_create()) . '.' . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            $path = Yii::getAlias('@frontend'); 
            $path = $path."/web/uploads/$student/profile_photo/"; 
            //$file = explode('.',$sourcePath);
            $filname = date_timestamp_get(date_create()).'.'.$ext; 
                $this->ak_img_resize($path, $filname,'logo');


                /*deleting other logo images*/
                $dir = $path; 
                if($ext=='jpg'){
                $leave_files = array('logo_170X115.jpg');
                } else if($ext=='png'){
                $leave_files = array('logo_170X115.png');
                } else if($ext=='jpge'){
                $leave_files = array('logo_170X115.jpge');
                } else if($ext=='gif'){
                $leave_files = array('logo_170X115.gif');
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
        $student = Yii::$app->user->identity->student->id;
        $result = is_dir("./../web/uploads/$student/profile_photo");
        if ($result) {
            array_map('unlink', glob("./../web/uploads/$student/profile_photo/*"));
            echo json_encode(['error' => 'Processing request']);
            }
    }
 
    function ak_img_resize($path, $filname, $img_type){
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

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {  
        $details = UserLogin::findOne($id);
        if(!empty($details->student)) {
            return $this->redirect(['view', 'id' => $details->student->id]);
        }
        $model = new Student();
        $model->email = $details->email;
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->student_id = $id;
        $upload = new FileUpload();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                $this->saveProfilePicture($upload, $details);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
                return $this->render('create', [
                    'model' => $model,
                    'countries' => $countries,
                    'upload' => $upload
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'countries' => $countries,
                'upload' => $upload
            ]);
        }
    }  
     

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->identity->student->id);
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $upload = new FileUpload();
        
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
			return Json::encode(ActiveForm::validate($model)); 

		} 
        if(isset($model->majors_preference)) {
            $model->majors_preference = explode(',', $model->majors_preference);
        }
	 
          if ($model->load(Yii::$app->request->post())) {
		 
			$dob =strtotime($model->date_of_birth);
		    $model->date_of_birth = date('Y-m-d',$dob);

                
                if(!empty($model->majors_preference)) {
                $model->majors_preference = implode(',', $model->majors_preference);
                }
                /*if(!empty($model->qualification)){
                    $model->qualification = $model->qualification;
                    if(isset($model->others)){
                        $model->others = $model->others;
                    }else{
                        $model->others = '';
                    }
                    
                }*/           
			 
            if($model->save(false)) { 
                $userlogin = UserLogin::findOne(Yii::$app->user->identity->id);
                $userlogin->majors_preference = $model->majors_preference;
                $userlogin->save(false);
                return $this->redirect(['view']);
            }
          
        }  else {
               return $this->render('update', [
                'model' => $model,
                'countries' => $countries,
                'upload' => $upload

            ]);
            }

         
    }

    /**
     * Deletes an existing Student model.
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
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateSchoolDetails() {
        $model = Yii::$app->user->identity;
        $schools = $model->studentSchoolDetails;

        if(Yii::$app->request->post()) {
            $this->saveSchoolDetails($schools, $model);
        }

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax('school_details_form', [
                'model' => $model,
                'schools' => empty($schools) ? [new StudentSchoolDetail] : $schools
            ]);
        }
        return $this->render('school_details_form', [
            'model' => $model,
            'schools' => empty($schools) ? [new StudentSchoolDetail] : $schools,
            'layout' => 'index'
        ]);
    }

    private function saveSchoolDetails($schools, $student) {
        $oldIDs = ArrayHelper::map($schools, 'id', 'id');
        $schools = Model::createMultiple(StudentSchoolDetail::classname(), $schools);
        $result = Model::loadMultiple($schools, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($schools, 'id', 'id')));
        $valid = Model::validateMultiple($schools, ['name', 'from_date', 'to_date', 'curriculum']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentSchoolDetail::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($schools as $school) {
                    $school->student_id = $student->id;
                    $school->created_by = $student->id;
                    $school->updated_by = $student->id;
                    $school->created_at = gmdate('Y-m-d H:i:s');
                    $school->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $school->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }

    public function actionUpdateCollegeDetails() {
        $model = Yii::$app->user->identity;
        $colleges = $model->studentCollegeDetails;

        if(Yii::$app->request->post()) {
            $this->saveCollegeDetails($colleges, $model);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('college_details_form', [
                'model' => $model,
                'colleges' => empty($colleges) ? [new StudentCollegeDetail] : $colleges,
            ]);
        }
        return $this->render('college_details_form', [
            'model' => $model,
            'colleges' => empty($colleges) ? [new StudentCollegeDetail] : $colleges,
            'layout' => 'index'
        ]);
    }

    private function saveCollegeDetails($colleges, $student) {
        $oldIDs = ArrayHelper::map($colleges, 'id', 'id');

        $colleges = Model::createMultiple(StudentCollegeDetail::classname(), $colleges);
        $result = Model::loadMultiple($colleges, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($colleges, 'id', 'id')));
        $valid = Model::validateMultiple($colleges, ['name', 'from_date', 'to_date', 'curriculum']);
        if ($valid) {
            $flag = true;
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if (!empty($deletedIDs)) {
                    StudentCollegeDetail::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($colleges as $college) {
                    $college->student_id = $student->id;
                    $college->created_by = $student->id;
                    $college->updated_by = $student->id;
                    $college->created_at = gmdate('Y-m-d H:i:s');
                    $college->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $college->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }

    public function actionUpdateSubjectDetails() {
        $model = Yii::$app->user->identity;
        $subjects = $model->studentSubjectDetails;

        if(Yii::$app->request->post()) {
            $this->saveSubjectDetails($subjects, $model);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('subject_details_form', [
                'model' => $model,
                'subjects' => empty($subjects) ? [new StudentSubjectDetail] : $subjects,
            ]);
        }
        return $this->render('subject_details_form', [
            'model' => $model,
            'subjects' => empty($subjects) ? [new StudentSubjectDetail] : $subjects,
            'layout' => 'index'
        ]);
    }

    private function saveSubjectDetails($subjects, $student) {
        $oldIDs = ArrayHelper::map($subjects, 'id', 'id');
        $subjects = Model::createMultiple(StudentSubjectDetail::classname(), $subjects);
        $result = Model::loadMultiple($subjects, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($subjects, 'id', 'id')));
        $valid = Model::validateMultiple($subjects, ['name', 'maximum_marks', 'marks_obtained']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentSubjectDetail::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($subjects as $subject) {
                    $subject->student_id = $student->id;
                    $subject->created_by = $student->id;
                    $subject->updated_by = $student->id;
                    $subject->created_at = gmdate('Y-m-d H:i:s');
                    $subject->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $subject->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }

    public function actionUpdateEnglishProficiency() {
        $model = Yii::$app->user->identity;
        $englishProficiency = $model->studentEnglishLanguageProficienceyDetails;

        if(Yii::$app->request->post()) {
            $this->saveEnglishProficiencyDetails($englishProficiency, $model);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('english_language_proficiencey_details_form', [
                'model' => $model,
                'englishProficiency' => empty($englishProficiency) ? [new StudentEnglishLanguageProficienceyDetails] : $englishProficiency,
            ]);
        }
        return $this->render('english_language_proficiencey_details_form', [
            'model' => $model,
            'englishProficiency' => empty($englishProficiency) ? [new StudentEnglishLanguageProficienceyDetails] : $englishProficiency,
            'layout' => 'index'
        ]);
    }

    private function saveEnglishProficiencyDetails($proficiency, $student) {
        $oldIDs = ArrayHelper::map($proficiency, 'id', 'id');
        $proficiency = Model::createMultiple(StudentEnglishLanguageProficienceyDetails::classname(), $proficiency);
        $result = Model::loadMultiple($proficiency, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($proficiency, 'id', 'id')));
        $valid = Model::validateMultiple($proficiency, ['test_name', 'reading_score', 'writing_score', 'listening_score', 'speaking_score']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentEnglishLanguageProficienceyDetails::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($proficiency as $prof) {
                    $prof->student_id = $student->id;
                    $prof->created_by = $student->id;
                    $prof->updated_by = $student->id;
                    $prof->created_at = gmdate('Y-m-d H:i:s');
                    $prof->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $prof->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }

    public function actionUpdateStandardTests() {
        $model = Yii::$app->user->identity;
        $standardTests = $model->studentStandardTestDetails;

        if(Yii::$app->request->post()) {
            $this->saveStandardDetails($standardTests, $model);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('standard_test_detail_form', [
                'model' => $model,
                'standardTests' => empty($standardTests) ? [new StudentStandardTestDetail] : $standardTests,
            ]);
        }
        return $this->render('standard_test_detail_form', [
            'model' => $model,
            'standardTests' => empty($standardTests) ? [new StudentStandardTestDetail] : $standardTests,
            'layout' => 'index'
        ]);
    }

    private function saveStandardDetails($tests, $student) {
        $oldIDs = ArrayHelper::map($tests, 'id', 'id');
        $tests = Model::createMultiple(StudentStandardTestDetail::classname(), $tests);
        $result = Model::loadMultiple($tests, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($tests, 'id', 'id')));
        $valid = Model::validateMultiple($tests, ['test_name','test_authority','test_date', 'verbal_score', 'quantitative_score', 'integrated_reasoning_score', 'data_interpretation_score']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentStandardTestDetail::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($tests as $test) {
                    $test->student_id = $student->id;
                    $test->created_by = $student->id;
                    $test->updated_by = $student->id;
                    $test->created_at = gmdate('Y-m-d H:i:s');
                    $test->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $test->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['application-form/index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }

    public function actionDocuments() {
        $model = Yii::$app->user->identity;
        return $this->render('documents', [
            'model' => $model,
        ]);
    }

    public function actionUploadProfilePhoto() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/profile_photo");
        if (!$result) {
            $result = FileHelper::createDirectory("./../web/uploads/$student/profile_photo");
        }
        $sourcePath = $_FILES['profile_photo']['tmp_name'];
        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/profile_photo/" . date_timestamp_get(date_create()) . '.' . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request']);
        }
    }

    public function actionDeletePhoto() {
        $student = Yii::$app->request->post('student_id');
        $key = Yii::$app->request->post('key');
        if (unlink("./../web/uploads/$student/profile_photo/$key")) {
            echo json_encode([]);
        } else {
            echo json_encode(['error' => 'Processing request ']);
        }
    }

    public function actionDownloadPassport() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/passport")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/documents/passport", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => ['passport.*']
            ]);
            if (count($passport_path) > 0) {
                Yii::$app->response->sendFile($passport_path[0]);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }

    public function actionUploadPassport() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/documents/passport");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/passport");
        } else {
            FileHelper::removeDirectory("./../web/uploads/$student/documents/passport");
            FileHelper::createDirectory("./../web/uploads/$student/documents/passport");
        }
        $sourcePath = $_FILES['upload_passport']['tmp_name'];
        $ext = pathinfo($_FILES['upload_passport']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/documents/passport/passport." . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request ' . $sourcePath]);
        }
        return;
    }

    public function actionDownloadVisaDetails() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/visa")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/document/visa", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => ['visa.*']
            ]);
            if (count($passport_path) > 0) {
                Yii::$app->response->sendFile($passport_path[0]);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }

    public function actionUploadVisaDetails() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/documents/visa");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/visa");
        } else {
            FileHelper::removeDirectory("./../web/uploads/$student/documents/visa");
            FileHelper::createDirectory("./../web/uploads/$student/documents/visa");
        }
        $sourcePath = $_FILES['upload_visa']['tmp_name'];
        $ext = pathinfo($_FILES['upload_visa']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/documents/visa/visa." . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request ' . $sourcePath]);
        }
        return;
    }

    public function actionDownloadReferenceLetter() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/reference_letter")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/documents/reference_letter", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => ['reference_letter.*']
            ]);
            if (count($passport_path) > 0) {
                Yii::$app->response->sendFile($passport_path[0]);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }

    public function actionUploadReferenceLetter() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/documents/reference_letter");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/reference_letter");
        } else {
            FileHelper::removeDirectory("./../web/uploads/$student/documents/reference_letter");
            FileHelper::createDirectory("./../web/uploads/$student/documents/reference_letter");
        }
        $sourcePath = $_FILES['reference_letter']['tmp_name'];
        $ext = pathinfo($_FILES['reference_letter']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/documents/reference_letter/reference_letter." . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request ' . $sourcePath]);
        }
        return;
    }

    public function actionDownloadResume() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/resume")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/documents/resume", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => ['reference_letter.*']
            ]);
            if (count($passport_path) > 0) {
                Yii::$app->response->sendFile($passport_path[0]);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }

    public function actionUploadResume() {
        $student = Yii::$app->request->post('student_id');
        $result = is_dir("./../web/uploads/$student/documents/resume");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/resume");
        } else {
            FileHelper::removeDirectory("./../web/uploads/$student/documents/resume");
            FileHelper::createDirectory("./../web/uploads/$student/documents/resume");
        }
        $sourcePath = $_FILES['resume']['tmp_name'];
        $ext = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$student/documents/resume/resume." . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request ' . $sourcePath]);
        }
        return;
    }

     public function actionDownloadStandardTests() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/standard_tests")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/documents/standard_tests", [
                'caseSensitive' => false,
                'recursive' => false,
            ]);
           
            if (count($passport_path) > 0) {
                $files = $passport_path;
                $result = is_dir("./../web/downloads");
                if (!$result) {
                    FileHelper::createDirectory("./../web/downloads");
                } 
                $zipname =  'downloads/standard_tests'.$id.'.zip';
                $zip = new \ZipArchive();
                $k = 0;
                $zip->open($zipname, \ZipArchive::CREATE);
                foreach ($files as $file) {
                    $normalized = FileHelper::normalizePath($file,'/');
                    $filename = explode($id.'/', $normalized);
                    //print_r($filename[1]);
                    $zip->addFile($normalized,$filename[1]);
                    $k++;
                }
                $zip->close();
                Yii::$app->response->sendFile($zipname);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }
public function actionDownloadall() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id", [
                'caseSensitive' => false,
                'recursive' => true,
            ]);
            //print_r($passport_path);
            //die();
            if (count($passport_path) > 0) {
                $files = $passport_path;
                $result = is_dir("./../web/downloads");
                if (!$result) {
                    FileHelper::createDirectory("./../web/downloads");
                } 
                $zipname = 'downloads/documents'.$id.'.zip';
                $zip = new \ZipArchive();
                $zip->open($zipname, \ZipArchive::CREATE);
                $k = 0;
                foreach ($files as $file) {
                    $normalized = FileHelper::normalizePath($file,'/');
                    $filename = explode($id.'/', $normalized);
                    //print_r($filename[1]);
                       $zip->addFile($normalized,$filename[1]);
                       $k++;
                }
                $zip->close();
                Yii::$app->response->sendFile($zipname);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }


    public function actionUploadStandardTests() {
        $student = Yii::$app->request->post('student_id');
        $i = 0;
        $result = is_dir("./../web/uploads/$student/documents/standard_tests");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/standard_tests");
        }

        while(isset($_FILES["document-".$i])) {
            if($_FILES["document-".$i]['error'] === 0) {
                $sourcePath = $_FILES["document-".$i]['tmp_name'];
                $ext = pathinfo($_FILES["document-".$i]['name'], PATHINFO_EXTENSION);
                $targetPath = "./../web/uploads/$student/documents/standard_tests/" . $_POST["test-" . $i] .'.'. $ext; // Target path where file is to be stored
                if (move_uploaded_file($sourcePath,$targetPath)) {
                }
                else {
                    echo json_encode(['status' => 'failure' ,'error' => 'Processing request ' . $sourcePath]);
                    return;
                }
            }
            $i++;
        }
        echo json_encode(['status' => 'success']);
        return;
    }

    public function actionDownloadTranscripts() {
        $id = Yii::$app->request->get('id');
        if (is_dir("./../web/uploads/$id/documents/transcripts")) {
            $passport_path = FileHelper::findFiles("./../web/uploads/$id/documents/transcripts", [
                'caseSensitive' => false,
                'recursive' => false,
            ]);
            if (count($passport_path) > 0) {
                $files = $passport_path;
                $result = is_dir("./../web/downloads");
                if (!$result) {
                    FileHelper::createDirectory("./../web/downloads");
                }
                $zipname = 'downloads/transcripts'.$id.'.zip';
                $zip = new \ZipArchive();
                $zip->open($zipname, \ZipArchive::CREATE);
                $k = 0;
                foreach ($files as $file) {
                       $normalized = FileHelper::normalizePath($file,'/');
                       $filename = explode('transcripts/', $normalized);
                       //print_r($filename[1]);
                       $zip->addFile($normalized,$filename[1]);
                       $k++;
                }
                $zip->close();
                Yii::$app->response->sendFile($zipname);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }


    public function actionUploadTranscripts() {
        $student = Yii::$app->request->post('student_id');
        $i = 0;
        $result = is_dir("./../web/uploads/$student/documents/transcripts");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents/transcripts");
        }

        while(isset($_FILES["document-".$i])) {
            if($_FILES["document-".$i]['error'] === 0) {
                $sourcePath = $_FILES["document-".$i]['tmp_name'];
                $ext = pathinfo($_FILES["document-".$i]['name'], PATHINFO_EXTENSION);
                $targetPath = "./../web/uploads/$student/documents/transcripts/" . $_POST["test-" . $i] .'.'. $ext; // Target path where file is to be stored
                if (move_uploaded_file($sourcePath,$targetPath)) {
                }
                else {
                    echo json_encode(['status' => 'failure' ,'error' => 'Processing request ' . $sourcePath]);
                    return;
                }
            }
            $i++;
        }
        echo json_encode(['status' => 'success']);
        return;
    }

    public function actionDependentStates() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $states = State::getStatesForCountry($country_id);
                echo Json::encode(['output'=>$states, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionGetStudentCalendar() {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $id = Yii::$app->user->identity->id;

        $events = StudentCalendar::find()->where(['and', "start >= '$start'", "end <= '$end'", "student_id=$id", "status!=2"])->all();

        return Json::encode(['status' => 'success' ,'response' => $events]);
    }
    public function actionGetStudentAllmeetings(){
        $events = StudentCalendar::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
        
        return $this->renderAjax('all_meetings', [
            'events' => $events
        ]);
       
    }
    public function actionGetInvities(){
        $events = StudentCalendar::find()->where(['=', 'id', $_POST['id']])->one();
        return $this->renderAjax('invities_list', [
            'events' => $events
        ]);
       
    }
    public function actionGetEventdetails(){
        $events = StudentCalendar::find()->where(['=', 'id', $_POST['id']])->one();
        return $this->renderAjax('event_details', [
            'events' => $events
        ]);
       
    }
    public function actionChangeEventstatus(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        Yii::$app->db->createCommand()
           ->update('student_calendar', ['status' => $status], ['student_id' => Yii::$app->user->identity->id, 'id' => $id])
           ->execute();
        $e_count = StudentCalendar::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_STUDENT)
        ->andWhere('created_by_role != '.Roles::ROLE_STUDENT)
        ->andWhere('status = 0')
        ->all();
        $e_count =  count($e_count);   
        return Json::encode(['status' => 'success' , 'e_count' => $e_count]);   
       
    }
    public function actionAddEvent() {
        $event = new StudentCalendar();
        $val = $_POST['event'];
        $event_availablity = 1;
        $event_appointment = 2;
        $appointment = null;
        $role = null;
        $invitees_list = array();
        if(isset($val['appointment_with'])) {  
            $appointment = $val['appointment_with'];
            $role = $val['appointment_role'];
        }
        if(isset($_POST['ids_consultant']) AND $_POST['ids_consultant']!='') {
            $consultant_ids = implode(', ', $_POST['ids_consultant']);
            foreach ($_POST['ids_consultant'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_CONSULTANT]);
            }
            
        } else { $consultant_ids = '0'; }
        if(isset($_POST['ids_trainer']) AND $_POST['ids_trainer']!='') {
            $trainer_ids = implode(', ', $_POST['ids_trainer']);
            foreach ($_POST['ids_trainer'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_TRAINER]);
            }
        } else { $trainer_ids = '0'; }
        if(isset($_POST['ids_employee']) AND $_POST['ids_employee']!='') {
            $employee_ids = implode(', ', $_POST['ids_employee']);
            foreach ($_POST['ids_employee'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_EMPLOYEE]);
            }
        } else { $employee_ids = '0'; }
        //print_r($invitees_list);
        $event->student_id = Yii::$app->user->identity->id;
        $event->title = $val['title'];
        $event->role_id = Roles::ROLE_STUDENT;
        $event->consultant_appointment_id = $appointment;
        $event->start = $val['start'];
        $event->end = $val['end'];
        $event->event_type = 0;
		$event->meetingtype = 0;
		$event->mode = $val['mode'];
        $event->alert = $val['alert'];
        $event->consultant_ids = $consultant_ids;
        $event->trainer_ids = $trainer_ids;
        $event->employee_ids = $employee_ids;
        $event->student_ids = 0;
        $event->created_by_role = Roles::ROLE_STUDENT;
        $event->student_id = Yii::$app->user->identity->id;
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

        if($event->event_type == $event_appointment) {
            $event->appointment_status = 0;
        }

        if($event->save(false)) {
            foreach ($invitees_list as $key => $value) {
                   
                    $consultant_event = new ConsultantCalendar();
                    $consultant_event->consultant_id = $value[0];
                    $consultant_event->role_id = $value[1];
                    $consultant_event->student_appointment_id = $event->id;
                    $consultant_event->event_type = $event->event_type;
                    $consultant_event->appointment_status = $event->appointment_status;
                    $consultant_event->meetingtype =  $event->meetingtype; 
                    $consultant_event->mode = $event->mode; 
                    $consultant_event->title = $event->title;
                    $consultant_event->location = $event->location;
                    //$consultant_event->url = $event->url;
                    $consultant_event->remarks = $event->remarks;
                    $consultant_event->start = $event->start;
                    $consultant_event->end = $event->end;
                    $consultant_event->time_stamp = $event->time_stamp;
                    $consultant_event->consultant_ids = $event->consultant_ids;
                    $consultant_event->trainer_ids = $event->trainer_ids;
                    $consultant_event->employee_ids = $event->employee_ids;
                    $consultant_event->created_by_role = Roles::ROLE_STUDENT;
                    $consultant_event->created_by = $event->created_by;
                    $consultant_event->created_at = $event->created_at;
                    $consultant_event->updated_by = $event->updated_by;
                    $consultant_event->updated_at = $event->updated_at; 
                    $consultant_event->save(false);
                    }
                    if($consultant_event->save(false)) {
                        $event->consultant_appointment_id = $consultant_event->id;
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

    public function actionUpdateEvent() {
        $val = $_POST['event'];
        $id = $val['id'];
        $event = StudentCalendar::findOne($id);
                
        $event_availablity = 1;
        $event_appointment = 2;
        $appointment = null;
        $role = null;
        $invitees_list = array();

        $consultant_event =  ConsultantCalendar::find()->where('student_appointment_id  ='.$id)->all();
            foreach($consultant_event as $c_event)
            {
                $c_event->delete();
            }
        /*if(isset($_POST['ids_consultant']) AND $_POST['ids_consultant']!='') {
            $consultant_ids = implode(', ', $_POST['ids_consultant']);
        } else { $consultant_ids = '0'; }
        if(isset($_POST['ids_trainer']) AND $_POST['ids_trainer']!='') {
            $trainer_ids = implode(', ', $_POST['ids_trainer']);
        } else { $trainer_ids = '0'; }
        if(isset($_POST['ids_employee']) AND $_POST['ids_employee']!='') {
            $employee_ids = implode(', ', $_POST['ids_employee']);
        } else { $employee_ids = '0'; }*/

        if(isset($_POST['ids_consultant']) AND $_POST['ids_consultant']!='') {
            $consultant_ids = implode(', ', $_POST['ids_consultant']);
            foreach ($_POST['ids_consultant'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_CONSULTANT]);
            }
            
        } else { $consultant_ids = '0'; }
        if(isset($_POST['ids_trainer']) AND $_POST['ids_trainer']!='') {
            $trainer_ids = implode(', ', $_POST['ids_trainer']);
            foreach ($_POST['ids_trainer'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_TRAINER]);
            }
        } else { $trainer_ids = '0'; }
        if(isset($_POST['ids_employee']) AND $_POST['ids_employee']!='') {
            $employee_ids = implode(', ', $_POST['ids_employee']);
            foreach ($_POST['ids_employee'] as $key => $value) {
               array_push($invitees_list,[$value,Roles::ROLE_EMPLOYEE]);
            }
        } else { $employee_ids = '0'; }

        $event->student_id = Yii::$app->user->identity->id;
        $event->role_id = Roles::ROLE_STUDENT;
        $event->title = $val['title'];
        $event->consultant_appointment_id = $appointment;
        $event->start = $val['start'];
        $event->end = $val['end'];
        $event->event_type = 0;		
		$event->meetingtype = 0;
		$event->mode = $val['mode'];
        $event->alert = $val['alert'];
        $event->consultant_ids = $consultant_ids;
        $event->trainer_ids = $trainer_ids;
        $event->employee_ids = $employee_ids;
        $event->student_ids = 0;
        $event->created_by_role = Roles::ROLE_STUDENT;
        $event->time_stamp = gmdate('U');
        $event->student_id = Yii::$app->user->identity->id;
        $event->created_by = Yii::$app->user->identity->id;
        $event->updated_by = Yii::$app->user->identity->id;
        $event->updated_at = gmdate('Y-m-d H:i:s');
        $event->created_at = gmdate('Y-m-d H:i:s');
        
        if(isset($val['remarks'])) {
            $event->remarks = $val['remarks'];
        }
        if(isset($val['location'])) {
            $event->location = $val['location'];
        }
        if($event->event_type == $event_appointment) {
            $event->appointment_status = 0;
        }
		if($event->save(false)) {
            foreach ($invitees_list as $key => $value) {
                   
                    $consultant_event = new ConsultantCalendar();
                    $consultant_event->consultant_id = $value[0];
                    $consultant_event->role_id = $value[1];
                    $consultant_event->student_appointment_id = $event->id;
                    $consultant_event->event_type = $event->event_type;
                    $consultant_event->appointment_status = $event->appointment_status;
                    $consultant_event->meetingtype =  $event->meetingtype; 
                    $consultant_event->mode = $event->mode; 
                    $consultant_event->title = $event->title;
                    $consultant_event->location = $event->location;
                    $consultant_event->remarks = $event->remarks;
                    $consultant_event->start = $event->start;
                    $consultant_event->end = $event->end;
                    $consultant_event->time_stamp = $event->time_stamp;
                    $consultant_event->consultant_ids = $event->consultant_ids;
                    $consultant_event->trainer_ids = $event->trainer_ids;
                    $consultant_event->employee_ids = $event->employee_ids;
                    $consultant_event->created_by_role = Roles::ROLE_STUDENT;
                    $consultant_event->created_by = $event->created_by;
                    $consultant_event->created_at = $event->created_at;
                    $consultant_event->updated_by = $event->updated_by;
                    $consultant_event->updated_at = $event->updated_at; 
                    $consultant_event->save(false);
                    }
                    if($consultant_event->save(false)) {
                        $event->consultant_appointment_id = $consultant_event->id;
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
        $event = StudentCalendar::findOne($id);
            if($event->delete()) {
            $transaction->commit();
            $consultant_event =  ConsultantCalendar::find()->where('student_appointment_id  ='.$id)->all();
            foreach($consultant_event as $c_event)
            {
                $c_event->delete();
            }
            return Json::encode(['status' => 'success' ,'response' => '']);    
            }
        
    }

    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
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

    private function validateEventBeforeAdd($start, $end, $event_type, $appointment, $role) {
        $event_availablity = 1;
        $event_appointment = 2;
        if($event_type != $event_appointment && $event_type != $event_availablity) {
            return true;
        }
        /**
            * condition 1: new event starts after the event and ends after event.
            * condition 2: new event starts before event and ends before event ends. *
            * condition 3: new event starts before event and ends after event.
            * condition 4: new event starts before start and ends in between. *
        */
        $student_id = Yii::$app->user->identity->id;
        $query = "SELECT * FROM student_calendar WHERE student_id=$student_id AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
        $models = StudentCalendar::findBySql($query);
        
        if(!$models->exists()) {
            if($event_type == $event_appointment) {
                if ($role == Roles::ROLE_CONSULTANT) {
                    $query = "SELECT * FROM consultant_calendar WHERE consultant_id=$appointment AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
                    $models = ConsultantCalendar::findBySql($query);

                    if(!$models->exists()) {
                        return true;
                    } else {
                        foreach($models->each() as $model) {
                            if ($model->event_type == $event_availablity) {
                                return ['status' => 'error', 'message' => ['You\'r consultant is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                            if ($model->event_type == $event_appointment) {
                                return ['status' => 'error', 'message' => ['You\'r consultant is unavailable from ' . $model->start . ' to ' . $model->end]];
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
        $event_availablity = 1;
        $event_appointment = 2;
        
        $student_id = Yii::$app->user->identity->id;
        $query = "SELECT * FROM student_calendar WHERE id <> $current_event->student_id AND student_id=$student_id AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
 
        $models = StudentCalendar::findBySql($query);

        if(!$models->exists()) {
            if($event_type == $event_appointment) {
                if ($role == Roles::ROLE_CONSULTANT) {
                    $query = "SELECT * FROM consultant_calendar WHERE id <> $current_event->consultant_appointment_id AND consultant_id=$appointment AND (event_type=$event_availablity OR event_type=$event_appointment) AND ((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end <= '$end') OR (start <= '$start' AND end > '$end') OR (start <= '$start' AND end > '$start' AND end <= '$end') OR (start = '$start' AND end = '$end'))";
                    $models = ConsultantCalendar::findBySql($query);

                    if(!$models->exists()) {
                        return true;
                    } else {
                        foreach($models->each() as $model) {
                            if ($model->event_type == $event_availablity) {
                                return ['status' => 'error', 'message' => ['You\'r consultant is unavailable from ' . $model->start . ' to ' . $model->end]];
                            }
                            if ($model->event_type == $event_appointment) {
                                return ['status' => 'error', 'message' => ['You\'r consultant is unavailable from ' . $model->start . ' to ' . $model->end]];
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

    function actionCourseList() {
        Yii::$app->view->params['activeTab'] = 'programs';
        $models = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
        return $this->render('shortlisted-courses', [
            'models' => $models
        ]);
    }

    public function actionDashboard() {
		 
        Yii::$app->view->params['activeTab'] = 'dashboard';
		
		$isProfileComplete = Student::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
		
		if(Yii::$app->user->identity->status !=4){
			 return $this->redirect(['student/student-shortlisted-courses']);
		}
		
        $shortlistedCourses = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->all();
        $freeApplicationPakcageId = PackageType::find()->where(['=', 'id', 6])->one()->id;
        $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $freeApplicationPakcageId]])->one();
        
        $areDocumentsUploaded = false;
        $profileMessage = '';
        $user = Yii::$app->user->identity;
        if (empty($isProfileComplete)) {
            $isProfileComplete = false;
            $profileMessage = 'Personal profile is not complete';
        } else {
            
            if(empty($user->studentEnglishLanguageProficienceyDetails)) {
                $isProfileComplete = false;
                $profileMessage = 'English Proficiency Details Missing';
            }
            if(empty($user->studentStandardTestDetails)) {
                $isProfileComplete = false;
                $profileMessage = 'Standard Tests Details Missing';
            }

            if(empty($profileMessage)) {
                $isProfileComplete = true;
            }
        }
        if (empty($hasFreeApplicationPackage)) {
            $hasFreeApplicationPackage = false;
        } else {
            $hasFreeApplicationPackage = true;
        }

        if (is_dir('./uploads/' . $user->id . '/documents')) {
            $areDocumentsUploaded = true;
        }
        $student_logged = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        $student_logged->logged_status = 1;                
        $student_logged->save(false);
        $universityApplications = $user->studentUniversityApplications;
        
        return $this->render('dashboard', [
            'shortlistedCourses' => empty($shortlistedCourses) ? [] : $shortlistedCourses,
            'hasFreeApplicationPackage' => $hasFreeApplicationPackage,
            'isProfileComplete' => $isProfileComplete,
            'profileMessage' => $profileMessage,
            'areDocumentsUploaded' => $areDocumentsUploaded,
            'universityApplications' => $universityApplications,
        ]);
    }

    public function actionRemoveFromShortlist() {
        $id = $_POST['id'];

        $model = StudentShortlistedCourse::findOne($id);

        if(empty($model)) {
            return json_encode(['status' => 'failure', 'message' => 'Course does not exist.']);
        }

        if ($model->delete()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failure', 'message' => 'Error deleting course.']);
    }

    public function actionBuyFreeApplicationPackage() {
        $package = $_GET['id'];
        $user = Yii::$app->user->identity->id;

        $model = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', $user], ['=', 'package_type_id', $package]])->one();

        if(empty($model)) {
            $model = new StudentPackageDetails();
            $model->student_id = $user;
            $model->package_type_id = $package;
            $model->package_subtype_id = $package;
            $model->package_offerings = '1';
            $model->limit_type = 0;
            $model->limit_pending = 0;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->created_by = $user;
            $model->updated_by = $user;

            if($model->save()) {
                return $this->redirect(['student/dashboard']);
            } else {
                var_dump($model);
                die();
                return $this->redirect(['packages/view', 'id' => $package, 'error' => 'Error buying package']);
            }
        }
    }

    public function actionPackages() {
		Yii::$app->view->params['activeTab'] = 'packages';
        $models = StudentPackageDetails::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->all();
        return $this->render('view-packages', [
            'models' => $models
        ]);
    }

    public function actionCalendar(){
        Yii::$app->view->params['activeTab'] = 'calendar';
        return $this->render('calendar');
    }

    public function actionGetApplicationFees(){
        $course = $_POST['course'];
        $university = $_POST['university'];

        $model = UniversityCourseList::find()->where(['AND', ['=', 'university_id', $university], ['=', 'id', $course]])->one();

        return $this->renderAjax('course-fees', [
            'model' => $model
        ]);
    }

    public function actionStudentShortlistedCourses() {
		Yii::$app->view->params['activeTab'] = 'programs';
        $shortlistedCourses = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
		  
        $freeApplicationPakcageId = PackageType::find()->where(['=', 'id',6])->one()->id;
        $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $freeApplicationPakcageId]])->one();
        if (empty($hasFreeApplicationPackage)) {
            $hasFreeApplicationPackage = false;
        } else {
            $hasFreeApplicationPackage = true;
        }

        return $this->render('student_shortlisted_courses', [
            'models' => empty($shortlistedCourses) ? [] : $shortlistedCourses,
            'hasFreeApplicationPackage' => $hasFreeApplicationPackage,
        ]);
    }
	
	public function actionStudentNotSubscribed() {
		Yii::$app->view->params['activeTab'] = 'dashboard';
		
        $shortlistedCourses = StudentShortlistedCourse::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->all();
		  
        $freeApplicationPakcageId = PackageType::find()->where(['=', 'id',6])->one()->id;
        $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $freeApplicationPakcageId]])->one();
		
        if (empty($hasFreeApplicationPackage)) {
            $hasFreeApplicationPackage = false;
        } else {
            $hasFreeApplicationPackage = true;
        }
		
		$durationType = $this->getOthers('duration_type');
		$types = $this-> getOthers('course_type');
		
        return $this->render('shortlisted_courses_not_subscribed', [
            'models' => empty($shortlistedCourses) ? [] : $shortlistedCourses,
            'hasFreeApplicationPackage' => $hasFreeApplicationPackage,
			'durationType' => $durationType, 
			 'types' => $types,
        ]);
    }
    public function actionGetchatcount() {
    $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);
        
    return json_encode(['unread_total' => $m_count]);    
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
    public function actionGetcallnotify() {
        $student_calls = array();
        $curr_date = gmdate('Y-m-d H:i:s');
        $notify_user = ChatvideoNotificarion::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('call_student = 1')
        ->andWhere(['<','created_at',$curr_date])
        ->andWhere(['notif_status'=>0])
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
            $notify->notif_status = 1;
            $notify->save(false);
        }

        return json_encode(['student_calls' => $student_calls]);   
        } 
    
     
}