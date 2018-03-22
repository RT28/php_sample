<?php
    use yii\helpers\Html;
    use kartik\date\DatePicker;
    use kartik\depdrop\DepDrop;
    use yii\helpers\Url;
    use yii\helpers\FileHelper;
    use kartik\file\FileInput;
    use dosamigos\ckeditor\CKEditor;
    $this->context->layout = 'admin-dashboard-sidebar';
?>

<?php    
    $city_data = [];
    $state_data = [];
    if (isset($model->city_id)) {
        $city_data = [$model->city_id => $model->city->name];
    }

    if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
    
?>

<div class="row">
   <div class="col-xs-12 col-sm-6">
      <div class="panel panel-default">
         <div class="panel-heading">Name &amp; Address</div>
         <div class="panel-body">
        
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'university-name','readonly' => true]) ?>
            <div class="row">
               <div class="col-xs-12 col-sm-3">
                  <?= $form->field($model, 'establishment_date')->textInput(['type' => 'number','readonly' => true])?>
               </div>
               <div class="col-xs-12 col-sm-3">                        
                  <?= $form->field($model, 'institution_type')->dropDownList($institutionType, ['id' => 'institution_type','readonly' => true]); ?>
               </div>
               <div class="col-xs-12 col-sm-3">                        
                  <?= $form->field($model, 'establishment')->dropDownList($establishment, ['id' => 'establishment','readonly' => true]); ?>
               </div>
			   <div class="col-xs-12 col-sm-3">
                    <?= $form->field($model, 'is_partner')->checkbox() ?>
					<?= $form->field($model, 'is_active')->checkbox() ?>
               </div>
            </div>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'id' => 'univesity-address','readonly' => true]) ?>
            <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','disabled' => true]); ?>
            <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'state_id'],
               'disabled' => true,
               'data' => $state_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['country_id'],
                   'placeholder' => 'Select State',
                   'url' => Url::to(['/university/dependent-states'])
               ]
               ]); ?>
            <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'city_id'],
               'disabled' => true,
               'data' => $city_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['country_id', 'state_id'],
                   'placeholder' => 'Select City',
                   'url' => Url::to(['/university/dependent-cities'])
               ]
               ]); ?>
            <?= $form->field($model, 'pincode')->textInput(['maxlength' => true,'readonly' => true]) ?>
         </div>
      </div>
   </div>
   <div class="col-xs-12 col-sm-6">
      <div class="panel panel-default">
         <div class="panel-heading">Contact</div>
         <div class="panel-body">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <?= $form->field($model, 'website')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <div class="row">
               <div class="col-xs-12 col-sm-6">
                  <?= $form->field($model, 'phone_1')->textInput(['maxlength' => true,'readonly' => true]) ?>
               </div>
               <div class="col-xs-12 col-sm-6">
                  <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true,'readonly' => true]) ?>
               </div>
            </div>
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <?= $form->field($model, 'contact_person_designation')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <?= $form->field($model, 'contact_email')->textInput(['maxlength' => true,'readonly' => true]) ?>
            <div class="row">
               <div class="col-xs-12 col-sm-6">
                  <?= $form->field($model, 'contact_mobile')->textInput(['maxlength' => true,'readonly' => true]) ?>
               </div>
               <div class="col-xs-12 col-sm-6">
                  <?= $form->field($model, 'fax')->textInput(['maxlength' => true,'readonly' => true]) ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>