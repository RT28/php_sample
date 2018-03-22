<!-- FOOTER-->
<!-- BUTTON BACK TO TOP-->
<div id="back-top"><a href="#top"><i class="fa fa-angle-double-up"></i></a></div>
<footer style="margin-top: 30px;">
  <div class="footer-main">
    <div class="container">
      <div class="footer-main-wrapper">
        <div class="row">
          <div class="col-2">
            <div class="col-md-3 col-sm-6 sd380">
              <div class="edugate-widget widget">
                <img src="images/logo.png" alt="" class="footer-logo"/>
                <div class="content-widget">
                  <p>Edugate is a great start for an education personnel or organization to start the online business with 1 Click.</p>
                  
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-6 sd380">
              <div class="useful-link-widget widget">
                <div class="title-widget">Sitemap</div>
                <div class="content-widget">
                  <div class="useful-link-list">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="list-unstyled">
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/index#services">Services</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/about">About Us</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/team">Our Team</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/portfolio">Portfolio</a></li>
                        </ul>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="list-unstyled">
                          <li><i class="fa fa-angle-right"></i><a href="#">Blog</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">Testimonial</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="?r=site/index#contact">Contact Us</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-2">
            <div class="col-md-3 col-sm-6 sd380">
              <div class="gallery-widget widget">
                <div class="title-widget">Achives</div>
                <div class="content-widget">
                  <div class="useful-link-list">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="list-unstyled">
                          <li><i class="fa fa-angle-right"></i><a href="#">January 2016</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">February 2016</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">March 2016</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">April 2016</a></li>
                        </ul>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <ul class="list-unstyled">
                          <li><i class="fa fa-angle-right"></i><a href="#">May 2016</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">June 2016</a></li>
                          <li><i class="fa fa-angle-right"></i><a href="#">July 2016</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
            </div>
            <div class="col-md-3 col-sm-6 sd380">
              <div class="mailing-widget widget">
                <div class="title-widget">Newsletter</div>
                <div class="content-wiget">
                  <p>Sign up for our mailing list to get latest updates and offers.</p>
                  <form action="">
                    <div class="input-group">
                      <input type="text" placeholder="Email address" class="form-control form-email-widget" id="txt-email"/>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-email" id="btn-subscribe"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>                        
                      </span>                      
                    </div>
                    <div id="subscription-status"></div>
                  </form>                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hyperlink">
        <div class="pull-left hyper-left">
          Copyright © <?= date('Y'); ?>
        </div>
        <div class="pull-right hyper-right">
        	<div class="socials"><a href="#" class="facebook"><i class="fa fa-facebook"></i></a><a href="#" class="google"><i class="fa fa-google-plus"></i></a><a href="#" class="twitter"><i class="fa fa-twitter"></i></a><a href="#" class="pinterest"><i class="fa fa-pinterest"></i></a></div>
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
