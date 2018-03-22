<?php
$this->registerJsFile('@web/js/site.js');
use backend\models\SiteConfig;
use yii\helpers\Url;
use frontend\models\UserLogin;
if (!Yii::$app->user->isGuest) {
$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);
}
?>
<!-- FOOTER-->
<!-- BUTTON BACK TO TOP-->
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
<footer>
  <div class="footer-main">
    <div class="container">
      <div class="footer-main-wrapper">
        <div class="row">
            <div class="col-md-3 col-sm-3 sd380">
              <div class="edugate-widget widget">
                <img src="/images/logo.png" alt="" class="footer-logo"/>
                <div class="content-widget">
                <div class="useful-link-list">
<ul class="list-unstyled">
<li class="f-address"><i class="fa fa-map-marker" aria-hidden="true"></i> Our Address:<br><?php echo SiteConfig::getAddress();?></li>
<li><a href="tel:<?php echo  SiteConfig::getPhoneNumber(); ?> "><i class="fa fa-phone" aria-hidden="true"></i>&nbsp <?php echo  SiteConfig::getPhoneNumber(); ?> </a></li>
<li><a href="mailto:info@gotouniversity.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp info@gotouniversity.com</a></li>
</ul>
                        </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 sd380">
              <div class="useful-link-widget widget"> 
                <div class="content-widget">
                  <div class="useful-link-list">
                        <ul class="list-unstyled">
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/index#services">Our Services</a></li>
                          <!--<li><i class="fa fa-angle-right"></i><a href="?r=counselor">Our Counselors </a></li> -->
                          <li><i class="fa fa-angle-right"></i><a href="?r=packages/index">Our Packages</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=university/index">Universities </a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=course/index">Programs</a></li>
						  <li><i class="fa fa-angle-right"></i><a href="?r=site/faq">FAQs</a></li>
                       
<li><i class="fa fa-angle-right"></i><a href="?r=site/contact"> Contact Us</a></li>					   </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 sd380">
              <div class="useful-link-widget widget">
              <div class="title-widget">Connect with us</div>
              <div class="socials"><a href="#" class="facebook"><i class="fa fa-facebook"></i></a><a href="#" class="google"><i class="fa fa-google-plus"></i></a><a href="#" class="twitter"><i class="fa fa-twitter"></i></a><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></div>
              </div>
              <div class="partner-with-us">
                	<img src="/images/handshake.png" alt=""/>
                    <div class="title"><a href="<?=Url::to('partner/web/index.php?r=university/university-enquiry/create', true)?>"> Partner with us</a></div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 sd380">
              <div class="widget">
                <div class="title-widget">Leave us a message</div>
                <div class="content-wiget">
                  <form id="frm-contact" name="frm-contact">
                      <div class="form-group">
                         <input type="text" class="form-control" id="txt-first-name" placeholder="First Name" aria-describedby="first-name-help">
                         <span id="first-name-help" class="help-block"></span>
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" id="txt-contact-email" placeholder="Email" aria-describedby="contact-email-help">
                          <span id="contact-email-help" class="help-block"></span>
						  </div>
                      <div class="form-group">
                         <input type="text" class="form-control" id="txt-contact-phone" placeholder="Phone" aria-describedby="contact-phone-help">
                          <span id="contact-phone-help" class="help-block"></span>
						  </div>
                      <div class="form-group">
                          <textarea class="form-control" rows="3" placeholder="Your Message" id="txt-contact-message" aria-describedby="contact-message-help"></textarea>
                          <span id="contact-message-help" class="help-block"></span>
						  </div>
                      <button type="button" class="btn btn-blue pull-right" id="btn-send-contact-query">Submit</button>
                    </form>
                           <p id="contact-query-status"></p>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="hyperlink">
        <div class="pull-left hyper-left">
          Copyright © <?= date('Y'); ?> <a href="http://gotouniversity.com">Gotouniversity</a>
        </div>
        <div class="pull-right hyper-right">
        	<div class="bottom-footer-links">
            	<ul class="list-unstyled">
                	<li><a href="javascript:void(0);">Terms of Service</a></li>
                	<li><a href="?r=site/privacy-policy">Privacy Statement</a></li>
                </ul>
            </div>

        </div>
      </div>
    </div>
  </div>
  <?php  if (!Yii::$app->user->isGuest) {
	  if($userLogin->status==4){  
	  ?>
	<div id="chaticon" class="chat-block">
	<div class="chat-tab">
	<i class="fa fa-commenting" aria-hidden="true"></i>
	</div>
	</div>
  <?php } }?>
</footer>

<script>
	$(document).ready(function(){
		 $('#chaticon').click(function(e){ 
			 $('#chaticon').hide();
			 $('#chatpopup').show();
		 });
	});	
 
  $(document).ready(function(){
    $('#btn-subscribe').click(function(e){
      var email = $('#txt-email').val();
      var regex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
      if(email === '' || email === null || email === undefined) {
        $('#subscription-status').html('Email is required.');
        return false;
      }
      if (!regex.test(email.toLowerCase())) {
        $('#subscription-status').html('Invalid email');
        return false;
      }
      else {
        $('#subscription-status').html('');
      }
      $.ajax({
        url: '?r=site/subscribe',
        method: 'POST',
        data: {
          email: email,
          source: window.location.pathname
        },
        success: function(response) {
          response = JSON.parse(response);
          if(response.status == "success") {
            $('#subscription-status').html('Thanks! You\'re subscribed to our news letters and updates.');
          } else {
            if(response.error && response.error[0].search('Email') > -1) {
              $('#subscription-status').html(email + ' is already subscribed');
            } else {
              console.error(error);
              $('#subscription-status').html('We had a problem adding you to our mailing list. Please try again');
            }
          }
        },
        error: function(error) {
          console.error(error);
          $('#subscription-status').html('We had a problem adding you to our mailing list. Please try again');
        }
      });
      e.preventDefault();
      return false;
    });
  });
</script>
<script type="text/javascript">
    	$('#dashboard-selector').on('change', function (e) {
			$('#dashboard-ul li a').eq($(this).val()).tab('show');
		});
    </script>
<script type="text/javascript">
		//Preload images first
$.fn.preload = function() {
    this.each(function(){
        $('<img/>')[0].src = this;
    });
}
var images = Array("images/background-slider-1.jpg",
                   "images/background-slider-2.jpg");
$([images[0],images[1],images[2],images[3]]).preload();
// Usage:
var currimg = 0;
$(document).ready(function(){
    function loadimg(){
       $('#banner').animate({ opacity: 1 }, 500,function(){
            //finished animating, minifade out and fade new back in
            $('#banner').animate({ opacity: 0.7 }, 100,function(){
                currimg++;
                if(currimg > images.length-1){
                    currimg=0;
                }
                var newimage = images[currimg];
                //swap out bg src
                $('#banner').css("background-image", "url("+newimage+")");
                //animate fully back in
                $('#banner').animate({ opacity: 1 }, 400,function(){
                    //set timer for next
                    setTimeout(loadimg,5000);
                });
            });
        });
     }
     setTimeout(loadimg,5000);
});
</script>
<script>
    $(document).ready(function () {
        // you want to enable the pointer events only on click;
        $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none on doc ready
        $('#canvas1').on('click', function () {
            $('#map_canvas1').removeClass('scrolloff'); // set the pointer events true on click
        });
        // you want to disable pointer events when the mouse leave the canvas area;
        $("#map_canvas1").mouseleave(function () {
            $('#map_canvas1').addClass('scrolloff'); // set the pointer events to none when mouse leaves the map area
        });
    });
</script>
