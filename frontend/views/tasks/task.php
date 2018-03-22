<?php
use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu;  
//use kartik\daterange\DateRangePicker;
use common\models\Student; 
use common\models\Tasks;
use partner\models\TaskCommentSearch;
use common\components\Commondata;

    $this->context->layout = 'profile';
    $this->title = 'Tasks';
?>
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-task col-xs-12">
        	<div class="task-list">
            <?php if(!empty($tasks)){ ?>
            <?php foreach($tasks as $task) { ?>
        		<div class="task-block">
                <?php if($model->verifybycounselor!=2){
                $id = Commondata::encrypt_decrypt('encrypt', $task['id']); ?>  
                    <a style="float: right;" href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
                    data-target="#taskUpdateModal" onclick="loadTaskupdate('<?= $id ?>')" ></a>  
                    <?php } ?>
        			<div class="row">
        				<div class="col-sm-6">
        					<h4 class="task-title"><?= $task['title'] ?></h4>
        				</div>
        			</div>
        			<div class="row mtop-20">
        				<div class="col-sm-3">
        					<lable>Date Added</lable>
        					<p>
                            <?php $newdt = strtotime($task['created_at']); 
                                  echo date('d-M-Y', $newdt); ?>     
                            </p>
        				</div>
        				<div class="col-sm-3 col-sm-offset-6">
        					<lable>Deadline</lable>
                            <p>
                            <?php $newdt = strtotime($task['due_date']); 
                                  echo date('d-M-Y', $newdt); ?>     
                            </p>
        				</div>
        			</div>
        			<div class="row mtop-20">
        				<div class="col-sm-3">
        					<lable>Responsibility</lable>
        					<p>
                            <?php $TaskResponsbility = Tasks::TaskResponsbility();
                            echo $TaskResponsbility[$task['responsibility']]; ?>
                            </p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Action</lable>
        					<p>
                            <?php
                            $TaskActions = Tasks::TaskActions();
                            echo $TaskActions[$task['action']];
                            ?>
                            </p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Counselor Verification</lable>
        					<p>
                            <?php
                            $actions = Tasks::TaskVerificationByCounselor();           
                            echo $actions[$task['verifybycounselor']];    
                            ?>           
                            </p>
        				</div>
        				<div class="col-sm-3">
        					<lable>Status</lable>
        					<p>
                            <?php
                            $TaskStatus = Tasks::TaskStatus();          
                            echo $TaskStatus[$task['status']];
                            ?>               
                            </p>
        				</div>
        			</div>
        		</div>
                <?php } } else { ?>
        		<div class="task-block create-task">
        			<a class="add-task" href="#">No Tasks assigend for you!</a>
        		</div>
                <?php } ?>
        	</div>
        </div>
    </div>
</div>
</div>
</div>
<div id="taskUpdateModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="taskUpdate" style="height:800px; overflow:scroll;">
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
    </div> 
<script type="text/javascript">
    function loadTaskupdate(id) {
    $.ajax({
             url: '/tasks/update?id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#taskUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
</script>