<?php
use yii\helpers\FileHelper;
use common\components\Roles;
use common\models\StudentPackageDetails;
use yii\helpers\Url;
use frontend\models\UserLogin;


  $session = Yii::$app->session;
  if(!isset($session['passcode'])||$session['passcode']!='univ@admin'){
    if(Yii::$app->controller->action->id!='accesstoken'){
      return Yii::$app->response->redirect(Url::to(['site/accesstoken']));
    }
    //return $this->redirect(['site/accesstoken']);
  }
$name = '';
 if(isset(Yii::$app->user->identity->id)){
	$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);
	$name = $userLogin->student->student->first_name;
 }


?>
<header>
<!-- <link rel="stylesheet" href="http://localhost/gotouniversity/frontend/web/bootstrap/css/bootstrap.min.css">
 --><link rel="stylesheet" href="http://localhost/test/css/bootstrap-dropdownhover.css">
<style>
.dropdown-inline {
  display: inline-block;
  position: relative;
}
</style>
</head>


<script src="http://localhost/test/js/bootstrap-dropdownhover.js"></script>
  <div class="header-main homepage-01">
    <div class="container-fluid">
      <div class="header-main-wrapper">
        <div class="navbar-heade">
          <div class="logo pull-left"><a href="?r=site/index" class="header-logo"><img src="/images/logo.png" alt=""/></a></div>
          <button type="button" data-toggle="collapse" data-target=".navigation" class="navbar-toggle edugate-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
	<?php
	$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
	?>
        <nav class="navigation collapse navbar-collapse pull-right">
          <ul class="nav-links nav navbar-nav">
          	<li class="dropdown">
    <button class="btn btn-default edu-tab main-menu dropdown-toggle" type="button" data-toggle="dropdown">Education
    <i class="fa fa-angle-down" aria-hidden="true"></i></button>
    <ul class="dropdown-menu">
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">Webinars <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a tabindex="-1" href="#">Upcoming Live Webinars</a></li>
          <li><a tabindex="-1" href="#">On Demand Webinars</a></li>
          <li class="dropdown-submenu">
            <a class="test" href="#">Online Education <span class="caret"></span></a>
            <ul class="dropdown-menu">
                      <li><a href="#">Live Classes</a></li>
                      <li><a href="#">Recorded Classes</a></li>
                      <li><a href="#">Free Education Videos</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a tabindex="-1" href="#">Videos</a></li>
      <li><a tabindex="-1" href="#">Blogs</a></li>
      <li><a tabindex="-1" href="#">News and Alerts</a></li>
    </ul>
  </li>
            <li><a href="?r=site/index" class="main-menu <?= ($activeTab == 'home') ? 'active' : '';?>">Home</a></li>
            <li><a href="?r=site/about" class="main-menu <?= ($activeTab == 'about') ? 'active' : '';?>">About Us</a></li>
           <!-- <li><a href="?r=site/index#services" class="main-menu <?= ($activeTab == 'services') ? 'active' : '';?>">Services</a></li>-->
            <li><a href="?r=university/index" class="main-menu <?= ($activeTab == 'university') ? 'active' : '';?>">Universities</a></li>
			<li><a href="?r=course/index" class="main-menu <?= ($activeTab == 'programs') ? 'active' : '';?>">Programs</a></li>
            <li><a href="?r=packages/index" class="main-menu <?= ($activeTab == 'package') ? 'active' : '';?>">Packages</a></li>
            <li><a href="?r=consultant/index" class="main-menu <?= ($activeTab == 'consultant') ? 'active' : '';?>">Consultant</a></li>
            <li><a href="?r=site/contact" class="main-menu <?= ($activeTab == 'contact') ? 'active' : '';?>">Contact Us</a></li>
            <?php if(Yii::$app->user->isGuest): ?>
              <li><a href="?r=site/signup" class="main-menu <?= ($activeTab == 'signup') ? 'active' : '';?>">Sign Up</a></li>
              <li class="button-login">
                <button type="button" class="btn btn-primary btn-blue btn-login" data-toggle="modal" data-target="#login-modal" value="?r=site/login">Login</button>
              </li>
            <?php endif; ?>
            <?php if(!Yii::$app->user->isGuest): ?>
                <?php
                  $name = '';
                  $id = Yii::$app->user->identity->id;
                  $user = Yii::$app->user->identity->student;
                  if (!empty($user)) {
                    $name = $user->first_name ;
                  } else {
                    $name = Yii::$app->user->identity->email;
                  }
                  $backgroundImage = './noprofile.gif';
                  if (is_dir('./uploads/'. $id . '/profile_photo')) {
                    $backgroundImage = "./uploads/".$id."/profile_photo/logo_170X115";
                    if(glob($backgroundImage.'.jpg')){
                      $backgroundImage = $backgroundImage.'.jpg';
                    } else if(glob($backgroundImage.'.png')){
                      $backgroundImage = $backgroundImage.'.png';
                    } else if(glob($backgroundImage.'.gif')){
                      $backgroundImage = $backgroundImage.'.gif';
                    }
                  }
                  /*$backgroundImage = './noprofile.gif';
                  if (is_dir('./uploads/'. $id . '/profile_photo')) {
                      $path = FileHelper::findFiles('./uploads/'. $id . '/profile_photo', [
                          'caseSensitive' => true,
                          'recursive' => false,
                          'only' => ['profile_photo.*']
                      ]);

                      if (count($path) > 0) {
                          $backgroundImage = $path[0];
                          $backgroundImage = str_replace("\\","/",$backgroundImage);
                      }
                  }*/
                ?>


    <input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
    <input type="hidden" id="from_role" value="<?= Roles::ROLE_STUDENT; ?>">
                <li class="button-login" style="margin-left: 0;">
                  <div class="dropdown">
                    <button class="btn btn-default btn-login dropdown-toggle student-icon" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img id="my_propic" src="<?= $backgroundImage; ?>"/>
                    <span><?php if(!empty($name)){echo $name;}?> 
						<i class="fa fa-angle-down" aria-hidden="true"></i></span>
                    </button>
		                
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		<?php if($userLogin->status==4){ ?>
		<li><a href="?r=student/dashboard">Dashboard</a></li>		 
		<li><a href="?r=student/student-shortlisted-courses">Shortlisted Courses</a></li>
		<li><a href="?r=favourite-universities/index">Shortlisted Universities</a></li>		 
		<li><a href="?r=student/view">My Profile</a></li>
		<li><a href="?r=tasks/index">My Tasks</a></li>
		<li><a href="?r=application-form/index">Application Form</a></li>
		<li><a href="?r=university-applications/index">Admission & Applications</a></li>
		<li><a href="?r=student/packages">Packages</a></li>
		<?php } ?>
			<?php if($userLogin->status!=4){ ?>
			<li><a href="?r=student/student-not-subscribed">Shortlisted Courses</a></li>
		<li><a href="?r=favourite-universities/student-not-subscribed">Shortlisted Universities</a></li>		 
		
				<?php } ?>
         <li><a href="?r=site/logout">Logout</a></li>
                    </ul>
                  </div>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>
</header>
