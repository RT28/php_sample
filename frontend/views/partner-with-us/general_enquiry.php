<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;  
use kartik\select2\Select2; 
use common\models\Country;
$codelist = Country::getAllCountriesPhoneCode(); 

$this->title = 'General  Enquiry';
$this->context->layout = 'index';
?>
<div class="section-padding">
<div class="site-signup container">

<div class="row">
 <div class="group-title-index">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
        <div class="col-xs-12"> 

 			<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>


<div class="row">
<div class="col-sm-6">
 <br>
    <?php $form = ActiveForm::begin( ); ?>


    <?= $form->field($model, 'name')->textInput(['placeHolder'=>'Name *'])->label(false); ?>

    <?= $form->field($model, 'email')->textInput(['placeHolder'=>'Email *'])->label(false); ?>
	
	<div class="row"> 
<div class="col-sm-6 pad-right-0">
	<?= $form->field($model, 'code')->widget(Select2::classname(), [
			'name' => 'codelist',
			'data' => $codelist,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
			'pluginOptions' => [
				'tags' => true,
			]
		])->label(false) ?> </div>
		<div class="col-sm-6 pad-left-0">
    <?= $form->field($model, 'phone')->textInput(['placeHolder'=>'Phone *'])->label(false); ?>  
	 </div> 
</div>
<div class="row">
<div class="col-sm-12">
    <?= $form->field($model, 'message')->textarea(['placeHolder'=>'Message *', 'rows' => 6])->label(false); ?>
 </div> 
</div>
<div class="row">
<div class="col-sm-12">  
<?= $form->field($model, 'agree')->checkbox(['label'=>'I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Use and Policy</a>'], true)->label(''); ?> 
</div> 
</div>
<div class="row">
<div class="col-sm-12 text-right">
  <?= Html::submitButton('Submit', ['id' => 'Submit','class' => 'btn btn-blue']) ?>
</div>
</div> 
</div>
</div>
    <?php ActiveForm::end(); ?>
 
</div>
</div>
</div>
</div>
<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> 
  </div>
</div>
