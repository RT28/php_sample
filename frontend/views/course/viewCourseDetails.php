<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\AdmissionWorkflow;
use common\components\Roles;
use frontend\models\UserLogin;
use backend\models\EmployeeLogin;
use partner\models\PartnerLogin;
use common\models\Currency;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */

$this->title = 'Course Details';
//$this->params['breadcrumbs'][] = ['label' => 'Student University Applications', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

$currency = $model->university->currency;
if(isset($currency)) {
    $iso_code = $currency->iso_code;
    $symbol = $currency->symbol != null ? $currency->symbol : "";
    $currency = "$symbol ($currency->name - $currency->iso_code)";
}

$currencies = ArrayHelper::map(Currency::find()->all(), 'iso_code', 'iso_code');
?>
<div class="course-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <input type="hidden" value="<?= $iso_code ?>" id="course_fees_currency"/>          

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?= Select2::widget([
                    'name' => 'currency',
                    'data' => $currencies,
                    'options' => [
                        'placeholder' => 'Select currency ...',                    
                    ],
                ]);
            ?>
        </div>
        <div class="col-xs-12 col-sm-6">
            <span id="local-currency_fees"></span>
        </div>
        
    </div>    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'University',
                'value' => $model->university->name
            ],
            [
                'label' => 'Course',
                'value' => $model->name
            ],
            [
                'label' => 'Description',
                'value' => $model->description
            ],          
            [
                'label' => 'Intake',
                'value' => $model->intake
            ],
            [
                'label' => 'language',
                'value' => $language
            ],
            [
                'label' => 'Fees',
                'value' => $currency . ' ' . $model->fees 
            ],
            [
                'label' => 'Duration',
                'value' => $model->duration
            ], 
            [
                'label' => 'Type',
                'value' => $type
            ],               
        ],
    ]) ?>

    <!-- Modal -->
    <div class="modal fade" id="remarks" tabindex="-1" role="dialog" aria-labelledby="remarks">
        <div class="modal-dialog rankings-modal" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="remarks">Remarks</h4>
            </div>
            <div class="modal-body">           
                <textarea id="txt-remarks" rows="6" style="width: 100%;"></textarea>
            </div>
            <div class="modal-footer">        
                <button type="button" class="btn btn-primary" id="btn-ok">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Cancel</button>
            </div>
            </div>
        </div>
    </div>

</div>


<script>
    window.onload = function(){
        $('select').on('change', function (evt) {
            var course_currency = $('#course_fees_currency').val();
            var local_currency = $(this).val();

            $.ajax({
                url: 'https://www.google.com/finance/converter?a='+ <?= $model->fees ?> + '&from=' + course_currency + '&to=' + local_currency,
                method: 'GET',
                type: 'JSON',          
                success: function(data) {
                    var regExp = /<div id=currency_converter_result>/i;
                    var substr = regExp.exec(data);
                    if(substr) {
                        var begin = data.substring(substr.index);
                        regExp = /<\/span>/i;                        
                        var end = regExp.exec(begin);
                        if(end) {
                            var value = begin.substring(0, end.index) + '</span></div>';
                            $('#local-currency_fees').html('Approx' + value);                          
                        }                                                
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    }
</script>