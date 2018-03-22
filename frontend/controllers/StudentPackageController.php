<?php

namespace frontend\controllers;

use Yii;
use frontend\models\StudentPackageDetails;
use frontend\models\StudentPackageDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PackageType;
use common\models\PackageSubtype;
use yii\helpers\Json;
use common\models\PackageOfferings;

/**
 * StudentPackageController implements the CRUD actions for StudentPackageDetails model.
 */
class StudentPackageController extends Controller
{
    /**
     * @inheritdoc
     */
  public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(), 
                'rules' => [ 
                    [
                        'actions' => ['index', 'view', 'dependent-package-subtypes', 'dependent-package-offerings', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    /**
     * Lists all StudentPackageDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPackageDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentPackageDetails model.
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
     * Creates a new StudentPackageDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentPackageDetails();
        $packageType = PackageType::getPackageType();
        $model->student_id = Yii::$app->user->identity->id;
        
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                $offerings = implode(',', $model->package_offerings);
                $model->package_offerings = $offerings;
                $temp = PackageSubtype::findOne($model->package_subtype_id);
                $model->limit_type = $temp->limit_type;
                $model->limit_pending = $temp->limit_count;            
                if($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                var_dump($model->errors);
                die();
            }                      
        }
        return $this->render('create', [
            'model' => $model,
            'packageType' => $packageType
        ]);
    }

    /**
     * Finds the StudentPackageDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentPackageDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPackageDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDependentPackageSubtypes() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $package_type_id = $parents[0];
                $subPackages = PackageSubtype::find()->where(['=', 'package_type_id', $package_type_id])->all();                
                echo Json::encode(['output'=>$subPackages, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionDependentPackageOfferings() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $package_type_id = $parents[0];
                $package_subtype_id = $parents[1];
                $subPackages = PackageSubtype::find()->where(['=', 'package_type_id', $package_type_id])->andWhere(['=', 'id', $package_subtype_id])->one();
                $offerings = $subPackages->package_offerings;
                $offerings = explode(',', $offerings);
                $offerings = PackageOfferings::find()->where(['in', 'id', $offerings])->all();                
                echo Json::encode(['output'=>$offerings, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
}
