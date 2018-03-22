<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\University */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
$this->registerJsFile('@web/js/institute.js');
?>
<?php $form = ActiveForm::begin(['id' => 'institute-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
   <?= Html::hiddenInput('currentTab' , $currentTab); ?>
    <?= Html::hiddenInput('tabs' ,implode(',', $tabs)); ?>
    <?= Html::hiddenInput('id',$id); ?>
    <div class="institute-form">   
        <?= Tabs::widget([
            'items' => [
                     [
                        'label' => 'Profile',
                        'content' => $this->render('_profile', [
                                'model' => $model,
                                 'currentTab' => $currentTab,
                                 'tabs' => $tabs,
                                 'countries' => $countries,
                                 'form'=>$form,
                            ]),
                        'active' => $currentTab === 'Profile' ? true : false,
                        'options' => ['id' => 'Profile'],                     
                    ],
                    [
                        'label' => 'About',
                        'content' =>array_search('About', $tabs) ? $this->render('_about', [
                            'model' => $model,
                             'currentTab' => $currentTab,
                             'tabs' => $tabs,
                             'form'=>$form,
                            'countries' => $countries,
                        ]) : null,
                        'headerOptions' => [                        
                            'class' => array_search('About', $tabs) ? 'enabled-tab' : 'disabled-tab' 
                        ],
                        'active' => $currentTab === 'About' ? true : false,
                        'options' => ['id' => 'About'],                     
                    ],
                   [
                        'label' => 'Services and Fees Structure',
                        'content' => array_search('Services', $tabs) ? $this->render('_services', [
                                'model' => $model,
                                'currentTab' => $currentTab,
                                'tabs' => $tabs,
                                'countries' => $countries,
                                'form'=>$form,
                            ]) : null,
                        'active' => $currentTab === 'Services' ? true : false,
                        'headerOptions' => [                        
                            'class' => array_search('Services', $tabs) ? 'enabled-tab' : 'disabled-tab' 
                        ],
                        'options' => [
                            'id' => 'Services',
                        ],
                    ],                
                    [
                        'label' => 'Branches',
                        'content' => array_search('Branches', $tabs) ? $this->render('_branches', [
                           'model' => $model,
                            'currentTab' => $currentTab,
                            'tabs' => $tabs,
                            'countries' => $countries,
                            'form'=>$form,
                        ]) : null,
                        'headerOptions' => [                        
                            'class' => array_search('Branches', $tabs) ? 'enabled-tab' : 'disabled-tab'
                        ],
                        'options' => ['id' => 'Branches'],
                    ],
                    [
                        'label' => 'Misc.',
                        'content' => array_search('Misc', $tabs) ? $this->render('_misc', [
                                'model' => $model,
                                 'currentTab' => $currentTab,
                                 'tabs' => $tabs,
                                'countries' => $countries,
                                'form'=>$form,
                            ]) : null,
                        'headerOptions' => [                        
                            'class' => array_search('Misc', $tabs) ? 'enabled-tab' : 'disabled-tab', 
                        ],
                        'active' => $currentTab === 'Misc' ? true : false,
                        'options' => ['id' => 'Misc'],                                           
                    ],
                  
                ],
            ]);
        ?>        
</div>


<div class="form-group text-center">
    <?= Html::submitInput('Save', ['class' => 'btn btn-primary', 'value' => 'Profile']) ?>
</div>

<?php ActiveForm::end(); ?>



