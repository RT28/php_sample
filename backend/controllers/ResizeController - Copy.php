<?php

namespace backend\controllers;

use Yii;
use common\models\University;
use backend\models\UniversitySearch;
use backend\models\SiteConfig;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors; 
use common\models\UniversityAdmission;
use common\components\Roles;
use common\components\AccessRule;
use common\models\UniversityCourseList;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\FileUpload;
use backend\models\UniversityDepartments;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;
use yii\helpers\FileHelper;
use common\models\Currency;
use common\components\Status;
use common\models\StandardTests;
use yii\base\ErrorException;
use common\models\UniversityBrochures;
use common\models\UniversityGallery;
use common\components\ConnectionSettings;
use yii\db\IntegrityException; 
use common\components\Commondata;

/**
 * UniversityController implements the CRUD actions for University model.
 */
class ResizeController extends Controller
{

    /**
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $rows = (new \yii\db\Query())
    ->select(['id'])
    ->from('university')
    ->all();

    foreach ($rows as $row) {

        $cu_id = $row['id'];
        //echo "ID: $cu_id<br /><br />";
        $path = Yii::getAlias('@backend'); 
        $filepath = $path."/web/uploads/$cu_id/logo/";
    $dir = $filepath;

// Open a directory, and read its contents
/*if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      echo $cu_id."=". "filename:" . $file . "<br>";
    }
    closedir($dh);
  }
}*/

        if (is_dir($filepath)) { 
        $imageFile = 'logo_170X115.png';
        $savefileinDB = $this->ak_img_resize($filepath, $imageFile,'logo'); 
        /*Yii::$app->db->createCommand()
       ->update('university', ['follow_status' => $model->status], ['id' => $student_id])
       ->execute();*/ 
        }

    }
    }


function ak_img_resize($path, $filename, $img_type){

       
       ini_set("memory_limit","-1");
       
                $fileExt = explode(".", $filename);
                $ext = end($fileExt);
                $data = getimagesize($path.$filename); 
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
             return $getFileNameToSaveDB;
            }
    }
 
	
}
