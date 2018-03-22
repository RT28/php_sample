<?php

namespace console\controllers; 
 
use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use backend\models\SiteConfig;
use common\models\Student;
use common\models\Consultant;
use common\models\Tasks;
use common\models\TaskCategory;
use common\models\TaskList;
use frontend\models\UserLogin;

class TaskcronController  extends Controller {
 
	
	public function actionIndex() {
        echo "Yes, cron service is running.";
    }
 
 
    public function actionHourly()
    {
		
		$students = Student::find()
		->leftJoin('user_login', 'user_login.id = student.student_id') 
		->where('user_login.status = '.UserLogin::STATUS_SUBSCRIBED)->all();
		$msg = array();
		
		$gmdate = gmdate('Y-m-d'); 
		$endtime = gmdate('H'); 

		if($endtime=='00'){
			$endtime = "01"; 
		}
		$starttime = $endtime-1;  
		$gmstarttime = $gmdate." ".$starttime.":00:00";
		$gmendtime = $gmdate." ".$starttime.":59:59";
		 
		foreach($students as $student){   
  
		$tasks = Tasks::find()
		->leftJoin('student', 'student.student_id = tasks.student_id')
		->leftJoin('task_list', 'task_list.id = tasks.task_list_id')
		->where('tasks.student_id = '.$student->student_id . ' AND tasks.status = 0
			     AND tasks.due_date != '' AND tasks.created_at between "'.$gmstarttime.'" and "'.$gmendtime.'"  ')
		->all(); 
  
		if(count($tasks)>0){
		$Toemail  = array();	
		$Toemail[] = $student->email; 
		
		$cc = array();
		
		foreach($tasks as $task){  
			
			if(!empty($task->consultant_id)){
				$consultant = Consultant::find()->where('consultant_id = '.$task->consultant_id)->one();
				if(!empty($consultant->email)){
				$cc[] = $consultant->email;
				}
			}
			
			
			if(!empty($task->notified)){
				$notifiedTo = 	explode(',',$task->notified);
				
				if(in_array(3, $notifiedTo)){ 
					if(!empty($student->father_email)){
						$cc[] = $student->father_email; 
					}
					if(!empty($student->mother_email)){
						$cc[] = $student->mother_email; 
					}
				}
				if(in_array(4, $notifiedTo)){ 
					if(!empty($task->additional)){
						$cc[] = $task->additional; 
					}
				} 
			} 
			
		} 
	 
		$subject = 'Assigned Task List.'; 
		$cc[] = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/cron_for_student_tasks'],
		['student' => $student,  
		 'tasks' =>$tasks,
		])
		->setFrom($from)
		->setTo($Toemail)
		->setCc($cc)
		->setSubject($subject);
		
		if($mail->send()){	

			foreach($tasks as $task){ 
				$task->created_msgsent = 1;
				$task->save(false);
			}
			
			$msg[$student->student_id]['msg'] = 'Success! Email sent.';
			
		}else{
			$msg[$student->student_id]['msg'] = 'Error! Email not sent.';
		} 

		}
		}
 
        return $this->render('index',[
			'message' => $msg, 
        ]);
    }
	
	public function actionDailytaskalert()
    {
		 $tasks = Tasks::find() 
		->leftJoin('task_list', 'task_list.id = tasks.task_list_id')
		->where('tasks.status != 2')		
		->all();
		 
 
		if(count($tasks)>0){ 
		$msg = array();
		foreach($tasks as $task){ 
		
		$Toemail = array();	
		
		$studentProfile = Student::find()->where(['=', 'student_id', $task->student_id])->one();
		$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

		$Toemail[] = $studentProfile->email; 
		if(!empty($task->notified)){
		$notifiedTo = 	explode(',',$task->notified);

		if(in_array(3, $notifiedTo)){ 
		if(!empty($studentProfile->parent_email)){
		$Toemail[] = $studentProfile->parent_email; 
		}
		}
		if(in_array(4, $notifiedTo)){ 
		if(!empty($task->additional)){
		$Toemail[] = $task->additional; 
		}
		}
		} 

		
		$Consultant = Consultant::find()->where(['=', 'consultant_id', $task->consultant_id])->one();
	 	
		$Toemail[] = $Consultant->email;  

		$catName = '';
		$masterCategory = TaskCategory::find()->where(['=', 'id', $task->task_category_id])->one();
		if(!empty($masterCategory)){
		$catName = $masterCategory->name;
		}

		$ListName = '';
		$taskList = TaskList::find()->where(['=', 'id', $task->task_list_id])->one();
		if(!empty($taskList)){
		$ListName = $taskList->name;
		}
 
		 
		$today = 	date( 'Y-m-d', strtotime( "now" ) );
		$duedate =  $task->due_date;

		$diff = strtotime($duedate) - strtotime($today);
		$interval = $diff / 60 / 60 / 24;

		$alert = $task->standard_alert;
		if(!empty($task->specific_alert)){
			if($task->specific_alert > $task->standard_alert){
				$alert = $task->specific_alert;
			}
		}
		/*$msg = "";
		$msg.= "<br/> Specific  ".  $task->specific_alert;
		$msg.= "<br/> Today ".  $today;
		$msg.= "<br/> Due Date ".  $duedate;
		$msg.= "<br/> interval ". $interval;
		$msg.= "<br/> alert ". $alert;
		$msg.= "<br/>----------------<br/>";  
		$filename = 'dailyTaskAlert'.date('d-m-Y');
		Yii::info($msg, $filename); */
		
		if($alert == $interval){
			
		$subject = "Alert : Status : Pending, Due Date : $duedate";
			
		$cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();		
		//$Toemail =  implode(',',$Toemail); 

		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/cron_taskalert_duedate'],
		['studentname' => $studentname,
			'catName' =>$catName,
			'ListName' =>$ListName,
			'model' =>$task,
		])
		->setFrom($from)
		->setTo($Toemail)
		->setCc($cc)
		->setSubject($subject);

		  
		if($mail->send()){						
			$msg[$task->student_id]['msg'] = 'Success! Email sent.';
		}else{
			$msg[$task->student_id]['msg'] = 'Error! Email not sent.';
		} 

		}

		}
		} 
  
	}
	
	public function actionUpdatehourly()
    {
		
		$students = Student::find()
		->leftJoin('user_login', 'user_login.id = student.student_id') 
		->where('user_login.status = '.UserLogin::STATUS_SUBSCRIBED)->all();
		$msg = array();
		
		$gmdate = gmdate('Y-m-d'); 
		$endtime = gmdate('H'); 

		if($endtime=='00'){
			$endtime = "01"; 
		}
		$starttime = $endtime-1;  
		$gmstarttime = $gmdate." ".$starttime.":00:00";
		$gmendtime = $gmdate." ".$starttime.":59:59";
		 
		foreach($students as $student){   
  
		$tasks = Tasks::find()
		->leftJoin('student', 'student.student_id = tasks.student_id')
		->leftJoin('task_list', 'task_list.id = tasks.task_list_id')
		->where('tasks.student_id = '.$student->student_id . ' AND 
				 tasks.status = "0" AND tasks.task_list_id != "24" AND 
				 tasks.due_date != "" AND tasks.created_at  between "'.$gmstarttime.'" and "'.$gmendtime.'"  ')
		->all();  
  
  
		if(count($tasks)>0){
		$Toemail  = array();	
		$Toemail[] = $student->email; 
		
		$cc = array();
		
		foreach($tasks as $task){  
			
			if(!empty($task->consultant_id)){
				$consultant = Consultant::find()->where('consultant_id = '.$task->consultant_id)->one();
				if(!empty($consultant->email)){
				$cc[] = $consultant->email;
				}
			}
			
			
			if(!empty($task->notified)){
				$notifiedTo = 	explode(',',$task->notified);
				
				if(in_array(3, $notifiedTo)){ 
					if(!empty($student->father_email)){
						$cc[] = $student->father_email; 
					}
					if(!empty($student->mother_email)){
						$cc[] = $student->mother_email; 
					}
				}
				if(in_array(4, $notifiedTo)){ 
					if(!empty($task->additional)){
						$cc[] = $task->additional; 
					}
				} 
			} 
			
		} 
	 
		$subject = 'Updated Task List.'; 
		$cc[] = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/cron_for_student_tasks'],
		['student' => $student,  
		 'tasks' =>$tasks,
		])
		->setFrom($from)
		->setTo($Toemail)
		->setCc($cc)
		->setSubject($subject);
		
		if($mail->send()){	
 
			$msg[$student->student_id]['msg'] = 'Success! Email sent.';
			
		}else{
			$msg[$student->student_id]['msg'] = 'Error! Email not sent.';
		} 

		}
		}
 
        return $this->render('index',[
			'message' => $msg, 
        ]);
    }

}
