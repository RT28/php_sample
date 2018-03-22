<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ChatHistory;
use common\components\Roles; 
use common\components\Commondata;
use common\models\Consultant;

/**
 * HomeSearchController
 */
class ApplicationFormController extends Controller
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

    public function actionIndex() {
        $id = Yii::$app->user->identity->student->id;
        $schools = Yii::$app->user->identity->studentSchoolDetails;
        $colleges = Yii::$app->user->identity->studentCollegeDetails;
        $subjects = Yii::$app->user->identity->studentSubjectDetails;
        $englishProficiency = Yii::$app->user->identity->studentEnglishLanguageProficienceyDetails;
        $standardTests = Yii::$app->user->identity->studentStandardTestDetails;
        Yii::$app->view->params['activeTab'] = 'application';
        return $this->render('index', [
            'schools' => $schools,
            'colleges' => $colleges,
            'subjects' => $subjects,
            'englishProficiency' => $englishProficiency,
            'standardTests' => $standardTests
        ]);
    }
	
	/**********************************************
	  @Created By:- Pankaj
	  @Uses :- This Method will show Application create Form
	  *********************************************/
	  
	public function actionCreate() {
        $id = Yii::$app->user->identity->student->id;
        $schools = Yii::$app->user->identity->studentSchoolDetails;
        $colleges = Yii::$app->user->identity->studentCollegeDetails;
        $subjects = Yii::$app->user->identity->studentSubjectDetails;
        $englishProficiency = Yii::$app->user->identity->studentEnglishLanguageProficienceyDetails;
        $standardTests = Yii::$app->user->identity->studentStandardTestDetails;
        Yii::$app->view->params['activeTab'] = 'application';
        return $this->render('create', [
            'schools' => $schools,
            'colleges' => $colleges,
            'subjects' => $subjects,
            'englishProficiency' => $englishProficiency,
            'standardTests' => $standardTests
        ]);
		
		
    }
	public function actionGetchatcount() {
    $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);
    return json_encode(['unread_total' => $m_count]);    
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