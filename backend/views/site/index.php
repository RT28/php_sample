<?php

/* @var $this yii\web\View */
use common\models\SRM;
use kartik\datetime\DateTimePicker;
use common\components\Status;
use common\components\Roles;
use backend\models\EmployeeLogin;
use common\models\StudentConsultantRelation;
use common\models\Student;
use frontend\models\UserLogin;
use backend\models\Employee;

$this->title = 'My Yii Application';

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="site-index col-xs-12 col-sm-9">

    <div class="jumbotron">
        <h1>Welcome! <span style="color: #00bcd4;"><?= Yii::$app->user->identity->username ?></span></h1>
    </div>    
</div>
<input type="hidden" id="from-id" val="<?= Yii::$app->user->identity->id; ?>"/>
<input type="hidden" id="from-role" val="<?= Yii::$app->user->identity->role_id; ?>"/>
<div class="col-xs-12 col-sm-3">
    <div class="panel panel-default notifications-window" id="notifications-panel">
        <div class="panel-heading">
            <h4>Notifications</h4>
        </div>
        <div class="panel body">
        </div>
    </div>
    <?php   if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id === \common\components\Roles::ROLE_CONSULTANT): ?>
        <div id="calendar"></div>        
    <?php endif;  ?>

    <!-- Chats-->
    <?php
        $employees = EmployeeLogin::find()->where(['AND', ['=', 'status', Status::STATUS_ACTIVE],['!=', 'id', Yii::$app->user->identity->id]])->all();
        $students = [];
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id == Roles::ROLE_CONSULTANT) {
            $students = StudentConsultantRelation::find()->where(['=', 'consultant_id', Yii::$app->user->identity->id])->all();
            $appointment_options = $students;
        } 
    ?>
    <div class="panel panel-default panel-custom panel-chat">
        <div class="panel-heading">
            Chat
        </div>
        <div class="panel-body">
            <?php foreach($employees as $employee): ?>
                <?php
                    $name = '';
                    /*if($employee->role_id === Roles::ROLE_SRM) {
                        $srm = SRM::find()->where(['=', 'srm_id', $employee->id])->one();
                        if(!empty($srm)) {
                            $name = $srm->name;
                        }
                    } else {*/
                        $emp = Employee::find()->where(['=', 'employee_id', $employee->id])->one();
                        $name = $emp->first_name . ' ' . $emp->last_name;
                    //}
                ?>
                <div class="chat-unit" data-to="<?= $employee->id . '-' . $employee->role_id; ?>">
                    <div class="chat-img">
                        <img src="images/user-1.jpg" alt="<?= $name; ?>"/>
                    </div>
                    <div class="chat-name"><?= $name; ?></div>
                    <div class="chat-status">
                        <span class="offline"></span>
                    </div>
                </div>
            <?php endforeach;?>
            <?php foreach($students as $student): ?>
                <div class="chat-unit" data-to="<?= $student->id . '-' . Roles::ROLE_STUDENT; ?>">
                    <?php
                        $student_name = $student->student->first_name . ' ' . $student->student->last_name;
                    ?>
                    <div class="chat-img">
                        <img src="images/user-1.jpg" alt="<?= $student_name; ?>"/>
                    </div>
                    <div class="chat-name"><?= $student_name; ?></div>
                    <div class="chat-status">
                        <span class="offline"></span>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="chat-parent"></div>  
</div>

<?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->role_id === Roles::ROLE_CONSULTANT): ?>
<div class="modal fade" id="calendar-modal" tabindex="-1" role="dialog" aria-labelledby="calendar">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">        
        <h4 class="modal-title" id="myModalLabel">Calendar</h4>
    </div>
    <div class="modal-body">
        <div class="alert alert-danger hidden calendar-alert alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <span class="calendar-alert-text"></span>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div id="calendar-detailed">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Events</div>
                    <div class="panel-body">                        
                        <div id="calendar-form">                
                            <form id="event-form">
                                <input type="hidden" id="input-event-id" placeholder=""/>                    
                                <div class="form-group">
                                    <label for="input-event-title">Title</label>
                                    <input type="text" class="form-control" id="input-event-title" placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label for="input-event-url">Url</label>
                                    <input type="text" class="form-control" id="input-event-url" placeholder="Url">
                                </div>
                                <div class="form-group">
                                    <label for="input-event-start">Start</label>                                    
                                    <?= DateTimePicker::widget([
                                            'name' => 'input-event-start',
                                            'type' => DateTimePicker::TYPE_INPUT,                                        
                                            'options' => ['placeholder' => 'Start Time', 'class' => 'form-control', 'id' => 'input-event-start'],
                                            'pluginOptions' => [
                                                'autoClose' => true,
                                                'format' => 'yyyy-mm-dd hh:ii',
                                                'todayHighlight' => true
                                            ]
                                        ]);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="input-event-end">End</label>                                    
                                    <?= DateTimePicker::widget([
                                            'name' => 'input-event-end',
                                            'type' => DateTimePicker::TYPE_INPUT,                                        
                                            'options' => ['placeholder' => 'Start Time', 'class' => 'form-control', 'id' => 'input-event-end'],
                                            'pluginOptions' => [
                                                'autoClose' => true,
                                                'format' => 'yyyy-mm-dd hh:ii',
                                                'todayHighlight' => true
                                            ]
                                        ]);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="input-event-event_type">Type</label>
                                    <select class="form-control" id="input-event-event_type" placeholder="Event Type"></select>
                                </div>
                                <div class="form-group hidden" id="appointment-container">
                                    <label for="input-event-appointment-with">Appointment With</label>
                                    <select class="form-control" id="input-event-appointment-with" placeholder="Appointment with">
                                        <option value="-1">Select</option>
                                        <?php foreach($appointment_options as $option): ?>
                                            <?php
                                                $name = $option->student->first_name . ' ' . $option->student->last_name;
                                            ?>
                                            <option value="<?= $option->student_id; ?>" data-role="<?= $option->student->role_id;?>"><?= $name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="input-event-status-container" class="hidden">
                                        <label for="input-event-remarks">Status</label>
                                        <p id="input-event-appointment-status"></p>
                                    </div>                                    
                                </div>
                                
                                <div class="form-group">
                                    <label for="input-event-remarks">Remarks</label>
                                    <textarea type="text" class="form-control" id="input-event-remarks" placeholder="Remarks" rows="4"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-event-add">Add</button>
                                    <button type="button" class="btn btn-success btn-event-form-update hidden">Update</button>
                                </div>
                            </form> 
                        </div>
                        <div id="calendar-event-detail" class="hidden">
                            <p id="event-id" class="hidden"></p>
                            <p id="event-appointment-with" class="hidden" role=""></p>
                            <div class="form-group">
                                <label for="input-event-title">Title</label>
                                <p id="event-title"></p>
                            </div>
                            <div class="form-group">
                                <label for="event-url">Url</label>
                                <p><a id="event-url"></a></p>
                            </div>
                            <div class="form-group">
                                <label for="event-start">Start</label>
                                <p id="event-start"></p>
                            </div>
                            <div class="form-group">
                                <label for="event-end">End</label>
                                <p id="event-end"></p>
                            </div>
                            <div class="form-group">
                                <label for="event-type">Type</label>
                                <p id="event-type"></p>
                            </div>
                            <div id="event-status-container" class="form-group hidden">
                                <label for="event-status">Status</label>
                                <p id="event-status"></p>
                            </div>
                            <div class="form-group">
                                <label for="event-remarks">Remarks</label>
                                <p id="event-remarks"></p>
                            </div>
                            <button type="button" class="btn btn-primary btn-event-update">Update</button>
                            <button type="button" class="btn btn-danger btn-event-delete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
    </div>
    </div>
</div>
<?php endif; ?>
</div>
