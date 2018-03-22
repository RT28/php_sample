<?php

namespace partner\modules\consultant\controllers;

use Yii;
use common\models\Consultant;
use common\models\Student;
use common\models\StudentConsultantRelation;
use partner\modules\consultant\models\AssignAssociateConsultant;
use common\models\ConsultantAssignedworkHistory;
use partner\modules\consultant\models\StudentConsultantRelationSearch;
use yii\filters\AccessControl; 
use common\components\AccessRule;
use common\components\Roles;
use frontend\models\UserLogin;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\widgets\Pjax; 
use yii\widgets\ActiveForm;
use common\components\Commondata;
use yii\db\IntegrityException; 
use yii\base\ErrorException;
use common\models\AccessList;  

/**
 * SubconsultantController implements the CRUD actions for StudentConsultantRelation model.
 */
class SubconsultantController extends Controller
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
							'actions' => ['index', 'create','view', 'update', 'delete', ],
							'allow' => true, 
							'roles' => [Roles::ROLE_CONSULTANT]
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
	
	public function beforeAction($action)
    {     
	
	$accessAuth = AccessList::accessActions($action);  
	if($accessAuth == false){   
		  throw new NotFoundHttpException('You are not authorized to perform this action.'); 
	} 	 
	return parent::beforeAction($action);
		
    }

    /**
     * Lists all StudentConsultantRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentConsultantRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'students' => $this->getAllAssignedStudent(), 
			'Subconsultants' => $this->getAllSubconsultants(),
        ]);
    }

    /**
     * Displays a single StudentConsultantRelation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StudentConsultantRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    

	  public function actionCreate()
    {
		//Yii::$app->view->params['activeTab'] = 'tasks';
      
		$parentConsultantId = Yii::$app->user->identity->id; 
		$consultant = Consultant::find()->where('consultant_id = '.$parentConsultantId)->one();  
		$student_id= '';		
		if(isset($_REQUEST['id'])){
				  $student_id = $_REQUEST['id'];  
			 }
	 
		$AssignAssociateConsultant = new AssignAssociateConsultant(); 
	 
		 
		 if (Yii::$app->request->isAjax && $AssignAssociateConsultant->load(Yii::$app->request->post())) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
				return Json::encode(ActiveForm::validate($AssignAssociateConsultant));  
		 }
		  
		 
		if ($AssignAssociateConsultant->load(Yii::$app->request->post())) {
			$model = new StudentConsultantRelation();
			 $SCR = StudentConsultantRelation::find()->where(['AND',
				['=', 'consultant_id', $AssignAssociateConsultant->consultant_id],
				['=', 'student_id',$AssignAssociateConsultant->student_id]]
				)->one();
			
			 $student = Student::find()->where(['=', 'student_id',$AssignAssociateConsultant->student_id])->one();	
				
			 if(!empty($SCR)){
				 $model = $SCR;
				     Yii::$app->getSession()->setFlash('Error', 'Error! This Consultant already assigned to student');   
					 return $this->redirect(['students/index']);
			 } 
			
			if($_POST['AssignAssociateConsultant']['access_list']) {
				$model->access_list = implode(',', $_POST['AssignAssociateConsultant']['access_list']);
			} 
			
			 
			$model->student_id = $_POST['AssignAssociateConsultant']['student_id'];
			$model->consultant_id = $_POST['AssignAssociateConsultant']['consultant_id'];
			$model->comment_by_consultant = $_POST['AssignAssociateConsultant']['comment_by_consultant'];
			$model->start_date = $_POST['AssignAssociateConsultant']['start_date'];
			$model->end_date = $_POST['AssignAssociateConsultant']['end_date'];
			$model->agency_id = $consultant->parent_partner_login_id;
			$model->is_sub_consultant = 1;
			$model->parent_consultant_id = $parentConsultantId;
			$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->created_at = gmdate('Y-m-d H:i:s');
			$model->updated_at = gmdate('Y-m-d H:i:s'); 
	 
	  
		  //try {
			if($model->save(false)){ 
			 
			$history = new ConsultantAssignedworkHistory();
			$history->assignedwork_id = $model->id;
			$history->consultant_id = $parentConsultantId;
			$history->status = 0;
			$history->comments = $model->comment_by_consultant;
			$history->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$history->created_at = gmdate('Y-m-d H:i:s');  
			$history->save(false);  
			  
			if($model->assigned_work_status==Consultant::STATUS_PENDING){
			 
				 $students = $this->getAllAssignedStudent();
				 $studentname =  $students[$model->student_id]; 
				 if(!empty($model->parent_consultant_id)){ 
					$mainconsultant = $this->getConsultantName($model->parent_consultant_id);
				 } 
				 if(!empty($model->consultant_id)){ 
				 $assoconsultant = $model->consultant->first_name.' '.$model->consultant->last_name;
				 }
				$to = array(); 
				$to[] = $student->email; 
				$to[] = $model->consultant->email; 
				$to[] = $mainconsultant->email;
				$subject = 'Associate Consultant assigned';
				$successmsg = 'Associate Consultant assigned.';
				$template = 'associate_consultant_assigned';
				
				$data = [
					'studentname'=>$studentname,
					'mainconsultant'=>$mainconsultant,
					'assoconsultant'=>$assoconsultant,
				];
				 
		 
				if(Commondata::sendGeneralMail($to,$subject,$data,$template,$successmsg)==true){
					$message = $mainconsultant->first_name.' '.$mainconsultant->last_name.' has assigned '.$assoconsultant.' as associate consultant for you.';
					$notification = Commondata::consultantNotification($model->student_id,$parentConsultantId,Roles::ROLE_CONSULTANT,$message,$model->created_by,$model->updated_by); 
					Yii::$app->getSession()->setFlash('Success', 'Associate Consultant assigned to student successfully.');
				}else{
					 
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');
				}
				}
				
			} 
			
			/*}catch (IntegrityException $e) { 
			
					Yii::$app->getSession()->setFlash('Error', 'Error in processiong.');   
				
			} */
	
			$studentid = Commondata::encrypt_decrypt('encrypt', $AssignAssociateConsultant->student_id);
				return $this->redirect(['students/view/','id'=>$studentid]);
			
        } else {
            return $this->renderAjax('create', [
                'model' => $AssignAssociateConsultant, 
				'students' => $this->getAllAssignedStudent(), 
				'Subconsultants' => $this->getAllSubconsultants(), 
				'student_id' => $student_id,
            ]);
        }
    }
	
    /**
     * Updates an existing StudentConsultantRelation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 
		$parentConsultantId = Yii::$app->user->identity->id; 
		$consultant = Consultant::find()->where('consultant_id = '.$parentConsultantId)->one();  
        $model = $this->findModel($id); 
		 
		 
		 if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
				return Json::encode(ActiveForm::validate($model));  
		 } 
		 
        if ($model->load(Yii::$app->request->post())) {
			 
			if($_POST['StudentConsultantRelation']['access_list']) {
				$model->access_list = implode(',', $_POST['StudentConsultantRelation']['access_list']);
			} 
			
				$model->is_sub_consultant = 1;
				$model->agency_id = $consultant->parent_partner_login_id;
				$model->parent_consultant_id = $parentConsultantId; 
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate('Y-m-d H:i:s');
				$model->updated_at = gmdate('Y-m-d H:i:s'); 
				 
			  	if($model->save(false)){ 
				
				$history = new ConsultantAssignedworkHistory();
				$history->assignedwork_id = $model->id;
				$history->consultant_id = $parentConsultantId;
				$history->status = $model->assigned_work_status;
				$history->comments = $model->comment_by_consultant;
				$history->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			    $history->created_at = gmdate('Y-m-d H:i:s'); 
				$history->save(false);
				
				if($model->assigned_work_status==Consultant::STATUS_COMPLETE){
			 
				 $students = $this->getAllAssignedStudent();
				 $studentname =  $students[$model->student_id]; 
				 if(!empty($model->parent_consultant_id)){ 
					$consultant = $this->getConsultantName($model->parent_consultant_id);
					$mainconsultant = $consultant->first_name.' '.$consultant->last_name;
					$to = $consultant->email; 
				 } 
				 if(!empty($model->consultant_id)){ 
				 $assoconsultant = $model->consultant->first_name.' '.$model->consultant->last_name;
				 }
				 
				 
				$subject = 'Completed Assigned '.$studentname.' work';
				$successmsg = 'All Assigned work has been completed.';
				$template = 'completed_assigned_work';
				
				$data = [
					'studentname'=>$studentname,
					'mainconsultant'=>$mainconsultant,
					'assoconsultant'=>$assoconsultant,
				];
						 
					if(Commondata::sendGeneralMail($to,$subject,$data,$template,$successmsg)==true){
						 
						Yii::$app->getSession()->setFlash('Success', 'Consultant  updated work status successfully.');
					}else{
						 
						Yii::$app->getSession()->setFlash('Error', 'Email not sent.');
					}
				}
				
				}
				
				$studentid = Commondata::encrypt_decrypt('encrypt', $model->student_id);
				return $this->redirect(['students/view/','id'=>$studentid]);
			 	
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
				'students' => $this->getAllAssignedStudent(), 
				'Subconsultants' => $this->getAllSubconsultants(),  
            ]);
        }
    }

	private function getConsultantName($consultant_id) {
		$consultant = Consultant::find()->where(
		['=','consultant_id', $consultant_id])->one();
			  
		return $consultant;
	}	
	
	private function getAllAssignedStudent() {
		 $id = Yii::$app->user->identity->id;  
		$students = StudentConsultantRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_consultant_relation.student_id') 
		->where('student_consultant_relation.consultant_id = '.$id . ' AND 
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
	
	private function getAllSubconsultants() {
		 $id = Yii::$app->user->identity->id;  
		$subconsultants = Consultant::find()	
		->select(['consultant_id','CONCAT(first_name, " ",last_name) as first_name']) 
        ->where('consultant_id != '.$id) ->all();  
		$subconsultantsList = ArrayHelper::map($subconsultants, 'consultant_id', 'first_name');
		return $subconsultantsList;
	}	
	
    /**
     * Deletes an existing StudentConsultantRelation model.
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
     * Finds the StudentConsultantRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentConsultantRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentConsultantRelation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
