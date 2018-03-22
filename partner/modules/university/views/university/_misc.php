<?php
    use yii\helpers\Html;
    use kartik\select2\Select2;
    use yii\helpers\Json;
    use yii\web\JsExpression;
    use yii\helpers\ArrayHelper;
    use common\models\StandardTests;
?>

<?php
    $location = $model->location;
    $location = str_replace([' ', ',,'], ',', $location);
    $location = str_replace(['POINT', 'GeomFromText(\'', '\')'], '', $location);
    $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
?>

<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Standard Tests & Currecny</div>
            <div class="panel-body">
                <?= $form->field($model, 'standard_tests_required')->checkbox() ?>
				  <?= $form->field($model, 'currency_id')->widget(Select2::classname(),[
                                'data' => $currencies,
                                'options' => ['placeholder' => 'Country']
                            ]);
                        ?>
                        <?= $form->field($model, 'currency_international_id')->widget(Select2::classname(),[
                                'data' => $currencies,
                                'options' => ['placeholder' => 'Country']
                            ]);
                        ?>
            </div>
        </div>
        <div class="panel panel-default">

            <div class="panel-heading">Student & Faculty</div>
            <div class="panel-body">
                <div class="row">
                   <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_students')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_international_students')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_undergraduate_students')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_post_graduate_students')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_faculties')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'no_of_international_faculty')->textInput() ?>
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
                <div class="form-group text-center">
                    <input type="text" id="map-search" class="form-control" name="map-serach" maxlength="255">
                    <input type="button" class="btn btn-blue mtop-10" onclick="initGoogleMap()" value="Update Map">
                </div>
                <div id="google-map-container"></div>
            </div>
        </div>
    </div>


<div class="col-xs-12 ">
        <div class="panel panel-default">
			 <div class="panel-heading">University Rankings</div>
            <div class="panel-body">
                <div class="row">

				 <div class="col-xs-12 ">
                        <?= Html::hiddenInput('university-rankings', $model->institution_ranking, ['id' => 'university-rankings']); ?>
                        <?php
                            $rankings = [];
                            $rankings = Json::decode($model->institution_ranking);
                            if(!is_array($rankings)){
                                $rankings = [];
                            }
                            $i = 0;
                        ?>
                        <button type="button" class="btn btn-blue mbot-10" data-toggle="modal" data-target="#update_rankings">
                            Update
                        </button>
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
 <!--    <div class="col-xs-12 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">Cost of Living & Accomodation</div>
            <div class="panel-body">
                <div class="row">
                   <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'accomodation_available')->checkbox(['options' => ['id' => 'university-accomodation']]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">

                    </div>
                    <!--<div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'hostel_strength')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'cost_of_living')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'undergarduate_fees')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'undergraduate_fees_international_students')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'post_graduate_fees')->textInput() ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($model, 'post_graduate_fees_international_students')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>-->



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
        <button type="button" class="btn btn-blue" onclick="onSaveChangesClick(this)">Save changes</button>
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
