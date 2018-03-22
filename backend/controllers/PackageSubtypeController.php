<?php

namespace backend\controllers;

use Yii;
use common\models\PackageSubtype;
use backend\models\PackageSubtypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use common\models\PackageType;
use common\models\Currency;
use common\components\PackageLimitType;
use common\models\PackageOfferings;

use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl;

/**
 * PackageSubtypeController implements the CRUD actions for PackageSubtype model.
 */
class PackageSubtypeController extends Controller
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
     * Lists all PackageSubtype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PackageSubtypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PackageSubtype model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $offerings = $model->package_offerings;
        $offerings = explode(',', $offerings);
        $temp = PackageOfferings::find()->where(['in', 'id', $offerings])->all();
        $offerings = "";
        foreach($temp as $value) {
            $offerings .= $value->name . ',';
        }

        return $this->render('view', [
            'model' => $model,
            'offerings' => $offerings
        ]);
    }

    /**
     * Creates a new PackageSubtype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PackageSubtype();
        $packageType = PackageType::getPackageType();
        $currency = Currency::getCurrency();
        $limitType = PackageLimitType::getPackageLimitType();
        $packageOfferings = PackageOfferings::getPackageOfferings();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();          
            $offerings = implode(',', $model->package_offerings);
            $model->package_offerings = $offerings;            
            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        return $this->render('create', [
            'model' => $model,
            'packageType' => $packageType,
            'currency' => $currency,
            'limitType' => $limitType,
            'packageOfferings' => $packageOfferings
        ]);
    }

    /**
     * Updates an existing PackageSubtype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $packageType = PackageType::getPackageType();
        $currency = Currency::getCurrency();
        $limitType = PackageLimitType::getPackageLimitType();
        $packageOfferings = PackageOfferings::getPackageOfferings();
        $offerings = $model->package_offerings;
        $offerings = explode(',', $offerings);
        $model->package_offerings = $offerings;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $offerings = implode(',', $model->package_offerings);
            $model->package_offerings = $offerings;
            if($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }            
        }
        return $this->render('update', [
            'model' => $model,
            'packageType' => $packageType,
            'currency' => $currency,
            'limitType' => $limitType,
            'packageOfferings' => $packageOfferings
        ]);
    }

    /**
     * Deletes an existing PackageSubtype model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Status::STATUS_INACTIVE;
        if($model->save()) {
            return $this->redirect(['index']);
        }
        return $this->redirect(Yii::$app->request->referrer);  
    }

    /**
     * Finds the PackageSubtype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PackageSubtype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PackageSubtype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}