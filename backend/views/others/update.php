<?php
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Json;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use common\models\Others;
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
$this->registerJsFile('@web/js/others.js');
$this->context->layout = 'admin-dashboard-sidebar';
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

/* Float the list items side by side */
ul.tab li {float: left;}

/* Style the links inside the list items */
ul.tab li a {
    display: inline-block;
    color: black;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    transition: 0.3s;
    font-size: 14px;

}

/* Change background color of links on hover */
ul.tab li a:hover {background-color: #ddd;cursor: pointer;}

/* Create an active/current tablink class */
ul.tab li a:focus, .active {background-color: #ccc;}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    
}

#ct{
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
  <ul class="tab">
                  <li><a class="tablinks active" style="margin:0px;" onclick="openTab(event, 'ct')">Course Types</a></li>
                  <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'est');">Establishment</a></li>
                  <li><a class="tablinks" style="margin:0px;" onclick="openTab(event, 'inst')">Institution</a></li>
   </ul>
 <tr>
<div id="ct" class="tabcontent">
 <div class="panel panel-default">
  <div class="panel-heading">Course Type</div>
    <div class="panel-body">
       <button type="button" class="btn btn-primary " onclick="openTab(event, 'est');>
                            Update
                        </button> 
      <div class="row">
            <div class="modal-body"> 
            <form method="post" enctype="multipart/form-data" id="trnscrpts">
                <table class="table table-bordered" id="course-form">
                    <tbody>
                        <tr>
                            <th>Course Type</th>
                            <!--<th>Delete Course Type</th>-->
                        </tr>
                        <?php                            
                             $i = 0;
                             $course = 'course_type';
                              foreach($model as $coursetype) {
                                        echo '<tr data-index="'.$i.'">';
                                            echo '<td><input class="course_type" name="test-'.$i.'" value="' .$model[$i]. '"/></td>';
                                           // echo '<td><button data-index="'.$i.'" class="btn btn-danger" onclick="onDeleteCourseButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                        ?>                    
                    </tbody>
                </table>
               <!-- <button type="button" class="btn btn-success" onclick="onAddClick('course_type','course-form','onDeleteCourseButtonClick(this)')"><span class="glyphicon glyphicon-plus"></button>-->
            </form>
      </div>
       <div class="modal-footer">
      <!-- <button type="button" class="btn btn-primary" onclick="onSaveChangesClick('course_type')">Save Changes</button>-->
      </div>
     </div>
    </div>
  </div>
</div>
<div id="ctupdate" class="tabcontent">
 <div class="panel panel-default">
  <div class="panel-heading">Course Type</div>
    <div class="panel-body">
      <div class="row">
            <div class="modal-body"> 
            <form method="post" enctype="multipart/form-data" id="trnscrpts">
                <table class="table table-bordered" id="course-form">
                    <tbody>
                        <tr>
                            <th>Course Type</th>
                            <th>Delete Course Type</th>
                        </tr>
                        <?php                            
                             $i = 0;
                             $course = 'course_type';
                              foreach($model as $coursetype) {
                                        echo '<tr data-index="'.$i.'">';
                                            echo '<td><input class="course_type" name="test-'.$i.'" value="' .$model[$i]. '"/></td>';
                                            echo '<td><button data-index="'.$i.'" class="btn btn-danger" onclick="onDeleteCourseButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                        ?>                    
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddClick('course_type','course-form','onDeleteCourseButtonClick(this)')"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="onSaveChangesClick('course_type')">Save Changes</button>
      </div>
     </div>
    </div>
  </div>
</div>

<div id="est" class="tabcontent">
  <div class="panel panel-default">
  <div class="panel-heading">Establishments</div>
    <div class="panel-body">
      <div class="row">
            <div class="modal-body"> 
            <form method="post" enctype="multipart/form-data" id="establish">
               <?php /*<input type="hidden" name="student_id" value="<?= $model->value ?>" />*/ ?>
                <table class="table table-bordered" id="establishments-form">
                    <tbody>
                        <tr>
                            <th>Establishment</th>
                            <th>Delete Estabishment Type</th>
                        </tr>
                        <?php                            
                             $i = 0;
                             $est = Others::find()->where(['name'=>'establishment'])->one();
                             $estvalue = explode(',', $est->value); 
                          
                            foreach($estvalue as $establish) {
                                        echo '<tr data-index="'.$i.'">';
                                            echo '<td><input class="establishment" name="test-'.$i.'" value="' .$estvalue[$i]. '"/></td>';
                                            echo '<td><button data-index="'.$i.'" class="btn btn-danger" onclick="onDeleteEstablishmentButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                        ?>                    
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddClick('establishment','establishments-form','onDeleteEstablishmentButtonClick(this)')"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="onSaveChangesClick('establishment')">Save Changes</button>
      </div>
    </div>
  </div>
</div>
</div>
<div id="inst" class="tabcontent">
  <div class="panel panel-default">
    <div class="panel-heading">Institution</div>
      <div class="panel-body">
      <div class="row">
            <div class="modal-body"> 
            <form method="post" enctype="multipart/form-data" id="institute">
               <?php /*<input type="hidden" name="student_id" value="<?= $model->value ?>" /> */?>
                <table class="table table-bordered" id="institution-form">
                    <tbody>
                        <tr>
                            <th>Institution</th>
                            <th>Delete Institution Type</th>
                        </tr>
                        <?php                            
                             $i = 0;
                             $inst = Others::find()->where(['name'=>'institution_type'])->one();
                             $instvalue = explode(',', $inst->value); 
                          
                            foreach($instvalue as $institute) {
                                        echo '<tr data-index="'.$i.'">';
                                            echo '<td><input class="institution_type" name="test-'.$i.'" value="' .$instvalue[$i]. '"/></td>';
                                            echo '<td><button data-index="'.$i.'" class="btn btn-danger" onclick="onDeleteInstitutionButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                        ?>                    
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddClick('institution_type','institution-form','onDeleteInstitutionButtonClick(this)')"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="onSaveChangesClick('institution_type')">Save Changes</button>
      </div>
    </div>
  </div>
      </div>
      
   
</div>