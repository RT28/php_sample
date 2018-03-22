<?php
namespace partner\modules\consultant\controllers;

use Yii;  
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper; 
use yii\filters\AccessControl;
use yii\filters\VerbFilter;  
use common\models\Consultant; 
use frontend\models\StudentNotifications;
use common\models\StudentConsultantRelation;
use common\models\StudentPartneremployeeRelation;
use common\models\Student;
use common\models\Country; 
use common\models\Degree;
use common\models\Majors;
use common\models\User;
use common\models\PackageType;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentStandardTestDetail;
use common\models\StudentPackageDetails;
use common\components\ConnectionSettings;
use common\components\AccessRule;
use common\components\Roles;
use partner\models\StudentAssignPackages;
use backend\models\SiteConfig;
use frontend\models\UserLogin; 
use partner\modules\consultant\models\StudentSearch;
use partner\modules\consultant\models\StudentStatusSearch; 
use common\models\StudentFavouriteUniversities; 
use common\models\StudentFavouriteCourses; 
use common\models\UniversityCourseList; 
use partner\modules\consultant\models\TasksSearch;
use frontend\models\StudentCalendar; 
use yii\data\ActiveDataProvider; 
use common\models\Tasks; 
use common\models\TaskComment;
use common\models\TaskList;
use yii\db\ActiveQuery;
use yii\db\Expression; 
use yii\db\Command;
use common\models\FileUpload; 
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use common\models\DocumentTypes;
use common\models\StudentDocument;
use common\components\Model;
use common\components\Commondata;
use common\models\AccessList; 
use common\models\University; 
use common\models\DegreeLevel; 
use yii\web\NotFoundHttpException;
use partner\modules\consultant\models\ShortlistUniversities;
use yii\web\ForbiddenHttpException; 



class StudentsController extends \yii\web\Controller
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
						'actions' => ['index', 'view', 'status',  'download',
									'assign-package', 'update','deletedocument','upload-documents','getdocumentlist', 'activation-link', 'download-all', 'connect-disconnect-associate',  'tests','change-package-limt', 'disconnect','add-event','shortlistuniversities','shortlistprograms','dependent-courses','getuniversitieslist','getprograms','getdegreelevellist','remove-from-shortlist','calendar'],
						'allow' => true, 
						'roles' => [Roles::ROLE_CONSULTANT]
					], 
							
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
	
	public function beforeAction($action)
    { 
	if($action->id){     
		$accessAuth = AccessList::accessActions($action->id);
		if($accessAuth == false){    
			  throw new ForbiddenHttpException("Sorry, you don't have permission to view this page.");
		}	
	}
	
	return parent::beforeAction($action);
		
    }
	 
	
    public function actionIndex() { 
		
		Yii::$app->view->params['activeTab'] = 'students';
	
		$searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        	$id = Yii::$app->user->identity->id;
        	$consultant_logged = Consultant::find()->where(['consultant_id'=>$id])->one();
            $consultant_logged->logged_status = 1;
            $consultant_logged->last_active = gmdate('Y-m-d H:i:s');                
            $consultant_logged->save(false);
		 
		return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider 
        ]);
    }
	
	public function actionUpdate($id)
    {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		
        $model = $this->findModel($id);
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $upload = new FileUpload();

		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
			return Json::encode(ActiveForm::validate($model)); 

		} 
	 
          if ($model->load(Yii::$app->request->post())) {
		 
			$dob =strtotime($model->date_of_birth);
		    $model->date_of_birth = date('Y-m-d',$dob);
			 
            if($model->save()) { 
				$id = Commondata::encrypt_decrypt('encrypt', $model->id);
                return $this->redirect(['view', 'id' => $id ]);
            }
          
        }  else {
               return $this->renderAjax('update', [
                'model' => $model,
                'countries' => $countries,
                'upload' => $upload
            ]);
            }

         
    }
	
	 public function actionStatus() { 
	
		Yii::$app->view->params['activeTab'] = 'dashboard';
	
		$searchModel = new StudentStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
		 
		return $this->render('status', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
	
	

	public function actionAssignPackage($id) {
		
		$id = Commondata::encrypt_decrypt('decrypt', $id); 
		
		Yii::$app->view->params['activeTab'] = 'students';
        $model = User::findOne($id);
		$consultant_id = Yii::$app->user->identity->id; 
        $StudentAssignPackages = new StudentAssignPackages();

		if ($model->load(Yii::$app->request->post())) {
			$StudentAssignPackages->load(Yii::$app->request->post());
			    $StudentPD = StudentPackageDetails::find()->where(['AND',
				['=', 'student_id', $model->id],
				['=', 'package_type_id',$StudentAssignPackages->packagestype]]
				)->one();
				
				if(empty($StudentPD)) {
					 $StudentPD = new StudentPackageDetails();
				}	
				
				$StudentPD->student_id =  $model->id;
				$StudentPD->package_type_id =  $StudentAssignPackages->packagestype;  
				$StudentPD->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$StudentPD->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$StudentPD->created_at = gmdate('Y-m-d H:i:s');
				$StudentPD->updated_at = gmdate('Y-m-d H:i:s');
				
				$consultantname = Yii::$app->user->identity->consultant->first_name.' '.Yii::$app->user->identity->consultant->last_name;
			 
				
				if($StudentPD->save(false)){
					
					//$model->access_code = $model->access_code;
					$model->status = UserLogin::STATUS_ACCESS_SENT;
					$model->comment = $model->comment;
					$model->save(false); 
					$message = "Packages Assigned to you.";
				if(!empty($StudentAssignPackages->packagestype)){
					$pacakeges = PackageType::getPackageType();
					$pacakgeName = $pacakeges[$StudentAssignPackages->packagestype]; 
					 $message  = $pacakgeName." assigned to you";;
				}
			
			 
				$notification = new StudentNotifications(); 
				$notification->student_id = $model->id;
				$notification->from_id = $consultant_id;
				$notification->from_role = Roles::ROLE_CONSULTANT;
				$notification->message = $message;
				$notification->timestamp =  gmdate('Y-m-d H:i:s');
				$notification->created_by = Yii::$app->user->identity->username;
				$notification->updated_by = Yii::$app->user->identity->username;
				$notification->created_at = gmdate('Y-m-d H:i:s');
				$notification->updated_at = gmdate('Y-m-d H:i:s');
				$notification->save(false); 
				
					$tasklist = TaskList::find()
					->leftJoin('task_category', 'task_category.id =  task_list.task_category_id')
					->where('task_list.auto_assign =1')	->all();
		
		if(count($tasklist)>0){ 
	 
		foreach($tasklist as $task){ 
		
		
		
		$chktask = Tasks::find()->where('tasks.student_id ='.$model->id.' AND tasks.task_list_id = '.$task->id)		
		->one();
			 
			 if(empty($chktask)){
				 $chktask =  new Tasks();
			 }
			
			
			$chktask->student_id = $model->id;
			$chktask->consultant_id = $consultant_id;
			$chktask->task_category_id = $task->task_category_id;
			$chktask->task_list_id = $task->id;
			$chktask->title = $task->name; 
			$chktask->description = $task->name; 
			$chktask->notified = "1,2";
			$chktask->standard_alert =  1;  
			$chktask->responsibility = 0;
			$chktask->others = '';
			$chktask->due_date = '';
			$chktask->action =0;
			$chktask->status =0;
			$chktask->verifybycounselor =0;
			$chktask->comments = 'Automatically Task assigned.';			
			 
			$chktask->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$chktask->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$chktask->created_at = gmdate('Y-m-d H:i:s');
			$chktask->updated_at = gmdate('Y-m-d H:i:s');  
			$chktask->save();
			
			/*if($chktask->save()){
			 
				$comment = new TaskComment();
				$comment->task_id =$chktask->id;
				$comment->student_id =$chktask->student_id;
				$comment->consultant_id = $consultant_id;
				$comment->action =0;
				$comment->status =0;
				$comment->comment =$chktask->comments;
				$comment->created_by = $chktask->updated_by;
				$comment->created_at = $chktask->updated_at;
				$comment->save();  
			}*/
		
		}
		
		}
	  
				
				    $packagestype = $StudentPD->package_type_id ;
					$user = $model->first_name. ' '.  $model->last_name; 

					if($this->sendActivationLink($model->id, $model->email, $user,$consultantname,$packagestype)) {
						$link = "index.php?r=consultant/leads/index&status=3";
                        return $this->redirect($link);
						/*return $this->render('assign-package', [
						'model' => $model, 
						'StudentAssignPackages' => $StudentAssignPackages,
						'packages' =>  PackageType::getPackageType(),
						'status' => 'success', 'id' => $model->id]);*/
					}
				}	
			  
		}	 
        return $this->render('assign-package', [
            'model' => $model, 
			'StudentAssignPackages' => $StudentAssignPackages, 			
            'packages' =>  PackageType::getPackageType(),
        ]);
    }

	private function sendActivationLink($id, $email,$name,$consultantname,$packagestype) {
		$cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();	
				
        $time = time();
        Yii::$app->mailer->compose(['html' => '@common/mail/dashboard_access'],[
                'user' => $name,
				'consultantname' => $consultantname,
				'packagestype' => $packagestype,
                'link' => ConnectionSettings::BASE_URL . 'site/activate-dashboard?id=' . $id . '&ptid=' . $packagestype . '&timestamp=' . strtotime('+2 days', $time),
            ])
            ->setFrom($from)
            ->setTo($email)
			->setCc($cc)
            ->setSubject('GoToUniversity Dashboard Access Link')
            ->send();
        return true;
    }
	
    public function actionView($id) {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		
		Yii::$app->view->params['activeTab'] = 'students';
		$consultant_id = Yii::$app->user->identity->id; 


        $model = Student::findOne($id);
		$student = $model->student_id;
		
        $englishTests = StudentEnglishLanguageProficienceyDetails::find()->where(['=', 'student_id', $student])->all();
        $standardTests = StudentStandardTestDetail::find()->where(['=', 'student_id', $student])->all();
         
		
		$associates = StudentConsultantRelation::find()->where(['AND',
		['=','student_id', $student], 
		['=','parent_consultant_id', $consultant_id],
		['=','is_sub_consultant', 1], 
		])->all(); 
		 
		$employees = StudentPartneremployeeRelation::find()->where(['AND',
		['=','student_id', $student], 
		['=','consultant_id', $consultant_id],
		])->all();
		
		$packages = StudentPackageDetails::find()->where(['=', 'student_id', $student])->all();

		$shortlistedCourses = StudentFavouriteCourses::find()->where(['=', 'student_id', $student])->orderBy(['id' => SORT_DESC])->all();

		$shortlistedUni = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$student,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all();
		
		$meeting = StudentCalendar::find()->where(['=', 'student_id', $student])->orderBy(['id' => SORT_DESC])->all();

		 
		$taskModel = new TasksSearch();
		$taskModel->student_id = $student;
        $taskdataProvider = $taskModel->search(Yii::$app->request->queryParams);
		 
		$query = "SELECT * FROM student_document where student_id='$student'";

        $studentDocumentModel = StudentDocument::findBySql($query)->all();
		
		$query1 = "SELECT sd.document_type_id,dt.document_name FROM student_document AS sd INNER JOIN `document_types` AS dt ON sd.document_type_id=dt.document_id WHERE sd.student_id='$student' GROUP BY sd.document_type_id";

        $studentDocumentModel = StudentDocument::findBySql($query)->all();
		
		$documentTypeModel = StudentDocument::findBySql($query1)->all();
		
		
        return $this->render('view', [
            'model' => $model,
            'englishTests' => $englishTests,
            'standardTests' => $standardTests,
            'associates' => $associates, 
			'employees' => $employees, 
            'packages' => $packages,
			'shortlistedCourses' => $shortlistedCourses,
			'shortlistedUni' => $shortlistedUni,
			'taskModel' => $taskModel,
            'taskdataProvider' => $taskdataProvider, 
			'meeting' => $meeting,
			'stud_documentlist' => $studentDocumentModel,
			'documenttype' => $documentTypeModel,
			'asd' => 'asd',
			 
        ]);
    }

    public function actionDownload($id) {
		Yii::$app->view->params['activeTab'] = 'students';
        $fileName = $_GET['name'];
        if (is_dir("./../../frontend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../frontend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
              return  Yii::$app->response->sendFile($path[0]);
            }
        }else{
			 echo json_encode(['error']);
             return;
		}
		
		 
    }

	 public function actionDownloadAll($id) {
        
        if (is_dir("./../../frontend/web/uploads/$id")) {
            $path = FileHelper::findFiles("./../../frontend/web/uploads/$id", [
                'caseSensitive' => false,
                'recursive' => true,
            ]);
            if(count($path) > 0) {
                $files = $path;
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
	
  

    public function actionConnectDisconnectAssociate() {
		
		Yii::$app->view->params['activeTab'] = 'students';
        $consultant = $_POST['consultant'];
        $student = $_POST['student'];
		$astatus = $_POST['astatus'];
 		
        $model = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $student], ['=', 'consultant_id', $consultant]])->one();
 
 
		 if($astatus == 1){
			$astatus = 0; 
		 }elseif($astatus == 0){
			$astatus = 1; 
		 }else{
			 $astatus = 0; 
		 }
  
		$model->status = $astatus; 
        if($model->save(false)) {
            return json_encode(['status' => 'success' , 'astatus' => $astatus, 'message' => 'Associate Consultant status is updated.']);
        }else{
			 return json_encode(['status' => 'error', 'messsage' => 'Error in updating status.']);
		}
		
       
    } 
    

    public function actionChangePackageLimt() {
		
		Yii::$app->view->params['activeTab'] = 'students';
		
        $id = $_POST['id'];
        $value = $_POST['value'];

        $model = StudentPackageDetails::findOne($id);

        if(empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Package details not found']);
        }

        $model->limit_pending = $value;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_at = gmdate('Y-m-d H:i:s');

        if($model->save()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'message' => 'Error saving changes']);
    }

    public function actionDisconnect() {
		
		Yii::$app->view->params['activeTab'] = 'students';
		
        $student = $_POST['student'];
        $id = Yii::$app->user->identity->id;

        // disconnect all accosiates first.

        $associates = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]])->all();

        if(sizeof($associates) > 0) {
            $transaction = \Yii::$app->db->beginTransaction();
            $count = StudentConsultantRelation::deleteAll(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]]);
            if ($count == sizeof($associates)) {
                $model = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $student], ['=', 'consultant_id', Yii::$app->user->identity->id]])->one();
                if(empty($model)) {
                    $transaction->rollBack();
                    return json_encode(['status' => 'error', 'message' => 'Error disconneting consultant. No relation found']);
                }
                if ($model->delete()) {
                    $transaction->commit();
                    return json_encode(['status' => 'success']);
                }
                $transaction->rollBack();
                return json_encode(['status' => 'error', 'message' => 'Error disconneting consultant. No relation found']);
            } else {
                $transaction->rollBack();
                return json_encode(['status' => 'error', 'message' => 'Error disconnecting one or more associates']);
            }
        }
    }
	
	
	 public function actionUploadDocuments() {
        
		$data = Yii::$app->request->post();
		$student = $data['student_id'];
		$message=array();
        $i = 102; 
        $result = is_dir("./../../frontend/web/uploads/$student/documents");
        if (!$result) {
            FileHelper::createDirectory("./../../frontend/web/uploads/$student/documents");
        }
		 
	
        while(isset($_FILES["document-".$i])) {
			
			if($_FILES["document-".$i]['error'] === 0) {
                $sourcePath = $_FILES["document-".$i]['tmp_name'];
				//$name=$_FILES["document-".$i]['name'];
				$rand= rand(4,1000);
				$name=$rand.'_'.$_FILES["document-".$i]['name'];
                $ext = pathinfo($_FILES["document-".$i]['name'], PATHINFO_EXTENSION);
                //$targetPath = "./../web/uploads/$student/documents/" . $_POST["test-" . $i] .'.'. $ext; // Target path where file is to be stored
				
				$targetPath = "./../../frontend/web/uploads/$student/documents/".$name; // Target path where file is to be stored
				
                if(move_uploaded_file($sourcePath,$targetPath)) {
				/****************************
				   @Created by: Pankaj
				   @Use :- Student document list is inserting in student_document table.
				   **************************/
					$model = new StudentDocument();
					$model->student_id = $student;
					$model->document_type_id = $data['document_type_id_'.$i];
					$model->document_name = $data['test-'.$i];
					$model->document_file = $name;
					$model->created_at = gmdate('Y-m-d H:i:s');
					$model->save();
					/*end*/
					 
					Yii::$app->getSession()->setFlash('Success', 'Documents uploaded successfully.');  
                }
                else { 
                   Yii::$app->getSession()->setFlash('Error', 'Error in Document upload.'); 
                }
            }
            $i++;
        }
		 
		return $this->redirect(['view','id'=>$student,'#'=>'documents']); 
    }
	
  
	 public function actionDeletedocument() {
        ini_set('max_execution_time', 5*60); // 5 minutes
		
        $message=array();
		$data = Yii::$app->request->get();
	
		$fileName = $data['name'];
		$student_document_id = $data['studocuid'];
		$model = StudentDocument::findOne($student_document_id);
        $student = $model->student_id;
		
		if($student_document_id!="" && $fileName!=""){
		$path = "./../../frontend/web/uploads/$student/documents/$fileName.";
		
		
		$recordDeleted=$model->delete();
			if($recordDeleted){
				unlink($path);  
				Yii::$app->getSession()->setFlash('Success', 'Document has been deleted successfully.');
			}else{ 
				  Yii::$app->getSession()->setFlash('Error', 'Error in Delete Document.'); 
			}
		}
		return $this->redirect(['view','id'=>$student]); 
		  
    }
	
	public function actionGetdocumentlist(){
		
		$allArs = DocumentTypes::getAllDocumentList();
		echo json_encode($allArs);
		return;
		
	}
	
	
	 public function actionTests($id) {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		$student = Student::findOne($id);
		$model = $student;
		$standardTests = StudentStandardTestDetail::find()->where(['=', 'student_id', $student->student_id])->all(); 
    
        if(Yii::$app->request->post()) {
            $this->saveStandardDetails($standardTests, $student);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('standard_test_detail_form', [
                'model' => $model,
                'standardTests' => empty($standardTests) ? [new StudentStandardTestDetail] : $standardTests,
            ]);
        }
        return $this->renderAjax('standard_test_detail_form', [
            'model' => $model,
            'standardTests' => empty($standardTests) ? [new StudentStandardTestDetail] : $standardTests,
            'layout' => 'index'
        ]);
    }
	
	private function saveStandardDetails($tests, $student) {
		$consultant_id = Yii::$app->user->identity->consultant->consultant_id; 
        $oldIDs = ArrayHelper::map($tests, 'id', 'id');
        $tests = Model::createMultiple(StudentStandardTestDetail::classname(), $tests);
        $result = Model::loadMultiple($tests, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($tests, 'id', 'id')));
        $valid = Model::validateMultiple($tests, ['test_name', 'verbal_score', 'quantitative_score', 'integrated_reasoning_score', 'data_interpretation_score']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentStandardTestDetail::deleteAll(['id' => $deletedIDs]);
                }  
                foreach ($tests as $test) {
                    $test->student_id = $student->student_id;
                    $test->created_by = $consultant_id ; 
                    $test->updated_by = $consultant_id ;  
                    $test->created_at = gmdate('Y-m-d H:i:s');
                    $test->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $test->save(false))) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
					$id = Commondata::encrypt_decrypt('encrypt', $student->id);
                    return $this->redirect(['view','id'=>$id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
    }
	
	public function actionShortlistuniversities($id) {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		$student = Student::findOne($id);
		$model = $student;
		$student_id = $model->student_id;
		$favuni = new StudentFavouriteUniversities(); 
		$shortlistedUni = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$student_id,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all(); 
	  
		$universities = University::find()->orderBy(['name' => 'ASC'])->all();
		$universitiesList = ArrayHelper::map($universities, 'id', 'name');
		$favuniversities = ArrayHelper::map($shortlistedUni, 'university_id', 'university_id');
	 
        if(Yii::$app->request->post()) {
		 
		if(isset($_POST['StudentFavouriteUniversities']['universities']))
		{
			$postedData = $_POST['StudentFavouriteUniversities']['universities'];
			$this->saveUniversities($shortlistedUni, $student,$postedData);
		  
		}  
        }     
         
        return $this->renderAjax('shortlistuniversities', [
            'model' => $model,
			'favuniversities' => $favuniversities,
			'favuni' => $favuni,
			'universitiesList' => $universitiesList ,
			'shortlistedUni' => $shortlistedUni 
        ]);
    }
	
	
	private function saveUniversities($shortlistedUni, $student,$postedData) {
		$consultant_id = Yii::$app->user->identity->consultant->consultant_id; 
	 
        $oldIDs = ArrayHelper::map($shortlistedUni, 'id', 'id');
	
        $shortlistedUni = Model::createMultiple(StudentFavouriteUniversities::classname(), $shortlistedUni);
        $result = Model::loadMultiple($shortlistedUni, Yii::$app->request->post()); 
		if(isset($oldIDs)){
			$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($postedData, 'id', 'id')));
		 
		} 
         
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentFavouriteUniversities::deleteAll(['id' => $deletedIDs]);
                }   
	 
				foreach($postedData as $key=>$value){
					  
					$uni = new StudentFavouriteUniversities(); 
					$uni->student_id = $student->student_id;
					$uni->university_id = $value;
					$uni->favourite = 1;
					$uni->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
					$uni->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
					$uni->created_at = gmdate('Y-m-d H:i:s');
					$uni->updated_at = gmdate('Y-m-d H:i:s'); 
					 
					if (! ($flag = $uni->save(false))) {
						$transaction->rollBack();
						break;
					}  
				}
			 
                if ($flag) {
                    $transaction->commit();
					$id = Commondata::encrypt_decrypt('encrypt', $student->id);
                    return $this->redirect(['view','id'=>$id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
         
    }
	
	 
	 
	  public function actionShortlistprograms($id) {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		$student = Student::findOne($id);
		$model = $student; 
		$courses = StudentFavouriteCourses::find()->where(['=', 'student_id', $student->student_id])->all(); 
		$universities = University::find()->orderBy(['name' => 'ASC'])->all();
		$universitiesList = ArrayHelper::map($universities, 'id', 'name');

        if(Yii::$app->request->post()) { 
             $this->savePrograms($courses, $student,$_POST); 
			 
        }
        
		if (Yii::$app->request->isAjax) {
            return $this->renderAjax('shortlistprograms', [
               'model' => $model,
			'universitiesList' => $universitiesList,
            'courses' => empty($courses) ? [new StudentFavouriteCourses] : $courses,
            ]);
        }

        return $this->renderAjax('shortlistprograms', [
            'model' => $model,
			'universitiesList' => $universitiesList,
            'courses' => empty($courses) ? [new StudentFavouriteCourses] : $courses, 
        ]);
    }
	
	
	private function savePrograms($courses, $student, $postData) {
		$consultant_id = Yii::$app->user->identity->consultant->consultant_id; 
		$student_id = $student->student_id;
        $oldIDs = ArrayHelper::map($courses, 'id', 'id');
		
        $courses = Model::createMultiple(StudentFavouriteCourses::classname(), $courses); 
		
		$coursesData  = array();
		$tocompare  = array();
	 
		$i = 1;
		$j = 0;
		if(isset($postData['document'])){
		foreach($postData as $row){			 
			if(isset($row[$i]['course_id'])){
				foreach($row[$i]['course_id'] as $key=>$value){
					$coursesData[$j]['university_id'] = $row[$i]['university_id'];
					$coursesData[$j]['course_id'] = $value;
					$tocompare[$j] = $value;
					$j++;
				}
			}
			$i++;
			
		} 
		}
		if(isset($tocompare)){
		$GetAllExistCourses = StudentFavouriteCourses::find()
								->where(['AND',
								['=', 'student_id', $student->student_id],
								['IN', 'course_id', $tocompare],
								])->all();
		}
		
        $result = Model::loadMultiple($GetAllExistCourses, Yii::$app->request->post());
		
		if(isset($oldIDs)){
			$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($GetAllExistCourses, 'id', 'course_id'))); 
		}
		
		/*echo "<pre>";		
		print_r($coursesData);
		print_r($tocompare);
		echo "-------------------";		
		print_r($oldIDs); 
		echo "-------------------";
		print_r($deletedIDs);
		echo "-------------------";
		print_r($GetAllExistCourses); 
		echo "</pre>"; */
		 
        echo $valid = Model::validateMultiple($GetAllExistCourses, ['university_id', 'course_id']);
	 
	 
		
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    StudentFavouriteCourses::deleteAll(['id' => $deletedIDs]);
                }  
				
                foreach ($coursesData as $getRow) {
					 $course = new StudentFavouriteCourses();
                    $course->student_id = $student_id;
					$course->university_id = $getRow['university_id'];
				    $course->course_id =  $getRow['course_id']; 
					$course->favourite = 1;
                    $course->created_by = $consultant_id ; 
                    $course->updated_by = $consultant_id ;  
                    $course->created_at = gmdate('Y-m-d H:i:s');
                    $course->updated_at = gmdate('Y-m-d H:i:s'); 
                     if (! ($flag = $course->save(false))) {
						
                        $transaction->rollBack();
                        break;
                    } 
                }
                if ($flag) {
                    $transaction->commit();
					$id = Commondata::encrypt_decrypt('encrypt', $student->id);
                    return $this->redirect(['view','id'=>$id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                echo 'Failure';
            }
        }
		
    }
	
	public function actionDependentCourses() {
	 
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $university = $parents[0];
                $courses = UniversityCourseList::getCoursesForUniversity($university);
                echo Json::encode(['output'=>$courses, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
	
	
	public function actionGetuniversitieslist(){
		 
		$universities = University::find()->orderBy(['name' => 'ASC'])->all();
		$universitiesList = ArrayHelper::map($universities, 'id', 'name'); 
		return   Json::encode($universitiesList);
	}
	
	public function actionGetdegreelevellist(){
		 
		$degreeLevels = DegreeLevel::getAllDegreeLevels();  
		return   Json::encode($degreeLevels);
	}
	
	 
	
	public function actionGetprograms(){
		 
		$courses = [];
		 if (isset($_POST['university'])) { 
			$university =  $_POST['university'];
			$degree_level =  $_POST['degree_level'];
			
			
		/*$courses = UniversityCourseList::findBySql('SELECT DISTINCT(ucl.name), ucl.id, ucl.name as coursename , degree.name as degreename , majors.name as majorname  FROM university_course_list as ucl 
		LEFT JOIN degree on degree.id = ucl.degree_id
		LEFT JOIN majors on majors.id = ucl.major_id
		WHERE university_id="' . $university . '" AND 
		degree_level_id = '.$degree_level.'
		order by degreename , majorname,  coursename')->all();

		echo "<pre>";
		print_r($courses);
		echo "</pre>";
		die; */
			 $courses =  UniversityCourseList::find()->select(['university_course_list.id','university_course_list.name','degree.name','majors.name',])->leftJoin('degree', '`degree`.`id` = `university_course_list`.`degree_id`') ->leftJoin('majors', '`majors`.`id` = `university_course_list`.`major_id`') 		->where(['AND',['university_id'=>$university],['degree_level_id'=>$degree_level]])->orderBy(['university_course_list.name' => 'ASC'])->all(); 
		 
		$num =  $_POST['num'];
		$programSelectBoxHtml = "<select id='course_id".$num."' name='document[".$num."][course_id][]' required multiple style=' width: 250px; height: 150px; ' ><option value=''>Select Program</option>"; 
		if(isset($courses)){
			foreach($courses as $course){ 
				$programSelectBoxHtml.= "<option value=".$course->id.">".$course->name."</option>";
			}
		$programSelectBoxHtml.= "</select>";
		
		}
		} 
        return  $programSelectBoxHtml;
	}
	
	 public function actionRemoveFromShortlist() {
        $id = $_POST['id'];

        $model = StudentFavouriteCourses::findOne($id);

        if(empty($model)) {
            return json_encode(['status' => 'failure', 'message' => 'Course does not exist.']);
        }

        if ($model->delete()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'failure', 'message' => 'Error deleting course.']);
    }
	public function actionCalendar(){
        Yii::$app->view->params['activeTab'] = 'calendar';
        return $this->render('calendar');
    }

	protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
