<?php

namespace backend\controllers;

use Yii;
use backend\models\Employee;
use backend\models\EmployeeLogin;
use backend\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use yii\helpers\Json;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
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
                        'actions' => ['index', 'view', 'create', 'update','dependent-states','disable','enable'],
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();
        $loginmodel = new EmployeeLogin();
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
        $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->updated_at = gmdate('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $loginmodel->load(Yii::$app->request->post()) && $model->validate()) {            
            $loginmodel->setPassword($loginmodel->password);
            $loginmodel->generateAuthKey();
            $loginmodel->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $loginmodel->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $loginmodel->created_at = gmdate('Y-m-d H:i:s');
            $loginmodel->updated_at = gmdate('Y-m-d H:i:s');
            if($loginmodel->save()){
                $model->employee_id = $loginmodel->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);    
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'countries' => $countries,
                'loginmodel'=> $loginmodel
            ]);
        }
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $loginmodel = EmployeeLogin::find()->where(['id'=>$model->employee_id])->one();
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            $model->updated_by = Yii::$app->user->identity->id;            
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);    
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'countries' => $countries,
                'loginmodel'=>$loginmodel
            ]);
        }
    }

    /**
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
     public function actionDisable($id)
    {
        $model= $this->findModel($id);
        $model->employeeLogins->status = 0;
        $model->employeeLogins->save(false);
        if($model->employeeLogins->save(false)){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->employeeLogins->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        }    
    }

    public function actionEnable($id)
    {
        $model= $this->findModel($id);
        $model->employeeLogins->status = 10;
        $model->employeeLogins->save(false);
        if( $model->employeeLogins->save(false)){
            return Json::encode(['status' => 'success' , 'message' => 'complete','data'=>$model->employeeLogins->status]);
        }else{
            return Json::encode(['status' => 'error' , 'message' => 'Error while saving in db.']);
        } 
    }
}
