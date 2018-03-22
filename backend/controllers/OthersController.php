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
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors;
use common\models\UniversityAdmission;
use common\components\Roles;
use common\components\AccessRule;
use common\models\UniversityCourseList;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\FileUpload;
use backend\models\UniversityDepartments;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;
use yii\helpers\FileHelper;
use frontend\models\UserLogin;
/**
 * UniversityController implements the CRUD actions for University model.
 */
class OthersController extends Controller
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
                        'actions' => ['index','save-changes','coursetype'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_EDITOR]
                    ],
                    [
                        'actions' => ['others','save-changes','coursetype'],
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
        $name = 'course_type';
        $model =$this->getOthers($name);
        return $this->render('index',[ 'model' => $model,]);
    }
      public function actionCoursetype()
    {
        $name = 'course_type';
        $model =$this->getOthers($name);
        return $this->render('coursetype',[ 'model' => $model,]);
    }
    
    public function actionSaveChanges($arr,$list)
    {
         echo $list;
         $model = Others::find()->where(['name'=>$list])->one();
         $model->value = $arr;
         $model->save();
        //return $this->render('coursetype',[ 'model' => $arr,]);
    }
    
  
    private function findCourseModel($id)
    {
        if (($model = UniversityCourseList::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

    /**
     * Finds the University model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return University the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {           
            $model = explode(',', $model->value);
            return $model;
        }
    }   
}
