<?php
namespace partner\modules\consultant\controllers;

use Yii;
use common\models\Consultant;
use common\models\Country;
use common\models\Degree;
use yii\helpers\ArrayHelper;
use common\components\Status;
use common\components\Roles;
use common\models\FileUpload;
use yii\web\UploadedFile;
use common\models\Others;
use yii\helpers\Json;
use common\models\ConsultantCalendar;
use frontend\models\StudentCalendar;
use common\models\CalendarSessionTokenRelation;
use common\components\CalendarEvents;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use common\components\ConnectionSettings;
use common\models\PartnerEmployee;
use common\models\ChatHistory;
use common\models\ChatvideoNotificarion;
use common\models\User;
use common\components\Commondata;

class VideoController extends \yii\web\Controller
{
    
    public function actionChat() {
        $studentid = Yii::$app->request->get('id');
        $studentid = Commondata::encrypt_decrypt('decrypt', $studentid);
        $current_date = gmdate('Y-m-d H:i:s');
        $sessionQuery = '';
        $message = '';
        $token = '';
        if(isset($studentid) AND $studentid!=''){
        $sessionQuery = CalendarSessionTokenRelation::find()
                        ->where(['=', 'consultant_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'student_id', $studentid])->one();
        if(empty($sessionQuery)) {
            $sessionQuery = new CalendarSessionTokenRelation();
            $sessionQuery->consultant_id = Yii::$app->user->identity->id;
            $sessionQuery->student_id = $studentid;            
            $sessionQuery->start = gmdate('Y-m-d H:i:s');
            $sessionQuery->end = gmdate('Y-m-d H+1:i:s');
            $sessionQuery->time_stamp = gmdate('U');
            $openTok = new OpenTok(ConnectionSettings::OPEN_TOK_API_KEY, ConnectionSettings::OPEN_TOK_API_SECRET);
            $session = $openTok->createSession(['mediaMode' => MediaMode::ROUTED]);
            $sessionQuery->session_id = $session->getSessionId();
            $sessionQuery->created_by = Yii::$app->user->identity->id;
            $sessionQuery->updated_by = Yii::$app->user->identity->id;
            $sessionQuery->created_at = gmdate('Y-m-d H:i:s');
            $sessionQuery->updated_at = gmdate('Y-m-d H:i:s');
            $token = $openTok->generateToken($sessionQuery->session_id);
            if(isset($event->student_appointment_id)) {
                $sessionQuery->student_id = $student_event->student_id;
            }
            if($sessionQuery->save()) {
                $message = 'Error generating Session. Please contact site admin!';
            }
        } else {
            $openTok = new OpenTok(ConnectionSettings::OPEN_TOK_API_KEY, ConnectionSettings::OPEN_TOK_API_SECRET);
            $token = $openTok->generateToken($sessionQuery->session_id);
        }
        $chatHistory =  ChatHistory::find()->where(['=', 'partner_login_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'student_id', $studentid])->all();
        $chat_name = User::find()->where(['=', 'id', $studentid])->one();
        $name =  $chat_name->first_name. " " .$chat_name->last_name; 
         
        /*$m_count = ChatHistory::find()
        ->where('partner_login_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
        ->andWhere('partner_read_status = 0')
        ->all();
        $m_count =  count($m_count); */
          Yii::$app->db->createCommand()
           ->update('chat_history', ['partner_read_status' => 1], ['partner_login_id' => Yii::$app->user->identity->id, 'student_id' => $studentid])
           ->execute();
        return $this->render('chat', [
            'message' => $message,
            'chat_name' => $name,
            //'m_count' => $m_count,
            'chatHistory' => $chatHistory,
            'partner_login_id' => $studentid,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
        } else{
            return $this->render('chat', [
            
        ]);

        }
    }
    
    public function actionVideocall() {
        $studentid = Yii::$app->request->get('id');
        $studentid = Commondata::encrypt_decrypt('decrypt', $studentid);
        $current_date = gmdate('Y-m-d H:i:s');
        $sessionQuery = '';
        $message = '';
        $token = '';
        $sessionQuery = CalendarSessionTokenRelation::find()
                        ->where(['=', 'consultant_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'student_id', $studentid])->one();
        if(empty($sessionQuery)) {
            $sessionQuery = new CalendarSessionTokenRelation();
            $sessionQuery->consultant_id = Yii::$app->user->identity->id;
            $sessionQuery->student_id = $studentid;            
            $sessionQuery->start = gmdate('Y-m-d H:i:s');
            $sessionQuery->end = gmdate('Y-m-d H+1:i:s');
            $sessionQuery->time_stamp = gmdate('U');
            $openTok = new OpenTok(ConnectionSettings::OPEN_TOK_API_KEY, ConnectionSettings::OPEN_TOK_API_SECRET);
            $session = $openTok->createSession(['mediaMode' => MediaMode::ROUTED]);
            $sessionQuery->session_id = $session->getSessionId();
            $sessionQuery->created_by = Yii::$app->user->identity->id;
            $sessionQuery->updated_by = Yii::$app->user->identity->id;
            $sessionQuery->created_at = gmdate('Y-m-d H:i:s');
            $sessionQuery->updated_at = gmdate('Y-m-d H:i:s');
            $token = $openTok->generateToken($sessionQuery->session_id);
            if(isset($event->student_appointment_id)) {
                $sessionQuery->student_id = $student_event->student_id;
            }
            if($sessionQuery->save()) {
                $message = 'Error generating Session. Please contact site admin!';
            }
        } else {
            $openTok = new OpenTok(ConnectionSettings::OPEN_TOK_API_KEY, ConnectionSettings::OPEN_TOK_API_SECRET);
            $token = $openTok->generateToken($sessionQuery->session_id);
        }
        $model = new ChatvideoNotificarion();
            $model->student_id = $studentid;
            $model->partner_login_id = Yii::$app->user->identity->id; 
            $model->role_id = Roles::ROLE_CONSULTANT;
            $model->call_student = 0;
            $model->created_at = gmdate('Y-m-d H:i:s + 3 minute');             
            $model->save(false);
        return $this->render('video', [
            'message' => $message,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
    }
    public function actionRoom($ref=1){
        $token = Yii::$app->user->identity->id.'-'.$ref;
        return $this->render('room', [
            //'message' => $message,
            'openTokSessionToken' => $token,
        ]);
    }
    public function actionInbox(){
        return $this->render('inbox');
    }
    
    public function actionChat1(){
        return $this->render('chat');
    }
    
    public function actionTask(){
        return $this->render('task');
    }

    public function actionGetloggeduser(){
        $id = Yii::$app->user->identity->id;

        /*To find online consultants*/
        $online_students = array(); 
        $students = User::find()
        ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.$id.'')
        ->andWhere('user_login.logged_status = 1')
        ->all();

        /*$consultants = Consultant::find()
        ->leftJoin('student_consultant_relation', 'student_consultant_relation.consultant_id = consultant.consultant_id') 
        ->where('student_consultant_relation.student_id = '.$id)
        ->andWhere('consultant.logged_status = 1')
        ->all();*/
        foreach($students as $student){
            $alertTime = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($student['last_active'])));
            if(gmdate('Y-m-d H:i:s') > $alertTime){
            $active_con = 0;
            } else { $active_con = 1; }
            array_push($online_students, [$student['id'],$active_con]);
        }
        /*To set the current opened student messages as read by consultant*/
        if(isset($_POST['partner_login_id']) AND $_POST['partner_login_id']!==''){ 
                  Yii::$app->db->createCommand()
                   ->update('chat_history', ['partner_read_status' => 1], ['partner_login_id' => $id, 'student_id' => $_POST['partner_login_id']])
                   ->execute();
                }
        /*end*/ 
        /*To find the unread messages for consultant sent by student*/
        $messages_student = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('chat_history')
                    ->where('partner_login_id = '.$id)
                    ->andWhere('role_id = '.Roles::ROLE_STUDENT)
                    ->andWhere('partner_read_status = 0')
                    ->distinct()
                    ->all();
                    if($messages_student){
                        
                        $unread_students = array();
                        foreach ($messages_student as $message) {
                            $m_count = ChatHistory::find()
                            ->where('partner_login_id = '.$id)
                            ->andWhere('role_id = '.Roles::ROLE_STUDENT)
                            ->andWhere('student_id = '.$message['student_id'].'')
                            ->andWhere('partner_read_status = 0')
                            ->all();
                            $m_count =  count($m_count);
                         array_push($unread_students,[$message['student_id'],$m_count]);
                        }
                    }
        /*to update logged active*/
            $consultant_active = Consultant::find()->where(['consultant_id'=>$id])->one();
            $consultant_active->last_active = gmdate('Y-m-d H:i:s');                
            $consultant_active->save(false);
        /*To find total number of unread messages for consultant*/            
        $m_count = ChatHistory::find()
        ->where('partner_login_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_CONSULTANT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('PARTNER_read_status = 0')
        ->all();
        $m_count =  count($m_count);              
        return json_encode(['online_students' => $online_students,'unread_students' => $unread_students,'unread_total' => $m_count]);
        
    }
    public function actionSavechat() {
        $consultant_id = Yii::$app->user->identity->id;
        //echo $_POST['partner_login_id'];
            $model = new ChatHistory();
            $model->student_id = $_POST['partner_login_id'];
            $model->partner_login_id = $consultant_id; 
            $model->sender_id = $consultant_id;
            $model->message = $_POST['message'];
            $model->role_id = Roles::ROLE_CONSULTANT;
            $model->created_at = gmdate('Y-m-d H:i:s');             
            $model->save(false);
            return true;            
     }
}
