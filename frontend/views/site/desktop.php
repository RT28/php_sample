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
                <h1>About Us</h1>
            </div>
            <p class="about-main-info">Understanding how overwhelming the process of applying to 
the right university can be, our goal is simple yet comprehensive: we provide a platform that connects students with universities, empowering the students to make the right choice with minimum effort, while providing universities with constant updates on students needs and latest trends.</p>
<p>We achieve this purpose in two ways:</p>
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
                <h1>Our</br> Journey</h1>
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
                <h1>Vision </h1>
              </div>
              <p>Empowering students to make the best choices regarding their higher education and connecting these students with institutions across the globe through our online platform.</p>
              </div>
              <div class="col-sm-6">
              <div class="green-title">
                <h1>Mission</h1>
              </div>
              <p>We aim to be a one stop solution provider for the needs of students seeking higher education and to deliver a high quality technology driven platform for their journey towards that. We also aim to provide educational institutions access to students around the world and with analytics on latest trends and student needs.</p>
              </div>
              </div>
              <div class="group-title-index">
                <h1>Why</br>GoToUniversity?</h1>
              </div>
              
              <div class="row">
                <div class="col-sm-6">
                <ul class="content-ul">
                  <li>A comprehensive search engine with the most updated information on courses and universities, allowing you to find information about schools across the world on a single platform.</li>

<li>Quick comparison and evaluation of different programs in terms of fees, course structure, admission criteria, location and career options.</li>

<li>Free admission counseling and guidance/supervision for the successful completion of the entire application process for GTU partner universities.</li>

<li>Top career and admission consultants from around the world on one portal, so that you can choose the one who best matches your needs.</li>

<li>Regular newsletters to keep you updated with university deadlines, latest news on education, universities and prevailing trends.</li>


        </ul>
                </div>
                <div class="col-sm-6">
                <ul class="content-ul">
                  
<li>Access to the student dashboard, where you can shortlist universities/programs, complete online applications, upload the necessary documents, as well as communicate with the respective consultants through video and text chat.</li>
                    
<li>You are assigned a consultant and given access to a user-friendly system that provides you with complete clarity on the tasks that need to be completed, as well as receive alerts and reminders from your consultant to ensure the entire process is smooth and stress-free.</li>

<li>Access to free advice from our consultants regarding availability of scholarships and financial aid.</li>

<li>Communicate directly with the university representatives through our portal.</li>

<li>Access to university and other expert speaker webinars through our portal which will help you make a right decision about your higher education choices.</li>
        </ul>
                </div>
              </div>
              <div class="text-center about-top">
                <a href="#top"> <img src="/images/scroll-to-top.png"/> </br>Back To Top</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->registerJsFile('../frontend/web/js/chatnotification.js'); ?>
<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
<?php $this->registerJsFile('../frontend/web/js/easyNotify.js'); ?>

<script>
/*var myFunction = function() {
  alert('Click function');
};
var myImg = "http://gotouniversity.com/images/logo.png";
window.setInterval(function(){


  var options = {
    title: 'New Message',
    options: {
      body: 'Message from Roshan Roy',
      icon: myImg,
      lang: 'en-US',
      onClick: myFunction
    }
  };
  console.log(options);
  $("#easyNotify").easyNotify(options);
}, 15000);*/
</script>
