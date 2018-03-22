<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use common\components\ConnectionSettings;
use common\models\UniversityGallery;
use common\models\UniversityCourseList;
use common\models\Advertisement;
use common\models\StudentFavouriteUniversities;

$path= ConnectionSettings::BASE_URL.'backend';
$asw_path = ConnectionSettings::ASW_URL.'uploads/';
$TodayDate = date('Y-m-d');

?>

 <div class="col-sm-12">
    <div class="group-title-index title-with-count">
    <div class="row">
        <h4>Listing</h4>
        <h1><?= $universityTotalCount; ?> Universities</h1>
    </div>
    </div>
 </div>
 <div class="book-section-listing-pg">
              <?php if(Yii::$app->user->isGuest) {?>
              <a href ="/signup" class= 'btn btn-blue pull-right' target="_blank" >Book your free session with our consultant</a>
              <?php } ?>
            </div>

<div class="row">
<div class="col-sm-12">
<div class="row university-listing-row" id='set_todiv'>
<?php


$c = 1;
foreach($models as $model):
$LogoSrc = '';
$LogoSrc = $path."/web/default-university.png"; 

$UGallery = "";

$UGallery = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $model->id],  
				['=', 'photo_type', 'logo'],				
				['=', 'status',  '1' ],
				['=', 'active',  '1' ]
				])->one();


if(isset($UGallery)){ 
	$LogoSrc = $asw_path.$model->id."/logo/".$UGallery->filename;  
}
 

if(empty($UGallery)){				
 
				
$logo_path = $asw_path.$model->id."/logo/logo";
if(glob($logo_path.'.jpg')){
  $LogoSrc = $logo_path.'.jpg';
} else if(glob($logo_path.'.png')){
  $LogoSrc = $logo_path.'.png';
} else if(glob($logo_path.'.gif')){
  $LogoSrc = $logo_path.'.gif';
}

}
?>


<div class="col-md-4 col-sm-6 university-listing-box">
    <div class="course-box">
        <div class="university-logo">
            <img src="<?php echo $LogoSrc;?>" alt=""/>
        </div>
        <?php 
            /*$sep = '-'; 
            $res = strtolower($model->name);
            $res = preg_replace('/[^[:alnum:]]/', ' ', $res);
            $res = preg_replace('/[[:space:]]+/', $sep, $res);*/
            $res = strtolower($model->name);
            $url_key = str_replace(" ", "-", $res);
            $url_key = rawurlencode($url_key);
            //$url_key =  trim($res, $sep);
            //$str = $model->name;
             //echo $str_dn;
         ?>
        <h4 class="university-name"><?= Html::a($model->name, ['university/view', 'id' => $url_key], ['class' => 'profile-link','title'=>$model->name]) ?></h4>
        <!--<p class="university-address-1"><?= $model->address ?></p>-->
        <!--<p class="university-address-1" title="<?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->country->name ?>"><?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->country->name ?></p>-->
       
<?php  $Courses = UniversityCourseList::find()->where(['=', 'university_id', $model->id])->all();
       $url = '/site/login';
        $favourite = StudentFavouriteUniversities::find()->where(['AND', ['=', 'university_id', $model->id], ['=', 'student_id', Yii::$app->user->identity->id]])->one();
 ?>

 <div class="row">
 <div class="col-xs-8">
        <?php if(count($Courses) > 0){
            $course_count = count($Courses);
            $prg_text = 'Programs';
            } else {
            $course_count = '&nbsp;';
            $prg_text = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';    
            } ?>
	   <div class="program-count"><div class="programm-units"><?php echo $course_count;?></div> <?php echo $prg_text; ?></div>
       </div>
 <div class="col-xs-4">
       <!--<a href="?r=site/login" class="course-apply shortlist-course with-info pull-right" type="button" data-course="18740" data-university="570"><i class="fa fa-plus" aria-hidden="true"></i></a>-->
       <?php if(!empty($favourite) && $favourite->favourite == 1) { ?>
                  <button type="button" class="btn-favourites added-button shortlist-btn shortlist-course with-info" data-shortlist="1" data-university="<?= $model->id ?>"><i class="fa fa-plus" aria-hidden="true"></i><span></span></button>
                  <?php }else{ ?>
                  <button type="button" class="btn-favourites add-button shortlist-btn shortlist-course with-info" data-university="<?= $model->id ?>" data-shortlist="0" data-toggle="modal" data-target="#login-modal" value="<?= (!Yii::$app->user->isGuest) ? '/university/favourite' : $url ?>"><i class="fa fa-plus" aria-hidden="true"></i><span></span></button>
        <?php }?>
       </div>

       </div>
       
    </div>
    </div>
    <!-- show advertisement between blocks -->
        <?php 
        $Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'university'],
        ['=', 'status',  '1' ],['=', 'section',  'between' ],['=', 'position',  $c ],
        ['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all();
        $path= ConnectionSettings::BASE_URL.'backend';
        ?>
        <?php foreach($Ads as $ad): ?>
        <div class="col-md-4 col-sm-6 university-listing-box">
        <div class="tile-ad">
        <a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="width:<?= $ad->width?> px; height:<?= $ad->height?> px;"/> </a>
        </div>
        </div>
        <?php ?>
        <?php endforeach; ?>
        <!-- end advertisement block -->
<?php $c++; endforeach ?>


<?php
/****************************************
 @Created By :- Pankaj Kumar
 @Module :- Program Fillter
 @Controller :- Coursecontroller/index
 @Function :- custom Ajax based pagination work.
************************************************/

$cur_page = $currpage;
$page= $currpage-1;
$per_page = $pages->defaultPageSize; // Per page records
$previous_btn = true;
$next_btn = true;
$start = $page * $per_page;
$end = $cur_page * $per_page;
$count=$pages->totalCount;
if($count>0){
	$no_of_paginations = ceil($count / $per_page);
}else{
	$no_of_paginations = 0;
}
 /* Calculating the staring and ending value for paging */
        if ($cur_page >= 10) {
            $start_loop = $cur_page - 4;
            if ($no_of_paginations > $cur_page + 5) {
                $end_loop = $cur_page + 4;
                //echo "if no of pagination (end loop)= ". $end_loop;
            } else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 5) {
                $start_loop = $no_of_paginations - 5;
                $end_loop = $no_of_paginations;
                //echo "else (start loop)= ". $start_loop;
            } else {
                $end_loop = $no_of_paginations;
                //echo "else (end loop)= ". $end_loop;
            }
        } else {
            $start_loop = 1;
            if ($no_of_paginations > 10)
                $end_loop = 10;
            else
                $end_loop = $no_of_paginations;
        }
		$displaymsg='';
        if ($cur_page == 0 || $cur_page == 1) {
            if ($count <= $per_page) {
                $end = $count;
            }else if($end==0){
				$end = $per_page;
			}
            if($count>0){
                $displaymsg = 'Showing 1 to ' . $end . ' of ' . $count . ' entries';                
            }
        } elseif ($cur_page > 1 && $cur_page <= $no_of_paginations) {
            if ($count <= $end) {
                $end = $count;
            }
            $displaymsg = 'Showing ' . $start . ' to ' . $end . ' of ' . $count . ' entries';
        }
		$msg='';
        $msg = "<div class='pagination col-sm-12'>";
        $msg .="<div style='float:left; height:14px; padding:8px' role='status' aria-live='polite'>";
        $msg .= $displaymsg;
        $msg .= "</div>";
        $msg .="<div style='float:right;'><ul class='pagination' id='pagin_count'>";

        if ($previous_btn && $cur_page > 1) {
            $pre = $cur_page - 1;
            $msg .="<li p='$pre'><a href='javascript:void()' onClick='pagingcustom($pre);'>Previous</a></li>";
        }
        for ($i = $start_loop; $i <= $end_loop; $i++) {
            if ($cur_page == $i || ($cur_page == 0 && $i==1))
                $msg .="<li p='$i' class='active'><a>{$i}</a></li>";
            else
                $msg .="<li p='$i'><a href='javascript:void()' onClick='pagingcustom($i);'>{$i}</a></li>";
        }
        // for enabling the next button
        if ($next_btn && $cur_page < $no_of_paginations) {
            $nex = $cur_page + 1;
            $msg .="<li p='$nex'><a href='javascript:void()' onClick='pagingcustom($nex);'>Next</a></li>";
        }
        $msg = $msg . "</ul></div></div>";
		echo $msg;

		/******** End *******/

?>


</div>
</div>
</div>
