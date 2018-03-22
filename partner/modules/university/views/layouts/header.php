<?php
use yii\helpers\FileHelper;
use common\models\University; 
use common\components\Roles;
use yii\helpers\Html;
use common\components\ConnectionSettings;

$partner_id = Yii::$app->user->identity->partner_id;
$model = University::find()->where(['=', 'id', $partner_id])->one();
$id = $partner_id;

$LogoPhotoPath = [];
$src = './noprofile.gif';
if(is_dir('./../../backend/web/uploads/'.$id.'/logo')) {
$LogoPhotoPath = FileHelper::findFiles('./../../backend/web/uploads/'.$id.'/logo', [
'caseSensitive' => true,
'recursive' => false,
//'only' => ['logo.*']
]);
}

if (count($LogoPhotoPath) > 0) {

$src = $LogoPhotoPath[0];
}

?>

<nav class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div class="gtu-logo">
<a href="<?php echo ConnectionSettings::BASE_URL; ?>"><img src="images/logo.png"/></a>
</div>
<div class="university-logo"><img src="<?= $src; ?>"  alt="<?= $university->name ?>"/></div>
</div>
<div class="user-info pull-right">

 <div class="university-name">

<?php echo Html::beginForm(['/site/logout'], 'post');
	echo Html::submitButton('Logout',['class'=>'btn btn-blue'] ); ?>
<?php echo Html::endForm(); ?>
</div>
</div>
</div>
</nav>
