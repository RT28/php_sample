<?php
use yii\helpers\Html;
  use yii\helpers\FileHelper;
  use common\models\Consultant;
  use common\components\Roles;
?>
<header>
  <div class="header-main homepage-01">
    <div class="container">
      <div class="header-main-wrapper">
        <div class="navbar-heade">
          <div class="logo pull-left"><a href="/site" class="header-logo"><img src="images/logo.png" alt=""/></a></div>
          <button type="button" data-toggle="collapse" data-target=".navigation" class="navbar-toggle edugate-navbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <nav class="navigation collapse navbar-collapse pull-right">
          <ul class="nav-links nav navbar-nav">
            <li><a href="/site" class="main-menu">Home</a></li>
            <li><a href="/about-us" class="main-menu">About Us</a></li>
            <!-- <li><a href="/gotouniversity/frontend/web/index.php?r=site/index#services" class="main-menu">Services</a></li>
            <li><a href="/gotouniversity/frontend/web/index.php?r=university/index" class="main-menu">University Info</a></li> -->
            <li><a href="/packages" class="main-menu">Packages</a></li>
            <li><a href="/consultants" class="main-menu">Consultant</a></li>
            <!-- <li><a href="/gotouniversity/frontend/web/index.php?r=site/index#contact" class="main-menu">Contact Us</a></li> -->
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
                  $user = Consultant::find()->where(['=', 'consultant_id', $model->id])->one();
                  if (!empty($user)) {
                    $name = $user->first_name. ' '.$user->last_name;
                  } else {
                    $name = Yii::$app->user->identity->email; 
                  }
                  
                  $backgroundImage = './noprofile.gif';
                  
				  
                     if (is_dir('./uploads/consultant/'. $model->id . '/profile_photo')) {
                    $backgroundImage = "./uploads/consultant/".$model->id."/profile_photo/consultant_image_228X228";
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

                  /*$backgroundImage = './noprofile.gif';
                  if (is_dir('./uploads/'. $id . '/profile_photo')) {
                    $backgroundImage = "./uploads/".$id."/profile_photo/logo_170X115";
                    if(glob($backgroundImage.'.jpg')){
                      $backgroundImage = $backgroundImage.'.jpg';
                    } else if(glob($backgroundImage.'.png')){
                      $backgroundImage = $backgroundImage.'.png';
                    } else if(glob($backgroundImage.'.gif')){
                      $backgroundImage = $backgroundImage.'.gif';
                    }
                  }*/
                ?>
                <li class="button-login">
                  <div class="dropdown">
                    <button style="background-image: url(<?= $backgroundImage; ?>);"class="btn btn-default btn-login dropdown-toggle student-icon" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					
                        <li><a href="?r=consultant/students/index">My Students</a></li>
						<li><a href="?r=consultant/tasks/index">Tasks</a></li>
                        <?php if(Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT): ?>
                          <li><a href="?r=consultant/associates/index">Associates</a></li>
                        <?php endif;?>
                        <li><a href="?r=consultant/university-applications/index">Student Applications</a></li>
                        <li><a href="?r=consultant/consultant/index">My Profile</a></li>
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
    <style type="text/css">
            .box{
                float:right;
                overflow: hidden;
                background: #f0e68c;
            }
            /* Add padding and border to inner content
            for better animation effect */
            .box-inner{
                width: 370px;
                padding: 10px;
                border: 1px solid #a29415;
            }
        </style>
</header>