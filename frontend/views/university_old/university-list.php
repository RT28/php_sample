<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use common\components\ConnectionSettings;
use common\models\UniversityGallery;
use common\models\UniversityCourseList;

$path= ConnectionSettings::BASE_URL.'backend';

?>

<div class="group-title-index">
<div class="row">
<div class="col-sm-6">
    <h1><?= $universityTotalCount; ?> Universities</h1>
</div>
<div class="col-sm-6">

	<a href ="<?=Url::to('partner/web/index.php?r=university/university-enquiry/create', true)?>" class= 'btn btn-blue pull-right' >Partner with us<a/>
</div>
</div>
</div>
<div class="body-3 loaded" style="width: auto; height: auto;">
    <div class="dots-loader"></div>
</div>
<div class="row">
<div class="col-sm-12">
<div class="row">
<?php



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
	$LogoSrc = $path."/web/uploads/".$model->id."/logo/".$UGallery->filename;  
}
 

if(empty($UGallery)){				
 
				
$logo_path = "./../../backend/web/uploads/".$model->id."/logo/logo";
if(glob($logo_path.'.jpg')){
  $LogoSrc = $logo_path.'.jpg';
} else if(glob($logo_path.'.png')){
  $LogoSrc = $logo_path.'.png';
} else if(glob($logo_path.'.gif')){
  $LogoSrc = $logo_path.'.gif';
}

}
?>

<div class="col-md-4 col-sm-6">
    <div class="course-box">
        <div class="university-logo">
            <img src="<?php echo $LogoSrc;?>" alt=""/>
        </div>
        <h4 class="university-name"><?= Html::a($model->name, ['university/view', 'id' => $model->id], ['class' => 'profile-link','title'=>$model->name]) ?></h4>
        <!--<p class="university-address-1"><?= $model->address ?></p>-->
        <p class="university-address-1" title="<?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->country->name ?>"><?= $model->city->name ?>, <?= $model->state->name ?>, <?= $model->country->name ?></p>
       
<?php  $Courses = UniversityCourseList::find()->where(['=', 'university_id', $model->id])->all();
 
 ?>
	   <div class="program-count">Programs : <?php echo count($Courses);?></div>
    </div>
    </div>
<?php endforeach ?>


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
            if ($no_of_paginations > $cur_page + 4) {
                $end_loop = $cur_page + 4;
                //echo "if no of pagination (end loop)= ". $end_loop;
            } else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 9) {
                $start_loop = $no_of_paginations - 9;
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
            if ($count <= $end) {
                $end = $count;
            }else if($end==0){
				$end = $per_page;
			}
            $displaymsg = 'Showing 1 to ' . $end . ' of ' . $count . ' entries';

        } elseif ($cur_page > 1 && $cur_page <= $no_of_paginations) {
            if ($count <= $end) {
                $end = $count;
            }
            $displaymsg = 'Showing ' . $start . ' to ' . $end . ' of ' . $count . ' entries';
        }
		$msg='';
        $msg = "<div class='pagination'>";
        $msg .="<div style='float:left; height:14px; padding:8px' role='status' aria-live='polite'>";
        $msg .= $displaymsg;
        $msg .= "</div>";
        $msg .="<div style='float:right;'><ul class='pagination'>";

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
