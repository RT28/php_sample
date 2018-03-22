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
<div class="student-view">
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
    <div class="row">
        <div class="col-xs-12 col-sm-4">
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
        <div class="col-xs-12 col-sm-8">
            <div class="row">
                <div class="row border">
                    <h2><?= $model->first_name . ' ' , $model->last_name ?></h2>
                    <p>Nationality: <?= $model->nationality ?></p>
                </div>
                <div class="row border">
                    <span>Wants to study:</span>
                    <span>
                        <?= $majors ?>
                    </span>
                </div>
                <div class="row border">
                    <span>In:</span>
                    <span>
                        <?= $countries ?>
                    </span>
                </div>                
            </div>
        </div>
    </div>   

  <div class="row">
        <div class="col-xs-12 col-sm-6 border">
            <label>Email:</label>
            <span><?=  $model->email ?> </span> 
        </div>
		<div class="col-xs-12 col-sm-6 border">
            <label>Father :</label>
            <span><?=  $model->father_name ?> </span> 
        </div>
		
        <div class="col-xs-12 col-sm-6 border">
            <label>Father Email:</label>
            <span><?=  $model->father_email ?> </span> 
        </div>
		
		<div class="col-xs-12 col-sm-6 border">
            <label>Mother :</label>
            <span><?=  $model->mother_name ?> </span> 
        </div>
		<div class="col-xs-12 col-sm-6 border">
            <label>Mother Email:</label>
            <span><?=  $model->mother_email ?> </span> 
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 border">
            <label>Phone:</label>
            <span>+<?=  $model->code.$model->phone ?> </span> 
        </div>

        <div class="col-xs-12 col-sm-6 border">
            <label>Father Phone:</label>
            <span>+<?=  $model->father_phonecode.$model->father_phone ?> </span> 
        </div>
		 <div class="col-xs-12 col-sm-6 border">
            <label>Mother Phone:</label>
            <span>+<?=  $model->mother_phonecode.$model->mother_phone ?> </span> 
        </div>
    </div>

    <div class="row border">
        <h3>Residential Address</h3>
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

    <div class="row border">
        <h3>Permanent Address</h3>
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
</div>
