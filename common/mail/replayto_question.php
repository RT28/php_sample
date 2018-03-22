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
	University has replied to your question.

</div><br><br>
<div>
Question : <?= $model->question?>
</div>
<br/> 
<div>
Answer : <?= $model->answer?>
</div><br><br>
Thank You,