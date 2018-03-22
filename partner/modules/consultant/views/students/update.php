<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\Commondata; 

if(isset($layout)) {
    $this->context->layout = $layout;
}

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = 'Update Student Profile';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
 
    <h1><?= Html::encode($this->title) ?></h1>

<?php  
$id = Commondata::encrypt_decrypt('encrypt', $model->id); 
if(!$model->isNewRecord) {
echo Html::a('View', Url::to(['students/view', 'id' => $id]), ['class'=>'btn btn-primary']); 
}
?>

    <?= $this->render('_form', [
        'model' => $model,
        'countries' => $countries,
        'upload' => $upload
    ]) ?>
 
