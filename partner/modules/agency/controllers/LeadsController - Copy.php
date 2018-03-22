<?php
namespace partner\modules\agency\controllers;

use common\models\Consultant;
use common\models\StudentConsultantRelation;
use common\models\Student;
use common\models\Degree;
use common\models\Majors;
use common\models\User;
use common\models\PackageType;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentStandardTestDetail;
use yii\helpers\FileHelper;
use common\models\StudentAssociateConsultants;
use common\models\AssociateConsultants;
use common\models\StudentPackageDetails;
use yii\helpers\ArrayHelper;
use partner\models\StudentAssignPackages;
use common\components\ConnectionSettings;
use backend\models\SiteConfig;
use frontend\models\UserLogin;
use common\models\Country; 
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\VerbFilter; 
use common\components\Roles; 
use partner\modules\agency\models\LeadsSearch;
use partner\models\PartnerLogin;

use Yii;

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
                        'actions' => ['index', 'view', 'create', 'update', 'disable', 'enable','createlogin', 'createlogin', 'dependent-states', 'dependent-cities',],
                        'allow' => true,
                        'roles' => [Roles::ROLE_AGENCY]
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
	
    public function actionIndex() { 
	
		Yii::$app->view->params['activeTab'] = 'leads';
	
		$searchModel = new LeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
		 
		return $this->render('index', [
			'searchModel' => $searchModel,
            'dataProvider' => $dataProvider 
        ]);
    }
	
	

	public function actionAssignPackage($id) {
		Yii::$app->view->params['activeTab'] = 'students';
        $model = User::findOne($id);
 
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
				//$StudentPD->consultant_id =  Yii::$app->user->identity->consultant->id; 
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
				
				    $packagestype = $StudentPD->package_type_id ;
					$user = $model->first_name. ' '.  $model->last_name; 

					if($this->sendActivationLink($model->id, $model->email, $user,$consultantname,$packagestype)) {
						return $this->render('assign-package', [
						'model' => $model, 
						'StudentAssignPackages' => $StudentAssignPackages,
						'packages' =>  PackageType::getPackageType(),
						'status' => 'success', 'id' => $model->id]);
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
                'link' => ConnectionSettings::BASE_URL . 'frontend/web/index.php?r=site/activate-dashboard&id=' . $id . '&ptid=' . $packagestype . '&timestamp=' . strtotime('+2 days', $time),
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
		
        $model = Student::findOne($id);
        $englishTests = StudentEnglishLanguageProficienceyDetails::find()->where(['=', 'student_id', $model->student_id])->all();
        $standardTests = StudentStandardTestDetail::find()->where(['=', 'student_id', $model->student_id])->all();
        $associates = StudentAssociateConsultants::find()->where(['=','student_id', $model->student_id])->all();
        $consultantAssociates = AssociateConsultants::find()->where(['=', 'parent_consultant_id', Yii::$app->user->identity->id])->all();
        $packages = StudentPackageDetails::find()->where(['=', 'student_id', $model->student_id])->all();

        return $this->render('view', [
            'model' => $model,
            'englishTests' => $englishTests,
            'standardTests' => $standardTests,
            'associates' => $associates,
            'consultantAssociates' => $consultantAssociates,
            'packages' => $packages
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

        $associates = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]])->all();

        if(sizeof($associates) > 0) {
            $transaction = \Yii::$app->db->beginTransaction();
            $count = StudentAssociateConsultants::deleteAll(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]]);
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
