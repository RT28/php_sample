<?php

namespace backend\controllers;

use Yii;
use common\models\Agency;
use backend\models\AgencySearch;
use partner\models\PartnerLogin;
use common\components\Status;
use backend\models\SiteConfig;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;
use common\components\ConnectionSettings; 
use common\components\Commondata;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AgencyController implements the CRUD actions for Agency model.
 */
class AgencyController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'dependent-states', 'dependent-cities', 'createlogin'  ],
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
     * Lists all Agency models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgencySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Agency model.
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
     * Creates a new Agency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Agency();
		$partnerLogin = new PartnerLogin();
		$countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
       
		$message = '';
        if(Yii::$app->request->post() ) {
            $model->load(Yii::$app->request->post());  
            $exists = PartnerLogin::find()->where(['=', 'email', $model->email])->one();
          
			if(empty($exists)) {
				 
                //$partnerLogin->username = $model->email;
				$partnerLogin->email = $model->email;
				$partnerLogin->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$partnerLogin->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
				$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
                $partnerLogin->updated_at = gmdate('Y-m-d H:i:s');				
				$partnerLogin->status = Status::STATUS_NEW;
				$partnerLogin->role_id = Roles::ROLE_AGENCY; 
				
                if($partnerLogin->save(false)) {
					$model->status = Status::STATUS_NEW;
					 if($model->speciality){
						 $model->speciality = implode(',',$model->speciality); 
					 }
					 
					$model->partner_login_id = $partnerLogin->id;					
					$model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
					$model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
					$model->created_at = gmdate('Y-m-d H:i:s');
					$model->updated_at = gmdate('Y-m-d H:i:s');
				  
					if($model->save()) {	
						$partnerLogin->partner_id =$model->id;
						$partnerLogin->save(false);
						 $model->save();
				  
						Yii::$app->getSession()->setFlash('Success', 'Agency has been created successfully.'); 
					} else {
					Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact Administrator.'); 
					}					 	
						
                } else {
                   Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact Administrator.'); 
                } 
            } else {
                Yii::$app->getSession()->setFlash('Error', 'Error! User already exists as partner.Please contact Administrator.');  
            }
			
			 
				return $this->redirect(['agency/index']);
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
     * Updates an existing Agency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

		$countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
       
        if ($model->load(Yii::$app->request->post()) ) {
			 if($model->speciality){
				$model->speciality = implode(',',$model->speciality); 
			 }
					 
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
	
	 public function actionCreatelogin($id)
    {
	 
			
		$model = $this->findModel($id); 
		$to = $model->email;
		$user = $model->name;
		
		$subject = 'Agency Login credentilas link';
		$template = 'createlogin_agency';
		$time = time();	
		$timestring = strtotime('+2 days', $time);
		$timestamp = Commondata::encrypt_decrypt('encrypt',$timestring);
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id);
		
		$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=agency/agency/login&id=' . $encryptedid . '&timestamp=' .$timestamp; 
	   
		$data = array('user' => $user, 'link' => $link);		
		$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		if($mailsent==true){ 
			Yii::$app->getSession()->setFlash('Success', 'We have sent username and password link on your email '.$to.'. Click on link and create login credentials.'); 
		}else{
			Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
		}
			
		return $this->redirect('?r=agency/index'); 
		 
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
 
	
    /**
     * Deletes an existing Agency model.
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
     * Finds the Agency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Agency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Agency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
