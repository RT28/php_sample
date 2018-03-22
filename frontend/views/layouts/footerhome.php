<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm; 
use common\models\Country; 

$this->registerJsFile('@web/js/site.js');
use backend\models\SiteConfig;
use yii\helpers\Url;
use frontend\models\UserLogin;
if (!Yii::$app->user->isGuest) {
$userLogin =UserLogin::findOne(Yii::$app->user->identity->id);
}

$codelist = Country::getAllCountries();
?>
<!-- FOOTER-->
<!-- BUTTON BACK TO TOP-->
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
<footer>
  <div class="footer-main">
    <div class="container">
              <div class="group-title-index">
            <h1><?= Yii::t('gtufooter', 'Let’s') ?> <br> <?= Yii::t('gtufooter', 'Connect.') ?></h1>
            <div class="social-media-links pull-right">
              <a href="https://www.facebook.com/go2university/" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a>
                <a href="https://plus.google.com/u/0/103041279877923883182" target="_blank" class="google"><i class="fa fa-google-plus"></i></a>
                <a href="https://twitter.com/GoToUniv" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a>
                <a href="https://www.linkedin.com/company/13360416/" target="_blank" class="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </div>
          </div>
      <div class="footer-main-wrapper">
        <div class="row">
            <div class="col-md-6 col-sm-6">
              <ul class="footer-menu">
                  <li><a href="/partner-with-us"><?= Yii::t('gtufooter', 'Partner With Us') ?></a></li>
                  <li><a href="/site/faq"><?= Yii::t('gtufooter', 'FAQs') ?></a></li>
                  <li><span><?= Yii::t('gtufooter', 'Reach Out') ?></span></li>
                </ul>
                <div class="footer-c-details">
                  <div class="c-link"><a href="tel:+97142428518"><img src="/images/call.svg"> +971 - 42428518</a></div>
                  <div class="c-link"><a href="mailto:info@gotouniversity.com"><img src="/images/mail.svg"> info@gotouniversity.com</a></div>
                </div>
                <div class="footer-logo">
                  <img src="/images/logo.svg"/>
                </div>
                
                <div class="hyperlink hidden-xs">
                  <div class="pull-left hyper-left">
                    <!--Copyright © <?= date('Y'); ?> <a href="http://gotouniversity.com">Gotouniversity</a>A Private Unit of GoTo Education Services-->
                    <div class="bottom-footer-links">
                        <ul class="list-unstyled">
                            <li><a target="_blank" href="/site/term"><?= Yii::t('gtufooter', 'Terms of Service') ?></a></li>
                            <li><a target="_blank" href="/site/privacy-policy"><?= Yii::t('gtufooter', 'Privacy Statement') ?></a></li>
                          </ul>
                      </div>
                    
                  </div>
                </div>
            </div>
            
            
            <div class="col-md-6 col-sm-6">
              <div class="contect-form-footer">
                <div class="content-wiget">
        
        <p id="contact-query-status" style="display: none;"></p> 
        
         <form id="frm-contact" name="frm-contact">
          
                      <div class="form-group">
                         <input type="text" class="form-control" id="txt-first-name" placeholder="First Name" aria-describedby="first-name-help" required>
                         <span id="first-name-help" class="help-block"></span>
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control" id="txt-contact-email" placeholder="Email" aria-describedby="contact-email-help" required>
                          <span id="contact-email-help" class="help-block"></span>
              </div>
 
                      <div class="form-group">
                     
        <div class="form-group contect-no-grp">
        <div class="col-md-6 col-sm-6 pad-0 pad-0-xs">
        <select id="contact-phone_code" name="code"  class="form-control"> 
        <option value="">Country Code</option>
        <?php foreach($codelist as $code) { ?>
        <option value="<?php echo $code->phone_code; ?>">
        <?php  echo $code->name.' (+'.$code->phone_code.')'; ?>
        </option>
        <?php  }?>

        </select>

        <span id="contact-phone_code-help" class="help-block"></span>
</div>
<div class="col-md-6 col-sm-6 pad-0-xs">
        <input type="text" class="form-control" id="txt-contact-phone" placeholder="Phone" aria-describedby="contact-phone-help">

        <span id="contact-phone-help" class="help-block"></span>
        </div>
                      <div class="form-group">
                          <textarea class="form-control" rows="5" placeholder="Your Message" id="txt-contact-message" aria-describedby="contact-message-help" required></textarea>
                          <span id="contact-message-help" class="help-block"></span>
              </div>
                      <button type="button" class="btn btn-blue" id="btn-send-contact-query"><?= Yii::t('gtufooter', 'Submit') ?> <i class="fa fa-caret-right" aria-hidden="true"></i></button>
                    
        </form>
                         
                </div>
              </div>
            </div>
        </div>
        
                <div class="hyperlink visible-xs">
                  <div class="pull-left hyper-left">
                    <!--Copyright © <?= date('Y'); ?> <a href="http://gotouniversity.com">Gotouniversity</a>A Private Unit of GoTo Education Services-->
                    <div class="bottom-footer-links">
                        <ul class="list-unstyled">
                            <li><a target="_blank" href="/site/term"><?= Yii::t('gtufooter', 'Terms of Service') ?></a></li>
                            <li><a target="_blank" href="/site/privacy-policy"><?= Yii::t('gtufooter', 'Privacy Statement') ?></a></li>
                          </ul>
                      </div>
                    
                  </div>
                </div>
      </div>
    </div>
  </div>
  <?php  if (!Yii::$app->user->isGuest) {
    if($userLogin->status==4){  
    ?>
  <div id="chaticon" class="chat-block">
  <div class="chat-tab" id="nfc_detail">
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
        url: '/site/subscribe',
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
var images = Array("/images/background-slider-1.jpg",
                   "/images/background-slider-2.jpg",
                   "/images/background-slider-3.jpg",
                   "/images/background-slider-4.jpg");
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
                    setTimeout(loadimg,30000);
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
