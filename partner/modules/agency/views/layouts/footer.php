<!-- FOOTER-->
<!-- BUTTON BACK TO TOP-->
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
<footer>
  <div class="footer-main inner-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <div class="footer-logo"> <img src="/images/logo.svg"/> </div>
        </div>
        <div class="col-sm-6">
          <div class="social-media-links pull-right"> <a href="https://www.facebook.com/go2university/" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a> <a href="https://plus.google.com/u/0/103041279877923883182" target="_blank" class="google"><i class="fa fa-google-plus"></i></a> <a href="https://twitter.com/GoToUniv" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a> <a href="https://www.linkedin.com/company/13360416/" target="_blank" class="linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </div>
        </div>
      </div>
      <div class="footer-main-wrapper">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <ul class="footer-menu">
              <li><a href="">Partner With Us</a></li>
              <li><a role="button" data-toggle="modal" data-target="#footer-form">Drop a Message</a></li>
              <li><a href="/site/faq">FAQs</a></li>
            </ul>
            <div class="hyperlink hidden-xs">
              <div class="pull-left hyper-left"> 
                <!--Copyright © <?= date('Y'); ?> <a href="http://gotouniversity.com">Gotouniversity</a>A Private Unit of GoTo Education Services-->
                <div class="bottom-footer-links">
                  <ul class="list-unstyled">
                    <li><a target="_blank" href="/site/term">Terms of Service</a></li>
                    <li><a target="_blank" href="/site/privacy-policy">Privacy Statement</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="footer-c-details">
              <div class="c-link"><a href="tel:+97142428518"><img src="/images/call.svg"> +971 - 42428518</a></div>
              <div class="c-link"><a href="mailto:info@gotouniversity.com"><img src="/images/mail.svg"> info@gotouniversity.com</a></div>
            </div>
            <div class="hyperlink visible-xs">
              <div class="pull-left hyper-left"> 
                <!--Copyright © <?= date('Y'); ?> <a href="http://gotouniversity.com">Gotouniversity</a>A Private Unit of GoTo Education Services-->
                <div class="bottom-footer-links">
                  <ul class="list-unstyled">
                    <li><a target="_blank" href="/site/term">Terms of Service</a></li>
                    <li><a target="_blank" href="/site/privacy-policy">Privacy Statement</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<script>
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
