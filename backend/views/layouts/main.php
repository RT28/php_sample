<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\assets\FullCalendarAsset;
use backend\assets\MomentAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\sidenav\SideNav;

AppAsset::register($this);
FullCalendarAsset::register($this);
MomentAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <link type="text/css" rel="stylesheet" href="font/font-icon/font-awesome-4.4.0/css/font-awesome.css">
    <link type="text/css" rel="stylesheet" href="font/main/stylesheet.css">
    <script src="https://static.opentok.com/v2/js/opentok.js" charset="utf-8"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'containerOptions' => [
            'class' => ['c-navbar']
        ],
        'items' => [
            [
                'url' => ['/site/index'],
                'label' => 'Home',
            ],
            [
                'label' => 'Employee',
                'items' => [
                    ['label' => 'View', 'url' => ['/employee/index']],
                    ['label' => 'Create', 'url' => ['/employee/create']],
                ]
            ],
            [                
                'label' => 'University',
                'items' => [
                    ['label' => 'View', 'url' => ['/university/index']],
                    ['label' => 'Create', 'url' => ['/university/create']],
                    ['label' => 'Upload', 'url' => ['/university/upload-university']],
                    ['label' => 'Upload Programs', 'url' => ['/university/upload-programs']],
                    ['label' => 'Upload Admissions', 'url' => ['/university/upload-admissions']],
                ]
            ],
            [
                'label' => 'Currency',
                'items' => [
                    ['label' => 'View', 'url' => ['/currency/index']],
                    ['label' => 'Create', 'url' => ['/currency/create']],
                ]
            ],
            [
                'label' => 'Country',
                'items' => [
                    ['label' => 'View', 'url' => ['/country/index']],
                    ['label' => 'Create', 'url' => ['/country/create']],
                ]
            ],
            [
                'label' => 'State',
                'items' => [
                    ['label' => 'View', 'url' => ['/state/index']],
                    ['label' => 'Create', 'url' => ['/state/create']],
                ]
            ],
            [
                'label' => 'City',
                'items' => [
                    ['label' => 'View', 'url' => ['/city/index']],
                    ['label' => 'Create', 'url' => ['/city/create']],
                ]
            ],
            [
                'label' => 'Discipline',
                'items' => [
                    ['label' => 'View', 'url' => ['/degree/index']],
                    ['label' => 'Create', 'url' => ['/degree/create']],
                ]
            ],
            [
                'label' => 'Degree Level',
                'items' => [
                    ['label' => 'View', 'url' => ['/degree-level/index']],
                    ['label' => 'Create', 'url' => ['/degree-level/create']],
                ]
            ],
            [
                'label' => 'Sub Discipline',
                'items' => [
                    ['label' => 'View', 'url' => ['/majors/index']],
                    ['label' => 'Create', 'url' => ['/majors/create']],
                ]
            ],
            [
                'label' => 'Package Type',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-type/index']],
                    ['label' => 'Create', 'url' => ['/package-type/create']],
                ]
            ],
            [
                'label' => 'Package Offerings',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-offerings/index']],
                    ['label' => 'Create', 'url' => ['/package-offerings/create']],
                ]
            ],
            [
                'label' => 'Package Sub-Types',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-subtype/index']],
                    ['label' => 'Create', 'url' => ['/package-subtype/create']],
                ]
            ],
            [
                'label' => 'Featured Universities',
                'items' => [
                    ['label' => 'View', 'url' => ['/featured-universities/index']],
                    ['label' => 'Create', 'url' => ['/featured-universities/create']],
                ]
            ],
            [
                'label' => 'Services',
                'items' => [
                    ['label' => 'View', 'url' => ['/services/index']],
                    ['label' => 'Create', 'url' => ['/services/create']],
                ]
            ],
            [
                'label' => 'University Applications',
                'items' => [
                    ['label' => 'View', 'url' => ['/university-applications/index']],
                ]
            ],
            [
                'label' => 'Others',
                'items' => [
                    ['label' => 'Others', 'url' => ['/others/index']],
                ]
            ],
			[                
                'label' => 'Document List Type',
                'items' => [
                    ['label' => 'View', 'url' => ['/dtypes/index']],
                    ['label' => 'Create', 'url' => ['/dtypes/create']],
                ]
            ]
			
        ],
    ]);

    NavBar::begin([
        'brandLabel' => 'GoToUniversity',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navbar-container',
        ],
    ]);
    $menuItems = [
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
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

    <div class="container-fluid content-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid footer-container">
        <p class="pull-left">&copy; GoToUniversity <?= date('Y') ?></p>
</footer>

<?php $this->endBody() ?>
<script src="js/main.js"></script>
</body>
</html>
<?php $this->endPage() ?>
