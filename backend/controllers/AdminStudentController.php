<?php

namespace backend\controllers;

use Yii;
use common\models\Student;
use common\models\Agency;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\StudentUniversityApplicationSearchNew;
use backend\models\StudentApplicationSearch; 
use common\models\StudentPackageDetails;
use common\models\StudentUniveristyApplication;
use backend\models\StudentSearch;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors;
use common\models\UniversityAdmission;
use common\components\Roles;
use common\components\AccessRule;
use common\models\UniversityCourseList;
use common\models\StudentConsultantRelation;
use common\models\Consultant;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\FileUpload;
use backend\models\UniversityDepartments;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;
use yii\helpers\FileHelper;
use common\models\Currency;
use yii\helpers\ArrayHelper;
use common\models\User; 
use common\models\PartnerEmployee;
use common\models\StudentPartneremployeeRelation;
use common\models\StudentSchoolDetail;
use common\models\StudentCollegeDetail;
use common\models\StudentSubjectDetail;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentStandardTestDetail;
use common\models\PackageType;
use common\models\PackageOfferings;
use backend\models\SiteConfig;
use common\components\ConnectionSettings;
use frontend\models\UserLogin;
use yii\db\IntegrityException; 
use yii\base\ErrorException;

/**
 * AdminStudentController implements the CRUD actions for student model.
 */
class AdminStudentController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update','assign-agency','dependent-agency','view-applications','view-profile','school-details','college-details','subject-details','english-proficiency','standard-tests','documents','update-school-details','update-college-details','update-subject-details','update-english-proficiency','update-standard-tests','update-event','view-all-applications', 'consultant-view','employee-view','package-view',
                        'disable','enable', 'assigned-counselor'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_EDITOR]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN]
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
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }
	
	 public function actionAssignedCounselor()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('assigned-counselor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionViewProfile($id)
    {   
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        return $this->render('studentprofile', [
            'model' => $model,
           
        ]);
    }

     public function action($id)
    {   
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Finds the University model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return University the loaded model
     * @throws NotFoundHttpException if the model cannot be found
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);        
         $this->view->params['customParam'] = $id;
       
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $upload = new FileUpload();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
		 
			$dob =strtotime($model->date_of_birth);
		    $model->date_of_birth = date('Y-m-d',$dob);
			 
            if($model->save()) {
                $this->saveProfilePicture($upload, $model->student); 
				 
                return $this->redirect(['view', 'id' => $model->id]);
            } 
        }
		
	return $this->render('update', [
                    'model' => $model, 
                    'countries' => $countries,
                    'upload' => $upload
                ]);
        
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
    
    public function actionSchoolDetails($id) {
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        $schools = $model->student->studentSchoolDetails;
        return $this->render('school_details', [
            'model' => $model,
            'schools' => $schools,
        ]);
    }

    public function actionCollegeDetails($id) {
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        $colleges = $model->student->studentCollegeDetails;

        return $this->render('college_details', [
            'model' => $model,
            'colleges' => empty($colleges) ? [new StudentCollegeDetail] : $colleges,
        ]);
    }

    
    

    public function actionSubjectDetails($id) {
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        $subjects = $model->student->studentSubjectDetails;

        return $this->render('subject_details', [
            'model' => $model,
            'subjects' => empty($subjects) ? [new StudentSubjectDetail] : $subjects,
        ]);
    }


    
    public function actionEnglishProficiency($id) {
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        $englishProficiency = $model->student->studentEnglishLanguageProficienceyDetails;

        return $this->render('english_language_proficiencey_details', [
            'model' => $model,
            'englishProficiency' => empty($englishProficiency) ? [new StudentEnglishLanguageProficienceyDetails] : $englishProficiency,
        ]);
    }

  

    public function actionStandardTests($id) {
        $model = $this->findModel($id);
        $this->view->params['customParam'] = $id;
        $standardTests = $model->student->studentStandardTestDetails;

        return $this->render('standard_test_details', [
            'model' => $model,
            'standardTests' => empty($standardTests) ? [new StudentStandardTestDetail] : $standardTests,
        ]);
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
	
    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {           
            $model = explode(',', $model->value);
            return $model;
        }
    }

     public function actionViewApplications($id) {
        $model = $this->findModel($id);
        $searchModel = new StudentUniversityApplicationSearchNew();
        $query = StudentUniveristyApplication::find()->where(['student.student_id' => $model->student_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$query);
          return $this->render('../admin-university/applications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewAllApplications() {
       
        $searchModel = new StudentApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          return $this->render('applications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	
	 public function actionDependentAgency() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $agency_id = $parents[0];
                $selected = '';
 
                $out = Consultant::find()
                ->where(['parent_partner_login_id'=>$agency_id])
                ->select(['consultant_id as id','CONCAT(first_name, " ", last_name) as name']) 
                ->orderBy('name')
                ->asArray()->all();
				 
                echo Json::encode(['output'=>$out, 'selected'=>'selected']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    } 
	
	 
	
	/*  public function actionDependentAgency() {        
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
               echo $agency_id = $parents[0]; 
				 die;
                $consultants = Consultant::getConsultantsForAgency($agency_id);                
                echo Json::encode(['output'=>$consultants, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    } */
	
     public function actionAssignAgency($id) {
       $model = $this->findModel($id);
	   $user = User::findOne(['id'=>$model->student_id]); 
	   $SCR = StudentConsultantRelation::findOne(['student_id'=>$model->student_id]);
	   
    
       $package = StudentPackageDetails::findOne(['student_id'=>$model->student_id]);
	   
	   
	  $allConsultants = Consultant::find()
	  ->select(['consultant_id','CONCAT(first_name, " ", last_name) as first_name']);
 
	  $allConsultants->orderBy('first_name')->all();
	  
	  
       $consultant_name = ArrayHelper::map($allConsultants,'consultant_id','first_name');
       $package_name = ArrayHelper::map(PackageType::find()->all(),'id','name');
	   
		$cc = array();
		$cc[] = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();
		$email = $model->email;
		$name = $model->first_name;
		
		 
			   isset($SCR) ? $SCR :$SCR = new StudentConsultantRelation();
			   if(isset($SCR)){
	 
				  
				if($SCR->load(Yii::$app->request->post())) {	
	
				  $assignedConsultant = 'Not Assigned';
				if(!empty($SCR->agency_id)){
					$assignedAgency = Agency::findOne(['partner_login_id'=>$SCR->agency_id]); 
 					$assignedAgencyName = $assignedAgency->name;  
					$cc[]= $assignedAgency->email; 
				} 
$assignedConsultantname = '';
$cid = '';
				if(!empty($_POST['StudentConsultantRelation[consultant_id]'])){
					$assignedConsultant = Consultant::findOne(['consultant_id'=>$SCR->consultant_id]); 
 					$assignedConsultantname = $assignedConsultant->first_name." ".$assignedConsultant->last_name;
					$cid = $SCR->consultant_id ;
					$cc[]= $assignedConsultant->email; 
		 
					$consultant =  $_POST['StudentConsultantRelation[consultant_id]'];
					$SCR->consultant_id = $consultant;
					$SCR->parent_consultant_id = $consultant; 
				}
				
				$SCR->student_id = $model->student_id;	 			
				$SCR->created_by =  Yii::$app->user->identity->id;
				$SCR->updated_by =  Yii::$app->user->identity->id;
				$SCR->created_at =gmdate('Y-m-d H:i:s');
				$SCR->updated_at =gmdate('Y-m-d H:i:s'); 
		 
			try {
                if($SCR->save()){
				  
				 
		/*$to = $email; 
		$subject = ' Consultant Assigned to you.';
		$template = 'agency_assignedto_student';   
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id); 
		$link = ConnectionSettings::BASE_URL . 'frontend/web/index.php?r=consultant/view&id='.$cid; 
		
		$data = array('name' => $name, 'agency' => $assignedAgencyName, 'consultant' => $assignedConsultantname, 'link' => $link);		
		$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		if($mailsent==true){ 
			Yii::$app->getSession()->setFlash('Success', 'Agency has been assigned successfully.'); 
		}*/ 
		Yii::$app->getSession()->setFlash('Success', 'Agency has been assigned successfully.'); 
					 
				
					return $this->redirect(array('assigned-counselor')); 
					
				} 
				
			}catch (IntegrityException $e) { 
			
					Yii::$app->getSession()->setFlash('Error', 'Error! Consultant already assigned');  
				return $this->redirect(['index']);
				
			}catch (Exception $e) {
				Yii::$app->getSession()->setFlash('Error', 'Error! Consultant already assigned');  
					return $this->redirect(['index']);	
	
	}
	return $this->redirect(array('assigned-counselor')); 
	  				
                 
			   }	
			   }
        
      
        
        return $this->render('assign_agency_form', [ 
			'model' => $model,
			'user' => $user,
            'consultant_name' => $consultant_name,
            'consultant'=>$SCR,
			
        ]);
    }
     

      public function actionConsultantView($id)
    {
        $model1= $this->findModel($id);
        $model2 = StudentConsultantRelation::findOne(['student_id'=>$model1->student_id]);
        $this->view->params['customParam'] = $id;
        $model = Consultant::findOne(['consultant_id'=>$model2->consultant_id]);
        $text = array('Consultant Details','Consultant not assigned');
        if(isset($model)){
             return $this->render('consultant-view', [
            'model' => $model,
			'agencies' => Agency::getAllAgencies(),
        ]);
        }
       else{
        return $this->render('not-assigned',['text'=>$text]);
       }
    }
	
	  public function actionEmployeeView($id)
    {
        $model1= $this->findModel($id);
        $model2 = StudentPartneremployeeRelation::findOne(['student_id'=>$model1->student_id]);
        $this->view->params['customParam'] = $id;
        $model = PartnerEmployee::findOne(['partner_login_id'=>$model2->parent_employee_id]);
        $text = array('Employee Details','Employee not assigned');
        if(isset($model)){
             return $this->render('employee-view', [
            'model' => $model,
			'agencies' => Agency::getAllAgencies(),
        ]);
        }
       else{
        return $this->render('not-assigned',['text'=>$text]);
       }
    }

    public function actionPackageView($id)
    {
        $model1= $this->findModel($id);
        $model = StudentPackageDetails::findOne(['student_id'=>$model1->student_id]);
        $packageOfferings = isset($model->package_offerings) ? PackageOfferings::find()->where(['in', 'id', explode(',', $model->package_offerings)])->all() : [];
        $offerings = [];
        foreach ($packageOfferings as $offering) {
            array_push($offerings, $offering->name);
        }
        $offerings = implode(',', $offerings);
        $this->view->params['customParam'] = $id;
        $text = array('Package Details','Package not assigned');
        if(isset($model)){
             return $this->render('package-view', [
            'model' => $model,
            'packageOfferings' => empty($offerings) ? 'NA': $offerings
        ]);
        }
       else{
        return $this->render('not-assigned',['text'=>$text]);
       }
    }

    public function actionDisable($id)
    {
        $model= $this->findModel($id);
        $model->student->status = 0;
        $model->student->save();
        $this->view->params['customParam'] = $id;
        if( $model->save()){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->student->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        }    
    }

    public function actionEnable($id)
    {
        $model= $this->findModel($id);
        $model->student->status = 10;
        $model->student->save();
        $this->view->params['customParam'] = $id;
        if( $model->save()){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->student->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        } 
    }
}
