<?php
use yii\helpers\FileHelper;   
use yii\helpers\Html;
use common\components\Roles;
use common\components\ConnectionSettings;
$Frontendpath= ConnectionSettings::BASE_URL;
$this->registerCssFile('../../frontend/web/css/style.css');

?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="header-main homepage-01">
<div class="container">
<div class="navbar-header">
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<div class="gtu-logo">
<a href="<?php echo $Frontendpath;?>"><img src="images/logo.png"/></a>
</div> 
</div>
<div class="user-info pull-right">

<?php
$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
?>
<nav class="navigation collapse navbar-collapse pull-left">
<ul class="nav-links nav navbar-nav">
<li><a href="<?php echo $Frontendpath;?>" class="main-menu <?= ($activeTab == 'home') ? 'active' : '';?>">Home</a></li> 

<?php  if(!Yii::$app->user->isGuest){ 
?>
<?php  
if(Yii::$app->user->identity->role_id ==Roles::ROLE_UNIVERSITY){ ?>

<li><a href="university/dashboard" class="main-menu">Partner Dashboard</a></li>
<?php } ?>
<li><a href="site/logout" class="main-menu">Logout</a></li>
<?php }
if(Yii::$app->user->isGuest){ ?>
<li><a href="site/general" class="main-menu <?= ($activeTab == 'agency') ? 'active' : '';?>">General Enquiry</a></li>  
<li><a href="university/university-enquiry/create" class="main-menu <?= ($activeTab == 'consultant') ? 'active' : '';?>">University </a></li> 
<li><a href="university/university-enquiry/create" class="main-menu <?= ($activeTab == 'agency') ? 'active' : '';?>">Agency </a></li> 
<li><a href="consultant/consultant/create" class="main-menu<?= ($activeTab == 'signup') ? 'active' : '';?>">Consultant </a></li> 
<li><a href="site/login" class="main-menu<?= ($activeTab == 'login') ? 'active' : '';?>">Login</a></li>
<?php }?>

</ul>
</nav> 

</div>
</div>
</div>
</nav>
