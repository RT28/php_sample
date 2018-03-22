<?php

use common\components\PackageLimitType;
if($subPackage->limit_type == PackageLimitType::LIMIT_HOURS) {
    $time = $time;
} else {
    $time = $subPackage->limit_count;
}

$this->context->layout = 'index';
$this->title = 'Select Consultant';
?>
<input type="hidden" id="package" value="<?= $package->id; ?>" />
<input type="hidden" id="sub-package" value="<?= $subPackage->id; ?>" />
<input type="hidden" id="offerings" value="<?= implode(',', $offeringIds); ?>" />
<div id="wrapper-content" class="package-select-consultant"><!-- PAGE WRAPPER-->
<div id="page-wrapper"><!-- MAIN CONTENT-->
<div class="main-content"><!-- CONTENT-->
<div class="content"><!-- SLIDER BANNER-->
<div class="package-info">
<div class="section-padding">
<div class="container">
<div class="error alert alert-danger hidden"></div>
<h1><?= $this->title ?></h1>
<h2> Package: <?= $package->name; ?> - <?= $subPackage->name; ?> - $<?= $subPackage->fees; ?></h2>
<ul class="list-group">
	<?php foreach($offerings as $offering): ?>
		<li class="list-group-item"><?= $offering->name; ?> <?= $offering->time; ?></li>
	<?php endforeach; ?>
</ul>
<ul class="list-group">
	<?php foreach($consultants as $consultant): ?>
		<li class="list-group-item"><?= $consultant->name; ?><input type="radio" name="consultant" class="rdo-selected" data-consultant="<?= $consultant->consultant_id; ?>"/></li>
	<?php endforeach; ?>
</ul>
<h3><?= Yii::t('gtuservice', 'Total: $') ?><span id="total"><?= $cost ?></span></h3>
<input type="hidden" id="time" value="<?= $time; ?>" />
<button class="btn btn-blue btn-confirm"><?= Yii::t('gtuservice', 'Buy') ?></button>
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
