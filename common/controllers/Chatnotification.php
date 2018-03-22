<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UniversityCourseList;
use common\models\Student;
use common\models\StudentFavouriteUniversities;
use common\models\University;
use common\models\Others;
use common\models\ChatHistory;
use common\components\Roles; 

//use common\models\UniversityCourseList;

/**
 * CourseListController
 */
class ChatnotificationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StudentUniveristyApplication models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		/*Yii::$app->view->params['activeTab'] = 'universities';
		$user = Yii::$app->user->identity->id;
		$models = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$user,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all();
		return $this->render('index', [
		'models' => $models
		]);*/
    }

    public function actionChangenotify() {
    Yii::$app->db->createCommand()
       ->update('chat_history', ['student_notification' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();
       return json_encode(['success' => 'success']);    
    }
}
