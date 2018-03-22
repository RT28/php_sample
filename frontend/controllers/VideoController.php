<?php
namespace frontend\controllers;

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
use common\components\Commondata;
use partner\models\PartnerLogin;
use common\models\ChatvideoNotificarion;
use common\components\AccessRule;
use yii\filters\AccessControl;
use common\models\User;

class VideoController extends \yii\web\Controller
{

        public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
                'only'=> ['videocall'],
                'rules' => [
                    [
                        'actions' => ['videocall'
                        ],
                        'allow' => true, 
                        'roles' => ['@'],
                    ],
                     
                ]
            ],
        ];
    } 

    public function actionChat() {
        Yii::$app->view->params['activeTab'] = 'chat';
        $consultantid = Yii::$app->request->get('id');
        $consultantid = Commondata::encrypt_decrypt('decrypt', $consultantid);
        $current_date = gmdate('Y-m-d H:i:s');
        $sessionQuery = '';
        $message = '';
        $token = '';
        if(isset($consultantid) AND $consultantid!=''){
        $sessionQuery = CalendarSessionTokenRelation::find()
                        ->where(['=', 'student_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'consultant_id', $consultantid])->one();
        if(empty($sessionQuery)) {
            $sessionQuery = new CalendarSessionTokenRelation();
            $sessionQuery->student_id = Yii::$app->user->identity->id;
            $sessionQuery->consultant_id = $consultantid;            
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
        $chatHistory =  ChatHistory::find()->where(['=', 'student_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'partner_login_id', $consultantid])->all();
        $role = PartnerLogin::find()
                  ->where(['=', 'id', $consultantid])
                  ->one();
        $role =  $role->role_id; 
        if($role == Roles::ROLE_CONSULTANT){
        $chat_name = Consultant::find()->where(['=', 'partner_login_id', $consultantid])->one();
        $name =  $chat_name->first_name. " " .$chat_name->last_name;
        $logged_status =  $chat_name->logged_status;
        //$my_id =  $chat_name->consultant_id;
        } else {
        $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $consultantid])->one();
        $name =  $chat_name->first_name. " " .$chat_name->last_name;
        $logged_status =  $chat_name->logged_status; 
       // $my_id =  $chat_name->consultant_id;   
        }
        Yii::$app->db->createCommand()
       ->update('chat_history', ['student_read_status' => 1], ['student_id' => Yii::$app->user->identity->id, 'partner_login_id' => $consultantid])
       ->execute();
        /*$m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_STUDENT)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);*/
        return $this->render('chat', [
            'message' => $message,
            'chat_name' => $name,
            'logged_status' => $logged_status,
            //'m_count' => $m_count,
            'chatHistory' => $chatHistory,
            'partner_login_id' => $consultantid,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
        } else{
            return $this->render('chat', []);
        }
    }
    
    public function actionVideocall($consultantid=1) {
        Yii::$app->view->params['activeTab'] = 'chat';
        $consultantid = Yii::$app->request->get('id');
        $callType = Yii::$app->request->get('q');
        $consultantid = Commondata::encrypt_decrypt('decrypt', $consultantid);
        $current_date = gmdate('Y-m-d H:i:s');
        $sessionQuery = '';
        $message = '';
        $token = '';
        $sessionQuery = CalendarSessionTokenRelation::find()
                        ->where(['=', 'student_id', Yii::$app->user->identity->id])
                        ->andWhere(['=', 'consultant_id', $consultantid])->one();
        if(empty($sessionQuery)) {
            $sessionQuery = new CalendarSessionTokenRelation();
            $sessionQuery->student_id = Yii::$app->user->identity->id;
            $sessionQuery->consultant_id = $consultantid;            
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
            $model->partner_login_id = $consultantid;
            $model->student_id = Yii::$app->user->identity->id; 
            $model->role_id = Roles::ROLE_STUDENT;
            $model->call_partner = 0;             
            $model->save(false);
        if($callType == 'video'){    
        return $this->render('video', [
            'message' => $message,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
        } else {
           return $this->render('audio', [
            'message' => $message,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
        }
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
        $online_consultants = array(); 
        $consultants = Consultant::find()
        ->leftJoin('student_consultant_relation', 'student_consultant_relation.consultant_id = consultant.consultant_id') 
        ->where('student_consultant_relation.student_id = '.$id)
        ->andWhere('consultant.logged_status = 1')
        ->all();
        foreach($consultants as $consultant){
            $alertTime = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($consultant['last_active'])));
            if(gmdate('Y-m-d H:i:s') > $alertTime){
            $active_con = 0;
            } else { $active_con = 1; }
            array_push($online_consultants,[$consultant['id'],$active_con]);
        }

        /*To find online trainees*/
        $online_trainees = array(); 
        $trainees = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_TRAINER)
        ->andWhere('partner_employee.profile_type = '.Roles::PROFILE_TRAINER)
        ->andWhere('partner_employee.logged_status = 1')
        ->all();
        foreach($trainees as $trainee){
            array_push($online_trainees, $trainee['id']);
        }

        /*To find online editors*/
        $online_editors = array(); 
        $editors = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_TRAINER)
        ->andWhere('partner_employee.profile_type = '.Roles::PROFILE_EDITOR)
        ->andWhere('partner_employee.logged_status = 1')
        ->all();
        foreach($editors as $editor){
            array_push($online_editors, $editor['id']);
        }

        /*To find online employees*/
        $online_employees = array(); 
        $employees = PartnerEmployee::find()
        ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
        ->where('student_partneremployee_relation.student_id = '.$id)
        ->andWhere('partner_employee.role_id = '.Roles::ROLE_EMPLOYEE)
        ->andWhere('partner_employee.logged_status = 1')
        ->all(); 
        foreach($employees as $employee){
            array_push($online_employees, $employee['id']);
        }
        /*To set the current opened partner messages as read by student*/
        if(isset($_POST['partner_login_id']) AND $_POST['partner_login_id']!==''){ 
                  Yii::$app->db->createCommand()
                   ->update('chat_history', ['student_read_status' => 1], ['student_id' => $id, 'partner_login_id' => $_POST['partner_login_id']])
                   ->execute();
                }
        /*end*/ 
        /*To find the unread messages for student sent by consultant*/
        $messages_consultant = (new \yii\db\Query())
                    ->select(['partner_login_id'])
                    ->from('chat_history')
                    ->where('student_id = '.$id)
                    ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
                    ->andWhere('student_read_status = 0')
                    ->distinct()
                    ->all();
                    if($messages_consultant){
                        
                        $unread_consultants = array();
                        foreach ($messages_consultant as $message) {
                            $m_count = ChatHistory::find()
                            ->where('student_id = '.$id)
                            ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
                            ->andWhere('partner_login_id = '.$message['partner_login_id'].'')
                            ->andWhere('student_read_status = 0')
                            ->all();
                            $m_count =  count($m_count);
                         array_push($unread_consultants,[$message['partner_login_id'],$m_count]);
                        }
                    }
        /*To find the unread messages for student sent by trainees*/            
        $messages_trainees = (new \yii\db\Query())
                    ->select(['partner_login_id'])
                    ->from('chat_history')
                    ->where('student_id = '.$id)
                    ->andWhere('role_id = '.Roles::ROLE_TRAINER)
                    ->andWhere('student_read_status = 0')
                    ->distinct()
                    ->all();
                    if($messages_trainees){
                        
                        $unread_trainees = array();
                        foreach ($messages_trainees as $message) {
                            $m_count = ChatHistory::find()
                            ->where('student_id = '.$id)
                            ->andWhere('role_id = '.Roles::ROLE_TRAINER)
                            ->andWhere('partner_login_id = '.$message['partner_login_id'].'')
                            ->all();
                            $m_count =  count($m_count);
                         array_push($unread_trainees,[$message['partner_login_id'],$m_count]);
                        }
                    }
        /*To find the unread messages for student sent by employee*/            
        $messages_employees = (new \yii\db\Query())
                    ->select(['partner_login_id'])
                    ->from('chat_history')
                    ->where('student_id = '.$id)
                    ->andWhere('role_id = '.Roles::ROLE_EMPLOYEE)
                    ->andWhere('student_read_status = 0')
                    ->distinct()
                    ->all();
                    if($messages_employees){
                        
                        $unread_employees = array();
                        foreach ($messages_employees as $message) {
                            $m_count = ChatHistory::find()
                            ->where('student_id = '.$id)
                            ->andWhere('role_id = '.Roles::ROLE_EMPLOYEE)
                            ->andWhere('partner_login_id = '.$message['partner_login_id'].'')
                            ->all();
                            $m_count =  count($m_count);
                         array_push($unread_employees,[$message['partner_login_id'],$m_count]);
                        }
                    }
        /*To find total number of unread messages for student*/            
        $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('sender_id != '.Yii::$app->user->identity->id)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count);                                    
         /*$unread_consultants = array();               
        $messages = ChatHistory::find()->distinct('partner_login_id')
        ->where('student_id = '.$id)
        ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
        ->andWhere('student_read_status = 0')
        ->all();
        foreach($messages as $message){
            $m_count = ChatHistory::find()->distinct()
            ->where('student_id = '.$id)
            ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
            ->andWhere('partner_login_id = '.$message['partner_login_id'].'')
            ->all();
            $m_count =  count($m_count);
            array_push($unread_consultants,[$message['partner_login_id'],$m_count]);
        }*/

        $student_active = User::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        $student_active->last_active = gmdate('Y-m-d H:i:s');                
        $student_active->save(false);

        return json_encode(['online_consultants' => $online_consultants , 'online_trainees' => $online_trainees , 'online_editors' => $online_editors , 'online_employees' => $online_employees,'unread_consultants' => $unread_consultants,'unread_trainees' => $unread_trainees,'unread_employees' => $unread_employees,'unread_total' => $m_count]);
        
    }
    public function actionSavechat() {
        $student_id = Yii::$app->user->identity->id;
        //echo $_POST['partner_login_id'];
            $model = new ChatHistory();
            $model->student_id = $student_id;
            $model->partner_login_id = $_POST['partner_login_id']; 
            $model->sender_id = $student_id;
            $model->role_id = Roles::ROLE_STUDENT;
            $model->message = $_POST['message'];   
            $model->created_at = gmdate('Y-m-d H:i:s');          
            $model->save(false);
            return true;            
     }

    public function actionGetchatcount(){
        $m_count = ChatHistory::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id = '.Roles::ROLE_STUDENT)
        ->andWhere('student_read_status = 0')
        ->all();
        $m_count =  count($m_count); echo $m_count;
    } 

    /*public function actionChatnotification() {
        
        $student_calls = array();
        $notify_user = ChatvideoNotificarion::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('call_student = 0')
        ->distinct()
        ->all();
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_CONSULTANT){
            $chat_name = Consultant::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['partner_login_id']);
            array_push($student_calls, [$notify['partner_login_id'],$name,$ids]);
            //array_push($student_calls, [$notify['partner_login_id'],$name]);
        }
        Yii::$app->db->createCommand()
       ->update('chat_call_notification', ['call_student' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();

        return json_encode(['student_calls' => $student_calls]);

        
        }*/
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

        $student_calls = array();
        $notify_user = ChatvideoNotificarion::find()
        ->where('student_id = '.Yii::$app->user->identity->id)
        ->andWhere('role_id != '.Roles::ROLE_STUDENT)
        ->andWhere('call_student = 0')
        ->distinct()
        ->all();
        foreach($notify_user as $notify){
            if($notify['role_id'] == Roles::ROLE_CONSULTANT){
            $chat_name = Consultant::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            } else {
            $chat_name = PartnerEmployee::find()->where(['=', 'partner_login_id', $notify['partner_login_id']])->one();
            $name =  $chat_name->first_name. " " .$chat_name->last_name;
            }
            $ids = Commondata::encrypt_decrypt('encrypt', $notify['partner_login_id']);
            array_push($student_calls, [$notify['partner_login_id'],$name,$ids]);
            //array_push($student_calls, [$notify['partner_login_id'],$name]);
        }
        /*Yii::$app->db->createCommand()
       ->update('chat_call_notification', ['call_student' => 1], ['student_id' => Yii::$app->user->identity->id])
       ->execute();*/

        return json_encode(['student_calls' => $student_calls ,'student_chats' => $student_chats]);

        /*call notification*/  
        
        }
}
