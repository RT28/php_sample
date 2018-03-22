<?php

namespace backend\controllers;

use Yii;
use common\models\Institute;
use backend\models\InstituteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * InstituteController implements the CRUD actions for Institute model.
 */
class InstituteController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update',],
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
     * Lists all Institute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstituteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Institute model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
        return $this->render('institute_view', [
            'model' => $this->findModel($id),
            'countries' => $countries,
        ]);
    }

     private function validateForm($tabs, $model)
    {
        $rules = [
            'Profile' => ['name', 'address', 'country_id','state_id', 'city_id', 'pincode', 'email','contact_details', 'contact_person', 'contact_person_designation',],
            'About' => ['description'],
            'Services'=>['test_offered','fees_structure'],
            'Branches'=>['branches'],
            'Misc' => ['website','video_url']
        ];     
        $flag = true;
        foreach($tabs as $tab) {            
            if(isset($rules[$tab]) && !$model->validate($rules[$tab])) {             
                $flag = false;
                break;
            }
        }
        if ($flag) {
            return [
                'action' => 'next',
                'count' => count($tabs)
            ];            
        }
        return [
            'action' => 'same'
        ];
    }

    private function getCurrentTabAndTabs($tabs) {
        $map = [
            'Profile' => [
                'currentTab' => 'About',
                'tabs' => ['Profile','About']
            ],
            'Profile,About' => [
                'currentTab' => 'Services',
                'tabs' => ['Profile','About','Services']
            ],
            'Profile,About,Services' => [
                'currentTab' => 'Branches',
                'tabs' => ['Profile','About','Services','Branches']
            ],
            'Profile,About,Services,Branches' => [
                'currentTab' => 'Misc',
                'tabs' => ['Profile','About','Services','Branches','Misc']
            ],
            'Profile,About,Services,Branches,Misc' => [
                'currentTab' => 'Misc',
                'tabs' => ['Profile','About','Services','Branches','Misc']
            ],
        ];

        return $map[$tabs];
    }

  /*  public function actionCreate1()
    {
       $model = Yii::$app->request->post('id');
        if (!empty($model)) {
            $model = $this->findModel($model); 
        } else {
            $model = new Institute();
        }

        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
        
        $model->tests_offered = explode(',', $model->tests_offered);
        if ($model->load(Yii::$app->request->post())) {
               if(is_array($model->tests_offered)){
                $model->tests_offered= implode(',', $model->tests_offered);
                }             
                  
            $model->fees_structure = Yii::$app->request->post('fees_structure');  
             $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();

            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->save();
             if($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }      
            }
           
                return $this->render('create-new', [
                'id' => isset($model->id) ? $model->id : null,
                'model' => $model,
                'countries' => $countries,
            ]);
            
    }*/


    /**
     * Creates a new Institute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  public function actionCreate()
    {
       $model = Yii::$app->request->post('id');
        if (!empty($model)) {
            $model = $this->findModel($model); 
        } else {
            $model = new Institute();
        }

        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
        $currentTab = 'Profile';
        $tabs = ['Profile'];
       
        $model->tests_offered = explode(',', $model->tests_offered);
        if ($model->load(Yii::$app->request->post())) {
            $model->fees_structure = Yii::$app->request->post('fees_structure'); 
            
              if(is_array($model->tests_offered)){
                $model->tests_offered= implode(',', $model->tests_offered);
                } 

                $currentTab = Yii::$app->request->post('currentTab');                                 
                $tabs = explode(',', Yii::$app->request->post('tabs'));                        
                $result = $this->validateForm($tabs, $model); 
                print_r($result);
         
              if ($result['action'] === 'next') {     
                 if ($result['count'] >= 3) {             
                    $model->fees_structure = Yii::$app->request->post('fees_structure');
                    

                    $isModelSaved = $model->save(false);                    
                }   

                if ($result['count'] >= 5 ) {        
                      
                    $model->fees_structure = Yii::$app->request->post('fees_structure');
                    $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                    $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                    $model->created_at = gmdate('Y-m-d H:i:s');
                    $model->updated_at = gmdate('Y-m-d H:i:s');                                 
                    $isModelSaved = $model->save(false);
                    if($isModelSaved)
                      return $this->redirect(['view', 'id' => $model->id]);                   
                }      
                
                }                
                $tabs = $this->getCurrentTabAndTabs(implode(',', $tabs));                                                        
                $currentTab = $tabs['currentTab'];                
                $tabs = $tabs['tabs'];
            }             
       
           return $this->render('create', [
                'id' => isset($model->id) ? $model->id : null,
                'model' => $model,
                'countries' => $countries,
                'currentTab' => $currentTab,
                'tabs' => $tabs,
            ]);
    }

    /**
     * Updates an existing Institute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name'); 
        $model->tests_offered = explode(',', $model->tests_offered);
        $currentTab = 'Profile';
        $tabs = ['Profile','About','Services','Branches','Misc'];

        if ($model->load(Yii::$app->request->post())) {
              if(is_array($model->tests_offered)){
                $model->tests_offered= implode(',', $model->tests_offered);
            }        
            $model->save();
          
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'id'=>$id,
                'model' => $model,
                'countries' => $countries,
                'currentTab' => $currentTab,
                'tabs' => $tabs,
            ]);
        }
    }

    /**
     * Deletes an existing Institute model.
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
     * Finds the Institute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Institute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Institute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
