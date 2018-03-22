<?php
use yii\helpers\Url;
use yii\helpers\Html;

use yii\helpers\Json;
use frontend\models\Favorites;
use common\models\University;
use common\models\Student;
use common\models\Degree;
use common\models\UniversityCourseList;
use yii\helpers\FileHelper;
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use common\components\ConnectionSettings;
use common\models\UniversityGallery;

$this->title = $model->name;
$this->context->layout = 'main';

$path= ConnectionSettings::BASE_URL.'partner/';

?>

<h2 class="uni-name"> <?= $model->name ?> FAQs </h2>
  <div class="faq-section">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php $i=0; foreach ($univinfocategory as $categorySingle)  {?>
                <div class="tab-pane" >
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>" onclick="get_faqList('<?php echo $categorySingle['slag']; ?>');">
                          <?php echo $categorySingle['category']; ?>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?php echo $categorySingle['slag']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                      <div class="panel-body">
                      <?php echo nl2br($model->info_for_consultant); ?>
                      </div>
                    </div>
                  </div>
                </div>  
                <?php $i++ ;} ?>  

              </div>
</div>
   
<script type="text/javascript">
  function get_faqList(id){
    $('.tab-view').hide();
    $('.tab-'+id).show();
    $('.collapse').hide();
    $('#collapse'+id).show();
  }
</script>

