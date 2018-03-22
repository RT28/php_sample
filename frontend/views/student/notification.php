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


$this->title = 'Notifications';
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
                <div id="tab-profile">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="">
                        <h6 class="dashboard-small-heading">New Notifications (<?= $un_count; ?>)</h6> 
                        <?php foreach($unreadNotifications as $unread) { ?>
                        <p><span></span><?= $unread['message']; ?> on <?= date('d-M-Y', strtotime($unread['created_at'])); ?></p>
                        <?php } ?> 

                        <h6 class="dashboard-small-heading">Older Notifications (<?= $rd_count; ?>)</h6> 
                        <?php foreach($readNotifications as $read) { ?>
                        <p><span></span><?= $read['message']; ?> on <?= date('d-M-Y', strtotime($read['created_at'])); ?></p>
                        <?php } ?> 

                        </div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){ 
    fnUpdateNotification();
});
function fnUpdateNotification() { 
    $.ajax({
            url: 'updatenotification',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
                
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
</script>
<?php
    $this->registerJsFile('js/student.js');
?>

