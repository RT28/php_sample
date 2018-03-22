<?php

namespace common\components;
use Yii; 
use backend\models\SiteConfig;
use common\models\Others;
use frontend\models\StudentNotifications;

class Commondata { 
  
  
    const TITLE_MR = 1;   
    const TITLE_MRS = 2;
    const TITLE_MISS = 3;
    const TITLE_JR = 4;
    const TITLE_SR = 5;
	const TITLE_DR = 6; 
	
	const GENDER_MALE = 1;   
    const GENDER_FEMALE = 2;  
	
	const DAY_MONDAY = 1;   
    const DAY_TUESDAY = 2; 
	const DAY_WEDNESDAY = 3; 
	const DAY_THURSDAY = 4;
	const DAY_FRIDAY = 5;
	const DAY_SATURDAY = 6;
	const DAY_SUNDAY = 7; 
	
	const PROFICIENY_NA = 0;
	const PROFICIENY_BEGIN = 1;   
    const PROFICIENY_INTERMEDIATE = 2; 
	const PROFICIENY_FLUENT = 3; 	

    public static function getTitle() {
        return [
			Commondata::TITLE_MR => 'Mr.',
            Commondata::TITLE_MRS => 'Mrs.',
            Commondata::TITLE_MISS => 'Ms.',            
            Commondata::TITLE_JR => 'Jr.',
            Commondata::TITLE_SR => 'Sr.',
            Commondata::TITLE_DR => 'Dr.', 
        ];
    }

    public static function getTitleName($code) {
        $title = Commondata::getTitle();
        return $title[$code];
    }
	
	public static function getGender() {
        return [
			Commondata::GENDER_MALE => 'Male',
            Commondata::GENDER_FEMALE => 'Female', 
        ];
    }

    public static function getGenderName($code) {
        $gender = Commondata::getGender();
        return $gender[$code];
    }
	
	public static function getProficiency() {
        return [
			Commondata::PROFICIENY_NA => 'NA',
			Commondata::PROFICIENY_BEGIN => 'Begin',
            Commondata::PROFICIENY_INTERMEDIATE => 'Intermediate', 
			Commondata::PROFICIENY_FLUENT => 'Fluent',  
        ];
    }

    public static function getProficiencyName($code) {
        $proficiency = Commondata::getProficiency();
        return $proficiency[$code];
    }
   
 
   public static function getDay() {
        return [
			Commondata::DAY_MONDAY => 'Monday', 
			Commondata::DAY_TUESDAY => 'Tuesday',
			Commondata::DAY_WEDNESDAY => 'Wednesday',
			Commondata::DAY_THURSDAY => 'Thursday',
			Commondata::DAY_FRIDAY => 'Friday',
			Commondata::DAY_SATURDAY => 'Saturday',
			Commondata::DAY_SUNDAY => 'Sunday',
        ];
    }
	 

    public static function getDayName($code) {
        $day = Commondata::getDay();
        return $day[$code];
    }
 	
	
	

	public function sendGeneralMail($to,$subject,$data,$template,$successmsg) {
       
		$cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();	
		
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setCc($cc)
            ->setSubject($subject);
			
			$status = false;
            if($mail->send()){
				$status = true;
	
			} 
			
			return $status;
    } 
	
	
	public static function sendCreateLoginLink($to,$subject,$data,$template) {
       $mailsent = false;
		$cc = SiteConfig::getConfigGeneralEmail();
		$from = SiteConfig::getConfigFromEmail();	
		
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setCc($cc)
            ->setSubject($subject);
			
            if($mail->send()){ 
				$mailsent = true;
	
			} 
		return $mailsent ;
    } 

    public static function sendContactQuery($to,$subject,$data,$template) {
       $mailsent = false;
		$from = SiteConfig::getConfigFromEmail();
		$cc = SiteConfig::getConfigStoreEmail();	
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            //->setFrom($from)
            ->setFrom([$from => 'GoToUniversity'])
            ->setTo($to)
			->setCc($cc)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 

				$mailsent = true;

			} 
		return $mailsent ;
    } 

    public static function sendContactQueryDetails($enquiry_from,$subject,$data,$template) {
       $maildetails = false;
		$from = SiteConfig::getConfigFromEmail();
		$to = SiteConfig::getConfigStoreEmail();
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 
            	
				$maildetails = true;

			} 
		return $maildetails ;
    } 
  
/*university contact enquiry*/
	public static function sendUniversityQuery($to,$subject,$data,$template) {
       $mailsent = false;
		$from = SiteConfig::getConfigFromEmail();
		$cc = SiteConfig::getConfigUniversityEmail();	
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setCc($cc)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 

				$mailsent = true;

			} 
		return $mailsent ;
    } 

    public static function sendUniversityQueryDetails($enquiry_from,$subject,$data,$template) {
       $maildetails = false;
		$from = SiteConfig::getConfigFromEmail();
		$to = SiteConfig::getConfigUniversityEmail();
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 
            	
				$maildetails = true;

			} 
		return $maildetails ;
    }   
/*consultant contact enquiry*/
	public static function sendConsultantQuery($to,$subject,$data,$template) {
       $mailsent = false;
		$from = SiteConfig::getConfigFromEmail();
		$cc = SiteConfig::getConfigConsultantEmail();	
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setCc($cc)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 

				$mailsent = true;

			} 
		return $mailsent ;
    } 

    public static function sendConsultantQueryDetails($enquiry_from,$subject,$data,$template) {
       $maildetails = false;
		$from = SiteConfig::getConfigFromEmail();
		$to = SiteConfig::getConfigConsultantEmail();
		$bcc = SiteConfig::getConfigGeneralEmail();
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['data'=>$data])
            ->setFrom($from)
            ->setTo($to)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 
            	
				$maildetails = true;

			} 
		return $maildetails ;
    }    
/*send student enquiry*/
public static function sendStudentQuery($model,$subject,$template) {
       $mailsent = false;
		$from = SiteConfig::getConfigFromEmail();
		$cc = SiteConfig::getConfigStudentEmail();	
		$bcc = SiteConfig::getConfigGeneralEmail();
		$to = $cc;
		$mail = Yii::$app->mailer->compose(['html' => '@common/mail/'.$template],['model'=>$model])
            ->setFrom($from)
            ->setTo($to)
			->setBcc($bcc)
            ->setSubject($subject);
			
            if($mail->send()){ 

				$mailsent = true;

			} 
		return $mailsent ;
    } 

  public static function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
	}

	public static function wanttobegin() {
		$currDate = date('Y');
		$currDate1 = $currDate+1;
		$currDate2 = $currDate1+1;
		$begin = array($currDate,$currDate1,$currDate2);
		return $begin;
	}

	public static function qualificationList() {
		$qualification = array(1=>'High School',2=>'Intermediate',
							   3=>'Diploma  or Certification',
							   4=>'Graduate',5=>'Post Graduate',6=>'Others');
		return $qualification;
	}
	
	public static function diduknow() {
		
		$diduknow = array(0=>'Not Availiable',1=>"Google Ad's Search/Display/Gmail",2=>"Google Organic Search",
			  3=>"Facebook / Google + / Social Media",
			  4=>"News paper / Magazine / print Media",
			  5=>"Friends / Reference/Teachers/Counsellors",
			  6=>"Events /Seminars / Work shops / School Fair",
			  7=>"Website",
			  8=>"Others"); 
			  
		return $diduknow;
	}
	
	public static function phonetype() { 
		$phonetype = array(0=>'Not Availiable',1=>'Home',2=>'Mobile',3=>'Work');  
		return $phonetype;
	}
	
	public static function accessStatus() {  
		$accessStatus = array(0=>'Not Subscribed',1=>'Active',2=>'Inactive',3=>'Access Sent',4=>'Subscribed');
 		return $accessStatus;
	}
	
	public static function consultnatAccessList() {  
		$list = array( 1=>'Task Management',2=>'View Dashboard',3=>'Upload and Download Documents',4=>'Assign Trainer/Employee Access');
 		return $list;
	}
	
	
	public static function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }

    public static function consultantNotification($student_id,$consultant_id,$role,$message,$created_by,$updated_by) {
       			$notification = new StudentNotifications(); 
				$notification->student_id = $student_id;
				$notification->from_id = $consultant_id;
				$notification->from_role = $role;
				$notification->message = $message;
				$notification->timestamp =  gmdate('Y-m-d H:i:s');
				$notification->created_by = $created_by;
				$notification->updated_by = $updated_by;
				$notification->created_at = gmdate('Y-m-d H:i:s');
				$notification->updated_at = gmdate('Y-m-d H:i:s');
				$notification->save(false);
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
	
	 
}

?>