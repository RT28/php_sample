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
$this->registerJsFile('@web/js/institute.js');
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');

$state_data = [];
 if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
   $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');

   

?>

<style type="text/css">
ul.tab {
    list-style-type: none;
    margin-right: 0px;
    padding: 0;
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}
ul.tab li {float: left;}

ul.tab li a {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 14px;

}

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
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country'])->label('Country');  ?>

                            <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
                                                 'options' => ['id' => 'state_id'],
                                                 'data' => $state_data,
                                                 'type' => DepDrop::TYPE_SELECT2,
                                                 'pluginOptions' => [
                                                     'depends' => ['country_id'],
                                                     'placeholder' => 'Select State',
                                                     'url' => Url::to(['/university/dependent-states'])
                                                 ]
                                                 ])->label('State'); ?>

                            <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>
                </div>
          </div>
       </div>

       <div class="col-xs-12 col-sm-6">
          <div class="panel panel-default">
             <div class="panel-heading">Contact</div>
             <div class="panel-body">

                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'contact_details')->textInput() ?>

                            <?= $form->field($model, 'contact_person')->textInput() ?>

                            <?= $form->field($model, 'contact_person_designation')->textInput() ?>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="About" class="tabcontent">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
        </div>
    </div>
    </div>

    <div id="Services" class="tabcontent">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Services and Fees structure</div>
                        <div class="panel-body">
                             <?= $form->field($model, 'tests_offered')->widget(Select2::classname(), [
                                            'name' => 'color_2',                    
                                            'data' => $tests ,
                                            'maintainOrder' => true,
                                            'options' => ['placeholder' => 'Select a test ...', 'multiple' => true],
                                            'pluginOptions' => [
                                                'tags' => true                     
                                            ]
                                        ]) ?> 

                           <?= Html::hiddenInput('fees_structure', $model->fees_structure, ['id' => 'fees_structure']); ?>
                            <?php
                                $fees = [];        
                                $fees = Json::decode($model->fees_structure);

                                if(!is_array($fees)){
                                    $fees = [];
                                }
                                $i = 0;     
                            ?>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_fees">
                                Update
                            </button>             
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

                            <?= $form->field($model, 'branches')->widget(CKEditor::className(), [
                                'options' => ['rows' => 10],
                                'preset' => 'basic'
                            ]) ?>
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

                            <?= $form->field($model, 'video_url')->textInput(['maxlength' => true]);?>

                            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

        
        </div>
     
    
    <?php ActiveForm::end(); ?>

</div>
<div class="modal fade" id="update_fees" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog rankings-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Fees Structure</h4>
      </div>
      <div class="modal-body">
            <table class="table table-bordered" id="fees-structure-form">
                <tbody>
                    <tr>
                        <th>Course</th>
                        <th>Fees</th>
                        <th>Duration</th>
                        <th></th>
                    </tr>
                    <?php
                        $i = 0;
                    ?>
                    <?php foreach ($fees as $fee): ?>
                        <tr data-index="<?= $i; ?>">
                            <td><input id="course-<?= $i; ?>" value="<?= $fee['course'] ?>"/></td>
                            <td><input id="fees-<?= $i; ?>" value="<?= $fee['fees'] ?>"/></td>
                            <td><input id="duration-<?= $i; ?>" value="<?= $fee['duration'] ?>"/></td>
                            <td><button data-index="<?= $i++; ?>" class="btn btn-danger" onclick="onDeleteRankingButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-success" onclick="onAddRankingButtonClick(this)"><span class="glyphicon glyphicon-plus"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
        <button type="button" class="btn btn-primary" onclick="onSaveChangesClick(this)">Save changes</button>
      </div>
    </div>
  </div>
</div>