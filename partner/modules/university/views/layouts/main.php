<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\components\ConnectionSettings;
use frontend\assets\FullCalendarAsset;
use frontend\assets\MomentAsset;
use kartik\datetime\DateTimePicker;
use common\components\Roles;
use kartik\sidenav\SideNav;


AppAsset::register($this);
MomentAsset::register($this);
FullCalendarAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <!-- LIBRARY FONT-->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="font/main/stylesheet.css" rel="stylesheet">
<script src="libs/js-cookie/js.cookie.js"></script>
    <!-- LIBRARY CSS-->
    <link type="text/css" rel="stylesheet" href="libs/animate/animate.css">
    <link type="text/css" rel="stylesheet" href="libs/owl-carousel-2.0/assets/owl.carousel.css">
    <link type="text/css" rel="stylesheet" href="libs/selectbox/css/jquery.selectbox.css">
    <link type="text/css" rel="stylesheet" href="libs/fancybox/css/jquery.fancybox.css">
    <link type="text/css" rel="stylesheet" href="libs/fancybox/css/jquery.fancybox-buttons.css">
    <link type="text/css" rel="stylesheet" href="libs/media-element/build/mediaelementplayer.min.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input-facebook.css">
    <link type="text/css" rel="stylesheet" href="libs/tokeninput/css/token-input-mac.css">
    <script src="libs/js-cookie/js.cookie.js"></script> 
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<!-- LOADING-->
<div class="body-2 loading">
  <div class="dots-loader"></div>
</div>
    <?php include 'header.php';?>
    <input type="hidden" id="from_id" value="<?= Yii::$app->user->identity->id; ?>">
    <input type="hidden" id="from_role" value="<?= Roles::ROLE_UNIVERSITY; ?>">
    <div class="wrap">
    <?php

    echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'containerOptions' => [
            'class' => ['c-navbar']
        ],
        'items' => [
            [
                'url' => ['/university/university/view'],
                'label' => 'Home',
                'icon' => 'home',
            ],
            [
                'label' => 'University',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/university/university/view']],
                    ['label' => 'Update', 'url' => ['/university/university/update']],
                ]
            ],
            [
                'label' => 'Course List',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/university/university-course-list/index']],
                ]
            ],
            [
                'label' => 'Student',
                'icon' => 'user',
                'items' => [
                    ['label' => 'All Students', 'url' => ['#']],
                    ['label' => 'Student Applications', 'url' => ['#']],
                ]
            ],
        ]
    ]);

?>
    <!-- WRAPPER-->
    <div id="wrapper-content" class="student-profile"><!-- PAGE WRAPPER-->
        <div id="page-wrapper"><!-- MAIN CONTENT-->
            <div class="main-content"><!-- CONTENT-->
                <div class="content">
    <div class="container-fluid">
                        <div class="dashboard-block">
        <div class="row">

                                <div class="col-sm-10">
                                    <?= $content ?>
                                </div>
                                <div class="col-sm-2">
                                    <div class="dashboard-right">
                                        <div class="panel panel-default panel-custom panel-noti">
                                            <div class="panel-heading"> Notifications <span class="noti-count">9</span> </div>
                                            <div class="panel-body" id="notifications-panel"></div>
            </div>
                                        <div id="calendar">
            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-title">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="images/login-header-bg.png" alt=""/>
                    <button type="button" class="close custom-modal-close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="alert alert-danger alert-dismissible" role="alert" id="modal-error-container" style="display: none;">
                    <strong id="modal-error"></strong>
                </div>
                <div class="modal-body" id="modal-container">
                </div>
    </div>
        </div>
    </div>
 
</div>

<?php $this->endBody() ?>


<!-- JAVASCRIPT LIBS-->
<script src="libs/jquery/jquery-ui.js"></script>
<script src="libs/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<script src="libs/smooth-scroll/jquery-smoothscroll.js"></script>
<script src="libs/owl-carousel-2.0/owl.carousel.min.js"></script>
<script src="libs/appear/jquery.appear.js"></script>
<script src="libs/count-to/jquery.countTo.js"></script>
<script src="libs/wow-js/wow.min.js"></script>
<script src="libs/selectbox/js/jquery.selectbox-0.2.min.js"></script>
<script src="libs/fancybox/js/jquery.fancybox.js"></script>
<script src="libs/fancybox/js/jquery.fancybox-buttons.js"></script>
<script src="js/main.js"></script>


 <!-- Bootstrap core JavaScript
    ================================================== -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
<script>
	var myChart = new Chart({...})
</script>
        <script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
<script>
var ctx = document.getElementById("myChart1");
var myChart = new Chart(ctx, {
type: 'bar',
data: {
labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
}]
},
options: {
scales: {
    yAxes: [{
        ticks: {
            beginAtZero:true
        }
    }]
}
}
});
</script>
<script>
var ctx = document.getElementById("myChart2");
var myChart = new Chart(ctx, {
type: 'bar',
data: {
labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
}]
},
options: {
scales: {
    yAxes: [{
        ticks: {
            beginAtZero:true
        }
    }]
}
}
});
</script>
</html>
<?php $this->endPage() ?>
