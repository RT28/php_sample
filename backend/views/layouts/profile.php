<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\FullCalendarAsset;
use common\widgets\Alert;
use kartik\datetime\DateTimePicker;
use common\components\Roles;

AppAsset::register($this);
//FullCalendarAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Go To University',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
           
            $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?php $modelid = $this->params['customParam']; ?>
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="?r=admin-student/index">Home</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/view-profile&id=<?php echo $modelid ?>">Profile</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/school-details&id=<?php echo $modelid ?>">School Details</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/college-details&id=<?php echo $modelid ?>">College Details</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/subject-details&id=<?php echo $modelid ?>">Subject Details</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/english-proficiency&id=<?php echo $modelid ?>">English Language Proficiency</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/standard-tests&id=<?php echo $modelid ?>">Standard Tests</a></li> 
                    <li class="list-group-item"><a href="?r=admin-student/consultant-view&id=<?php echo $modelid ?>">Consultants</a></li>
					 <li class="list-group-item"><a href="?r=admin-student/employee-view&id=<?php echo $modelid ?>">Employee/Trainers</a></li>
                    <li class="list-group-item"><a href="?r=admin-student/package-view&id=<?php echo $modelid ?>">Package Details</a></li>
                    
                    <!--<li class="list-group-item"><a href="?r=admin-student/documents&id=<?php echo $modelid ?>">Documents</a></li>-->
                </ul>
            </div>
            <div class="col-xs-12 col-sm-9">
                <?= $content ?>
            </div>
            <div class="fixed-right">
               <div id="calendar">
                </div>
            </div>
        </div>        
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Goto University <?= date('Y') ?></p>
    </div>
</footer>

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
</div>

<?php $this->endBody() ?>
<script src="js/main.js"></script>
</body>
</html>
<?php $this->endPage() ?>
