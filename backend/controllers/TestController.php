<?php

namespace backend\controllers; 

use Yii;
use backend\models\SiteConfig;
use common\models\Student;
use common\models\Consultant;
use common\models\Tasks;
use common\models\TaskCategory;
use common\models\TaskList;
use frontend\models\UserLogin;
use yii\db\ActiveQuery;
use Aws\S3\S3Client;

class TestController extends \yii\web\Controller
{

	/*public function actionTest(){
		$s3Client = new S3Client([
		    'version'     => 'latest',
		    'region'      => 'ap-south-1',
		    'credentials' => [
		        'key'    => 'AKIAJCL7RQCGDEOQRN6A',
		        'secret' => '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',
		    ],
		]);
		$result = $s3Client->putObject([
		    'Bucket' => 'gotouniv',
		    'Key'    => 'AKIAJCL7RQCGDEOQRN6A',
		    'Body'   => 'this is the body!'
		]);
	}*/
	public function actionPhotogallery(){
		$path = Yii::getAlias('@backend');
		$rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('university')
    ->all();
    
    foreach ($rows as $row) {
    	$filename = $path."/web/photo_gallery/".$row['id']."/photos"; 
		if(file_exists($filename)){ 
			
			$dir = $filename;
			if (is_dir($dir)){
			  if ($dh = opendir($dir)){
			    while (($file = readdir($dh)) !== false){
			    	if($file!='.' AND $file!='..'){
			    		Yii::$app->db->createCommand()
						->insert('university_gallery', [
								'university_id' => $row['id'],
								'photo_type' => 'photo',
								'filename' => $file,
								'status' => 1,
								'active' => 1,
								'created_by' => 5,
								'updated_by' => 5,
								'created_at' => '2017-08-21 09:21:00',
								'updated_at' => '2017-08-21 09:21:00',
								])
						->execute();
			    		echo $file. '<br>';
			    /*$s3Client = new S3Client([
			    'version'     => 'latest',
			    'region'      => 'ap-south-1',
			    'credentials' => [
			        'key'    => 'AKIAJCL7RQCGDEOQRN6A',
			        'secret' => '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',
			    ],
				]);

				$filepath = $path."/web/uploads/brochures/".$row['id']."/".$value;
				$result = $s3Client->putObject([
				    'Bucket' => 'gotouniv',
				    'Key'    => 'brochures/'.$row['id'].'/'.$file,
				    'SourceFile' => $filepath,
				    'ACL' => 'public-read',
				]); */
			  		}
			    }
			    closedir($dh);
			  }
			}
    	
		}
	}
		
	}

/*	public function actionCoverphoto(){
		$path = Yii::getAlias('@backend'); 
		$rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('university')
    ->where(['id' => 100])
    ->all();
    foreach ($rows as $row) {
    	$filename = $path."/web/uploads/".$row['id']."/cover_photo"; 
		if(file_exists($filename)){ 
		
			      	$s3Client = new S3Client([
			    'version'     => 'latest',
			    'region'      => 'ap-south-1',
			    'credentials' => [
			        'key'    => 'AKIAJCL7RQCGDEOQRN6A',
			        'secret' => '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',
			    ],
				]);

				$filepath = $path."/web/uploads/100/cover_photo/cover_photo_1500X500.jpg";
				$result = $s3Client->putObject([
				    'Bucket' => 'gotouniv',
				    'Key'    => 'cover_photo/100/cover_photo_1500X500.jpg',
				    'SourceFile' => $filepath,
				    'ACL' => 'public-read',
				]); 
			    
		
	}*/

	public function actionCoverphoto(){
		$path = Yii::getAlias('@backend'); 
		$s3Client = new S3Client([
			    'version'     => 'latest',
			    'region'      => 'ap-south-1',
			    'credentials' => [
			        'key'    => 'AKIAJCL7RQCGDEOQRN6A',
			        'secret' => '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',
			    ],
				]);
		$rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('university')
    ->all();
    foreach ($rows as $row) {
    	$filename = $path."/web/uploads/".$row['id']."/cover_photo"; 
		if(file_exists($filename)){ 
			
			$dir = $filename;
			if (is_dir($dir)){
			  if ($dh = opendir($dir)){
			    while (($file = readdir($dh)) !== false){
			    	if($file!='.' AND $file!='..'){
			      	
				$filepath = $path."/web/uploads/".$row['id']."/cover_photo/".$file;
				$result = $s3Client->putObject([
				    'Bucket' => 'gotouniv',
				    'Key'    => 'cover_photo/'.$row['id'].'/'.$file,
				    'SourceFile' => $filepath,
				    'ACL' => 'public-read',
				]); 
			  		}
			    }
			    closedir($dh);
			  }
			}
    	
		}
	}
		
	}

	public function actionBrochure(){
		$path = Yii::getAlias('@backend'); 
		$rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('university')
    ->all();
    foreach ($rows as $row) {
    	$filename = $path."/web/uploads/brochures/".$row['id']; 
		if(file_exists($filename)){ 
			
			$dir = $filename;
			if (is_dir($dir)){
			  if ($dh = opendir($dir)){
			    while (($file = readdir($dh)) !== false){
			    	if($file!='.' AND $file!='..'){
			      	$s3Client = new S3Client([
			    'version'     => 'latest',
			    'region'      => 'ap-south-1',
			    'credentials' => [
			        'key'    => 'AKIAJCL7RQCGDEOQRN6A',
			        'secret' => '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',
			    ],
				]);

				$filepath = $path."/web/uploads/brochures/".$row['id']."/".$file;
				$result = $s3Client->putObject([
				    'Bucket' => 'gotouniv',
				    'Key'    => 'brochures/'.$row['id'].'/'.$file,
				    'SourceFile' => $filepath,
				    'ACL' => 'public-read',
				]); 
			  		}
			    }
			    closedir($dh);
			  }
			}
    	
		}
	}
		
	}

    public function actionIndex()
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
	 
		echo "<br/> Specific  ".  $task->specific_alert;
		echo "<br/> Today ".  $today;
		echo "<br/> Due Date ".  $duedate;
		echo "<br/> interval ". $interval;
		echo "<br/> alert ". $alert;
		echo "<br/>----------------<br/>";
		
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
		die;
 
        return $this->render('index',[
			'message' => $msg, 
        ]);
		
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
		->where('tasks.student_id = '.$student->student_id . ' AND tasks.status = 0 AND tasks.created_msgsent = 1 AND tasks.updated_at  between "'.$gmstarttime.'" and "'.$gmendtime.'"  ')
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
