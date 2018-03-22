<?php
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;

  /* @var $this yii\web\View */
  $this->title = 'About';
  $this->context->layout = 'index';
  $this->registerJsFile('@web/js/site.js');
?>
<script>
	$('body').addClass('about-us-page');
</script>
<div id="wrapper-content" class="about-page"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content"><!-- SLIDER BANNER-->
      <div class="about-img-block">
      	<div class="container">
            <div class="group-title-index">
                <h1><?= Yii::t('gtuabout', 'About Us') ?></h1>
            </div>
            <p class="about-main-info"><?= Yii::t('gtuabout', 'Understanding how overwhelming the process of applying to 
the right university can be, our goal is simple yet comprehensive: we provide a platform that connects students with universities, empowering the students to make the right choice with minimum effort, while providing universities with constant updates on students needs and latest trends.') ?></p>
<p><?= Yii::t('gtuabout', 'We achieve this purpose in two ways:') ?></p>
        </div>
      </div>
        <div class="section-padding">
          <div class="container text_justify">
            <div class="row mbot-30"> 
              <!--<p> Understanding how overwhelming the process of applying to the right university can be, our goal is simple yet comprehensive: we provide a platform that connects students with universities, empowering the students to make the right choice with minimum effort, while providing universities with constant updates on students’ needs and latest trends. We achieve this purpose in two ways: </p>-->
            <div class="col-sm-6"> 
              <p class="about-step stap-1"> on one hand we engage with universities, providing them with a comprehensive platform to showcase their courses and programs to students across the globe </p>
              </div>
              <div class="col-sm-6">
              <p class="about-step stap-2"> on the other hand we engage with students, offering guidance right from shortlisting courses that best match their profile to guiding them through the application process and providing support with every aspect required until they find themselves on campus (including career coaching, essays and interview guidance, preparation for tests, visa and financial information, and much more). </p>
              </div>
              </div>
            <div class="row mbot-30"> 
              <div class="col-sm-6">
              <p> Our dedicated team of counselors and consultants strive to make student’s journey for international degree hassle-free and uncomplicated with just a few clicks. </p>
              </div>
              <div class="col-sm-6">
              <p>We aim to make the students’ journey towards an international degree hassle-free and enjoyable, as we understand it to be a stepping stone in the way of valuable careers for the change makers of tomorrow.</p>
              </div>
              </div>
              <div class="group-title-index">
                <h1><?= Yii::t('gtuabout', 'Our') ?></br> <?= Yii::t('gtuabout', 'Journey') ?></h1>
              </div>
              
            <div class="row mbot-30"> 
              <div class="col-sm-6">
              <p>We started our journey in 2011 as <strong>Brighter Prep</strong>, and later we established <strong>Brighter Admissions</strong> with a desire to help teenagers and young professionals from all backgrounds realize their dream of studying in top universities around the world. We soon realised that despite unprecedented access to information thanks to the Internet, students were still grossly misinformed with regard to their options and found it</p>
              </div>
              <div class="col-sm-6">
              	<p>difficult to gather necessary and relevant information online. GoToUniversity aims to not only bridge this information gap, but also give students the tools they need to become guides for themselves and others. Our vision is to empower the youth to grow through education, and <strong>GoToUniversity</strong> is a step in that direction.</p>

              </div>
            </div>
            <div class="row mbot-30"> 
              <div class="col-sm-6">
              <div class="green-title">
                <h1><?= Yii::t('gtuabout', 'Vision') ?> </h1>
              </div>
              <p>Empowering students to make the best choices regarding their higher education and connecting these students with institutions across the globe through our online platform.</p>
              </div>
              <div class="col-sm-6">
              <div class="green-title">
                <h1><?= Yii::t('gtuabout', 'Mission') ?></h1>
              </div>
              <p>We aim to be a one stop solution provider for the needs of students seeking higher education and to deliver a high quality technology driven platform for their journey towards that. We also aim to provide educational institutions access to students around the world and with analytics on latest trends and student needs.</p>
              </div>
              </div>
              <div class="group-title-index">
                <h1><?= Yii::t('gtuabout', 'Why') ?></br><?= Yii::t('gtuabout', 'GoToUniversity?') ?></h1>
              </div>
              
              <div class="row">
              	<div class="col-sm-6">
                <ul class="content-ul">
                	<li><?= Yii::t('gtuabout', 'A comprehensive search engine with the most updated information on courses and universities, allowing you to find information about schools across the world on a single platform.') ?></li>

<li><?= Yii::t('gtuabout', 'Quick comparison and evaluation of different programs in terms of fees, course structure, admission criteria, location and career options.') ?></li>

<li><?= Yii::t('gtuabout', 'Free admission counseling and guidance/supervision for the successful completion of the entire application process for GTU partner universities') ?>.</li>

<li><?= Yii::t('gtuabout', 'Top career and admission consultants from around the world on one portal, so that you can choose the one who best matches your needs.') ?></li>

<li><?= Yii::t('gtuabout', 'Regular newsletters to keep you updated with university deadlines, latest news on education, universities and prevailing trends.') ?></li>


				</ul>
                </div>
              	<div class="col-sm-6">
                <ul class="content-ul">
                	
<li><?= Yii::t('gtuabout', 'Access to the student dashboard, where you can shortlist universities/programs, complete online applications, upload the necessary documents, as well as communicate with the respective consultants through video and text chat.') ?></li>
                    
<li><?= Yii::t('gtuabout', 'You are assigned a consultant and given access to a user-friendly system that provides you with complete clarity on the tasks that need to be completed, as well as receive alerts and reminders from your consultant to ensure the entire process is smooth and stress-free.') ?></li>

<li><?= Yii::t('gtuabout', 'Access to free advice from our consultants regarding availability of scholarships and financial aid.') ?></li>

<li><?= Yii::t('gtuabout', 'Communicate directly with the university representatives through our portal.') ?></li>

<li><?= Yii::t('gtuabout', 'Access to university and other expert speaker webinars through our portal which will help you make a right decision about your higher education choices.') ?></li>
				</ul>
                </div>
              </div>
              <div class="text-center about-top">
              	<a id="back_btn" > <img src="/images/scroll-to-top.png"/> </br><?= Yii::t('gtuabout', 'Back To Top') ?></a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/easyNotify.js'); ?>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<script type="text/javascript">
  $('#back_btn').click(function (e) { 
      $('html, body').animate({
        scrollTop: $('#page-wrapper').offset().top - 20
    }, 'slow');
});
</script>

