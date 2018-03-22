<?php
use yii\helpers\Html;
  use yii\helpers\FileHelper;
  use common\models\PartnerEmployee;
  use common\components\Roles;
?>
<header>
  <div class="header-main homepage-01">
    <div class="container-fluid">
      <div class="header-main-wrapper">
        <div class="navbar-heade">
          <div class="logo pull-left"><a href="?r=site/index" class="header-logo"><img src="images/logo.png" alt=""/></a></div>
          <button type="button" data-toggle="collapse" data-target=".navigation" class="navbar-toggle edugate-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <nav class="navigation collapse navbar-collapse pull-right">
          <ul class="nav-links nav navbar-nav">
            <li><a href="/gotouniversity/frontend/web/index.php?r=site/index" class="main-menu">Home</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=site/about" class="main-menu">About Us</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=site/index#services" class="main-menu">Services</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=university/index" class="main-menu">University Info</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=packages/index" class="main-menu">Packages</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=agency/index" class="main-menu">Consultant</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=site/index#contact" class="main-menu">Contact Us</a></li>
            <?php if(Yii::$app->user->isGuest): ?>
              <li><a href="?r=site/signup" class="main-menu">Sign Up</a></li>
              <li class="button-login">
                <button type="button" class="btn btn-primary btn-blue btn-login" data-toggle="modal" data-target="#login-modal" value="?r=site/login">Login</button>
              </li>
            <?php endif; ?>
            <?php if(!Yii::$app->user->isGuest): ?>
                <?php
                  $name = '';
                  $model = Yii::$app->user->identity;
                  $user = PartnerEmployee::find()->where(['=', 'partner_login_id', $model->id])->one();
                  if (!empty($user)) {
                    $name = $user->first_name.' '.$user->last_name;
                  } else {
                    $name = Yii::$app->user->identity->email; 
                  }
                  
                  $backgroundImage = './noprofile.gif';
				
				          if (is_dir('./uploads/employee/'. $model->id . '/profile_photo')) {
                    $backgroundImage = "./uploads/employee/".$model->id."/profile_photo/consultant_image_228X228";
                    if(glob($backgroundImage.'.jpg')){
                      $backgroundImage = $backgroundImage.'.jpg';
                    } else if(glob($backgroundImage.'.png')){
                      $backgroundImage = $backgroundImage.'.png';
                    } else if(glob($backgroundImage.'.gif')){
                      $backgroundImage = $backgroundImage.'.gif';
                    } else if(glob($backgroundImage.'.jpeg')){
                      $backgroundImage = $backgroundImage.'.jpeg';
                    } else if(glob($backgroundImage.'.JPG')){
                      $backgroundImage = $backgroundImage.'.JPG';
                    } else if(glob($backgroundImage.'.PNG')){
                      $backgroundImage = $backgroundImage.'.PNG';
                    } else if(glob($backgroundImage.'.GIF')){
                      $backgroundImage = $backgroundImage.'.GIF';
                    } else if(glob($backgroundImage.'.JPEG')){
                      $backgroundImage = $backgroundImage.'.JPEG';
                    }
                  } else {

                  }
				  
                ?>
                <li class="button-login">
                  <div class="dropdown">
                    <button style="background-image: url(<?= $backgroundImage; ?>);"class="btn btn-default btn-login dropdown-toggle student-icon" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					 
                        <li><a href="?r=employee/employee/index">My Profile</a></li>
                       <li><?php 
	echo Html::a('Logout', ['/site/logout'] , ['class' => '','title' => '']); ?> </li>
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