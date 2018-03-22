<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\Commondata;  
use common\models\Degree; 
use common\models\Country;
use common\models\DegreeLevel;
use common\models\StandardTests;
use common\models\Advertisement;
use common\components\ConnectionSettings;

$this->title = 'Consultant';
$this->context->layout = 'index';
$TodayDate = date('Y-m-d');
$path= ConnectionSettings::BASE_URL.'backend';

?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content"><!-- SLIDER BANNER-->
        <div class="container">
          <div class="section section-padding package">
            <div class="row">

              <div class="col-sm-6 text-left">
                <div class="group-title-index">
                  <h1>Our</br>
                    Consultants </h1>
                </div>
              </div>
              <div class="col-sm-6">
              <?php if(Yii::$app->user->isGuest) {?>
              <a href ="/signup" class= 'btn btn-blue pull-right' target="_blank" >Book your free session with our consultant</a>
              <?php } ?>
            </div>
              <div class="col-sm-6 text-right">
                <?php  
                $form = ActiveForm::begin(['action' =>  '/consultant/index', 'method' =>  'GET', 'id' => 'consultant_index']); ?>
                <select name="sort" class="sort-option">
                  <option value="consultant.first_name" <?php if (isset($_GET['sort']) &&  $_GET['sort']=='consultant.first_name') {echo "selected"; } ?>>Name</option>
                  <option value="country.name" <?php if (isset($_GET['sort']) && $_GET['sort']=='country.name') {echo "selected"; } ?>>Country</option>
                  <option value="city.name" <?php if (isset($_GET['sort']) &&  $_GET['sort']=='city.name') {echo "selected" ;} ?>>City</option>
                </select>
                <select name="order" class="sort-option">
                  <option value="ASC" <?php if (isset($_GET['order']) &&  $_GET['order']=='ASC') {echo "selected"; } ?>>Ascending</option>
                  <option value="DESC" <?php if (isset($_GET['order']) && $_GET['order']=='DESC') {echo "selected"; } ?>>Descending</option>
                </select>
                <!--<input type="submit" value="Sort" />-->
                <?php ActiveForm::end(); ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9">
                <div class="row" id="accordion" role="tablist" aria-multiselectable="true">
                  <?php foreach($models as $model): ?>
<?php 
$days = Commondata::getDay();
$consultantName =  Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;
  
$degreelevel = '';
if($model->degree_level){
    $dtemp = $model->degree_level;
        if (strpos($dtemp, ',')) {
            $darr = explode(',', $dtemp);
        } else {
            $darr[] = $dtemp;
        }
$darr = DegreeLevel::find()->select('name')
                              ->where(['in', 'id', $darr])
                              ->asArray()
                              ->all();
        
        foreach($darr as $dlevel) {
            $degreelevel[]= $dlevel['name'];
        }
  $degreelevel = implode(',', $degreelevel);
}

$country_level = '';
if($model->country_level){
    $ctemp = $model->country_level;
        if (strpos($ctemp, ',')) {
            $carr = explode(',', $ctemp);
        } else {
            $carr[] = $ctemp;
        }
$carr = Country::find()->select('name')
                              ->where(['in', 'id', $carr])
                              ->asArray()
                              ->all();
        
        foreach($carr as $clevel) {
            $country_level[]= $clevel['name'];
        }
  $country_level = implode(',', $country_level);
}

/*$responsible = '';
if($model->responsible){
    $rtemp = $model->responsible;
        if (strpos($rtemp, ',')) {
            $rarr = explode(',', $rtemp);
        } else {
            $rarr[] = $rtemp;
        }
$rarr = Country::find()->select('name')
                              ->where(['in', 'id', $rarr])
                              ->asArray()
                              ->all();
        
        foreach($rarr as $rlevel) {
            $responsible[]= $rlevel['name'];
        }
  $responsible = implode(',', $responsible);
}*/

$tests = '';
if($model->standard_test){
    $stemp = $model->standard_test;
        if (strpos($stemp, ',')) {
            $tarr = explode(',', $stemp);
        } else {
            $tarr[] = $stemp;
        }
$tarr = StandardTests::find()->select('name')
                              ->where(['in', 'id', $tarr])
                              ->asArray()
                              ->all();
        
        foreach($tarr as $test) {
            $tests[]= $test['name'];
        }
  $tests = implode(', ', $tests);
}
  
$degrees = '';
if($model->speciality){
    $temp = $model->speciality;
        if (strpos($temp, ',')) {
            $sarr = explode(',', $temp);
        } else {
            $sarr[] = $temp;
        }
$sarr = Degree::find()->select('name')
                              ->where(['in', 'id', $sarr])
                              ->asArray()
                              ->all();
        
        foreach($sarr as $degree) {
            $degrees[]= $degree['name'];
        }
  $degrees = implode(',', $degrees);
}
$getworkdays = 'NA';
$getdays = array();
if(!empty($model->work_days)){
    $temp = $model->work_days;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        } 
        if(isset($arr)){
        foreach($arr as $day) {
            $getdays[]= $days[$day];
        }
    }
  $getworkdays = implode(',', $getdays);
}
  
?>

        <?php
            $profile_path = "./../../partner/web/uploads/consultant/".$model->consultant_id."/profile_photo/consultant_image_228X228";
            if(glob($profile_path.'.jpg')){
              $src = $profile_path.'.jpg';
            } else if(glob($profile_path.'.png')){
              $src = $profile_path.'.png';
            } else if(glob($profile_path.'.gif')){
              $src = $profile_path.'.gif';
            } else if(glob($profile_path.'.jpeg')){
              $src = $profile_path.'.jpeg';
            } else if(glob($profile_path.'.JPG')){
              $src = $profile_path.'.JPG';
            } else if(glob($profile_path.'.PNG')){
              $src = $profile_path.'.PNG';
            } else if(glob($profile_path.'.GIF')){
              $src = $profile_path.'.GIF';
            } else if(glob($profile_path.'.JPEG')){
              $src = $profile_path.'.JPEG';
            }

            else {
                $src = './../../partner/web/noprofile.gif';
            }
        ?>
                  <div class="col-sm-12">
                    <div class="consultant-list-block">
                    <div class="consultant-list-top-point" id="<?= $model->consultant_id ?>"></div> 
                    <a role="button" data-toggle="collapse" href="#consultant<?= $model->consultant_id ?>" aria-expanded="false" aria-controls="consultant<?= $model->consultant_id ?>">
                      <div class="trigger">
                        <div class="row">
                          <div class="col-sm-4">
                            <div class="consultant-image"> 
                              <img src="<?= $src; ?>" alt="<?= $model->first_name.' '.$model->last_name; ?>" />
                              <!-- <img src="/images/user-4.jpg" alt="" /> --> </div>
                          </div>
                          <div class="col-sm-8">
                            <div class="caption">
                              <h3 class="consultant-name"><?php echo Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;?></h3>
                              <div class="row">
                                <div class="col-sm-6">
                                  <div class="consultant-info-div">
                                    <label>Country: </label>
                                    <span>
                                    <?= $model->country->name; ?>
                                    </span></div>
                                  <div class="consultant-info-div">
                                    <label>Experience: </label>
                                    <span><?php echo $model->experience_years.' Years '.$model->experience_months.' Months';?></span></div>
                                </div>
                                <div class="col-sm-6">
                                  <div class="consultant-info-div">
                                    <label>Languages: </label>
                                    <span><?php if(isset($model->languages)) { echo $model->languages;  } ?></span></div>
                                  <!-- <div class="consultant-info-div">
                                    <label>Gender: </label>
                                    <span><?php echo Commondata::getGenderName($model->gender);?></span></div> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      </a>
                      <div class="collapse" id="consultant<?= $model->consultant_id ?>">
                        <div class="">
                        	<div class="row">
                            	<div class="col-sm-8">
                                  <div class="consultant-info-div">
                                    <label>About: </label>
                                    <p class="about-content"><?= $model->description ?></p>
                                  </div>
                                </div>
                            	<div class="col-sm-4">
                                  <div class="consultant-info-div">
                                    <label>Specialization </label>
                                     <?php if(!empty($degreelevel) || $degreelevel!=0) {?>
                                     <span>Degree Level :</span>
                                    <ul class="detail-list">
                                    <?php
                                    $degreelevel = explode(',', $degreelevel);
                                    ?>
                                    <?php foreach($degreelevel as $dlevel): ?>
                                    <li><?= $dlevel; ?></li>
                                    <?php endforeach; ?>
                                    </ul>
                                    <?php } ?>
                                    <span>Country Level</span>
                                    <?php if(!empty($country_level) || $country_level!=0) {?>
                                    <ul class="detail-list">
                                    <?php
                                    $country_levels = explode(',', $country_level);
                                    ?>
                                    <?php foreach($country_levels as $clevel): ?>
                                    <li><?= $clevel; ?></li>
                                    <?php endforeach; ?>
                                    </ul>
                                    <?php } ?>
                                  </div>
                                  <div class="consultant-info-div">
                                    <span>Standard Test Strategy</span>
                                    <p><?php echo $tests; ?></p></p>
                                  </div>
                                </div>
                                  <!--<div class="consultant-info-div">
                                    <label>Working Hours: </label>
                                    <span><?php echo $model->work_hours_start.' to '.$model->work_hours_end;?></span>
                                  </div>
                                  <div class="consultant-info-div">
                                    <label>Working Days: </label>
                                    <span><?php if(isset($getworkdays)) { echo $getworkdays;  } ?></span>
                                  </div>-->
                                </div>
                            </div><div class="row">
                            	<div class="col-sm-8">
                                </div>
                            	<div class="col-sm-4">
                                  
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="col-sm-3 right-side-addblocks">
                <?php 
                $Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'consultant'],
                ['=', 'status',  '1' ],['=', 'section',  'right' ],
                ['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all(); 
                ?>
                <div class="ad-blocks">
                  <?php foreach($Ads as $ad): ?>
                  <a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="height: <?= $ad->height;?>px; width: <?= $ad->width;?>px;"/> </a>
                  <p style="height: 8px;">&nbsp;</p>
                  <?php   ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/easyNotify.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>

