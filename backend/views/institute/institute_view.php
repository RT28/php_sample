<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\StandardTests;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Json;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Institute */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Institutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/institute.js');
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');

$state_data = [];
 if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
   $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
   $model_tests = explode(',', $model->tests_offered);
   $tests_offered = [];
   foreach ($model_tests as $key => $value) {
    array_push($tests_offered , $tests[$value]);
   }
   

?>

<style type="text/css">
ul.tab {
    list-style-type: none;
    margin-right: 0px;
    padding: 0;
    overflow: hidden;
   
}
ul.tab li {float: left;}


ul.tab li a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
    position: relative;
    display: block;
    padding: 10px 15px;
}
/*ul.tab li a {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 14px;

}*/

ul.tab li a:hover {background-color: #ddd;cursor: pointer;}

/* Create an active/current tablink class */
ul.tab li a:focus, .active {background-color: #ccc;}

.tabcontent {
    display: none;
    padding: 6px 12px;
    
}

#Profile{
    display: block;
}
</style>
<script type="text/javascript">
    function openTab(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";

}
</script>

<div class="institute-form">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
                <h1><?= Html::encode($this->title) ?></h1>

                <p>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>
 <ul class="tab">
                  <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'Profile')">Profile</a></li>

                  <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'About')">About</a>
                  </li>

                  <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'Services')">Services</a>
                  </li>

                  <li><a class="tablinks " style="margin:0px;" onclick="openTab(event, 'Branches')">Branches</a>
                  </li>

                 <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'Misc')">Misc</a></li>
                      

                </ul>
    <?php $form = ActiveForm::begin(); ?>
     <div id="Profile" class="tabcontent">
         <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Name & Adress</div>
                        <div class="panel-body">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

                            <?= $form->field($model, 'adress')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

                            <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country','disabled' => true,])->label('Country');  ?>

                            <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
                                                 'options' => ['id' => 'state_id'],
                                                 'data' => $state_data,
                                                 'type' => DepDrop::TYPE_SELECT2,
                                                 'disabled' => true,
                                                 'pluginOptions' => [
                                                     'depends' => ['country_id'],
                                                     'placeholder' => 'Select State',
                                                     'url' => Url::to(['/university/dependent-states'])
                                                 ]
                                                 ])->label('State'); ?>

                            <?= $form->field($model, 'city_id')->textInput(['maxlength' => true, 'readonly'=>true]) ?>
                </div>
          </div>
       </div>

       <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
             <div class="panel-heading">Contact</div>
             <div class="panel-body">

                            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

                            <?= $form->field($model, 'contact_details')->textInput(['readonly'=>true]) ?>

                            <?= $form->field($model, 'contact_person')->textInput(['readonly'=>true]) ?>

                            <?= $form->field($model, 'contact_person_designation')->textInput(['readonly'=>true]) ?>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="About" class="tabcontent">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
        <?= Html::activeLabel($model, 'description'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->description);
        echo '<br><br>';
        ?>
        </div>
    </div>
    </div>

    <div id="Services" class="tabcontent">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Services and Fees structure</div>
                        <div class="panel-body">
                             <?= Html::activeLabel($model, 'tests_offered'); ?>

                                       <?php 
                                        echo '<br>';
                                         print_r(implode(',',$tests_offered)); 
                                         echo '<br></br>';
                                       ?>

                           <?= Html::hiddenInput('fees_structure', $model->fees_structure, ['id' => 'fees_structure']); ?>
                            <?php
                                $fees = [];        
                                $fees = Json::decode($model->fees_structure);

                                if(!is_array($fees)){
                                    $fees = [];
                                }
                                $i = 0;     
                            ?>
            
                            <table class="table table-bordered" id="fees-structure">
                                <tr>
                                    <th>Course</th>
                                    <th>Fees</th>
                                    <th>Duration</th>
                                </tr>
                                <?php foreach ($fees as $fee): ?>
                                    <tr data-index="<?= $i++; ?>">
                                        <td><?= $fee['course'] ?></td>
                                        <td><?= $fee['fees'] ?></td>
                                        <td><?= $fee['duration'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div id="Branches" class="tabcontent"> 
           <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Branches</div>
                        <div class="panel-body">
                            <?php 
                            echo '<br><br>';
                            echo  strip_tags($model->branches);
                            echo '<br><br>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div id="Misc" class="tabcontent"> 
            <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Misc</div>
                        <div class="panel-body">

                            <?= $form->field($model, 'video_url')->textInput(['maxlength' => true,'readonly'=>true]);?>

                            <?= $form->field($model, 'website')->textInput(['maxlength' => true,'readonly'=>true]) ?>

                           
                        </div>
                    </div>
                </div>
            </div>
    </div>

        
        </div>
     
    
    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
