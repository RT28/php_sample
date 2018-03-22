<?php

namespace partner\modules\employee\controllers;

use Yii;
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\models\StudentConsultantRelation;
use common\models\StudentPartneremployeeRelation;
use common\models\PartnerAssignedworkHistory;
use partner\modules\consultant\models\StudentPartneremployeeRelationSearch;
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

use common\components\Commondata;

/**
 * SubconsultantController implements the CRUD actions for StudentPartneremployeeRelation model.
 */
class AssignemployeeController extends Controller
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
							'roles' => [Roles::ROLE_EMPLOYEE,Roles::ROLE_TRAINER]
					], 					 
					[
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_EMPLOYEE,Roles::ROLE_TRAINER]
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

    /**
     * Lists all StudentPartneremployeeRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPartneremployeeRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'students' => $this->getAllAssignedStudent(), 
			'employees' => $this->getAllEmployees(),
        ]);
    }

    /**
     * Displays a single StudentPartneremployeeRelation model.
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
     * Creates a new StudentPartneremployeeRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    

	public function actionCreate()
	{

	$model = new StudentPartneremployeeRelation();

	$parentConsultantId = Yii::$app->user->identity->id; 
	$student_id= '';		
	if(isset($_REQUEST['id'])){
		  $student_id = $_REQUEST['id'];  
	 }

	if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
	 
	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
		return Json::encode(ActiveForm::validate($model)); 

	} 
	if ($model->load(Yii::$app->request->post())) {
		
		 $SPR = StudentPartneremployeeRelation::find()->where(['AND',
				['=', 'consultant_id', $model->consultant_id],
				['=', 'student_id',$model->student_id]]
				)->one();
				
			 if(isset($SPR)){
				 $model = $SPR;
				     
			 }
			 
			if(isset($_POST['StudentPartneremployeeRelation']['access_list'])) {
				$model->access_list = implode(',', $_POST['StudentPartneremployeeRelation']['access_list']);
			} 
			$model->consultant_id = $parentConsultantId;
			$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$model->created_at = gmdate('Y-m-d H:i:s');
			$model->updated_at = gmdate('Y-m-d H:i:s'); 
		if($model->save(false)){ 
			 
			$history = new PartnerAssignedworkHistory();
			$history->assignedwork_id = $model->id;
			$history->consultant_id = $parentConsultantId;
			$history->parent_employee_id = $model->parent_employee_id;
			$history->status = 0;
			$history->comments = $model->comment_by_consultant;
			$history->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
			$history->created_at = gmdate('Y-m-d H:i:s');  
			$history->save(false);  
			  
			if($model->assigned_work_status==PartnerEmployee::STATUS_PENDING){
			 
				 $students = $this->getAllAssignedStudent();
				 $studentname =  $students[$model->student_id]; 
				 if(!empty($model->consultant_id)){ 
					$mainconsultant = $this->getConsultantName($model->consultant_id);
				 } 
				 if(!empty($model->parent_employee_id)){ 
				 $employee = $model->parentEmployee->first_name.' '.$model->parentEmployee->last_name;
				 }
				 
				$to = $model->parentEmployee->email; 
				$subject = 'Trainer/Employee assigned to '.$studentname;
				$successmsg = 'Trainer/Employee assigned to '.$studentname;
				$template = 'employee_assigned';
				
				$data = [
					'studentname'=>$studentname,
					'mainconsultant'=>$mainconsultant,
					'employee'=>$employee,
				];
						 
				if(Commondata::sendGeneralMail($to,$subject,$data,$template,$successmsg)==true){
					 
					Yii::$app->getSession()->setFlash('Success', 'Trainer/Employee Assigned to student successfully.');
				}else{
					 
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');
				}
				}
				
			}
			
			return $this->redirect(['students/index']);
		
	} else {
	return $this->renderAjax('create', [
		'model' => $model, 
		'students' => $this->getAllAssignedStudent(), 
		'employees' => $this->getAllEmployees(), 
		'student_id' => $student_id,
	]);
	}
	}
	
    /**
     * Updates an existing StudentPartneremployeeRelation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 
		$parentConsultantId = Yii::$app->user->identity->id; 
        $model = $this->findModel($id); 
		  
		 if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
				return Json::encode(ActiveForm::validate($model));  
		 } 
		 
        if ($model->load(Yii::$app->request->post())) {
				if(isset($_POST['StudentPartneremployeeRelation']['access_list'])) {
					$model->access_list = implode(',', $_POST['StudentPartneremployeeRelation']['access_list']);
				}  
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->created_at = gmdate('Y-m-d H:i:s');
				$model->updated_at = gmdate('Y-m-d H:i:s'); 
			  	if($model->save(false)){ 
				
				$history = new PartnerAssignedworkHistory();
				$history->assignedwork_id = $model->id;
				$history->consultant_id = $model->consultant_id;
				$history->parent_employee_id = $model->parent_employee_id;
				$history->status = 0;
				$history->comments = $model->comment_by_consultant;
				$history->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$history->created_at = gmdate('Y-m-d H:i:s');  
				$history->save(false); 
				
				if($model->assigned_work_status==PartnerEmployee::STATUS_COMPLETE){
			 
				 $students = $this->getAllAssignedStudent();
				 $studentname =  $students[$model->student_id]; 
				 if(!empty($model->consultant_id)){ 
					$consultant = $this->getConsultantName($model->consultant_id);
					$mainconsultant = $consultant->first_name.' '.$consultant->last_name;
					$to = $consultant->email; 
				 } 
				 if(!empty($model->parent_employee_id)){ 
				 $assoconsultant = $model->parentEmployee->first_name.' '.$model->parentEmployee->last_name;
				 }
				 
				 
				$subject = 'Trainer/Employee, completed assigned work to '.$studentname;
				$successmsg = 'Trainer/Employee, completed assigned work to '.$studentname;
				$template = 'completed_assigned_employee_work';
				
				$data = [
					'studentname'=>$studentname,
					'mainconsultant'=>$mainconsultant,
					'assoconsultant'=>$assoconsultant,
				];
						 
				if(Commondata::sendGeneralMail($to,$subject,$data,$template,$successmsg)==true){
					 
					Yii::$app->getSession()->setFlash('Success', 'Trainer/Employee updated work status successfully.');
				}else{
					 
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');
				}
				}
				
				}
				
				
				return $this->redirect(['students/index']);
			 	
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
				'students' => $this->getAllAssignedStudent(), 
				'employees' => $this->getAllEmployees(),  
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
		$students = StudentPartneremployeeRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_partneremployee_relation.student_id') 
		->where('student_partneremployee_relation.parent_employee_id = '.$id . ' AND 
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
	
	private function getAllEmployees() {
		 $id = Yii::$app->user->identity->id;  
		$subconsultants = PartnerEmployee::find()	
		->select(['partner_login_id','CONCAT(first_name, " ",last_name) as first_name']) 
        ->where('partner_login_id != '.$id) ->all();  
		$subconsultantsList = ArrayHelper::map($subconsultants, 'partner_login_id', 'first_name');
		return $subconsultantsList;
	}	
	
    /**
     * Deletes an existing StudentPartneremployeeRelation model.
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
     * Finds the StudentPartneremployeeRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentPartneremployeeRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPartneremployeeRelation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
