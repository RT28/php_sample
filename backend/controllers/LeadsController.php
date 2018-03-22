<?php

namespace backend\controllers;

use Yii;
use common\models\Student;
use backend\models\LeadsSearch;
use backend\models\SiteConfig;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use common\components\Roles;
use common\components\AccessRule; 
use yii\db\Expression;
use yii\helpers\Json; 
use backend\models\UniversityDepartments; 
use yii\helpers\FileHelper; 
use common\models\StandardTests;
use yii\base\ErrorException; 
use yii\db\IntegrityException; 
use common\models\Consultant;
use common\models\User;


/**
 * UniversityController implements the CRUD actions for University model.
 */
class LeadsController extends Controller
{
    /**
     * @inheritdoc
     */    
    
    //private $failed_bulk_models;
    

    /**
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$message = '';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			//'message' =>  $message,
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
            'model' => $this->findModel($id)
        ]);
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
