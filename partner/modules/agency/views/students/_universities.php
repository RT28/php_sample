<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Favorites;
use common\models\University;
use common\models\Student;
use common\models\UniversityCourseList;
use common\components\ConnectionSettings;
use common\models\UniversityGallery;
	 
$path= ConnectionSettings::BASE_URL.'backend'; 
$this->title = 'Shortlisted Universities';
 $forntUrl = ConnectionSettings::BASE_URL.'frontend';
?>
<div class="col-sm-12"> 
<div class="row">
<div class="alert alert-danger remove-message hidden"></div>
 

  <?php if(sizeof($shortlistedUni) === 0): ?>
        <h2> You haven't shortlisted any course yet.</h2>
      
    <?php else: ?>
<div class="row">
<?php 
$UGallery = "";
$LogoSrc = $path."/web/default-university.png";
foreach($shortlistedUni as $model):
//$LogoSrc = $path."/web/default-university.png";
//$UGallery = UniversityGallery::find()->where(['AND', ['=', 'university_id', $model->university_id],['=', 'photo_type',  'logo' ],['=', 'status',  '1' ],['=', 'active',  '1' ]])->one();

/*if($UGallery){
     $LogoSrc = $path."/web/uploads/".$model->university_id.'/logo/'.$UGallery->filename;
}*/
$logo_path = "./../../backend/web/uploads/".$model->university_id."/logo/logo";
if(glob($logo_path.'.jpg')){
  $LogoSrc = $logo_path.'.jpg';
} else if(glob($logo_path.'.png')){
  $LogoSrc = $logo_path.'.png';
} else if(glob($logo_path.'.gif')){
  $LogoSrc = $logo_path.'.gif';
}
?>

<div class="col-md-4 col-sm-6">
    <div class="course-box">
        <div class="university-logo">
            <img src="<?php echo $LogoSrc;?>" alt=""/>
        </div>
        <h4 class="university-name">
		<a href="<?= $forntUrl.'/web/index.php?r=university/view&id='.$model->university->id;?>" class = 'profile-link'><?= $model->university->name?> </a>
        </h4>
        <p class="university-address-1" title="<?= $model->university->city->name ?>, <?= $model->university->state->name ?>, <?= $model->university->country->name ?>"><?= $model->university->city->name ?>, <?= $model->university->state->name ?>, <?= $model->university->country->name ?></p>
    </div>
</div>

<?php endforeach ?>
</div>
    <?php endif; ?>
</div>
</div>
 
 
