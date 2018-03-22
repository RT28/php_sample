<?php

use yii\helpers\Html; 
use yii\widgets\ActiveForm;

$this->title = 'Create Credentials';
$this->params['breadcrumbs'][] = ['label' => 'University', 'url' =>['create']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="create-university col-xs-12 ">
    <div class="row">
        <h1><?= Html::encode($this->title) ?> </h1>

			<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>

        
		<?php $form = ActiveForm::begin(['id' => 'university-registration-form']) ?>


<div class="row">
   <div class="col-xs-12 col-sm-6">
      <div class="panel panel-default">
	<div class="panel-heading">Create Your Credentials</div>
         <div class="panel-body">
            <?= $form->field($PartnerSignup, 'username')->textInput(['maxlength' => true ]) ?>
           
			<?= $form->field($PartnerSignup, 'password')->textInput(['type' => 'password' ]) ?>
			
			<?= $form->field($PartnerSignup, 'confirm_password')->textInput(['type' => 'password' ]) ?>
			
			 <?= $form->field($PartnerSignup, 'agree')->checkbox(['label'=>'I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Use and Policy</a>'], true)->label(''); ?>
			
         </div>
      </div>
   </div>
 
          
		   </div>
		  </div>
 
    <div class="form-group">
        <?= Html::submitButton('Create Login', ['class' =>  'btn btn-primary', 'id' => 'btn-create' ]) ?>
    </div>
<?php ActiveForm::end(); ?>

    </div>
</div>


<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> 
  </div>
</div>