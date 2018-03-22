<?php

namespace backend\controllers;

use Yii;
use common\models\Consultant;
use backend\models\ConsultantSearch;
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
use common\components\Commondata;
use common\models\Country;
use common\models\Degree;
use common\models\Others;
use common\models\Agency;
use yii\helpers\ArrayHelper;
use yii\db\IntegrityException; 
use yii\base\ErrorException;

/**
 * AdminConsultantController implements the CRUD actions for consultant model.
 */
class AdminConsultantController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update','verify', 'disable', 'enable','createlogin','dependent-cities', 'dependent-states'],
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
     * Lists all consultant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->layout = 'admin-dashboard-sidebar';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single consultant model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' =>$model,
			'agencies' => Agency::getAllAgencies(),
			'languages' => $this->getOthers('languages'),
        ]);
    }

    /**
     * Creates a new consultant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$model = new Consultant();
        $partnerLogin = new PartnerLogin();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
        //$degrees = Degree::find()->orderBy('name')->all();
		$message = '';
        if(Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());  
            $exists = PartnerLogin::find()->where(['=', 'email', $model->email])->one();
          
			if(empty($exists)) {
				
				$partnerLogin->username = $model->email;
                $partnerLogin->email = $model->email;				
				$partnerLogin->status = Status::STATUS_NEW;
				$partnerLogin->role_id = Roles::ROLE_CONSULTANT;
				$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
                $partnerLogin->updated_at = gmdate('Y-m-d H:i:s');
				$partnerLogin->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$partnerLogin->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				
				
			 
						
						
          if($partnerLogin->save(false)) {
				
			if(!empty($model->country_level)){
				$model->country_level = implode(',',$model->country_level);
			}
			if(!empty($model->degree_level)){
				$model->degree_level = implode(',',$model->degree_level);
			}
			if(!empty($model->standard_test)){
				$model->standard_test = implode(',',$model->standard_test);
			}
			
			if($model->speciality){
				$model->speciality = implode(',',$model->speciality); 
			}
			if($model->languages){
				$model->languages = implode(',',$model->languages); 
			}
			if($model->work_days){
						$model->work_days = implode(',',$model->work_days);
			}
						$model->partner_login_id = $partnerLogin->id;	
						$model->consultant_id = $partnerLogin->id;	 
						$model->created_at = gmdate('Y-m-d H:i:s');
						$model->updated_at = gmdate('Y-m-d H:i:s');
						$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
						$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
 						$model->save();
					  		 
						if($model->save(false)) {
								$partnerLogin->partner_id =$model->id;
								$partnerLogin->save(false); 
				
					Yii::$app->getSession()->setFlash('Success', 'Success! Registration successfull.'); 
							} else {
					Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact Administrator.'); 
							}
					 	
						
                } else { 
					Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact administrator'); 
                } 
            } else {
				Yii::$app->getSession()->setFlash('Error', 'Error! Consultant already exists');  
            }
				return $this->redirect(['admin-consultant/index']);
        }
		 
        return $this->render('create', [
            'model' => $model,
            'partnerLogin' => $partnerLogin,
            'countries' => $countries,
			'degrees' => Degree::getAllDegrees(),
			'agencies' => Agency::getAllAgencies(),
			'languages' => $this->getOthers('languages'),
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
        $model = $this->findModel($id);

		$partnerLogin = new PartnerLogin();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
		
        if ($model->load(Yii::$app->request->post()) ) {
			
			
			if(!empty($model->country_level)){
				$model->country_level = implode(',',$model->country_level);
			}
			if(!empty($model->degree_level)){
				$model->degree_level = implode(',',$model->degree_level);
			}
			if(!empty($model->standard_test)){
				$model->standard_test = implode(',',$model->standard_test);
			}
			
           if($model->speciality){
						$model->speciality = implode(',',$model->speciality); 
			}
			if($model->languages){
				$model->languages = implode(',',$model->languages); 
			}
			if($model->work_days){
						$model->work_days = implode(',',$model->work_days);
			}
					
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->save(false);
			
            return $this->redirect(['admin-consultant/index']);
			
        } else {
            return $this->render('update', [
                 'model' => $model,
            'partnerLogin' => $partnerLogin,
            'countries' => $countries,
			'degrees' => Degree::getAllDegrees(),
			'agencies' => Agency::getAllAgencies(), 
			'languages' => $this->getOthers('languages'), 
			
            ]);
        }
    }

    /**
     * Deletes an existing consultant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	   $model = $this->findModel($id);
		 
		
		$partnerLogin = PartnerLogin::find()->where(['=', 'id', $model->consultant_id])->one();
		
		try {
		 if(!empty($partnerLogin))	{ 
		    
		   $partnerLogin->delete(); 
		   $model->delete(); 
		   Yii::$app->getSession()->setFlash('Success', 'Consultant has been deleted successfully.'); 
			} else {
					Yii::$app->getSession()->setFlash('Error', 'Error processing your request. ');
					
		 }  
		}catch (IntegrityException $e) { 
			
		  /* $partnerLogin->status = PartnerLogin::STATUS_INACTIVE;
		   $partnerLogin->save(false);
		   
		   $model->status = PartnerLogin::STATUS_INACTIVE;
		   $model->save(false); */
		   Yii::$app->getSession()->setFlash('Error', 'We can not delete consultant because we are maintaining students and their work history in our database. You can Deactivate and In Active Consultant.');   
				
		}

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
        if (($model = Consultant::findOne($id)) !== null) {
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

    public function actionVerify() {
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
	  
	    $searchModel = new ConsultantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			
		$model = $this->findModel($id);
		$to = $model->email;

		$subject = 'Consultant Login credentilas link';
		$template = 'createlogin_consultant';
		$time = time();	
		$timestring = strtotime('+2 days', $time);
		$timestamp = Commondata::encrypt_decrypt('encrypt',$timestring);
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id);
	  
		$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=consultant/consultant/login&id=' . $encryptedid . '&timestamp=' .$timestamp; 
	   
		$data = array('user' => $to, 'link' => $link);		
		$message = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		 return $this->render('index', [
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
		'message' =>  $message,
        ]); 
		 
    }
	
	
	private function getOthers($name) {
        $model = [];
		$stringarray = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
			$i = 0;
			foreach($model as $key=>$value){
				$stringarray[$i]['id'] = $value; 
				$stringarray[$i]['name'] = $value; 
				$i++;
			}			
			
			$languages = ArrayHelper::map($stringarray , 'id', 'name');
			
            return $languages;
        }
    }
}
