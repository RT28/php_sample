<?php

namespace backend\controllers;

use Yii;
use common\models\University;
use backend\models\UniversitySearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\StudentUniversityApplicationSearchNew;
use common\models\StudentUniveristyApplication;
use common\models\Consultant;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors;
use common\models\UniversityAdmission;
use common\components\Roles;
use common\components\AccessRule;
use common\models\UniversityCourseList;
use common\models\FileUpload;
use common\models\Currency;
use common\models\Others;
use common\models\DegreeLevel;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use backend\models\UniversityDepartments;
use common\components\Model;
use yii\helpers\FileHelper;
/**
 * UniversityController implements the CRUD actions for University model.
 */
class AdminUniversityController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'dependent-states', 'dependent-cities', 'dependent-courses', 'upload-photos', 'delete-photo', 'dependent-courses','view-applications','university-applications-view','university-applications-update','update-state'],
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
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     */
    private function getCurrentTabAndTabs($tabs) {
        $map = [
            'ProfileView' => [
                'currentTab' => 'About',
                'tabs' => ['Profile', 'About']
            ],
            'Profile,About' => [
                'currentTab' => 'Misc',
                'tabs' => ['Profile', 'About', 'Misc']
            ],
            'Profile,About,Misc' => [
                'currentTab' => 'Department',
                'tabs' => ['Profile', 'About', 'Misc', 'Department']
            ],
            'Profile,About,Misc,Department' => [
                'currentTab' => 'Gallery',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery']
            ],
            'Profile,About,Misc,Department,Gallery' => [
                'currentTab' => 'Admissions',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery','Admissions']
            ],
            'Profile,About,Misc,Department,Gallery,Admissions' => [
                'currentTab' => 'Admissions',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery','Admissions']
            ],
        ];

        return $map[$tabs];
    }

    /**
     * Creates a new University model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    

    private function findCourseModel($id)
    {
        if (($model = UniversityCourseList::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

   
    protected function findModel($id)
    {
        if (($model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    public function actionViewApplications($id) {        
        $searchModel = new StudentUniversityApplicationSearchNew();
        $query = StudentUniveristyApplication::find()->where(['university_id' => $id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$query);
          return $this->render('applications', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

      public function actionUniversityApplicationsView($id)
    {
        return $this->render('university-applications-view', [
            'model' => $this->findModelApplication($id),
        ]);
    }

    

    protected function findModelApplication($id)
    {
        if (($model = StudentUniveristyApplication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   
}
