<?php
    use common\models\PackageOfferings;
    use common\components\PackageLimitType;
    use yii\helpers\FileHelper;
    $this->title = $package->name;
    $this->context->layout = 'index';
?>

<input type="hidden" id="limit-type" value="<?= $subPackage->limit_type; ?>" />
<input type="hidden" id="limit-count" value="<?= $subPackage->limit_count; ?>" />
<input type="hidden" id="package" value="<?= $package->id; ?>" />
<input type="hidden" id="sub-package" value="<?= $subPackage->id; ?>" />
<input type="hidden" id="hour-cost" value="250" />
<input type="hidden" id="five-hour-cost" value="1100" />

<div id="wrapper-content" class="package-offerings"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content"><!-- SLIDER BANNER-->
<div class="package-info">
<div class="section-padding">
<div class="container">
<div class="error alert alert-danger hidden"></div> 
<div class="info alert alert-info hidden"></div> 
<h1 class="package-title text-center">
<?= $package->name; ?>
<?php
$url = '/packages/buy';
if (Yii::$app->user->isGuest) {
$url = '/site/login';
}
?>
<button class="btn btn-blue btn-buy" data-url="<?= $url; ?>">
                            <?= Yii::t('gtuservice', 'Buy') ?></button>
</h1>
<h2 class="package-sub-title text-center"><?= $subPackage->description; ?></h2>
<?php if($subPackage->limit_type != PackageLimitType::LIMIT_HOURS): ?>
<input type="hidden" id="non-hour-cost" value="<?= $subPackage->fees; ?>"/>
<?php endif; ?>
<div class="row">
<?php foreach($offerings as $offering): ?>
<div class="col-sm-6">
<div class="package-block">
<div class="group-title-index">
<h1>
<?= $offering->name; ?> (<?= $offering->time; ?> Hrs)
<input type="checkbox" class="chk-offering" data-offering="<?= $offering->id; ?>" data-time="<?= $offering->time; ?>"/>
</h1>
</div>
<div class="row">
<div class="col-sm-6">
<div class="package-block-img">
<?php
$src = 'images/article-1.jpg';
if (is_dir("./../../backend/web/package-offerings-uploads/$offering->id")) {
$icon = FileHelper::findFiles("./../../backend/web/package-offerings-uploads/$offering->id", [
'caseSensitive' => true,
'recursive' => false,
]);
if (count($icon) > 0) {
$src = $icon[0];
$src = str_replace('\\','/', $src);                            
}
}
?>
<img src="<?= $src;?>" alt="<?= $offering->name; ?>" class="package-offering-icon">
</div>
</div>
<div class="col-sm-6">
<div class="package-block-text">
<div class="ic-cots"> <i class="fa fa-quote-right" aria-hidden="true"></i> </div>
<p><?= $offering->description; ?></p>
</div>
</div>
</div>
</div>
</div>
<?php endforeach; ?>
<div class="col-xs-12 text-center" style="margin-top: 20px;">
<button class="btn btn-blue btn-buy" data-url="<?= $url ;?>"><?= Yii::t('gtuservice', 'Buy') ?></button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php
    $this->registerJsFile('js/packages.js');
?>