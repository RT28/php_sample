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
	public $uploadessay; 
	public $imageadvert; 
	public $attachment; 
	public $title;
	
	public function rules()
	{
		return [
			[['imageFile', 'logoFile', 'profilePhoto', 'consultantImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif','checkExtensionByMimeType'=>false],
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
			$file = explode('.',$this->imageFile->name);
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->imageFile->saveAs($path."/web/uploads/$university->id/cover_photo/" .  $filname);
				/*resize cover photo starts here author@roan-------------------------------------------------------*/
				$fileExt = explode(".", $filname);
				$fileExt = end($fileExt);
				$data = getimagesize($path."/web/uploads/$university->id/cover_photo/" . $filname);
				$width_1  = $data[0];
				$height_1 = $data[1];
				$original_file = $path."/web/uploads/$university->id/cover_photo/" . $filname;	
				
				$resized_file_1 = $path."/web/uploads/$university->id/cover_photo/" . '1800X1200_'.$filname;
				$wmax_1 = 1500;
				$hmax_1 = 500;
				if($width_1>$wmax_1 OR $height_1>$hmax_1){
				$this->ak_img_resize($original_file, $resized_file_1, $wmax_1, $hmax_1, $fileExt);
				}
				else {
				$this->ak_img_resize($original_file, $resized_file_1, $width_1, $height_1, $fileExt);   
				}
				unlink($original_file);
				/*resize cover photo end here --------------------------------------------------------------------*/ 		
			return $filname;
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
			$file = explode('.',$this->imageFile->name);
			$filname = $file[0] .time(). '.'. $file[1];			
			$this->logoFile->saveAs($path."/web/uploads/$university->id/logo/" .  $filname);
			/*resize logo starts here author@roan-------------------------------------------------------*/
				$fileExt = explode(".", $filname);
				$fileExt = end($fileExt);
				$data = getimagesize($path."/web/uploads/$university->id/logo/" . $filname);
				$width_1  = $data[0];
				$height_1 = $data[1];
				$original_file = $path."/web/uploads/$university->id/logo/" . $filname;
				
				$resized_file_1 = $path."/web/uploads/$university->id/logo/" . '170X115_'.$filname;
				$wmax_1 = 170;
				$hmax_1 = 115;
				if($width_1>$wmax_1 OR $height_1>$hmax_1){
				$this->ak_img_resize($original_file, $resized_file_1, $wmax_1, $hmax_1, $fileExt);
				}
				else {
				$this->ak_img_resize($original_file, $resized_file_1, $width_1, $height_1, $fileExt);   
				}
				unlink($original_file);
                /*resize logo end here --------------------------------------------------------------------*/ 
			return $filname;
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
				$files = explode('.',$file->name);
				$filname = $files[0] .time(). '.'. $files[1];				
                $result = $file->saveAs($path."/web/uploads/$university->id/photos/" . $filname);

                /*resize university photo starts here author@roan-------------------------------------------------------*/
				$fileExt = explode(".", $filname);
				$fileExt = end($fileExt);
				$data = getimagesize($path."/web/uploads/$university->id/photos/" . $filname);
				$width_1 = $width_2 = $data[0];
				$height_1 = $height_2 = $data[1];
				$original_file = $path."/web/uploads/$university->id/photos/" . $filname;

				$resized_file_1 = $path."/web/uploads/$university->id/photos/" . '1800X1200_'.$filname;
				$wmax_1 = 1800;
				$hmax_1 = 1200;
				if($width_1>$wmax_1 OR $height_1>$hmax_1){
				$this->ak_img_resize($original_file, $resized_file_1, $wmax_1, $hmax_1, $fileExt);
				}
				else {
				$this->ak_img_resize($original_file, $resized_file_1, $width_1, $height_1, $fileExt);   
				}

				$resized_file_2 = $path."/web/uploads/$university->id/photos/" . '600X400_'.$filname;
				$wmax_2 = 600;
				$hmax_2 = 400;
				if($width_2>$wmax_2 OR $height_2>$hmax_2){
				$this->ak_img_resize($original_file, $resized_file_2, $wmax_2, $hmax_2, $fileExt);
				}
				else {
				$this->ak_img_resize($original_file, $resized_file_2, $width_2, $height_2, $fileExt);   
				}
				unlink($original_file);
                /*resize university photo end here --------------------------------------------------------------------*/

				$filenames[] = $filname;
				if(!$result) {
					return false;
				}
            }
			return $filenames;
		}
		return false;
	}
	
	public function uploadConsultantImage($consultant) {
		$result = is_dir("./../../partner/web/uploads/$consultant->id/");
		if (!$result) {
			$result = FileHelper::createDirectory("./../../partner/web/uploads/$consultant->id/");
		}
		if ($this->validate() && isset($this->consultantImage)) {
			$this->consultantImage->saveAs("./../../partner/web/uploads/$consultant->id/profile_photo" . '.' . $this->consultantImage->extension);
			$this->consultantImage = null;
			return true;
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
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->imageadvert->saveAs($path."/web/uploads/advertisements/$model->id/".  $filname);			
			return $filname;
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
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/consultanttasks/$model->id/".  $filname);			
			return $filname;
		}
		return false;
	}
	
	public function uploadSrmTask($model) {
		$path = Yii::getAlias('@frontend'); 
		$result = is_dir($path."/web/uploads/srmtasks/$model->id");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/srmtasks/$model->id");
		}
		if ($this->validate() && isset($this->attachment)) { 
			$file = explode('.',$this->attachment->name);
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/srmtasks/$model->id/".  $filname);			
			return $filname;
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
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->attachment->saveAs($path."/web/uploads/tasks/$model->id/".  $filname);			
			return $filname;
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
			$filname = $file[0] .time(). '.'. $file[1]; 
			$this->imageFile->saveAs($path."/web/uploads/$university->university_id/cover_photo/" .  $filname);			
			return $filname;
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
			$filname = $file[0] .time(). '.'. $file[1];			
			$this->logoFile->saveAs($path."/web/uploads/$university->university_id/logo/" .  $filname); 
			return $filname;
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
				$filname = $files[0] .time(). '.'. $files[1];				
                $result = $file->saveAs($path."/web/uploads/$university->university_id/photos/" . $filname);
				$filenames[] = $filname;
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
				$filname = $files[0] .time(). '.'. $files[1];				
                $result = $file->saveAs($path."/web/uploads/$university->university_id/documents/" . $filname);
				$filenames[] = $filname;
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

/*    function ak_img_resize($target, $newcopy, $w, $h, $ext){

			    list($w_orig, $h_orig) = getimagesize($target);
			    $scale_ratio = $w_orig / $h_orig; 
			    if (($w / $h) > $scale_ratio) {
			           $w = $h * $scale_ratio;
			    } else {
			           $h = $w / $scale_ratio;
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
			    $tci = imagecreatetruecolor($w, $h);
			    imagealphablending($tci, false);
				imagesavealpha($tci, true);
			    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
			    if ($ext == "png"){ 
			    imagepng($tci, $newcopy, 5);
				}
				else{ 
			    imagejpeg($tci, $newcopy, 80);
				}
    }*/
}
