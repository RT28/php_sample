<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\sidenav\SideNav;

AppAsset::register($this);
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

     echo SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,        
        'containerOptions' => [
            'class' => ['c-navbar']
        ],
        'items' => [
            [
                'url' => ['/site/index'],
                'label' => 'Home',
                'icon' => 'home',
				'items' => [
                    ['label' => 'Site Configuration', 'url' => ['/site-config/']], 
                ]
            ],
			
			[
                'label' => 'GTU Notifications',
                'icon' => 'user',
                'items' => [
                    ['label' => 'View', 'url' => ['/notifications/']],
                    ['label' => 'Create','url' => ['/notifications/']],
                ]
            ],  
		  
		[                
			'label' => 'Enquiries',
			'icon' => 'education',
			'items' => [
				['label' => 'General', 'url' => ['/general-enquiry/index']],
				['label' => 'University/Agency', 'url' => ['/university-enquiry/index']],
				['label' => 'Consultant', 'url' => ['/consultant-enquiry/index']],  
			]
		],
			
			  
            [
                'label' => 'Employee',
                'icon' => 'user',
                'items' => [
                    ['label' => 'View', 'url' => ['/employee/index']],
                    ['label' => 'Create','url' => ['/employee/create']],
                ]
            ],
			[                
                'label' => 'Agencies',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/agency/index']],
                    ['label' => 'Create', 'url' => ['/agency/create']],  
                ]
            ],
            [                
                'label' => 'Universities',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/university/index']],
                    ['label' => 'Create', 'url' => ['/university/create']], 
					 ['label' => 'Partner Universities', 'url' => ['/newunivserities/index']],
                    ['label' => 'Upload', 'url' => ['/university/upload-university']],
                    ['label' => 'Upload Admissions', 'url' => ['/university/upload-admissions']],  
					['label' => 'Featured Universities', 'url' => ['/featured-universities/index']],
					['label' => 'Create Featured University', 'url' => ['/featured-universities/create']],
					['label' => 'Approve University data', 'url' => ['/university-temp/index']],
					
                ]
            ],	
            [                
                'label' => 'Leads',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/leads/index']],
                ]
            ],
            [                
                'label' => 'Invoice',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/invoice/index']],
                ]
            ],
            [                
                'label' => 'Webinar',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/webinar/index']],
                ]
            ],
			[                
                'label' => 'Tasks',
                'icon' => 'education',
                'items' => [
                    ['label' => 'Task Category', 'url' => ['/task-category/index']],
					['label' => 'Task Lists', 'url' => ['/task-list/index']],
				]
			],
            [                
                'label' => 'University Information',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/universityinfo/index']],
                ]
            ],
			[                
                'label' => 'Programs',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/program']], 				
                    ['label' => 'Upload Programs', 'url' => ['/university/upload-programs']],
                ]
            ],
			[
                'label' => 'Student',
                'icon' => 'user',
                'items' => [
                    ['label' => 'All Students', 'url' => ['/admin-student/index']],
					['label' => 'Students List with Agencies', 'url' => ['/admin-student/assigned-counselor']],
                    ['label' => 'Student Applications', 'url' => ['/admin-student/view-all-applications']],
                ]
            ],
             
            [                
                'label' => 'Consultants',
                'icon' => 'user',
                'items' => [
                    ['label' => 'View', 'url' => ['/admin-consultant/index']],
                    ['label' => 'Create', 'url' => ['/admin-consultant/create']],
					
                ]
            ],
			[
                'label' => 'GTU Bugs',
                'icon' => 'user',
                'items' => [
                    ['label' => 'View', 'url' => ['/gtubugs/index']], 
					['label' => 'Module', 'url' => ['/gtumodule/index']], 
					['label' => 'Environment', 'url' => ['/gtuenvironment/index']], 
                ]
            ],
            [                
                'label' => 'Addons',
                'icon' => 'th-list',
                'items' => [
                   [
                'label' => 'Currency',
                 'icon' => 'usd',
                'items' => [
                    ['label' => 'View', 'url' => ['/currency/index']],
                    ['label' => 'Create', 'url' => ['/currency/create']],
                ]
            ],
			[
                'label' => 'Articles',
                'icon' => 'globe',
                'items' => [
                    ['label' => 'View', 'url' => ['/articles/index']], 
                ]
            ],

            [
                'label' => 'Continents',
                'icon' => 'globe',
                'items' => [
                    ['label' => 'View', 'url' => ['/continent/index']], 
                ]
            ],
			[
                'label' => 'Country',
                'icon' => 'globe',
                'items' => [
                    ['label' => 'View', 'url' => ['/country/index']],
                    ['label' => 'Create', 'url' => ['/country/create']],
                ]
            ],
            [                
                'label' => 'State',
                'icon' => 'screenshot',
                'items' => [
                    ['label' => 'View', 'url' => ['/state/index']],
                    ['label' => 'Create', 'url' => ['/state/create']],
                ]
            ],
            [                
                'label' => 'City',
                'icon' => 'map-marker',
                'items' => [
                    ['label' => 'View', 'url' => ['/city/index']],
                    ['label' => 'Create', 'url' => ['/city/create']],
                ]
            ],
            [                
                'label' => 'Degree Level',
                'icon' => 'education',
                'items' => [
                    ['label' => 'View', 'url' => ['/degree-level/index']],
                    ['label' => 'Create', 'url' => ['/degree-level/create']],
                ]
            ],
            [                
                'label' => 'Discipline',
                'icon' => 'book',
                'items' => [
                    ['label' => 'View', 'url' => ['/degree/index']],
                    ['label' => 'Create', 'url' => ['/degree/create']],
                ]
            ],
            [                
                'label' => 'Sub Discipline',
                 'icon' => 'book',
                'items' => [
                    ['label' => 'View', 'url' => ['/majors/index']],
                    ['label' => 'Create', 'url' => ['/majors/create']],
                ]
            ],
			
			[                
                'label' => 'Test',
                  'icon' => 'copy',
                'items' => [
                    ['label' => 'Test Category', 'url' => ['/test-category/index']],
					['label' => 'Test Subjects', 'url' => ['/test-subject/index']],
                    ['label' => 'Standard Tests', 'url' => ['/standard-tests/index']],
                ]
            ],
                       
            [                
                'label' => 'Package Type',
                'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-type/index']],
                    ['label' => 'Create', 'url' => ['/package-type/create']],
                ]
            ],
            [                
                'label' => 'Package Offerings',
                'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-offerings/index']],
                    ['label' => 'Create', 'url' => ['/package-offerings/create']],
                ]
            ],
            [                
                'label' => 'Package Sub-Types',
                 'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/package-subtype/index']],
                    ['label' => 'Create', 'url' => ['/package-subtype/create']],
                ]
            ],
            [                
                'label' => 'Faq Category',
                 'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/faq-category/index']],
                    ['label' => 'Create', 'url' => ['/faq-category/create']],
                ]
            ],
            [                
                'label' => 'Ranking Type',
                 'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/ranking-type/index']],
                    ['label' => 'Create', 'url' => ['/ranking-type/create']],
                ]
            ],
            [                
                'label' => 'Others',
                'icon' => 'th-large',
                'items' => [
                    ['label' => 'Others', 'url' => ['/others/index']],
                ]
            ],
			[
                'label' => 'Essays',
				 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/essay/index']],
                    ['label' => 'Create', 'url' => ['/essay/create']],
                ]
            ],
			[
                'label' => 'Advertisement',
				 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/advertisement/index']], 
                ]
            ],
			[
                'label' => 'Services',
				 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/services/index']],
                    ['label' => 'Create', 'url' => ['/services/create']],
                ]
            ],
            [
                'label' => 'FAQ',
                 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/faq/index']],
                    ['label' => 'Create', 'url' => ['/faq/create']],
                ]
            ],
            [
                'label' => 'Articles',
                 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/articles/index']],
                    ['label' => 'Create', 'url' => ['/articles/create']],
                ]
            ],
            [
                'label' => 'Terms & Policy',
                 'icon' => 'th-large',
                'items' => [
                    ['label' => 'View', 'url' => ['/terms-policy/index']],
                    ['label' => 'Create', 'url' => ['/terms-policy/create']],
                ]
            ],
			 [                
                'label' => 'Document List Type',
                'icon' => 'gift',
                'items' => [
                    ['label' => 'View', 'url' => ['/dtypes/index']],
                    ['label' => 'Create', 'url' => ['/dtypes/create']],
                ]
            ],
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
    </div>
</footer>

<?php $this->endBody() ?>
<script src="js/main.js"></script>
</body>
</html>
<?php $this->endPage() ?>
