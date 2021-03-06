<?php

namespace backend\controllers;

use Yii;
use common\models\Currency;
use backend\models\CurrencySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Country;
use yii\helpers\ArrayHelper;

use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * CurrencyController implements the CRUD actions for Currency model.
 */
class CurrencyController extends Controller
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
     * Lists all Currency models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CurrencySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Currency model.
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
     * Creates a new Currency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Currency();
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }         
            else{
                print_r($model->getErrors());die();
            }   
        }
        return $this->render('create', [
            'model' => $model,
            'countries' => $countries
        ]);
    }

    /**
     * Updates an existing Currency model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {            
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        return $this->render('update', [
            'model' => $model,
            'countries' => $countries
        ]);
    }

    /**
     * Deletes an existing Currency model.
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
     * Finds the Currency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Currency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Currency::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
