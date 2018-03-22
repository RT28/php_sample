<?php

namespace partner\modules\consultant\controllers;

use Yii;
use common\models\Tasks;  
use partner\modules\consultant\models\TasksSearch;
use common\models\TaskCategory;
use common\models\TaskList; 
use common\models\TaskComment;
use common\models\StudentConsultantRelation;
use backend\models\SiteConfig;
use common\models\Student;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl; 
use common\components\AccessRule;
use common\components\Roles; 
use common\models\FileUpload;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\components\ConnectionSettings;
use common\components\CalendarEvents;
use common\models\Invoice;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use frontend\models\UserLogin;
use common\components\Commondata;
use frontend\models\StudentNotifications;

class TasksController extends Controller
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
							'actions' => ['index', 'create','view', 'update', 'delete','download',
							'subcat', 'list', 'getdetail', 'reminder', 'getparentemail'],
							'allow' => true, 
							'roles' => [Roles::ROLE_CONSULTANT]
					], 
							
                    ],
                   
            ],
           
        ];
    } 
    /**
     * Lists all StudentTasks models.
     * @return mixed
     */
	 
    public function actionIndex()
    {
		 Yii::$app->view->params['activeTab'] = 'tasks';
        
         
		$id = Yii::$app->user->identity->id;   
		$searchModel = new TasksSearch(); 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 
 
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'TaskStatus' => Tasks::TaskStatus(), 
			'TaskActions' => Tasks::TaskActions(),
			'TaskResponsbility' => Tasks::TaskResponsbility(),
			'TaskSpecificAlert' => Tasks::TaskSpecificAlert(), 
			'VerificationByCounselor' => Tasks::TaskVerificationByCounselor(),
			'students' => $this->getAllAssignedStudent(),
        ]);
    }

    
    public function actionView()
    {
		$id=$_POST['id'];
		$model = $this->findModel($id);
 
 
		//$status = Tasks::TaskStatus();
		
		//$taskStatus = $this->getStatus($status);
		 
	 
        return $this->renderAjax('view', [
            'model' => $model, 
        ]);
    }

	/* private function getStatus($status,$values)
    {
		$data = explode(',',$values);
		foreach($data as $value){
			if (array_key_exists($value, $status)) {
			$status []=  $status[$value];
		}
		} 
		
		return $status;
		
	}*/
 
    public function actionCreate()
    {
		//Yii::$app->view->params['activeTab'] = 'tasks';
        $model = new Tasks();
		$upload = new FileUpload();
		$id = Yii::$app->user->identity->id; 
		$consultant_id = Yii::$app->user->identity->id;
		$student_id= '';		
		if(isset($_REQUEST['id'])){
				  $student_id = $_REQUEST['id'];
			 }
		 if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			 
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
				return Json::encode(ActiveForm::validate($model)); 
			
		 } 
	  if ($model->load(Yii::$app->request->post())) {
				$sid = $_POST['student_id'];
				$model->consultant_id = $consultant_id; 
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate('Y-m-d H:i:s');
				$model->updated_at = gmdate('Y-m-d H:i:s');
	 
				if(empty($_POST['Tasks']['standard_alert'])) {
					$model->standard_alert =  1;
				}
				if(empty($_POST['Tasks']['specific_alert'])) {
				$model->specific_alert =  1;
				} 
				if(isset($_POST['Tasks']['notified'])) {
					$model->notified = implode(',', $_POST['Tasks']['notified']);
				}
							 
				if(!empty($model->task_list_id) || $model->task_list_id!=0){
					$task = TaskList::find()->where(['=', 'id', $model->task_list_id])->one();
					$model->title = $task->name;
				} 
				$model->action =0;
				$model->status =0;
				$model->verifybycounselor =0;
				 
				
				if($model->save()){
				 
					$comment = new TaskComment();
					$comment->task_id =$model->id;
					$comment->student_id = 0;
					$comment->consultant_id =$model->consultant_id;
					$comment->action =0;
					$comment->status =0;
					$comment->comment =$model->comments; 
					$comment->created_by = $model->updated_by;
					$comment->created_at = $model->updated_at;
					$comment->save();

					$message  = "New task ". $model->title." assigned to you";
					$notification = new StudentNotifications(); 
					$notification->student_id = 24;
					$notification->from_id = $model->consultant_id;
					$notification->from_role = Roles::ROLE_CONSULTANT;
					$notification->message = $message;
					$notification->timestamp =  gmdate('Y-m-d H:i:s');
					$notification->created_by = Yii::$app->user->identity->username;
					$notification->updated_by = Yii::$app->user->identity->username;
					$notification->created_at = gmdate('Y-m-d H:i:s');
					$notification->updated_at = gmdate('Y-m-d H:i:s');
					$notification->save(false); 
					
					

					CalendarEvents::assignTaskcalender($model, $consultant_id, Roles::ROLE_STUDENT,CalendarEvents::TYPE_TASK,CalendarEvents::MODE_SKYPE); 
					 
					  Yii::$app->getSession()->setFlash('Success', 'Task has been created.');  
				}else{
					Yii::$app->getSession()->setFlash('Error', 'Task was not created.'); 
				}
				
				return $this->redirect(['index']);
			 	
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
				'TaskCategories' => TaskCategory::getAllTaskCategories(),
				'TasksList' => TaskList::getAllTaskList(),
				'upload' => $upload,
				'TaskStatus' => Tasks::TaskStatus(),
				'TaskActions' => Tasks::TaskActions(),
				'TaskResponsbility' => Tasks::TaskResponsbility(),
				'TaskSpecificAlert' => Tasks::TaskSpecificAlert(), 
				'students' => $this->getAllAssignedStudent(),
				'VerificationByCounselor' => Tasks::TaskVerificationByCounselor(),
				'student_id' => $student_id,
            ]);
        }
    }
 
   public function actionUpdate($id)
    {
		 
		$consultant_id = Yii::$app->user->identity->id;
		Yii::$app->view->params['activeTab'] = 'tasks';
        $model = $this->findModel($id);
		$upload = new FileUpload();
  
		 if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
				return Json::encode(ActiveForm::validate($model)); 
			
		 }  
		  
          if ($model->load(Yii::$app->request->post())) {
			$model->consultant_id = Yii::$app->user->identity->id; 
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_at = gmdate('Y-m-d H:i:s');
			
			if(empty($_POST['Tasks']['standard_alert'])) {
					$model->standard_alert =  1;
			}
			if(empty($_POST['Tasks']['specific_alert'])) {
					$model->specific_alert =  1;
			} 
			
			if(isset($_POST['Tasks']['notified'])) {
                $model->notified = implode(',', $_POST['Tasks']['notified']);
			}
			
			if(!empty($model->task_list_id) || $model->task_list_id!=0){
				$task = TaskList::find()->where(['=', 'id', $model->task_list_id])->one();
				$model->title = $task->name; 
			}
			
		 
			if($model->save()){
				
					  
				if($model->task_list_id==Tasks::getGenerateInvoiceTaskListId() && $model->action==2){
					$this->assignInvoiceTask($model, $consultant_id);
				}				
				 
			
				$comment = new TaskComment();
				$comment->task_id =$model->id;
				$comment->student_id = 0;
				$comment->consultant_id =$model->consultant_id;
				$comment->action =$model->action;
				$comment->status =$model->status; 
				$comment->comment =$model->comments;
				$comment->created_by = $model->updated_by;
			 	$comment->created_at = $model->updated_at;
				$comment->save();
				$subject = 'Task has been updated.'; 
				CalendarEvents::assignTaskcalender($model, $consultant_id, Roles::ROLE_STUDENT,CalendarEvents::TYPE_TASK,CalendarEvents::MODE_SKYPE);
				//$this->sendMail($model,$subject);
		 
				 //$this->saveUploadAttachment($upload, $model);
				 Yii::$app->getSession()->setFlash('Success', 'Task has been updated.'); 
			}else{
					Yii::$app->getSession()->setFlash('Error', 'Task was not updated.'); 
			}
			 
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
				'TaskCategories' => TaskCategory::getAllTaskCategories(),
				'TasksList' => TaskList::getAllTaskList(),
				'upload' => $upload,
				'TaskStatus' => Tasks::TaskStatus(),
				'TaskActions' => Tasks::TaskActions(),
				'TaskResponsbility' => Tasks::TaskResponsbility(),
				'TaskSpecificAlert' => Tasks::TaskSpecificAlert(), 
				'VerificationByCounselor' => Tasks::TaskVerificationByCounselor(),
				'students' => $this->getAllAssignedStudent(),
				'student_id' => $model->student_id,
            ]);
        }
    }
	private function assignInvoiceTask($model, $consultant_id){
		
		$chktask = Tasks::find()->where('tasks.student_id ='.$model->student_id.' AND tasks.consultant_id ='.$consultant_id.' AND tasks.task_list_id = 24 AND tasks.task_category_id = 8')->one();

			 if(empty($chktask)){
				 $chktask =  new Tasks();
			 }
			
			
			$chktask->student_id = $model->student_id;
			$chktask->consultant_id = $consultant_id;
			$chktask->task_category_id = 8;
			$chktask->task_list_id = 24;
			$chktask->title = 'Invoice Management';		
			$chktask->description ='Invoice Management Task';		
			$chktask->notified = "1,2";
			$chktask->standard_alert =  1;  
			$chktask->specific_alert =  1;
			$chktask->responsibility = Tasks::RESPONSIBILITY_CONSULTANT;
			$chktask->others = '';
			$chktask->due_date = '';
			$chktask->action =0;
			$chktask->status =0;
			$chktask->verifybycounselor =0;
			$chktask->comments = 'Raise Invoice requisition to GTU.';			
			 
			$chktask->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$chktask->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$chktask->created_at = gmdate('Y-m-d H:i:s');
			$chktask->updated_at = gmdate('Y-m-d H:i:s'); 
			 
			if($chktask->save()){
			   
				$invoice = new Invoice();
				$invoice->student_id = $model->student_id;
				$invoice->consultant_id = $consultant_id;
				$invoice->agency_id = 1; 
				$invoice->created_by = Yii::$app->user->identity->id;
				$invoice->updated_by = Yii::$app->user->identity->id;
				$invoice->created_at = gmdate('Y-m-d H:i:s');
				$invoice->updated_at = gmdate('Y-m-d H:i:s');
				$datetimeStr = gmdate('Y-m-d H:i:s');
				$datetime = strtotime($datetimeStr); 
				$invoice->refer_number = 'GT'.$datetime.rand(10,100);
				$invoice->save(false); 
			
			}
		 
	}
	
	private function sendMail($model, $subject){
	
	$Toemail = array();	
	$cc= array();
	$studentProfile = Student::find()->where(['=', 'student_id', $model->student_id])->one();
	$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

	$Toemail[] = $studentProfile->email; 
	if(!empty($model->notified)){
		$notifiedTo = 	explode(',',$model->notified);
		
		if(in_array(3, $notifiedTo)){ 
			if(!empty($studentProfile->father_email)){
				$cc[] = $studentProfile->father_email; 
			}
			if(!empty($studentProfile->mother_email)){
				$cc[] = $studentProfile->mother_email; 
			}
		}
		if(in_array(4, $notifiedTo)){ 
			if(!empty($model->additional)){
				$cc[] = $model->additional; 
			}
		}
	} 
	 
	$cc[] = Yii::$app->user->identity->consultant->email;  
	
	$catName = '';
	$masterCategory = TaskCategory::find()->where(['=', 'id', $model->task_category_id])->one();
	if(!empty($masterCategory)){
		$catName = $masterCategory->name;
	}

	$ListName = '';
	$taskList = TaskList::find()->where(['=', 'id', $model->task_list_id])->one();
	if(!empty($taskList)){
		$ListName = $taskList->name;
	}
 
	    $cc[] = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();		
		//$Toemail =  implode(',',$Toemail); 
		 
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/task_by_consultant'],
			['studentname' => $studentname,
			 'catName' =>$catName,
			 'ListName' =>$ListName,
			 'model' =>$model,
			])
			->setFrom($from)
			->setTo($Toemail)
			->setCc($cc)
			->setSubject($subject);
	 
		 if($mail->send()){
			 return true;
		 }else{
			  return false;
		 } 
			
   }

	private function getAllAssignedStudent() {
		 $id = Yii::$app->user->identity->id;  
		$students = StudentConsultantRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_consultant_relation.student_id') 
		->where('student_consultant_relation.consultant_id = '.$id . ' OR 
		student_consultant_relation.parent_consultant_id = '.$id . ' AND
		user_login.status = '.UserLogin::STATUS_SUBSCRIBED)
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
	private function saveUploadAttachment($upload, $model) {
        $newFile = UploadedFile::getInstance($upload, 'attachment');
	 
        if (isset($newFile)) {
            $upload->attachment = $newFile;
			//$filename = $upload->uploadConsultantTask($model);			
         	 
			if(isset($filename)){
		
            if(!empty($model)) {			 
					$model->updated_by = Yii::$app->user->identity->id;
					$model->updated_at = gmdate('Y-m-d H:i:s'); 
					$model->attachment = $filename; 
					$model->save(false); 
			} 	    
					return true;
            } else {
                return false;
            }
        }
        return true;
    }
	
	 

	public function actionDownload($id,$name) {
        ini_set('max_execution_time', 5*60); // 5 minutes
		$filepath = Yii::getAlias('@frontend'); 
        $fileName = $name;
        if (is_dir($filepath."/web/uploads/tasks/$id")) {
            $path = FileHelper::findFiles($filepath."/web/uploads/tasks/$id", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
        }
    }
	
	public function actionReminder($id) {
		 
		$model = $this->findModel($id);
		$subject= 'Task Reminder';
		  
		  /* if($this->sendMail($model,$subject)) {
				  
				 return 'Reminder sent.';
		   }else {
			   return 'Error in sending Reminder.';
        
		  }*/ 
		   if($this->sendMail($model,$subject)==true) {
			  
				 return json_encode(['status' => 'success', 'message' => 'Reminder sent.']);
				 exit;
		   }else{ 
			   return json_encode(['status' => 'error', 'message' => 'Error in sending Reminder.']);
			   exit;
		   }
    }
	 
	
    public function actionDelete($id)
    { 
		 $id = Commondata::encrypt_decrypt('decrypt', $id);
	
		$model = $this->findModel($id);
		$comments =  TaskComment::find()->where('task_id  ='.$id)->all();
		 
		foreach($comments as $comment)
		{
			$comment->delete();
		}	 
		
		
		//$comments->deleteAll();

        if($model->delete()){
			$subject = 'Task has been removed from your Task list.'; 
			$this->sendMail($model,$subject);
			Yii::$app->getSession()->setFlash('Success', 'Task has been removed from your task list.'); 
		}else{
			Yii::$app->getSession()->setFlash('Error', 'Task was not removed from your task list.');
		}

        return $this->redirect(['index']);
    }
	
	public function actionList() {
        if (isset($_POST['task_category_id'])) {
           $task_category_id = $_POST['task_category_id']; 
            $majors = TaskList::find()->where(['=', 'task_category_id', $task_category_id])->all();
           
		   return Json::encode(['result'=>$majors, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }

    public function actionSubcat() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $cat_id = $parents[0];
                $selected = '';

                $out = TaskList::find()
                ->where(['task_category_id'=>$cat_id])
                ->select(['id as id','name as name'])
                ->orderBy('name')
                ->asArray()->all();
				if(!empty($out)){
					array_push($out,['id'=>'0', 'name'=>'Others']);  
				}
                echo Json::encode(['output'=>$out, 'selected'=>'selected']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

   	public function actionGetdetail($id) {
        if (isset($id)) { 
            $TaskList = TaskList::find()->where(['=', 'id', $id])->one();
           $detail = "<label class='control-label' >Description </label> <br>".$TaskList->description.
					 "<label class='control-label' >How to Complete </label> <br>".$TaskList->how_to_complete;
		   return Json::encode(['result'=>$detail, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }
    public function actionGetparentemail() {
    	$id = $_POST['id'];
        if (isset($id)) {
            $StudentDet = Student::find()->where(['=', 'id', $id])->one();
           $detail = "<input type='checkbox' name='f_select' checked='checked'><input type='text' name='father_email' id='father_email' value='$StudentDet->father_email'>
					  <input type='checkbox' name='m_select' checked='checked'><input type='text' name='mother_email' id='mother_email' value='$StudentDet->mother_email'>";
           return Json::encode(['result'=>$detail, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }
	
	
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
		public function beforeAction($action)
    {            
        if ($action->id == 'subcat' ) {
            Yii::$app->controller->enableCsrfValidation = false;        
			}
			
        return parent::beforeAction($action);
    }
}

