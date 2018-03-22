<?php
namespace partner\modules\agency\controllers;

use Yii;
use partner\models\PartnerLogin;
use partner\models\PartnerSignup;
use partner\models\PartnerLoginForm;
use common\models\Agency; 
use common\models\Country;
use common\models\Degree;
use yii\helpers\ArrayHelper;
use common\components\Status;
use common\components\Roles;
use common\models\FileUpload;
use yii\web\UploadedFile;
use common\models\Others;
use yii\helpers\Json;   
use common\components\ConnectionSettings; 
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\SiteConfig; 
use yii\helpers\FileHelper; 
use common\components\Commondata;

class AgencyController extends \yii\web\Controller
{


public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
				'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],               
                'rules' => [   
					[
							'actions' => ['index', 'view', 'update', 'saveprofileajax',
							'get-consultant-calendar', 'add-event', 'update-event',
							'removeprofileajax','delete-event'],
							'allow' => true, 
							'roles' => [Roles::ROLE_AGENCY]
					],
					[  
						'actions' => ['create', 'login'],
						'allow' => true, 
						'roles' => ['?'],
					],
					[
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_AGENCY]
                    ]
							
                    ],
                   
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    } 
	
  
	 
    public function actionIndex() {
		 Yii::$app->view->params['activeTab'] = 'profile';
        $model = Yii::$app->user->identity->agency;
        return $this->render('index', [
            'model' => $model
        ]);
    }

	
	
	public function actionLogin($id,$timestamp)
    {  
		$timestamp = Commondata::encrypt_decrypt('decrypt',$timestamp);
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		
		$Agency = Agency::find()->where(['=', 'id', $id])->one(); 
		
		$partnerLogin = new PartnerLogin();
		$PartnerSignup = new PartnerSignup(); 
		
		
		$exists = PartnerLogin::find()
				  ->where(['=', 'partner_id', $Agency->id])
				  ->andWhere(['=', 'role_id', Roles::ROLE_AGENCY])
				  ->one();
	  
		if($exists) { 
			$partnerLogin = $exists; 
			if($exists->status==PartnerLogin::STATUS_ACTIVE) {
				Yii::$app->getSession()->setFlash('Error', 'You are already activated. Please login with your credentials or contact to Administrator.');	
				return $this->redirect('?r=site/login');  
			}	 
		} 
			
	    if($PartnerSignup->load(Yii::$app->request->post()) &&  $PartnerSignup->validate()) { 
		  
			$password = $PartnerSignup->password;
			$partnerLogin->username = $PartnerSignup->username;
			$partnerLogin->email = $Agency->email; 
			$partnerLogin->setPassword($password);
			$partnerLogin->status = PartnerLogin::STATUS_ACTIVE;
			$partnerLogin->role_id = Roles::ROLE_AGENCY;
			$partnerLogin->partner_id =  $Agency->id;
			$partnerLogin->generatePasswordResetToken();
			$partnerLogin->generateAuthKey(); 
			$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
			$partnerLogin->updated_at = gmdate('Y-m-d H:i:s');
			
			 
			if($partnerLogin->save(false)) { 

				$to = $Agency->email;
				$user = $Agency->name;
				$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=site/login';				
				$subject = $Agency->name.' created credentials successfully.';
				$template = 'welcome_email_agency';  
				
				$data = array('name' => $user, 'link' => $link,'username' => $partnerLogin->username, 'password' => $password);		
				$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);

				if($mailsent==true){  
					Yii::$app->getSession()->setFlash('Success', 'Your login credentials has been created successfully. Please login here.'); 
					return $this->redirect('?r=site/login');
				
				}else{
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
				}
			  
			}else {
				Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact to Administrator.'); 
			}  
			 
		}
		
		return $this->render('login', [ 
			'partnerSignup' => $PartnerSignup,   
        ]);
	}
	
	
  

    public function actionUpdate()
    {
		Yii::$app->view->params['activeTab'] = 'profile';
		
        $model = Yii::$app->user->identity->agency;
        $upload = new FileUpload();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
        $message = '';
        if($model->load(Yii::$app->request->post())) {
			 if($model->speciality){
				$model->speciality = implode(',',$model->speciality); 
			 }
				
            if ($model->save()) {
                if($this->saveProfilePicture($upload, Yii::$app->user->identity)) {
                    return $this->redirect(['agency/index']);
                }
                $message = 'Error updating profile picture.';
            }
            $message = 'Error updating profile.';
        }
        return $this->render('update', [
            'model' => $model,
            'countries' => $countries,
            'upload' => $upload,
            'message' => $message, 
			'degrees' => Degree::getAllDegrees(),
        ]);
    }

    private function saveProfilePicture($image, $agency) {
        $newFile = UploadedFile::getInstance($image, 'agencyImage');
        if (isset($newFile)) {
            $image->agencyImage = UploadedFile::getInstance($image, 'agencyImage');
            if ($image->uploadAgencyImage($agency)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
 
	public function actionSaveprofileajax() {
        $agency = Yii::$app->request->post('agency_id');
        $result = is_dir("./../web/uploads/agency/$agency/profile_photo");
        if (!$result) {
            $result = FileHelper::createDirectory("./../web/uploads/agency/$agency/profile_photo");
        }
        $sourcePath = $_FILES['profile_photo']['tmp_name'];
        $ext = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/agency/$agency/profile_photo/" . date_timestamp_get(date_create()) . '.' . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            $path = Yii::getAlias('@partner'); 
            $path = $path."/web/uploads/agency/$agency/profile_photo/"; 
            //$file = explode('.',$sourcePath);
            $filname = date_timestamp_get(date_create()).'.'.$ext; 
                $this->ak_img_resize($path, $filname,'consultant_image');
 
                /*deleting other logo images*/
                $dir = $path; 
                if($ext=='jpg'){
                $leave_files = array('consultant_image_228X228.jpg');
                } else if($ext=='png'){
                $leave_files = array('consultant_image_228X228.png');
                } else if($ext=='jpeg'){
                $leave_files = array('consultant_image_228X228.jpeg');
                } else if($ext=='gif'){
                $leave_files = array('consultant_image_228X228.gif');
                } else if($ext=='JPG'){
                $leave_files = array('consultant_image_228X228.JPG');
                } else if($ext=='PNG'){
                $leave_files = array('consultant_image_228X228.PNG');
                } else if($ext=='JPEG'){
                $leave_files = array('consultant_image_228X228.JPEG');
                } else if($ext=='GIF'){
                $leave_files = array('consultant_image_228X228.GIF');
                }

                foreach( glob("$dir/*") as $file ) {
                    if( !in_array(basename($file), $leave_files) )
                        unlink($file);
                }
                /*end deleting other logo images*/
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request']);
        }
    }  
	
	
	public function actionRemoveprofileajax() {
        $agency = Yii::$app->request->post('agency_id');
        $result = is_dir("./../web/uploads/agency/$agency/profile_photo");
        if ($result) {
            array_map('unlink', glob("./../web/uploads/agency/$agency/*"));
            echo json_encode(['error' => 'Processing request']);
            }
    }
	

	private function ak_img_resize($path, $filname, $img_type){
                $fileExt = explode(".", $filname);
                $ext = end($fileExt);
                $data = getimagesize($path.$filname);
                $width_1  = $data[0];
                $height_1 = $data[1];
                $target = $path.$filname;
                $w=array(); $h=array();
                if($img_type=='cover_photo'){ $w=['1500']; $h=['500']; }
                else if($img_type=='logo'){ $w=['170']; $h=['115']; }
                else if($img_type=='univ_gallery'){ $w=['1500']; $h=['1000'];}
                else if($img_type=='consultant_image'){ $w=['228']; $h=['228'];}
                
                list($w_orig, $h_orig) = getimagesize($target);
                $length = count($w);
                for ($i = 0; $i < $length; $i++) {
                    if($length==1){ $newcopy = $path.$img_type.'_'.$w[$i].'X'.$h[$i].'.'.$ext; }
                    else { $newcopy = $path.$w[$i].'X'.$h[$i].'.'.$ext; }

                    if($width_1>$w[$i] OR $height_1>$h[$i]){
                            $w[$i] = $w[$i]; $h[$i] = $h[$i];
                        } else{
                            $w[$i] = $width_1; $h[$i] = $height_1;
                        }
                        $scale_ratio = $w_orig / $h_orig; 
                        if (($w[$i] / $h[$i]) > $scale_ratio) {
                               $w[$i] = $h[$i] * $scale_ratio;
                        } else {
                               $h[$i] = $w[$i] / $scale_ratio;
                        }
                        $img = "";
                        $ext = strtolower($ext);
                        if ($ext == "gif"){ 
                          $img = imagecreatefromgif($target);
                        } else if($ext =="png"){ 
                          $img = imagecreatefrompng($target);
                        } else { 
                          $img = imagecreatefromjpeg($target);
                        }
                        $tci = imagecreatetruecolor($w[$i], $h[$i]);
                        imagealphablending($tci, false);
                        imagesavealpha($tci, true);
                        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w[$i], $h[$i], $w_orig, $h_orig);
                        if ($ext == "png"){ 
                        imagepng($tci, $newcopy, 5);
                        }
                        else{ 
                        imagejpeg($tci, $newcopy, 80);
                        }
            }
    }

	
    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }
 
   
}
