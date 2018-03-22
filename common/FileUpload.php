<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\imagine\Image;
use Imagine\Image\Box;


class FileUpload extends Model 
{
	public $imageFile;
	public $logoFile;
	public $profilePhoto;
	public $universityPhotos;
	public $consultantImage;
	public $agencyImage;
	public $employeeImage;
	public $trainerImage;
	public $uploadessay; 
	public $imageadvert; 
	public $attachment; 
	public $title;
	
	public function rules()
	{
		return [
			[['imageFile', 'profilePhoto', 'consultantImage', 'agencyImage', 'employeeImage', 'trainerImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif','checkExtensionByMimeType'=>false],
			[['logoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png','checkExtensionByMimeType'=>false],
			[['uploadessay'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif','checkExtensionByMimeType'=>false], 
			[['imageadvert'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif','checkExtensionByMimeType'=>false], 
			[['attachment'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx, pdf','checkExtensionByMimeType'=>false], 
			[['universityPhotos'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg', 'maxFiles' => 5,'checkExtensionByMimeType'=>false],
		];
	}

	public function upload($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->id/cover_photo");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->id/cover_photo");
		}
		if ($this->validate() && isset($this->imageFile)) { 
			$imageFile = $this->imageFile->name; 
			$this->imageFile->saveAs($path."/web/uploads/$university->id/cover_photo/" .  $imageFile);
				/*resize cover photo starts here author@roan-------------------------------------------------------*/
				$filepath = $path."/web/uploads/$university->id/cover_photo/";	
				$savefileinDB = $this->ak_img_resize($filepath, $imageFile,'cover_photo');
				unlink($filepath.$imageFile);
				/*resize cover photo end here --------------------------------------------------------------------*/ 		
			return $savefileinDB;
		}
		return false;
	}
	
 	public function uploadLogo($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->id/logo");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->id/logo");
		}
		if ($this->validate() && isset($this->logoFile)) { 
			$logoFile = $this->logoFile->name;			
			$this->logoFile->saveAs($path."/web/uploads/$university->id/logo/" .  $logoFile);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$filepath = $path."/web/uploads/$university->id/logo/";	
				$savefileinDB = $this->ak_img_resize($filepath, $logoFile,'logo');
				unlink($filepath.$logoFile);
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $savefileinDB;
		}
		return false;
	}
 

	public function uploadProfilePicture($student) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/$student->id/profile_photo");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$student->id/profile_photo");
		}		
		if ($this->validate() && isset($this->profilePhoto)) {
			$this->profilePhoto->saveAs($path."/web/uploads/$student->id/profile_photo/profile_photo" . '.' . $this->profilePhoto->extension);
			$this->profilePhoto = null;
			return true;
		}
		return false;
	}

	 
	public function uploadUniversityPhotos($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->id/photos");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->id/photos");
		}
		$filenames = array();
		if ($this->validate() && isset($this->universityPhotos)) {
			foreach ($this->universityPhotos as $file) { 
			  $getfilename = '';
				$files = explode('.',$file->name);
				$getfilename = $files[0] .time(). '.'. $files[1];	
				
                $result = $file->saveAs($path."/web/uploads/$university->id/photos/" . $getfilename);
				
                /*resize university photo starts here author@roan-------------------------------------------------------*/
				$filepath = $path."/web/uploads/$university->id/photos/";	
				$savefileinDB = $this->ak_img_resize($filepath, $getfilename,'photos');
				unlink($filepath.$getfilename);
                /*resize university photo end here --------------------------------------------------------------------*/

				$filenames[] = $savefileinDB;
				
				if(!$result) {
					return false;
				}
            }
			
			return $filenames;
		}
		return false;
	}
	public function uploadAgencyImage($agency) {
	   
		$path = Yii::getAlias('@partner'); 
		$result = is_dir($path."/web/uploads/agency/$agency->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/agency/$agency->id");
		}
		if ($this->validate() && isset($this->agencyImage)) {
			$file = explode('.',$this->agencyImage->name);
			$filename = $file[0] .time(). '.'. $file[1];			
			$this->agencyImage->saveAs($path."/web/uploads/agency/$agency->id/" .  $filename);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$path = $path."/web/uploads/agency/$agency->id/";	
				$this->ak_img_resize($path, $filename,'agency_image');
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $filename;
		}
		return false;
	}
	
	public function uploadPartnerEmployeeImage($employee) {
	   
		$path = Yii::getAlias('@partner'); 
		$result = is_dir($path."/web/uploads/employee/$employee->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/employee/$employee->id");
		}
		if ($this->validate() && isset($this->employeeImage)) {
			$file = explode('.',$this->employeeImage->name);
			$filename = $file[0] .time(). '.'. $file[1];			
			$this->employeeImage->saveAs($path."/web/uploads/employee/$employee->id/" .  $filename);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$path = $path."/web/uploads/employee/$employee->id/";	
				$this->ak_img_resize($path, $filename,'employee_image');
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $filename;
		}
		return false;
	}
	
	public function uploadPartnerTrainerImage($trainer) {
	   
		$path = Yii::getAlias('@partner'); 
		$result = is_dir($path."/web/uploads/trainer/$trainer->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/trainer/$trainer->id");
		}
		if ($this->validate() && isset($this->trainerImage)) {
			$file = explode('.',$this->trainerImage->name);
			$filename = $file[0] .time(). '.'. $file[1];			
			$this->trainerImage->saveAs($path."/web/uploads/trainer/$trainer->id/" .  $filename);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$path = $path."/web/uploads/trainer/$trainer->id/";	
				$this->ak_img_resize($path, $filename,'trainer_image');
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $filename;
		}
		return false;
	}
	
	public function uploadConsultantImage($consultant) {
		$path = Yii::getAlias('@partner'); 
		$result = is_dir($path."/web/uploads/consultant/$consultant->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/consultant/$consultant->id");
		}
		if ($this->validate() && isset($this->consultantImage)) {
			$file = explode('.',$this->consultantImage->name);
			$filename = $file[0] .time(). '.'. $file[1];			
			$this->consultantImage->saveAs($path."/web/uploads/consultant/$consultant->id/" .  $filename);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$path = $path."/web/uploads/consultant/$consultant->id/";	
				$this->ak_img_resize($path, $filename,'consultant_image');
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $filename;
		}
		return false;
	}
	
	public function uploadEssay($essay) {
		$result = is_dir("./../../backend/web/uploads/essays/$essay->id/");
	
		if (!$result) {
			$result = FileHelper::createDirectory("./../../backend/web/uploads/essays/$essay->id/");
		}
		if ($this->validate() && isset($this->uploadessay)) {
			$this->uploadessay->saveAs("./../../backend/web/uploads/essays/$essay->id/" .$this->uploadessay->name);
	 		$this->uploadessay = null;
			return true;
		}
		return false;
	}
	
 
	
	public function uploadAdvertisement($model) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/advertisements/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/advertisements/$model->id");
		}
		if ($this->validate() && isset($this->imageadvert)) { 
			$file = explode('.',$this->imageadvert->name);
			$filename = $file[0] .time(). '.'. $file[1]; 
			$this->imageadvert->saveAs($path."/web/uploads/advertisements/$model->id/".  $filename);			
			return $filename;
		}
		return false;
	}
	
	public function uploadConsultantTask($model) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/consultanttasks/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/consultanttasks/$model->id");
		}
		if ($this->validate() && isset($this->attachment)) { 
			$file = explode('.',$this->attachment->name);
			$filename = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/consultanttasks/$model->id/".  $filename);			
			return $filename;
		}
		return false;
	}
	 
	
	public function uploadTaskAttachment($model) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/tasks/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/tasks/$model->id");
		}
		if ($this->validate() && isset($this->attachment)) { 
			$file = explode('.',$this->attachment->name);
			$filename = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/tasks/$model->id/".  $filename);			
			return $filename;
		}
		return false;
	}
	public function uploadInvoiceAttachment($model) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/invoice/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/invoice/$model->id");
		}
		if ($this->validate() && isset($this->attachment)) { 
			$file = explode('.',$this->attachment->name);
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/invoice/$model->id/".  $filname);			
			return $filname;
		}
		return false;
	}
/*	public function uploadWebinarLogo($model) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/webinar/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/webinar/$model->id");
		}
		if ($this->validate() && isset($this->logoFile)) { 
			$file = explode('.',$this->logoFile->name);
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->logoFile->saveAs($path."/web/uploads/webinar/$model->id/".  $filname);			
			return $filname;
		}
		return false;
	}*/
	public function uploadWebinarLogo($model) { 
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/webinar/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/webinar/$model->id");
		}
		if ($this->validate() && isset($this->logoFile)) { 
			$logoFile = $this->logoFile->name;			
			$this->logoFile->saveAs($path."/web/uploads/webinar/$model->id/" .  $logoFile);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$filepath = $path."/web/uploads/webinar/$model->id/";	
				$savefileinDB = $this->ak_img_resize($filepath, $logoFile,'logo');
				unlink($filepath.$logoFile);
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $savefileinDB;
		}
		return false;
	}
	
	
	public function uploadTemp($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->university_id/cover_photo");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->university_id/cover_photo");
		}
		if ($this->validate() && isset($this->imageFile)) { 
			$file = explode('.',$this->imageFile->name);
			$filename = $file[0] .time(). '.'. $file[1]; 
			$this->imageFile->saveAs($path."/web/uploads/$university->university_id/cover_photo/" .  $filename);			
			/*resize cover photo starts here author@roan-------------------------------------------------------*/
				$path = $path."/web/uploads/$university->university_id/cover_photo/";	
				$filename = $this->ak_img_resize($path, $filename,'cover_photo');
				/*resize cover photo end here --------------------------------------------------------------------*/ 		
			return $filename;
		}
		return false;
	}

	public function uploadLogoTemp($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->university_id/logo");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->university_id/logo");
		
		}
		if ($this->validate() && isset($this->logoFile)) {
			$file = explode('.',$this->logoFile->name);
			$filename = $file[0] .time(). '.'. $file[1];			
			$this->logoFile->saveAs($path."/web/uploads/$university->university_id/logo/" .  $filename); 
			
				/*resize logo starts here author@Kalyani-------------------------------------------------------*/
				$path = $path."/web/uploads/$university->university_id/logo/";	
				$filename = $this->ak_img_resize($path, $filename,'logo');
                /*resize logo end here --------------------------------------------------------------------*/ 
				return $filename;
		}
		return false;
	}
	
	public function uploadUniversityPhotosTemp($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->university_id/photos");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->university_id/photos");
		}
		$filenames = array();
		if ($this->validate() && isset($this->universityPhotos)) {
			foreach ($this->universityPhotos as $file) {
				$files = explode('.',$file->name);
				$filename = $files[0] .time(). '.'. $files[1];				
                $result = $file->saveAs($path."/web/uploads/$university->university_id/photos/" . $filename);
				
				/*resize university photo starts here author@Kalyani-------------------------------------------------------*/
				$path = $path."/web/uploads/$university->university_id/photos/";	
				$filename = $this->ak_img_resize($path, $filename,'photos');
				//unlink($path.$filename);
                /*resize university photo end here --------------------------------------------------------------------*/

				$filenames[] = $filename;
				if(!$result) {
					return false;
				}
            }
			return $filenames;
		}
		return false;
	}
	
	public function uploaduniversityBrouchresTemp($university) {
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$university->university_id/documents");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$university->university_id/documents");
		}
		$filenames = array();
		if ($this->validate() && isset($this->universityPhotos)) {
			foreach ($this->universityPhotos as $file) {
				$files = explode('.',$file->name);
				$filename = $files[0] .time(). '.'. $files[1];				
                $result = $file->saveAs($path."/web/uploads/$university->university_id/documents/" . $filename);
				$filenames[] = $filename;
				if(!$result) {
					return false;
				}
            }
			return $filenames;
		}
		return false;
	}
	
	public function attributeLabels()
    {
        return [
		'imageFile' => 'Cover Image',
		'logoFile'=> 'Logo',
		'profilePhoto' => 'Profile Photo',
		'universityPhotos' => 'University Photos',
		'consultantImage' => 'Profile Photo',
		'essayFile' => 'Essay File'
        ];
    }
   function ak_img_resize($path, $filename, $img_type){
	   
	   ini_set("memory_limit","-1");
	   
    			$fileExt = explode(".", $filename);
				$ext = end($fileExt);
				$data = @getimagesize($path.$filename);
				$width_1  = $data[0];
				$height_1 = $data[1];
				$target = $path.$filename;
				$w=array(); $h=array();
				if($img_type=='cover_photo'){ $w=['1500']; $h=['500']; }
				else if($img_type=='logo'){ $w=['170']; $h=['115']; }
				else if($img_type=='photos'){ $w=['1500']; $h=['1000'];}
				else if($img_type=='consultant_image'){ $w=['228']; $h=['228'];}
				
			    list($w_orig, $h_orig) = @getimagesize($target);
			    $length = count($w);
			    for ($i = 0; $i < $length; $i++) {
					 	
			    	if($length==1){ 
					
						$newcopy = $path.$img_type.'_'.$w[$i].'X'.$h[$i].'.'.$ext; 
						$getFileNameToSaveDB = $img_type.'_'.$w[$i].'X'.$h[$i].'.'.$ext;
						
					if($img_type=='photos'){
						$newcopy = $path.reset($fileExt).'_'.$w[$i].'X'.$h[$i].'.'.$ext;
						$getFileNameToSaveDB = reset($fileExt).'_'.$w[$i].'X'.$h[$i].'.'.$ext;
					}
					
					} else { 
						$newcopy = $path.$w[$i].'X'.$h[$i].'.'.$ext; 
						$getFileNameToSaveDB = $img_type.'_'.$w[$i].'X'.$h[$i].'.'.$ext;
					}
				 	
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
					      $img = @imagecreatefromgif($target);
					    } else if($ext =="png"){ 
					      $img = @imagecreatefrompng($target);
					    } else { 
					      $img = @imagecreatefromjpeg($target);
					    }
					    $tci = @imagecreatetruecolor($w[$i], $h[$i]);
					    @imagealphablending($tci, false);
						@imagesavealpha($tci, true);
					    @imagecopyresampled($tci, $img, 0, 0, 0, 0, $w[$i], $h[$i], $w_orig, $h_orig);
					    if ($ext == "png"){ 
							@imagepng($tci, $newcopy, 5); 
						}else{ 
							@imagejpeg($tci, $newcopy, 80);						 
						}
			 return	$getFileNameToSaveDB;
			}
    }
 
}
