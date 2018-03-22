<?php
use yii\helpers\FileHelper;
use common\components\Roles;
use common\models\StudentPackageDetails;
use yii\helpers\Url;
use frontend\models\UserLogin;

  if(isset($_COOKIE['lang']))
  {
          \Yii::$app->language =$_COOKIE['lang'];
  }
  else
  {
          \Yii::$app->language ="en";
  }

  $session = Yii::$app->session;
  if(!isset($session['passcode'])||$session['passcode']!='univ@admin'){
    /*if(Yii::$app->controller->action->id!='accesstoken'){
      return Yii::$app->response->redirect(Url::to(['site/accesstoken']));
    }*/
    //return $this->redirect(['site/accesstoken']);
  }
$name = '';
 if(isset(Yii::$app->user->identity->id)){
	$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);
	$name = $userLogin->student->student->first_name;
 }


?>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<header>  
</head>

 
  <div class="header-main homepage-01">
    <div class="container">
      <div class="header-main-wrapper">
        <div class="navbar-heade">
          <div class="logo pull-left"><a href="/" class="header-logo"><img src="/images/logo.png" alt=""/></a></div>
          <div class="lang-dropdown">
          	<form>
            	<!--<select class="">
                	<option value="">EN</option>
                	<option value="1">FR</option>
                </select>-->
                <div class="dropdown">
                  <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= \Yii::$app->language ?>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dLabel">
                    <li><a href="https://gotouniversity.com/site/language?id=en" class="en">English</a></li>
                    <li><a href="https://gotouniversity.com/site/language?id=fa" class="fr">Farsi</a></li>
                  </ul>
                </div>
            </form>
            <!--<script>
            	$('.en').on('click',function(){
					$('#dLabel').addClass('eng');
					$('#dLabel').removeClass('fra');
				});
            	$('.fr').on('click',function(){
					$('#dLabel').addClass('fra');
					$('#dLabel').removeClass('eng');
				});
            </script>
-->          </div>
          
          <button type="button" data-toggle="collapse" data-target=".navigation" class="navbar-toggle edugate-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
	<?php
	$activeTab = isset(Yii::$app->view->params['activeTab']) ? Yii::$app->view->params['activeTab'] : '';
	?>
        <nav class="navigation collapse navbar-collapse pull-right">
          <ul class="nav-links nav navbar-nav">
          	<!-- <li class="dropdown">
    <button class="btn btn-default edu-tab main-menu dropdown-toggle" type="button" data-toggle="dropdown">Education
    <i class="fa fa-angle-down" aria-hidden="true"></i></button>
    <ul class="dropdown-menu">
      <li class="dropdown-submenu">
        <a class="test" tabindex="-1" href="#">Webinars <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a tabindex="-1" href="?r=webinar/index">Upcoming Live Webinars</a></li>
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
  </li> -->   <!--<li><a href="?r=site/index" class="main-menu <?= ($activeTab == 'home') ? 'active' : '';?>">Home</a></li>-->
            <li><a href="/about-us" class="main-menu <?= ($activeTab == 'about') ? 'active' : '';?>"><?= Yii::t('gtuheader', 'About Us') ?></a></li>
           <!-- <li><a href="?r=site/index#services" class="main-menu <?= ($activeTab == 'services') ? 'active' : '';?>">Services</a></li>-->
            <li><a href="/universities" class="main-menu <?= ($activeTab == 'university') ? 'active' : '';?>"><?= Yii::t('gtuheader', 'Universities') ?></a></li>            
            <li class="dropdown">
		<button class="btn btn-default edu-tab main-menu dropdown-toggle" type="button" data-toggle="dropdown"><?= Yii::t('gtuheader', 'Programs') ?>
		<i class="fa fa-angle-down" aria-hidden="true"></i></button>
		<ul class="dropdown-menu"> 
		<li><a tabindex="-1" href="/programs/bachelors"><?= Yii::t('gtuheader', 'Bachelors') ?></a></li>
		<li><a tabindex="-1" href="/programs/masters"><?= Yii::t('gtuheader', 'Masters') ?></a></li> 
		<li><a tabindex="-1" href="/programs/phd"><?= Yii::t('gtuheader', 'Phd') ?></a></li> 
		</ul>
		</li>
            
            <li><a href="/consultants" class="main-menu <?= ($activeTab == 'consultant') ? 'active' : '';?>"><?= Yii::t('gtuheader', 'Consultant') ?></a></li>
            <li><a href="/packages" class="main-menu <?= ($activeTab == 'package') ? 'active' : '';?>"><?= Yii::t('gtuheader', 'Packages') ?></a></li>
			
		<li class="dropdown">
		<button class="btn btn-default edu-tab main-menu dropdown-toggle" type="button" data-toggle="dropdown"><?= Yii::t('gtuheader', 'Sign Up') ?>
		<i class="fa fa-angle-down" aria-hidden="true"></i></button>
		<ul class="dropdown-menu"> 
		  <?php if(Yii::$app->user->isGuest): ?>
		<li><a tabindex="-1" href="/signup"><?= Yii::t('gtuheader', 'Students') ?></a></li>
		    <?php endif; ?>
		<li><a tabindex="-1" href="/partner-with-us"><?= Yii::t('gtuheader', 'Others') ?></a></li> 
		</ul>
		</li>
  
            <!--<li><a href="?r=site/contact" class="main-menu <?= ($activeTab == 'contact') ? 'active' : '';?>">Contact Us</a></li>-->
            <?php if(Yii::$app->user->isGuest): ?>
              <!--<li><a href="?r=site/signup" class="main-menu <?= ($activeTab == 'signup') ? 'active' : '';?>">Sign Up</a></li>-->
              <li class="button-login">
                <button type="button" class="btn btn-primary btn-blue btn-login" data-toggle="modal" data-target="#login-modal" value="/site/login">Login</button>
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
                <li class="button-login">
                  <div class="dropdown">
                    <button class="btn btn-default btn-login dropdown-toggle student-icon main-menu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img id="my_propic" src="/images/header-user-ic.png"/>
                    <?php if(!empty($name)){echo $name;}?> 
						<i class="fa fa-angle-down" aria-hidden="true"></i>
                    </button>
		                
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
		<?php if($userLogin->status==4){ ?>
		<li><a href="/student/dashboard"><?= Yii::t('gtuheader', 'Dashboard') ?></a></li>		 
		<li><a href="/student/student-shortlisted-courses"><?= Yii::t('gtuheader', 'Shortlisted Courses') ?></a></li>
		<li><a href="/favourite-universities/index"><?= Yii::t('gtuheader', 'Shortlisted Universities') ?></a></li>		 
		<li><a href="/student/view"><?= Yii::t('gtuheader', 'My Profile') ?></a></li>
		<li><a href="/tasks/index"><?= Yii::t('gtuheader', 'My Tasks') ?></a></li>
		<li><a href="/application-form/index"><?= Yii::t('gtuheader', 'Standard Tests') ?></a></li>
		<!-- <li><a href="/university-applications/index">Admission & Applications</a></li> -->
		<li><a href="/student/packages"><?= Yii::t('gtuheader', 'Packages') ?></a></li>
    <li><a href="/emailenquiry/index"><?= Yii::t('gtuheader', 'Email Enquiry') ?></a></li>
    <li><a href="/video/chat"><?= Yii::t('gtuheader', 'Live Chat') ?></a></li>
		<?php } ?>
			<?php if($userLogin->status!=4){ ?>
			<li><a href="/student/student-not-subscribed"><?= Yii::t('gtuheader', 'Shortlisted Courses') ?></a></li>
		<li><a href="/favourite-universities/student-not-subscribed"><?= Yii::t('gtuheader', 'Shortlisted Universities') ?></a></li>		 
		
				<?php } ?>
         <li><a href="/site/logout"><?= Yii::t('gtuheader', 'Logout') ?></a></li>
                    </ul>
                  </div>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
          
          <!--<div id="chat_pop" style="float: right;"></div>-->
          <!--<div id="video_call" style="float: right;"></div>-->
          <audio id="myAudio" loop>
            <source src="https://gotouniversity.com/media/ring.mp3" type="audio/mpeg" >
            Your browser does not support the audio element.
          </audio>

        </div>
      </div>
    </div>
</header>
