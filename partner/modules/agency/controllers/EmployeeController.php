<?php

namespace partner\modules\agency\controllers;

use Yii;
use common\models\PartnerEmployee;
use partner\modules\agency\models\PartnerEmployeeSearch; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use partner\models\PartnerLogin;
use common\components\Status;
use backend\models\SiteConfig;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;
use common\components\ConnectionSettings; 
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\components\Commondata; 
 
class EmployeeController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'disable', 'enable','createlogin', 'createlogin', 'dependent-states', 'dependent-cities',],
                        'allow' => true,
                        'roles' => [Roles::ROLE_AGENCY]
                    ],
					[  
						'actions' => ['login'],
						'allow' => true, 
						'roles' => ['?'],
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


    /**
     * Lists all partner_employee models.
     * @return mixed
     */
    public function actionIndex()
    {
		Yii::$app->view->params['activeTab'] = 'employee';
		 
		$searchModel = new PartnerEmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single partner_employee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		Yii::$app->view->params['activeTab'] = 'employee';
		$id = Commondata::encrypt_decrypt('decrypt', $id);
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' =>$model,
        ]);
    }

    /**
     * Creates a new partner_employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$helpemail = SiteConfig::getConfigHelpEmail();
		
		Yii::$app->view->params['activeTab'] = 'employee';
		$partner_id = Yii::$app->user->identity->id; 
		$model = new PartnerEmployee();
        $partnerLogin = new PartnerLogin();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
        //$degrees = Degree::find()->orderBy('name')->all();
		$message = '';
        if(Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());  
            $exists = PartnerLogin::find()->where(['=', 'email', $model->email])->one();
          
		 
			if(empty($exists)) {
				
				//$password = $partnerLogin->password_hash;
				//$partnerLogin->username = $model->email;  
				//$partnerLogin->setPassword($password);  
                $partnerLogin->email = $model->email;				
				$partnerLogin->status = Status::STATUS_NEW;
				$partnerLogin->role_id = Roles::ROLE_EMPLOYEE;
				$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
                $partnerLogin->updated_at = gmdate('Y-m-d H:i:s');
				$partnerLogin->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$partnerLogin->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				
				
                if($partnerLogin->save(false)) {
					 
					if($model->speciality){
						$model->speciality = implode(',',$model->speciality); 
			}
			if(!empty($model->work_days)){
				$model->work_days = implode(',',$model->work_days);
			}
			if(!empty($model->country_level)){
				$model->country_level = implode(',',$model->country_level);
			}
			if(!empty($model->responsible)){
				$model->responsible = implode(',',$model->responsible);
			}
			if(!empty($model->degree_level)){
				$model->degree_level = implode(',',$model->degree_level);
			}
			if(!empty($model->standard_test)){
				$model->standard_test = implode(',',$model->standard_test);
			}
				
				$model->parent_partner_login_id = $partner_id;	
				$model->partner_login_id = $partnerLogin->id;
				$model->role_id = Roles::ROLE_EMPLOYEE;						
				$model->created_at = gmdate('Y-m-d H:i:s');
				$model->updated_at = gmdate('Y-m-d H:i:s');
				$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();


				if($model->save()) {
				$partnerLogin->partner_id =$model->id;
				$partnerLogin->save(false); 


					Yii::$app->getSession()->setFlash('Success', 'Employee has been created successfully. '); 
					
				} else {
					Yii::$app->getSession()->setFlash('Error', 'Error in processing your request. Please send email to '.$helpemail);
				
				}
					 	
						
                } else {
                    Yii::$app->getSession()->setFlash('Error', 'Error in processing your request. Please send email to '.$helpemail);
                } 
            } else {
                Yii::$app->getSession()->setFlash('Error', 'User already exists as partner. Please send email to '.$helpemail); 
            }
			
			return $this->redirect(['employee/index']);
        }
		 
        return $this->render('create', [
            'model' => $model,
            'partnerLogin' => $partnerLogin,
            'countries' => $countries,
			'degrees' => Degree::getAllDegrees(),
            'message' => $message
        ]);
    }

    /**
     * Updates an existing consultant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		Yii::$app->view->params['activeTab'] = 'employee';
		$id = Commondata::encrypt_decrypt('decrypt', $id);
        $model = $this->findModel($id);

		$countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
		$message = '';
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->speciality){
						$model->speciality = implode(',',$model->speciality); 
			}
			if(!empty($model->work_days)){
				$model->work_days = implode(',',$model->work_days);
			}
			if(!empty($model->country_level)){
				$model->country_level = implode(',',$model->country_level);
			}
			if(!empty($model->responsible)){
				$model->responsible = implode(',',$model->responsible);
			}
			if(!empty($model->degree_level)){
				$model->degree_level = implode(',',$model->degree_level);
			}
			if(!empty($model->standard_test)){
				$model->standard_test = implode(',',$model->standard_test);
			}
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'countries' => $countries,
				'degrees' => Degree::getAllDegrees(),
            ]);
        }
    }

    /**
     * Deletes an existing partner_employee model.
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
     * Finds the consultant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return consultant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PartnerEmployee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function actionDisable()
    {
        
        $id = $_POST['id'];
        $model = PartnerLogin::findOne($id);

        if (empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Consultant not found']);
        }

        $model->status = Status::STATUS_INACTIVE;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_at = ('Y-m-d H:i:s');
        if ($model->save(false)) {
            return json_encode(['status' => 'success']);
        }

        return json_encode(['status' => 'error', 'message' => 'Error saving data.']);
    }

    public function actionEnable()
    {
        
        $id = $_POST['id'];
        $model = PartnerLogin::findOne($id);

        if (empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Consultant not found']);
        }

        $model->status = Status::STATUS_ACTIVE;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_at = ('Y-m-d H:i:s');
        if ($model->save(false)) {
            return json_encode(['status' => 'success']);
        }

        return json_encode(['status' => 'error', 'message' => 'Error saving data.']); 
    }

     
	
	 public function actionCreatelogin($id)
    {
		$id = Commondata::encrypt_decrypt('decrypt', $id);
	  
		Yii::$app->view->params['activeTab'] = 'employee';  
		$model = $this->findModel($id);
		$to = $model->email;
 
		$subject = 'Employee Login credentilas link';
		$template = 'createlogin_employee';
		$time = time();	
		$timestring = strtotime('+2 days', $time);
		$timestamp = Commondata::encrypt_decrypt('encrypt',$timestring);
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id);
	  
		$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=employee/employee/login&id=' . $encryptedid . '&timestamp=' .$timestamp; 
	   
		$data = array('user' => $to, 'link' => $link);		
		$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		if($mailsent==true){ 
			Yii::$app->getSession()->setFlash('Success', 'We have sent username and password link on your email '.$to.'. Click on link and create desired login credentials.'); 
		}else{
			Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
		}
			
		return $this->redirect('?r=agency/employee/index');  
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

    public function actionDependentCities() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $state_id = $parents[1];
                $cities = City::getCitiesForCountryAndState($country_id, $state_id);
                echo Json::encode(['output'=>$cities, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
 
}
