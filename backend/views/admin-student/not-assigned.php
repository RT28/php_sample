<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SRM */

//$this->title = 'SRM details';
//$this->params['breadcrumbs'][] = ['label' => 'Srms', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';

?>

<div class="srm-view">
    <h3><?php echo $text[0];?></h3>
    <h1><?= Html::encode($this->title) ?></h1>
    <br><br>
    <h3 style="color:red;"><?php echo $text[1];?></h3>
</div>
