<?php
namespace partner\modules\counselor\controllers;

use Yii;
use partner\models\PartnerLogin;
use partner\models\CounselorEnquiry;
use common\models\SRM;
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
use common\models\SrmCalendar;
use frontend\models\StudentCalendar;
use common\models\CalendarSessionTokenRelation;
use common\components\CalendarEvents;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use common\components\ConnectionSettings;

class VideoController extends \yii\web\Controller
{
    public function actionChat() {
        $current_date = gmdate('Y-m-d H:i:s');
        $sessionQuery = '';
        $message = '';
        $token = '';
        $event = SrmCalendar::find()->where(['AND', ['=', 'srm_id', Yii::$app->user->identity->id], ['=', 'event_type', CalendarEvents::EVENT_MEETING], ['<=', 'start', $current_date], ['>=', 'end', $current_date]])->one();
        if(!empty($event)) {
            $sessionQuery = CalendarSessionTokenRelation::find()->where(['=', 'srm_id', Yii::$app->user->identity->id]);
            if(isset($event->student_appointment_id) && $student_event = StudentCalendar::findOne($event->student_appointment_id)) {
                $sessionQuery = $sessionQuery->andWhere(['=', 'student_id', $student_event->student_id]);
            }
            $sessionQuery = $sessionQuery->andWhere(['=','start',$event->start]);
            $sessionQuery = $sessionQuery->andWhere(['=','end',$event->end]);
            $sessionQuery = $sessionQuery->one();
            if(empty($sessionQuery)) {
                $sessionQuery = new CalendarSessionTokenRelation();
                $sessionQuery->srm_id = Yii::$app->user->identity->id;
                $sessionQuery->start = $event->start;
                $sessionQuery->end = $event->end;
                $sessionQuery->time_stamp = $event->time_stamp;
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
        }
        return $this->render('video', [
            'event' => $event,
            'message' => $message,
            'openTokSessionId' => $sessionQuery->session_id,
            'openTokSessionToken' => $token,
            'openTokApiKey' => ConnectionSettings::OPEN_TOK_API_KEY
        ]);
    }
}
