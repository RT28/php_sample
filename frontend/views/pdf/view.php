<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Country;
use common\models\Majors;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Profile';
$this->context->layout = 'profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
    $majors = "";
    $countries = "";
    $smodel = Yii::$app->user->identity;
    $schools = $smodel->studentSchoolDetails;
    $colleges = $smodel->studentCollegeDetails;
    $subjects = $smodel->studentSubjectDetails;
    $englishProficiency = $smodel->studentEnglishLanguageProficienceyDetails;
    $standardTests = $smodel->studentStandardTestDetails;

    if(!empty($model->student->country_preference))
    {          
        $temp = $model->student->country_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);            
        } else {
            $arr[] = $temp;
        }
        $arr = Country::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $country) {
            $countries .= $country['name'] . ', ';
        }
    }

    if(!empty($model->student->majors_preference))
    {
        $temp = $model->student->majors_preference;
        if (strpos($temp, ',')) {
            $arr = explode(',', $temp);
        } else {
            $arr[] = $temp;
        }
        $arr = Majors::find()->select('name')
                              ->where(['in', 'id', $arr])
                              ->asArray()
                              ->all();
        
        foreach($arr as $major) {
            $majors .= $major['name'] . ', ';
        }
    }
?>
<html>
<head>
 <meta charset="utf-8">
<!--<style>
h1 {
    color: blue;
    font-family: verdana;
    font-size: 300%;
}
td  {
    border: 1px solid black;
}
table {
     width: 100%;
}
col-xs-12{
    width:30px;
}
</style>-->
</head>
<body>
<div class="student-view">
    <div class="row border">
        <div class="col-xs-4 col-sm-4">
            <?php
                $cover_photo_path = [];
                $user = $model->student->id;
                if(is_dir("./../web/uploads/$user/profile_photo")) {
                    $cover_photo_path = FileHelper::findFiles("./../web/uploads/$user/profile_photo", [
                        'caseSensitive' => true,
                        'recursive' => false,
                        'only' => ['profile_photo.*']
                    ]);
                }
                if (count($cover_photo_path) > 0) {
                    echo Html::img($cover_photo_path[0], ['alt' => $model->first_name , 'class' => 'cover-photo']);
                }
                else {
                    echo Html::img("./../web/noprofile.gif", ['alt' => $model->first_name , 'class' => 'cover-photo']);
                }
            ?>
        </div>
        <div class="col-xs-2"></div>
        <div class="col-xs-6 col-sm-8 push-xs-1">
            <div class="row">
                <div class="row">
                    <h2><?= $model->first_name . ' ' , $model->last_name ?></h2>
                    <p>&nbsp;&nbsp;&nbsp;Nationality: <?= $model->nationality ?></p>
                </div>
                <div class="row">
                    <span>&nbsp;&nbsp;&nbsp;Wants to study:</span>
                    <span>&nbsp;
                        <?= $majors ?>
                    </span>
                </div>
                <div class="row">
                    <span>&nbsp;&nbsp;&nbsp;In:</span>
                    <span>&nbsp;
                        <?= $countries ?>
                    </span>
                </div>                
            </div>
        </div>
    </div>   

    <div class="row">
        <div class="col-xs-5 col-sm-8 border" style="width:44.2%">
            <label>Email:</label>
            <span><?=  $model->email ?> </span> 
        </div>

        <div class="col-xs-5 col-sm-8 border" style="width:46.6%">
            <label>Parent Email:</label>
            <span><?=  $model->father_email ?> </span> 
        </div>
    </div>

    <div class="row">
        <div class="col-xs-5 col-sm-12 border" style="width:44.2%">
            <label>Phone:</label>
            <span><?=  $model->phone ?> </span> 
        </div>

        <div class="col-xs-5 col-sm-12 border" style="width:46.6%">
            <label>Parent Phone:</label>
            <span><?=  $model->father_phone ?> </span> 
        </div>
    </div>

    <div class="row border">
        <h3>&nbsp;&nbsp;Residential Address</h3>
        <div class="col-xs-6">
            <label>Address:</label>
            <span><?=  $model->address ?> </span> 
        </div>
        <div class="col-xs-6">
            <label>Street:</label>
            <span><?=  $model->street ?> </span> 
        </div>
        <div class="col-xs-6">
            <label>City:</label>
            <span><?=  $model->city ?> </span> 
        </div>
        <div class="col-xs-6">
            <label>State:</label>
            <span><?=  $model->state0->name ?> </span> 
        </div>

        <div class="col-xs-6">
            <label>Country:</label>
            <span><?=  $model->country0->name ?> </span> 
        </div>
    </div>

    <div class="row border">
        <h3>&nbsp;&nbsp;Permanent Address</h3>
        <div class="col-xs-12">
            <label>Address:</label>
            <span><?=  $model->address ?> </span> 
        </div>
        <div class="col-xs-12">
            <label>Street:</label>
            <span><?=  $model->street ?> </span> 
        </div>
        <div class="col-xs-12">
            <label>City:</label>
            <span><?=  $model->city ?> </span> 
        </div>
        <div class="col-xs-12">
            <label>State:</label>
            <span><?=  $model->state0->name ?> </span> 
        </div>

        <div class="col-xs-12">
            <label>Country:</label>
            <span><?=  $model->country0->name ?> </span> 
        </div>
    </div>

<h3>School Details </h3>
    <table class="table table-bordered">
        <tr>
            <td>Name</td>
            <td>From Date</td>
            <td>To Date</td>
            <td>Curriculum</td>
        </tr>
        <?php foreach ($schools as $school): ?>
            <tr>
                <td><?= $school->name ?></td>
                <td><?= $school->from_date ?></td>            
                <td><?= $school->to_date ?></td>
                <td><?= $school->curriculum ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<h3>College Details </h3>
    <table class="table table-bordered">
        <tr>
            <td>Name</td>
            <td>From Date</td>
            <td>To Date</td>
            <td>Major</td>
        </tr>
        <?php foreach ($colleges as $college): ?>
            <tr>
                <tr>
                <td><?= $college->name ?></td>
                <td><?= $college->from_date ?></td>            
                <td><?= $college->to_date ?></td>
                <td><?= $college->curriculum ?></td>
            </tr>
            </tr>
        <?php endforeach; ?>
    </table>

 <h3>Subject Details </h3>
    <table class="table table-bordered">
        <tr>
            <td>Name</td>
            <td>Marks Obtained</td>
            <td>Maximum Marks</td>
        </tr>
        <?= Html::a('Update', ['update-subject-details'], ['class' => 'btn btn-primary']) ?>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?= $subject->name ?></td>
                <td><?= $subject->marks_obtained ?></td>            
                <td><?= $subject->maximum_marks ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

 <h3>English Language Proficiency</h3>
    <table class="table table-bordered">
        <tr>
            <td>Name</th>
            <td>Reading</th>
            <td>Writing</th>
            <td>Listening</th>
            <td>Speaking</th>        
        </tr>
        <?= Html::a('Update', ['update-english-proficiency'], ['class' => 'btn btn-primary']) ?>
        <?php foreach ($englishProficiency as $test): ?>
            <tr>
                <td><?= $test->test_name ?></td>
                <td><?= $test->reading_score ?></td>            
                <td><?= $test->writing_score ?></td>
                <td><?= $test->listening_score ?></td>
                <td><?= $test->speaking_score ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

 <h3>Standard Test Details </h3>
    <table class="table table-bordered">
        <tr>
            <td>Name</th>
            <td>Verbal</th>
            <td>Quantitative</th>
            <td>IR</th>
            <td>DI</th>        
        </tr>
        <?= Html::a('Update', ['update-standard-tests'], ['class' => 'btn btn-primary']) ?>
        <?php foreach ($standardTests as $test): ?>
            <tr>
                <td><?= $test->test_name ?></td>
                <td><?= $test->verbal_score ?></td>            
                <td><?= $test->quantitative_score ?></td>
                <td><?= $test->integrated_reasoning_score ?></td>
                <td><?= $test->data_interpretation_score ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

