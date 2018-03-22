<?php
    $this->context->layout = 'profile';
    $this->title = 'Inbox';
?>
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-task col-xs-12">
        	<div class="task-list">
        		<div class="task-block">
        			<a href="#" class="edit-task-tab"><img src="/images/task-edit-ic.png"/></a>
        			<div class="row">
        				<div class="col-sm-6">
        					<h4 class="task-title">Couriering application documents to the university</h4>
        				</div>
        			</div>
        			<div class="row mtop-20">
        				<div class="col-sm-3">
        					<lable>Date Added</lable>
        					<p>9th October 2017</p>
        				</div>
        				<div class="col-sm-3 col-sm-offset-6">
        					<lable>Deadline</lable>
        					<p>9th October 2017</p>
        				</div>
        			</div>
        			<div class="row mtop-20">
        				<div class="col-sm-3">
        					<lable>Responsibility</lable>
        					<p>Student</p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Action</lable>
        					<p>Pending</p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Counselor Verification</lable>
        					<p>Pending</p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Status</lable>
        					<p>Pending</p>
        				</div>
        			</div>
        		</div>

        		<div class="task-block create-task">
        			<a class="add-task" href="#">+ Add New Task</a>
        		</div>
        	</div>
        </div>
    </div>
</div>
</div>
</div>