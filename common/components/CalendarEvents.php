<?php

namespace common\components;
use Yii;
use common\models\ConsultantCalendar;
use frontend\models\StudentCalendar; 
use yii\helpers\Json;

class CalendarEvents
{
    const EVENT_REMINDER = 0;
    const EVENT_UNAVAILABILITY = 1;
    const EVENT_MEETING = 2;
    const EVENT_OTHER = 3;

    const EVENT_STATUS_PENDING = 0;
    const EVENT_STATUS_APPROVED = 1;
	const EVENT_STATUS_CANCELLED = 2;
	
	
	const TYPE_APPOINTMENT = 0;
    const TYPE_EVENT = 1;
	const TYPE_FOLLOWUP = 2;
    const TYPE_TASK = 3;
    
	const DEFAULT_VALUE = 0;
	const MODE_PHONE = 1;
    const MODE_FACETOFACE = 2;
    const MODE_VIDEOCALL = 3;
	const MODE_OTHERS = 4;
 
	
	
	public static function getMeetingType() {
        return [ 
			CalendarEvents::TYPE_APPOINTMENT => 'Appointment',
			CalendarEvents::TYPE_EVENT => 'Event',			
			CalendarEvents::TYPE_FOLLOWUP => 'Followup',
			CalendarEvents::TYPE_TASK => 'Task',
            
        ];
    }

    public static function getMeetingTypeName($code) {
        $type = CalendarEvents::getMeetingType();
        return $type[$code];
    }
	
	public static function getMode() {
        return [
            CalendarEvents::DEFAULT_VALUE => '--Select--',
			CalendarEvents::MODE_PHONE => 'Telephone',
			CalendarEvents::MODE_FACETOFACE => 'Face to Face',
			CalendarEvents::MODE_VIDEOCALL => 'Video Call',
			CalendarEvents::MODE_OTHERS => 'Others',
            
        ];
    }

    public static function getModeName($code) {
        $mode = CalendarEvents::getMode();
        return $mode[$code];
    }
	
	public static function getEventStatus() {
        return [ 
			CalendarEvents::EVENT_STATUS_PENDING => 'Pending',
			CalendarEvents::EVENT_STATUS_APPROVED => 'Approved',			
			CalendarEvents::EVENT_STATUS_CANCELLED => 'Cancelled', 
            
        ];
    }

    public static function getEventStatusName($code) {
        $events = CalendarEvents::getEventStatus();
        return $events[$code];
    }
	 
	
	public function assignTaskcalender($model, $user, $role,$meetingtype,$mode) {
      
        $event = new ConsultantCalendar(); 
		
		$query = ConsultantCalendar::find()
		 ->where(['consultant_id'=>$model->consultant_id])
		 ->andWhere(['student_appointment_id'=>$model->student_id])
		 ->andWhere(['title'=>$model->title])
		 ->one();
		if(isset($query)){
			$event = $query;
		} 
		  
		$customduedate = Yii::$app->formatter->asDate($model->due_date, 'yyyy-MM-dd'); 
        $startdate = $customduedate.' 00:00:01'; 
		$enddate = $customduedate.' 23:59:59'; 
		 
		 
        $event->consultant_id = $model->consultant_id;
		$event->student_appointment_id = $model->student_id;
        $event->title = $model->title;
        $event->start = $startdate;
        $event->end = $enddate;
        $event->event_type = 2;
		$event->meetingtype = $meetingtype;
		$event->mode = $mode;
        $event->created_by = $model->created_by;
        $event->updated_by = $model->updated_by;
        $event->updated_at = gmdate('Y-m-d H:i:s');
        $event->created_at = gmdate('Y-m-d H:i:s');
        $event->time_stamp = gmdate('U');
        $event->remarks =  "Task Assigned."; 
        $event->appointment_status = CalendarEvents::EVENT_STATUS_PENDING; 
        if($event->save(false)) {
            if(isset($role)) {
                if($role == Roles::ROLE_STUDENT) {
                    $student_event = new StudentCalendar();
                    $student_event->student_id = $model->student_id;
                    $student_event->consultant_appointment_id = $event->id;
                    $student_event->event_type = $event->event_type;
                    $student_event->appointment_status = $event->appointment_status;
					$student_event->meetingtype =  $event->meetingtype; 
					$student_event->mode = $event->mode;
                    $student_event->title = $event->title;
                    $student_event->remarks = $event->remarks;
                    $student_event->start = $event->start;
                    $student_event->end = $event->end;
                    $student_event->time_stamp = $event->time_stamp;
                    $student_event->created_by = $event->created_by;
                    $student_event->created_at = $event->created_at;
                    $student_event->updated_by = $event->updated_by;
                    $student_event->updated_at = $event->updated_at; 
                    if($student_event->save(false)) {
                        $event->student_appointment_id = $student_event->id;
                        if($event->save(false)) {
                            return Json::encode(['status' => 'success' ,'response' => $event]);
                        } else {
                            return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving student appointment in student calendar.']);
                        }
                    } else {
                        return Json::encode(['status' => 'failure' ,'response' => $event, 'message' => 'Error while saving student appointment in consultant calendar.']);
                    }
                }
            } else {
                return Json::encode(['status' => 'success' ,'response' => $event]);
            }
        }
        return Json::encode(['status' => 'failure' ,'response' => $event,'message' => 'Error while saving student appointment.']);
    
    }
	
	
	    public function assignLeadcalender($model, $user, $role,$meetingtype,$mode) {
      
        $event = new ConsultantCalendar(); 
        $query = ConsultantCalendar::find()
         ->where(['consultant_id'=>$model->consultant_id])
         ->andWhere(['student_appointment_id'=>$model->student_id])
         ->andWhere(['title'=>$model->comment])
         ->one();
        if(isset($query)){
            $event = $query;
        } 
         
        $customduedate = Yii::$app->formatter->asDate($model->next_followup, 'yyyy-MM-dd'); 
        //echo "<br>";
        $startdate = $customduedate.' 00:00:00';
     //  echo "<br>";
         $enddate = $customduedate.' 23:30:00';
        //die;
        
        $event->consultant_id = $model->consultant_id;
        $event->student_appointment_id = $model->student_id;
         $event->title = $model->next_follow_comment;
        $event->start = $startdate;
        $event->end = $enddate;
        $event->event_type = 0;
        $event->meetingtype = $meetingtype;
        $event->mode = $mode;
        $event->created_by = $model->created_by;
        $event->updated_by = $model->updated_by;
        $event->updated_at = gmdate('Y-m-d H:i:s');
        $event->created_at = gmdate('Y-m-d H:i:s');
        $event->time_stamp = gmdate('U');
        $event->remarks =  "Task Assigned."; 
        $event->appointment_status = CalendarEvents::EVENT_STATUS_PENDING; 
        if($event->save(false)) {
            
                return Json::encode(['status' => 'success' ,'response' => $event]);
            }
        return Json::encode(['status' => 'failure' ,'response' => $event,'message' => 'Error while saving student appointment.']);
    
    }   
	
	 
	
}