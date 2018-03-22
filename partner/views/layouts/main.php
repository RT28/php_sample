<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use partner\assets\AppAsset;
use common\widgets\Alert;
use common\components\ConnectionSettings;
use frontend\assets\MomentAsset;
use kartik\sidenav\SideNav;
use yii\helpers\FileHelper;



AppAsset::register($this);
MomentAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?></title>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300">
<link href="font/main/stylesheet.css" rel="stylesheet">
<script src="libs/js-cookie/js.cookie.js"></script>
<?php $this->head() ?>

</head>

<body class="dash-body menu-active">
<?php $this->beginBody() ?>

<?php include 'header.php';?>

<?= Breadcrumbs::widget([
'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<div class="container">

<div class="row">

<!-- Tab panes -->
<div class="tab-content">


	<?= Alert::widget() ?>
<?= $content ?>



</div>
</div>
</div>


<?php $this->endBody() ?>

<script src="libs/jquery/jquery-ui.js"></script>
<script src="libs/bootstrap-3.3.5/js/bootstrap.min.js"></script> 
<script src="libs/wow-js/wow.min.js"></script> 
<script src="js/main.js"></script>

  
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

</html>
<?php $this->endPage() ?>
