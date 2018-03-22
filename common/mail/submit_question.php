<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
/* @var $form yii\widgets\ActiveForm */

?>
<div>
	Hi,<br><br>
	We would like to get clarification from you for the following question.

</div><br><br>
<div>
Question : <?= $model->question?>
</div>
<br/> <br/> 
Please click on the following link to reply for the question
<a href="<?= $link; ?>">reply</a>
Thank You,