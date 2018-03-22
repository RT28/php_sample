<?php

namespace partner\modules\consultant\controllers;

use Yii;
use common\models\University;
use partner\modules\consultant\models\UniversitySearch;
use backend\models\SiteConfig;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\components\Roles;
use common\components\AccessRule;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\FileUpload;
use common\components\Model;
use common\models\Others;
use yii\helpers\FileHelper;
use yii\base\ErrorException;

use common\components\ConnectionSettings;
use yii\db\IntegrityException; 

/**
 * UniversityController implements the CRUD actions for University model.
 */
class UniversityController extends Controller
{
    /**
     * @inheritdoc
     */    
    
    private $failed_bulk_models;
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'dependent-states', 'dependent-cities', 'dependent-courses', 'upload-photos', 'delete-photo', 'delete-logo', 'dependent-courses', 'dependent-majors', 'upload-university', 'upload-programs', 'upload-admissions', 'createlogin'],
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
    }*/

    /**
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'university';
        $searchModel = new UniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$message = '';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			//'message' =>  $message,
        ]);
    }

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     */
        public function actionView($id)
    {
        $model = $this->findModel($id);
        $univinfocategory = "SELECT * FROM university_info_category";
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
            SELECT * FROM university_info_category");

        $univinfocategory = $command->queryAll();
        return $this->render('view', [
            'id' => $id,
            'model' => $model,
            'univinfocategory' => $univinfocategory,
        ]);
    }



    protected function findModel($id)
    {
        if (($model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

 
	
}
