<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\Commondata;  
use common\models\Country;
use common\models\Degree;
use common\models\DegreeLevel;
use common\models\StandardTests;
 
$days = Commondata::getDay();
$consultantName =  Commondata::getTitleName($model->title). ' '.$model->first_name.' '.$model->last_name;
$this->title = $consultantName; 
$this->context->layout = 'index';
	

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

$responsible = '';
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
}

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

<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER--> 
				
                <div class="page-top-img">
                    <h1 class="page-title-top"><?php echo $consultantName;?> Detail Page</h1>
                </div>
                <div class="section section-padding profile-teacher">
                    <div class="container">
                      <div class="row">
                        <div class="col-sm-3">
                            <div class="teacher-info">
                                <div class="staff-item2 customize">
                                    <div class="staff-item-wrapper">
                                        <div class="staff-info">
                                            <a href="#" class="staff-avatar">
			<?php
			$src = './../../partner/web/noprofile.gif';

			if(is_dir('./../../partner/web/uploads/consultant/' . $model->consultant_id . '/profile_photo')) {
			$cover_photo_path = "./../../partner/web/uploads/consultant/".$model->consultant_id."/profile_photo/logo_170X115";
			if(glob($cover_photo_path.'.jpg')){
			$src = $cover_photo_path.'.jpg';
			} else if(glob($cover_photo_path.'.png')){
			$src = $cover_photo_path.'.png';
			} else if(glob($cover_photo_path.'.gif')){
			$src = $cover_photo_path.'.gif';
			} 
			} 
			?>
                                                <img src="<?= $src; ?>" alt="" class="img-responsive"/>
                                            </a>
                                            <a href="#" class="staff-name"><?= $consultantName; ?></a>
                                        </div>
                                    </div> 
                                    <!--<div class="staff-socials">
                                        <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                                        <a href="#" class="google"><i class="fa fa-google-plus"></i></a>
                                        <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                                        <a href="#" class="pinterest"><i class="fa fa-pinterest-p"></i></a>
                                    </div> -->
                                </div>

                              </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="teacher-des">
                                    <div class="title"><?= $consultantName; ?></div>
                                
                                    <div class="content">
                                                  
<div class="row">
<div class="col-sm-12"> 
<div class="row">
<div class="col-sm-6" > 
<p><strong>Name :</strong> <?php echo $consultantName;?></p> 
<p><strong>Gender :</strong> <?php echo Commondata::getGenderName($model->gender);?></p> 
<p><strong>Country  :</strong> <?php if($model->country->name) { echo $model->country->name;  } ?></p> 
<p><strong>Experience :</strong> <?php echo $model->experience_years.' Years '.$model->experience_months.' Months';?></p>
<p><strong>Working Hours :</strong> <?php echo $model->work_hours_start.' to '.$model->work_hours_end;?></p>
<p><strong>Working Days :</strong> <?php if(isset($getworkdays)) { echo $getworkdays;  } ?></p>
<p><strong>Description : </strong> <?php if($model->description) { echo $model->description;  } ?></p>
</div>
<div class="col-sm-6" >
<strong>Specialization :</strong>
 

 <?php if(!empty($degreelevel) || $degreelevel!=0) {?>
 <p><strong>Degree Level :</strong>
<ul class="detail-list">
<?php
$degreelevel = explode(',', $degreelevel);
?>
<?php foreach($degreelevel as $dlevel): ?>
<li><?= $dlevel; ?></li>
<?php endforeach; ?>
</ul></p>
<?php } ?>

 <?php if(!empty($country_level) || $country_level!=0) {?>
 <p><strong>College admission for :</strong>
<ul class="detail-list">
<?php
$country_levels = explode(',', $country_level);
?>
<?php foreach($country_levels as $clevel): ?>
<li><?= $clevel; ?></li>
<?php endforeach; ?>
</ul></p>
<?php } ?>

<!-- <?php if(!empty($responsible) || $responsible!=0) {?>
<p><strong>Responsible for countries :</strong>
<ul class="detail-list">
<?php
$responsible = explode(',', $responsible);
?>
<?php foreach($responsible as $res): ?>
<li><?= $res; ?></li>
<?php endforeach; ?>
</ul></p>
<?php } ?>
 

 <?php if(!empty($tests) || $tests!=0) {?>
 <p><strong>Standard Tests :</strong>
 <?php echo $tests; ?></p> 
 <?php  } ?>
<p><strong>Speciality :</strong> <ul class="detail-list">
<?php
$skills = explode(',', $degrees);
?>
<?php foreach($skills as $skill): ?>
<li><?= $skill; ?></li>
<?php endforeach; ?>
</ul>
</p> -->

</div> 			
</div> 


</div>
</div>
                                    </div>
                                </div>
                              </div>
                        </div>

                            <!--<div class="group-title-index">
                                <h1>Certificates</h1>
                            </div>
                            <div class="slider-logo">
                                <div class="slider-logo-wrapper">
                                    <div class="slider-logo-content">
                                        <div class="carousel-logos owl-carousel">
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-1.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-2.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-3.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-4.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-5.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-6.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-1.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-2.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-3.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-4.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-5.png" alt="" class="img-responsive"/></a></div>
                                            <div class="logo-iteam item"><a href="#"><img src="/images/logo/logo-carousel-6.png" alt="" class="img-responsive"/></a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <!--<div class="section teacher-course section-padding">
                    <div class="container teacher-course-wrapper">
                            <div class="group-title-index">
                                <h1>Courses</h1>
                            </div>
                            <div class="course-table">
                                <div class="outer-container">
                                    <div class="inner-container">
                                        <div class="table-header">
                                            <table class="edu-table-responsive">
                                                <thead>
                                                <tr class="heading-table">
                                                    <th class="col-1">id</th>
                                                    <th class="col-2">course name</th>
                                                    <th class="col-3">duration</th>
                                                    <th class="col-4">timeline</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <div class="table-body">
                                            <table class="edu-table-responsive table-hover">
                                                <tbody>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Sport Exercise Sciences</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Learning Website Optimization With Bootstrap</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Skeching Custom Item Prize Design</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Learning Website Optimization With Bootstrap</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Learning Viral Web Design Projects</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Email Marketing Strategy With MailChimp</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                                <tr class="table-row">
                                                    <td class="col-1"><span>ED1</span></td>
                                                    <td class="col-2"><a href="courses-detail.html">Social Media Network & Marketing</a></td>
                                                    <td class="col-3"><span>2 months</span></td>
                                                    <td class="col-4"><span>01/01/2016 -  02/15/2016</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJsFile('@web/js/pages/profile-teacher.js');
?>
