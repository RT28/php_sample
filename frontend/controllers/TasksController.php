<?php

namespace frontend\controllers;

use Yii;
use common\models\Tasks;
use common\models\Consultant;
use frontend\models\TasksSearch;
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
use common\components\Commondata;
use partner\models\TaskCommentSearch;
use common\models\ChatHistory;


 
class TasksController extends Controller
{
   

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(), 
                'rules' => [ 
                    [
                        'actions' => ['index','oldindex', 'view', 'download', 'reminder', 'update','delete', 'list','subcat','getchatcount','chatnotification'],
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
     * Lists all StudentTasks models.
     * @return mixed
     */
	 
    public function actionIndex()
    {
		 Yii::$app->view->params['activeTab'] = 'tasks';
        
         
		$id = Yii::$app->user->identity->student->id;   
		 
        $searchModel = new TasksSearch(); 		
		$query = TasksSearch::find()->where(['student_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	  	$tasks = Tasks::find()->where(['=', 'student_id', $id])
        ->andWhere(['!=', 'task_list_id', '24'])
        ->andWhere(['!=', 'due_date', 'NULL'])
        ->orderBy(['id' => 'ASC'])->all();
        return $this->render('task', [
        	'tasks' => $tasks,
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

    public function actionOldindex()
    {
		 Yii::$app->view->params['activeTab'] = 'tasks';
        
         
		$id = Yii::$app->user->identity->student->id;   
		 
        $searchModel = new TasksSearch(); 		
		$query = TasksSearch::find()->where(['student_id'=>$id]);
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
		Yii::$app->view->params['activeTab'] = 'tasks';
		
		 $id=$_GET['id'];
		 
		$model = $this->findModel($id); 
      	$searchModel = new TaskCommentSearch(); 		
	    $searchModel->task_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		return $this->renderAjax('view', [
			'model' => $model,
			'TaskCategories' => TaskCategory::getAllTaskCategories(),
			'TasksList' => TaskList::getAllTaskList(), 
			'TaskStatus' => Tasks::TaskStatus(),
			'TaskActions' => Tasks::TaskActions(),
			'TaskResponsbility' => Tasks::TaskResponsbility(),
			'TaskSpecificAlert' => Tasks::TaskSpecificAlert(), 
			'VerificationByCounselor' => Tasks::TaskVerificationByCounselor(),
			'students' => $this->getAllAssignedStudent(),
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
		]);
         
    }
 
 
   public function actionUpdate($id)
    {	
		Yii::$app->view->params['activeTab'] = 'tasks';
        $id = Commondata::encrypt_decrypt('decrypt', $id);
        $model = $this->findModel($id);
		$upload = new FileUpload();

		  
		  
        if ($model->load(Yii::$app->request->post())) {
			$model->student_id = Yii::$app->user->identity->student->id;
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_at = gmdate('Y-m-d H:i:s');
			
			if(isset($_POST['Tasks']['notified'])) {
                $model->notified = implode(',', $_POST['Tasks']['notified']);
			}
			
			if(!empty($model->task_list_id) || $model->task_list_id!=0){
				$task = TaskList::find()->where(['=', 'id', $model->task_list_id])->one();
				$model->title = $task->name;
			}
		 
			if($model->save(false)){
				
				$comment = new TaskComment();
				$comment->task_id =$model->id;
				$comment->student_id = $model->student_id;
				$comment->consultant_id = 0;
				$comment->action =$model->action;
				$comment->status =$model->status;
				$comment->comment =$model->comments;
				$comment->created_by = $model->updated_by;
			 	$comment->created_at = $model->updated_at;
				$comment->save(false);
				$subject = 'Task has been updated.'; 
				//$this->sendMail($model,$subject);
		 
				// $this->saveUploadAttachment($upload, $model);
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
            ]);
        }
    }
	
	private function sendMail($model, $subject){
	
	$Toemail = array();	
	$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
	$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

	$Toemail[] = $studentProfile->email; 
	if(!empty($model->notified)){
		$notifiedTo = 	explode(',',$model->notified);
		
		if(in_array(3, $notifiedTo)){ 
			if(!empty($studentProfile->father_email)){
				$Toemail[] = $studentProfile->father_email; 
			}
			if(!empty($studentProfile->mother_email)){
				$Toemail[] = $studentProfile->mother_email; 
			}
		}
		if(in_array(4, $notifiedTo)){ 
			if(!empty($model->additional)){
				$Toemail[] = $model->additional; 
			}
		}
	} 
	 
	$Toemail[] =  Yii::$app->user->identity->student->email;  
	
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
 
	    $cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();		
		//$Toemail =  implode(',',$Toemail); 
		 
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/task_by_student'],
			['studentname' => $studentname,
			 'catName' =>$catName,
			 'ListName' =>$ListName,
			 'model' =>$model,
			])
			->setFrom($from)
			->setTo($Toemail)
			->setCc($cc)
			->setSubject($subject);
	 
		 $mail->send(); 
			
   }

	private function getAllAssignedStudent() {
		$id = Yii::$app->user->identity->student->id;  
		$students = StudentConsultantRelation::find()->where(['=', 'student_id', $id])->all();
        
		$studentData = array();		
		$i = 0;				 
		foreach($students as $student){
 	
		$studentProfile = $student->student->student;	
		$studentData[$i]['id'] = $studentProfile->id;	
		$studentData[$i]['name'] = $studentProfile->id . ' - '. $studentProfile->first_name." ".$studentProfile->last_name;
		
		$i++;
		}
		 
		$studentList = ArrayHelper::map($studentData, 'id', 'name');
		return $studentList;
	}	
	private function saveUploadAttachment($upload, $model) {
        $newFile = UploadedFile::getInstance($upload, 'attachment');
	 
        if (isset($newFile)) {
            $upload->attachment = $newFile;
			$filename = $upload->uploadConsultantTask($model);			
         	 
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
	
	public function actionReminder() {
		$id = $_POST['id'];
		$model = $this->findModel($id);
		$subject= 'Task Reminder';
		 $send = false;
 
		   if($this->sendMail($model,$subject)) {
				 
		   } 
	      if($send ==true) {
			return json_encode(['status' => 'success', 'message' => 'Reminder sent.']);
        
          }
		  if($send ==false) {
			   return json_encode(['status' => 'error', 'message' => 'Error sending Reminder.']);
        
		  }
				
    }
	 
	
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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

   
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
        return json_encode(['student_chats' => $student_chats]);    
        
        }  
}

