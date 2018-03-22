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
use common\components\Commondata;
use common\models\Consultant;

//use common\models\UniversityCourseList;

/**
 * CourseListController
 */
class FavouriteUniversitiesController extends Controller
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
		
		Yii::$app->view->params['activeTab'] = 'universities';
		$user = Yii::$app->user->identity->id;
		$models = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$user,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all();
		return $this->render('index', [
		'models' => $models
		]);
    }

	public function actionStudentNotSubscribed()
    {
		
		Yii::$app->view->params['activeTab'] = 'universities';
		$user = Yii::$app->user->identity->id;
		$models = StudentFavouriteUniversities::find()->where(['AND',['student_id'=>$user,'favourite'=>'1']])->orderBy(['id' => 'DESC'])->all();
		return $this->render('index_not_subscribed', [
		'models' => $models
		]);
    }
	
    public function actionRemove() {
        $user = Yii::$app->user->identity->id;
        $university = $_POST['university'];

        $model = StudentFavouriteUniversities::find()->where(['AND', ['=', 'student_id', $user], ['=', 'university_id', $university]])->one();

        if(empty($model)) {
            return json_encode(['status' => 'failure', 'message' => 'University not in favourites!']);
        }

        if($model->delete() !== false) {
            return json_encode(['status' => 'success']);
        }

        return json_encode(['status' => 'failure', 'message' => 'Error deleting university from favourites!']);
    }
    public function actionGetchatcount() {
    $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);
    $notify_user = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->andWhere('student_notification = 0')
        ->all();
        $notify_user =  count($notify_user);    
    return json_encode(['unread_total' => $m_count,'notify_user' => $notify_user,'student_id' => Yii::$app->user->identity->id]);    
    }

    public function actionChangenotify() {
    Yii::$app->db->createCommand()
       ->update('chat_history', ['student_notification' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();
       return json_encode(['success' => 'success']);    
    }
    public function actionChatnotification() {
        $student_chats = array();
        $notify_user = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->andWhere('student_notification = 0')
        ->distinct()
        ->all();
        //$notify_user =  count($notify_user);
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_CONSULTANT){
            $chat_name = Consultant::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['partner_login_id']);
            array_push($student_chats, [$notify['partner_login_id'],$name,$ids]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_history', ['student_notification' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();
        return json_encode(['student_chats' => $student_chats]);    
        
        }
}
