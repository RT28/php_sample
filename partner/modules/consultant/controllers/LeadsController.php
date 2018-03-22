<?php
namespace partner\modules\consultant\controllers;

use Yii;  
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper; 
use yii\filters\AccessControl;
use yii\filters\VerbFilter;  
use common\models\Consultant; 
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
use common\models\Agency;
use partner\models\StudentAssignPackages;
use backend\models\SiteConfig;
use frontend\models\UserLogin; 
use partner\modules\consultant\models\LeadsSearch;
use frontend\models\StudentShortlistedCourse;
use common\models\StudentFavouriteUniversities;  
use partner\modules\consultant\models\TasksSearch;
use frontend\models\StudentCalendar; 
use yii\data\ActiveDataProvider; 
use common\models\Tasks; 
use common\models\TaskComment;
use common\models\TaskList;
use yii\db\ActiveQuery;
use yii\db\Expression; 
use yii\db\Command;
use yii\db\IntegrityException; 
use yii\base\ErrorException; 
use common\components\Commondata;

class LeadsController extends \yii\web\Controller
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
						'actions' => ['index', 'view', 'status',  'download', 'assign-package', 'assign-consultant',
							'activation-link', 'download-all', 'disconnect-associate',
							'connect-associate', 'change-package-limt', 'disconnect','add-event'],
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
	
    public function actionIndex() { 
	
		Yii::$app->view->params['activeTab'] = 'leads';
	    $id = Yii::$app->user->identity->id; 
		$searchModel = new LeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $students_new = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 0 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
        $studentnew =  count($students_new);

        $students_active = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 1 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
        $studentactive =  count($students_active);

         $students_inactive = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 2 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
         $studentinactive =  count($students_inactive);

         $students_accesssend = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 3 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
         $studentaccesssend =  count($students_accesssend);

         $students_subscribed = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 4 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
         $studentsubscribed =  count($students_subscribed);

         $students_closed = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`follow_status` = 6 AND `student_consultant_relation`.`consultant_id` = "'.$id.'" ' )->all();
         $studentclosed =  count($students_closed);

         $rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->Where(['like','next_followup',date("Y-m-d")])
                    ->distinct()
                    ->all();
                    if($rows_today){
                        
                        $tday_followup=array();
                        foreach ($rows_today as $today) {
                         array_push($tday_followup,$today['student_id']);
                        }
                        $check_condition = "AND `user_login`.`id` IN (" . implode(",", $tday_followup) . ")";
                    $students_today = User::find()->innerJoin('student_consultant_relation', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `student_consultant_relation`.`consultant_id` = "'.$id.'" '.$check_condition.'')->all();
                    $count_today =  count($students_today);
                    } else {
                        $count_today =  0;
                    }
		/*to set all leads as read*/         
           Yii::$app->db->createCommand()
           ->update('consultant', ['leads_count' => 0], ['partner_login_id' => Yii::$app->user->identity->id])
           ->execute();  
		return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'studentnew' => $studentnew, 
            'studentactive' => $studentactive,
            'studentinactive' => $studentinactive,
            'studentaccesssend' => $studentaccesssend,
            'studentsubscribed' => $studentsubscribed,
            'studentclosed' => $studentclosed,
            'studenttoday' => $count_today 
        ]);
    }
	 public function actionStatus() { 
	
		Yii::$app->view->params['activeTab'] = 'dashboard';
	
		$searchModel = new LeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
		 
		return $this->render('status', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
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
		Yii::$app->view->params['activeTab'] = 'students';
		 $consultant_id = Yii::$app->user->identity->id; 


        $model = Student::findOne($id);
        $englishTests = StudentEnglishLanguageProficienceyDetails::find()->where(['=', 'student_id', $model->student_id])->all();
        $standardTests = StudentStandardTestDetail::find()->where(['=', 'student_id', $model->student_id])->all();
         
		
		$associates = StudentConsultantRelation::find()->where(['AND',
		['=','student_id', $model->student_id], 
		['=','is_sub_consultant', 1], 
		])->all(); 
		 
		$employees = StudentPartneremployeeRelation::find()->where(['AND',
		['=','student_id', $model->student_id], 
		])->all();
		
		$packages = StudentPackageDetails::find()->where(['=', 'student_id', $model->student_id])->all();

		$shortlistedCourses = StudentShortlistedCourse::find()->where(['=', 'student_id', $model->student_id])->orderBy(['id' => SORT_DESC])->all();

		$shortlistedUni = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$model->student_id,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all();
		
		$meeting = StudentCalendar::find()->where(['=', 'student_id', $model->student_id])->orderBy(['id' => SORT_DESC])->all();

		 
		$taskModel = new TasksSearch();
		$taskModel->student_id = $model->student_id;
        $taskdataProvider = $taskModel->search(Yii::$app->request->queryParams);
		 
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
                Yii::$app->response->sendFile($path[0]);
            }
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
	
  
  public function actionAssignConsultant() {
	   
	  $agency_id = Yii::$app->user->identity->id;
		
	 $id = $_REQUEST['id'];  
	  
	 
       $model = Student::findOne(['student_id'=>$id]); 
	   $user = User::findOne(['id'=>$model->student_id]); 
	   $consultant = StudentConsultantRelation::findOne(['student_id'=>$model->student_id]);
	   
    
       $package = StudentPackageDetails::findOne(['student_id'=>$model->student_id]);
	   
	   
	  $allConsultants = Consultant::find()
	  ->select(['consultant_id','CONCAT(first_name, " ", last_name) as first_name'])
	  ->where(['parent_partner_login_id' => $agency_id])
	  ->orderBy('first_name')->all();
	 
	   
	  
       $consultant_name = ArrayHelper::map($allConsultants,'consultant_id','first_name');
 
	  
		$cc = array();
		$cc[] = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();
		$email = $model->email;
		$name = $model->first_name;
		
		 
			   isset($consultant) ? $consultant :$consultant = new StudentConsultantRelation();
			   if(isset($consultant)){
	 
				  
				if($consultant->load(Yii::$app->request->post())) {	
	
				  $assignedConsultant = 'Not Assigned';
				if(!empty($consultant->agency_id)){
					$assignedAgency = Agency::findOne(['partner_login_id'=>$consultant->agency_id]); 
 					$assignedAgencyName = $assignedAgency->name;  
					$cc[]= $assignedAgency->email; 
				} 

				if(!empty($consultant->consultant_id)){
					$assignedConsultant = Consultant::findOne(['consultant_id'=>$consultant->consultant_id]); 
 					$assignedConsultantname = $assignedConsultant->first_name." ".$assignedConsultant->last_name;
					$cid = $consultant->consultant_id ;
					$cc[]= $assignedConsultant->email; 
				}
				
				$consultant->consultant_id = $consultant->consultant_id;
				$consultant->parent_consultant_id = $consultant->consultant_id;$consultant->student_id = $model->student_id;	 			
				$consultant->created_by =  Yii::$app->user->identity->id;
				$consultant->updated_by =  Yii::$app->user->identity->id;
				$consultant->created_at =gmdate('Y-m-d H:i:s');
				$consultant->updated_at =gmdate('Y-m-d H:i:s'); 
		 
				try {
	
                if($consultant->save(false)){
				  
				if(!empty($consultant->consultant_id)){
					$mail = Yii::$app->mailer->compose(['html' => '@common/mail/agency_assignedto_student'],[
					'name' => $name,
					'agency' => $assignedAgencyName,
					'consultant' =>$assignedConsultantname, 
					'link' => ConnectionSettings::BASE_URL . 'consultant/view?id='.$cid
					])
					->setFrom($from)
					->setTo($email)
					->setCc($cc)
					->setSubject('Consultant Assigned to you.');
					$mail->send();
					
				}
				Yii::$app->getSession()->setFlash('Success', 'Consultant has been assigned successfully.'); 
				
					return $this->redirect(array('assigned-counselor')); 

				} 
			}catch (IntegrityException $e) { 
				Yii::$app->getSession()->setFlash('Error', 'Error! Consultant already assigned');  
				return $this->redirect(['index']); 
					
			}catch (Exception $e) {
					Yii::$app->getSession()->setFlash('Error', 'Error! Consultant already assigned');  
					return $this->redirect(['index']);					
	
			}
	
                 
			   }	
		}
        
      
        
        return $this->renderAjax('assign_consultant', [ 
			'model' => $model,
			'user' => $user,
            'consultant_name' => $consultant_name,
            'consultant'=>$consultant,
			
        ]);
    }
	

    public function actionDisconnectAssociate() {
		
		Yii::$app->view->params['activeTab'] = 'students';
        $consultant = $_POST['consultant'];
        $student = $_POST['student'];

        $model = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'associate_consultant_id', $consultant]])->one();

        if(empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Student and consultant are not connected']);
        }
        if($model->delete()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'messsage' => 'Error disconnecting student and associate']);
    }

    

    public function actionConnectAssociate() {
		Yii::$app->view->params['activeTab'] = 'students';
        $consultant = $_POST['consultant'];
        $student = $_POST['student'];

        $model = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'associate_consultant_id', $consultant]])->one();

        if(!empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Student and consultant are already connected']);
        }
        $model = new StudentAssociateConsultants();
        $model->student_id = $student;
        $model->associate_consultant_id = $consultant;
        $model->parent_consultant_id = Yii::$app->user->identity->id;
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_by = Yii::$app->user->identity->id;
        if($model->save()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'messsage' => 'Error disconnecting student and associate']);
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
}
