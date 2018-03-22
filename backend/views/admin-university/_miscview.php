<?php
    use yii\helpers\Html;
    use kartik\select2\Select2;
    use yii\helpers\Json;
    use yii\web\JsExpression;
?>

<?php
    $location = $model->location;
    $location = str_replace([' ', ',,'], ',', $location);
    $location = str_replace(['POINT', 'GeomFromText(\'', '\')'], '', $location);
?>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Standard Tests & Requirements</div>
            <div class="panel-body">
                <?= $form->field($model, 'standard_tests_required')->checkbox(['disabled' => "disabled"]) ?>
                <?= $form->field($model, 'standard_test_list')->widget(Select2::classname(), [
                    'name' => 'color_2',                    
                    'data' => [
                        '0' => 'TOEFL',
                        '1' => 'IELTS',
                        '2' => 'SAT',
                        '3' => 'GRE',
                        '4' => 'GMAT'
                    ],
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select a test ...', 'multiple' => true],
                    'disabled' => true,
                    'pluginOptions' => [
                        'tags' => true,
                        'templateResult' => new JsExpression('function(record) { return record.name + "-" + record.iso_code + "(" + record.symbol + ")";}'),                     
                    ]
                ]) ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">University Rankings</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <?= Html::hiddenInput('university-rankings', $model->institution_ranking, ['id' => 'university-rankings']); ?>
                        <?php
                            $rankings = [];        
                            $rankings = Json::decode($model->institution_ranking);
                            if(!is_array($rankings)){
                                $rankings = [];
                            }
                            $i = 0;       
                        ?>         
                        <table class="table table-bordered" id="institution-rankings">
                            <tr>
                                <th>Rank</th>
                                <th>Source</th>
                                <th>Name</th>
                            </tr>
                            <?php foreach ($rankings as $rank): ?>
                                <tr data-index="<?= $i++; ?>">
                                    <td><?= $rank['rank'] ?></td>
                                    <td><?= $rank['source'] ?></td>
                                    <td><?= $rank['name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Location</div>
            <div class="panel-body">
                <?= $form->field($model, 'location')->hiddenInput([
                        'id' => 'university-location',
                        'value' => $location
                    ])->label(false);
                ?>    
                <div id="google-map-container"></div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Student & Faculty</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_students')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_international_students')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_undergraduate_students')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_post_graduate_students')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_faculties')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_international_faculty')->textInput(['readonly'=>true]) ?>
                    </div>
                </div>
            </div>
        </div>               
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Cost of Living & Accomodation</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'accomodation_available')->checkbox(['disabled'=>'disabled']) ?>
                    </div>            
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'hostel_strength')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'cost_of_living')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'undergarduate_fees')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'undergraduate_fees_international_students')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'post_graduate_fees')->textInput(['readonly'=>true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'post_graduate_fees_international_students')->textInput(['readonly'=>true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update_rankings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog rankings-modal" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Rankings</h4>
      </div>
      <div class="modal-body">
            <table class="table table-bordered" id="institution-rankings-form">
                <tbody>
                    <tr>
                        <th>Rank</th>
                        <th>Source</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    <?php
                        $i = 0;
                    ?>
                    <?php foreach ($rankings as $rank): ?>
                        <tr data-index="<?= $i; ?>">
                            <td><input id="rank-<?= $i; ?>" value="<?= $rank['rank'] ?>"/></td>
                            <td><input id="source-<?= $i; ?>" value="<?= $rank['source'] ?>"/></td>
                            <td><input id="name-<?= $i; ?>" value="<?= $rank['name'] ?>"/></td>
                            <td><button data-index="<?= $i++; ?>" class="btn btn-danger" onclick="onDeleteRankingButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-success" onclick="onAddRankingButtonClick(this)"><span class="glyphicon glyphicon-plus"></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
        <button type="button" class="btn btn-primary" onclick="onSaveChangesClick(this)">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
$script = <<< JS

initGoogleMap();

JS;
$this->registerJs($script);
?>
