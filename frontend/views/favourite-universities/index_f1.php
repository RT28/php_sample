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
$asw_path = ConnectionSettings::ASW_URL.'uploads/';
$this->context->layout = 'profile';
$this->title = 'Shortlisted Universities';
?>
<div class="col-sm-12">
<?= $this->render('/student/_student_common_details'); ?>
<div class="row">
<div class="alert alert-danger remove-message hidden"></div>

<div class="col-xs-12 text-right">
<a class="btn btn-blue" href="/universities">View Universities</a>
</div>

  <?php if(sizeof($models) === 0): ?>
        <h2> You haven't shortlisted any course yet.</h2>
      
    <?php else: ?>
<div class="col-xs-12">
<div class="row mtop-10">
<?php 
$UGallery = "";
$LogoSrc = $path."/web/default-university.png";
foreach($models as $model):
//$LogoSrc = $path."/web/default-university.png";
//$UGallery = UniversityGallery::find()->where(['AND', ['=', 'university_id', $model->university_id],['=', 'photo_type',  'logo' ],['=', 'status',  '1' ],['=', 'active',  '1' ]])->one();

/*if($UGallery){
     $LogoSrc = $path."/web/uploads/".$model->university_id.'/logo/'.$UGallery->filename;
}*/
$LogoSrc = '';
$LogoSrc = $path."/web/default-university.png"; 

$UGallery = "";

$UGallery = UniversityGallery::find()->where(['AND',
        ['=', 'university_id', $model->university->id],  
        ['=', 'photo_type', 'logo'],        
        ['=', 'status',  '1' ],
        ['=', 'active',  '1' ]
        ])->one();


if(isset($UGallery)){ 
  $LogoSrc = $asw_path.$model->university->id."/logo/".$UGallery->filename;  
}
 

if(empty($UGallery)){       
 
        
$logo_path = $asw_path.$model->university->id."/logo/logo";
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
        <h4 class="university-name">
            <?= Html::a($model->university->name, ['university/view', 'id' => $model->university->id], ['class' => 'profile-link','title'=>$model->university->name]) ?>
            <a class="btn-unlist-course" data-university="<?= $model->university->id; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
        </h4>
        <!--<p class="university-address-1" title="<?= $model->university->city->name ?>, <?= $model->university->state->name ?>, <?= $model->university->country->name ?>"><?= $model->university->city->name ?>, <?= $model->university->state->name ?>, <?= $model->university->country->name ?></p>-->
        <div class="row">
 <div class="col-sm-8">
	   <div class="program-count"><div class="programm-units"><?= UniversityCourseList::find()->where(['=', 'university_id', $model->university->id])->count() ?></div> Programs</div>
       </div>

       </div>
    </div>
</div>

<?php endforeach ?>
</div>
    <?php endif; ?>
    </div>
</div>
</div>
</div>
</div>
<?php
    $this->registerJsFile('js/university.js');
?>
