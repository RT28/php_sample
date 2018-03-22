<?php
    $this->context->layout = 'profile';
    $this->title = 'Inbox';
?>
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-inbox col-xs-12">
        	<div class="new-msg-search">
			<div class="row">
            	<div class="col-sm-4">
                	<button class="btn btn-blue new-msg"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> New Message</button>
                </div>
            	<div class="col-sm-8">
                <form class="search-in-inbox">
                	<input type="text" class="form-control" placeholder="Search Messages or Name.."/>
                </form>
                </div>
            </div>
            </div>
            <div class="inbox-main-tabs">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs row" role="tablist">
    <li role="presentation" class="active col-sm-4 pad-left-0"><a href="#inbox" aria-controls="inbox" role="tab" data-toggle="tab">Inbox</a></li>
    <li role="presentation" class="col-sm-4 pad-0 text-center"><a href="#sent-message" aria-controls="sent-message" role="tab" data-toggle="tab">Sent Message</a></li>
    <li role="presentation"  class="col-sm-4 pad-right-0 text-right"><a href="#draft" aria-controls="draft" role="tab" data-toggle="tab">Draft</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="inbox">
    	
        <div class="row">
     		<div class="col-sm-4 pad-left-0 pad-right-0">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">
    <div class="sub-in-tab">Your documents have been received</div>
    <div class="sender-name">Mackenzie</div>
    </a></li>
    <li role="presentation"><a href="#2" aria-controls="2" role="tab" data-toggle="tab">
    <div class="sub-in-tab">Your documents have been received and application is closed</div>
    <div class="sender-name">Mackenzie</div>
    </a></li>
    <li role="presentation"><a href="#3" aria-controls="3" role="tab" data-toggle="tab">
    <div class="sub-in-tab">Your documents have been received and application is closed</div>
    <div class="sender-name">Mackenzie</div>
    </a></li>
    <li role="presentation"><a href="#4" aria-controls="4" role="tab" data-toggle="tab">
    <div class="sub-in-tab">Your documents have been received and application is closed</div>
    <div class="sender-name">Mackenzie</div>
    </a></li>
  </ul>
	</div>
    <div class="col-sm-8 pad-tight-0">
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="1">
    	<div class="subject-sender-details">
    		<h3 class="msg-subject">Your documents have been received</h3>
            <div class="sender-detail">
            	<div class="sender-image">
                	<img src="http://gotouniversity.com/partner/web/uploads/consultant/19/profile_photo/consultant_image_228X228.jpg"/>
                </div>
    			<div class="sender-name-msg">Mackenzie</div>
            </div>
        </div>
        <div class="msg-text">
        	<p>This package is specially designed for applicants looking to enrol in MBA programs. </br>
            Our consultants will help you shortlist the perfect schools from the thousands of MBA </br>
            programs available globally, and will then assist you throughout the application </br>
            process. You will be offered guidance on GMAT test strategy, essay writing, CV editing, </br>
            reference letters, as well as interview preparation. Students can opt either for the </br>
            comprehensive school package or for hourly services.</p>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="2">
    	<div class="subject-sender-details">
    		<h3 class="msg-subject">Your documents have been received and application is closed</h3>
            <div class="sender-detail">
            	<div class="sender-image">
                	<img src="http://gotouniversity.com/partner/web/uploads/consultant/19/profile_photo/consultant_image_228X228.jpg"/>
                </div>
    			<div class="sender-name-msg">Mackenzie</div>
            </div>
        </div>
        <div class="msg-text">
        	<p>This package is specially designed for applicants looking to enrol in MBA programs. </br>
            Our consultants will help you shortlist the perfect schools from the thousands of MBA </br>
            programs available globally, and will then assist you throughout the application </br>
            process. You will be offered guidance on GMAT test strategy, essay writing, CV editing, </br>
            reference letters, as well as interview preparation. Students can opt either for the </br>
            comprehensive school package or for hourly services.</p>
        </div></div>
    <div role="tabpanel" class="tab-pane" id="3">
    	<div class="subject-sender-details">
    		<h3 class="msg-subject">Your documents have been received and application is closed</h3>
            <div class="sender-detail">
            	<div class="sender-image">
                	<img src="http://gotouniversity.com/partner/web/uploads/consultant/19/profile_photo/consultant_image_228X228.jpg"/>
                </div>
    			<div class="sender-name-msg">Mackenzie</div>
            </div>
        </div>
        <div class="msg-text">
        	<p>This package is specially designed for applicants looking to enrol in MBA programs. </br>
            Our consultants will help you shortlist the perfect schools from the thousands of MBA </br>
            programs available globally, and will then assist you throughout the application </br>
            process. You will be offered guidance on GMAT test strategy, essay writing, CV editing, </br>
            reference letters, as well as interview preparation. Students can opt either for the </br>
            comprehensive school package or for hourly services.</p>
        </div></div>
    <div role="tabpanel" class="tab-pane" id="4">
    	<div class="subject-sender-details">
    		<h3 class="msg-subject">Your documents have been received and application is closed</h3>
            <div class="sender-detail">
            	<div class="sender-image">
                	<img src="http://gotouniversity.com/partner/web/uploads/consultant/19/profile_photo/consultant_image_228X228.jpg"/>
                </div>
    			<div class="sender-name-msg">Mackenzie</div>
            </div>
        </div>
        <div class="msg-text">
        	<p>This package is specially designed for applicants looking to enrol in MBA programs. </br>
            Our consultants will help you shortlist the perfect schools from the thousands of MBA </br>
            programs available globally, and will then assist you throughout the application </br>
            process. You will be offered guidance on GMAT test strategy, essay writing, CV editing, </br>
            reference letters, as well as interview preparation. Students can opt either for the </br>
            comprehensive school package or for hourly services.</p>
        </div></div>
  </div>
</div>
        </div>
    
    </div>
    <div role="tabpanel" class="tab-pane" id="sent-message">2</div>
    <div role="tabpanel" class="tab-pane" id="draft">3</div>
  </div>

</div>
        </div>
    </div>
</div>
</div>
</div>