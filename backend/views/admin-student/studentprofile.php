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

                        if($model->student->status == 0){
                            echo Html::button('Enable', ['id'=> $model->id,'class' => 'btn btn-success','onclick'=>'enable('.$model->id.');']);
                        }else{
                             echo Html::button('Disable',['id'=> $model->id,'class' => 'btn btn-danger', 
                            'onclick'=>'disable('.$model->id.');']);
                        }
                        echo '<br><br>';
?>
<div class="student-view">
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <?php
                $cover_photo_path = [];
                $user = $model->student->id;
                if(is_dir("./../../frontend/web/uploads/$user/profile_photo")) {
                    $cover_photo_path = FileHelper::findFiles("./../../frontend/web/uploads/$user/profile_photo", [
                        'caseSensitive' => true,
                        'recursive' => false,
                        'only' => ['profile_photo.*']
                    ]);
                }
                if (count($cover_photo_path) > 0) {
                    echo Html::img($cover_photo_path[0], ['alt' => $model->first_name , 'class' => 'cover-photo', 'width' => "262" ,'height'=> "197"]);
                }
                else {
                    echo Html::img("./../../frontend/web/noprofile.gif", ['alt' => $model->first_name , 'class' => 'cover-photo']);
                }
            ?>
        </div>
        <div class="col-xs-12 col-sm-8">
            <div class="row">
                <div class="row border">
                    <h2><?= '<nsp><nsp><nsp><nsp><nsp>'.$model->first_name . ' ' , $model->last_name ?></h2>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
  function disable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=admin-student/disable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Enable").removeClass('btn-primary btn-danger') .addClass("btn-primary btn-success");
                        $("#"+id).attr("onclick","enable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }

   function enable(id){
    var data = {'id': id };
             $.ajax({  
                        type: "GET",
                        url: "index.php?r=admin-student/enable",
                        data : data,
                        success: function(data){ 
                        $("#"+id).text("Disable").removeClass('btn-primary btn-success') .addClass("btn-primary btn-danger");
                        $("#"+id).attr("onclick","disable(id)");
                        },
                         error: function(status , message){ 
                        alert(message);
                        },

                    });
  }

</script>