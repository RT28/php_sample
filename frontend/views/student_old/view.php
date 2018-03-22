<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use common\models\Country;
use common\models\Majors;
use yii\helpers\ArrayHelper;
use common\components\Commondata; 

/* @var $this yii\web\View */
/* @var $model common\models\Student */


$this->title = 'Profile';
$this->context->layout = 'profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$AllCountries = Country::getAllCountries();
$AllCountries = ArrayHelper::map($AllCountries, 'id', 'name');
$phonetype = Commondata::phonetype();
$proficiency = Commondata::getProficiency();	
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

    $cover_photo_path = [];
    $src = './noprofile.gif';
    $user = $model->student->id;
    if(is_dir("./../web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);
    }
    if (count($cover_photo_path) > 0) {
        $src = $cover_photo_path[0];
    }
?>


<div class="student-profile-main">
    <?= $this->render('_student_common_details');
    ?>
    <div class="dashboard-detail">
        <div class="tab-content">
            <!-- PROFILE TAB -->
            <div role="tabpanel" class="tab-pane fade in active" id="d1">
                <div class="row" id="tab-profile">
                    <div class="col-sm-12">
                        <div class="basic-details">
                            <div class="row">
                                <div class="col-sm-6">
                                <h3>Basic Address</h3>
<p><strong>Nationality:</strong> <?php if($model->nationality){ echo $AllCountries[$model->nationality]; } ?></p>
<p><strong>Wants to study:</strong> <?= $majors ?> </p>
<p><strong>In:</strong> <?= $countries ?> </p>
<p><strong>Language Proficiency:</strong> <?php if(isset($model->language_proficiency)) { echo $proficiency[$model->language_proficiency]; }?></p>

<p><strong>Phone:</strong> +<?=  $model->code.$model->phone ?></p> 
<p><strong>Email:</strong> <?=  $model->email ?></p>




  
                                </div>
								 <div class="col-sm-6">
								 <h3>&nbsp;</h3>
                                <div class="col-sm-8">
                                    <?php
                                        $url = '?r=student/update&id=' . $model->id;
										$changepassword = '?r=student/changepassword';
                                    ?>
									<a class="btn btn-primary btn-blue  pull-left" href="<?= $changepassword; ?>" data-container="tab-profile">Change Password</a>
                              
									</div>
									 <div class="col-sm-4">
									
                                    <a class="btn btn-primary btn-blue btn-update pull-right" href="<?= $url; ?>" data-container="tab-profile">UPDATE</a>
                                </div>
                            </div>
                            
							</div>
							<div class="row">
							<div class="col-sm-6"> 
<h3>Father Details</h3>
<p><strong>Father Name:</strong> <?=  $model->father_name ?></p>  
<p><strong>Father Phone:</strong> +<?=  $model->father_phonecode.$model->father_phone ?></p> 
<p><strong>Father Email:</strong> <?=  $model->father_email ?></p>

</div>
<div class="col-sm-6"> 
<h3>Mother Details</h3>
<p><strong>Name:</strong> <?=  $model->mother_name ?></p>  
<p><strong>Phone:</strong> +<?=  $model->mother_phonecode.$model->mother_phone ?></p> 
<p><strong>Email:</strong> <?=  $model->mother_email ?></p> 
</div>
</div>
							
                        </div>
						<div class="row">
                                <div class="col-sm-6">
                            <div class="address">
                                <h3>Residential Address</h3>
                                <p><strong>Address:</strong> <?=  $model->address ?> </p>
                                <p><strong>Street:</strong> <?=  $model->street ?> </p>
                                <p><strong>City:</strong> <?=  $model->city ?> </p>
                                <p><strong>State:</strong> <?php  if(!empty($model->state0->name)){ echo $model->state0->name ; } ?> </p>
                                <p><strong>Country:</strong> <?=  $model->country0->name ?> </p>
                            </div>
                            </div>
                                <div class="col-sm-6">
                            <div class="address">
                                <h3>Permanent Address</h3>
                                <p><strong>Address:</strong> <?=  $model->address ?> </p>
                                <p><strong>Street:</strong> <?=  $model->street ?> </p>
                                <p><strong>City:</strong> <?=  $model->city ?> </p>
                                <p><strong>State:</strong> <?php  if(!empty($model->state0->name)){ echo $model->state0->name ; } ?> </p>
                                <p><strong>Country:</strong> <?=  $model->country0->name ?> </p>
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
</div>
<?php
    $this->registerJsFile('js/student.js');
?>
