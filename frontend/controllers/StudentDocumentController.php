<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use common\models\DocumentTypes;
use common\models\StudentDocument;
use common\components\AccessRule;
use yii\filters\AccessControl; 
use common\models\ChatHistory;
use common\components\Roles; 
use common\components\Commondata;
use common\models\Consultant;

/**
 * HomeSearchController
 */
class StudentDocumentController extends Controller
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
                        'actions' => ['index', 'upload-documents', 'download','deletedocument', 'download-all','getdocumentlist','chatnotification','getchatcount' ],
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
	
    public function actionIndex() {
        Yii::$app->view->params['activeTab'] = 'documents';
		 $student = Yii::$app->user->identity->id;
		$query = "SELECT * FROM student_document where student_id='$student'";

        $studentDocumentModel = StudentDocument::findBySql($query)->all();
		
		$query1 = "SELECT sd.document_type_id,dt.document_name FROM student_document AS sd INNER JOIN `document_types` AS dt ON sd.document_type_id=dt.document_id WHERE sd.student_id='$student' GROUP BY sd.document_type_id";

        $studentDocumentModel = StudentDocument::findBySql($query)->all();
		
		$documentTypeModel = StudentDocument::findBySql($query1)->all();

        
		
        return $this->render('index', [
            'stud_documentlist' => $studentDocumentModel,
			'documenttype' => $documentTypeModel
        ]);
    }
    public function actionUploadDocuments() {
        $student = Yii::$app->user->identity->id;
		$data = Yii::$app->request->post();
		$message=array();
        $i = 102;
        $result = is_dir("./../web/uploads/$student/documents");
        if (!$result) {
            FileHelper::createDirectory("./../web/uploads/$student/documents");
        }
        while(isset($_FILES["document-".$i])) {
			
			if($_FILES["document-".$i]['error'] === 0) {
                $sourcePath = $_FILES["document-".$i]['tmp_name'];
				//$name=$_FILES["document-".$i]['name'];
				$rand= rand(4,1000);
				$name=$rand.'_'.$_FILES["document-".$i]['name'];
                $ext = pathinfo($_FILES["document-".$i]['name'], PATHINFO_EXTENSION);
                //$targetPath = "./../web/uploads/$student/documents/" . $_POST["test-" . $i] .'.'. $ext; // Target path where file is to be stored
				
				$targetPath = "./../web/uploads/$student/documents/".$name; // Target path where file is to be stored
				
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
					
					$message=array('status' => 'success');
                }
                else {
                    echo json_encode(['status' => 'failure' ,'error' => 'Processing request ' . $sourcePath]);
                    return;
                }
            }
            $i++;
        }
		
		echo  json_encode($message);
       // echo json_encode(['status' => 'success']);
        return;
    }
    public function actionDownload() {
        ini_set('max_execution_time', 5*60); // 5 minutes
        $id = Yii::$app->user->identity->id;
        $fileName = $_GET['name'];
        if (is_dir("./../web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
        }
    }
    public function actionDownloadAll() {
        $id = Yii::$app->user->identity->id;
        if (is_dir("./../web/uploads/$id")) {
            $path = FileHelper::findFiles("./../web/uploads/$id", [
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
	/***********
		@Created By:- Pankaj
		@Use :- Delete Document from server
		**********/
	 public function actionDeletedocument() {
        ini_set('max_execution_time', 5*60); // 5 minutes
        $id = Yii::$app->user->identity->id;
        $message=array();
		$data = Yii::$app->request->get();
	
		$fileName = $data['name'];
		$student_document_id = $data['studocuid'];
		if($student_document_id!="" && $fileName!=""){
		$path = "../frotnend/web/uploads/$id/documents/$fileName";
		
		$model = StudentDocument::findOne($student_document_id);
		$recordDeleted=$model->delete();
			if($recordDeleted){
				unlink($path);
				$message=array('status' => 'success');
			}else{
				$message=array('status' => 'failed');
			}
		}
		//return $this->redirect(['index']);
		
		echo json_encode($message);return;
    }
	
	public function actionGetdocumentlist(){
		
		$allArs = DocumentTypes::getAllDocumentList();
		echo json_encode($allArs);
		return;
		
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