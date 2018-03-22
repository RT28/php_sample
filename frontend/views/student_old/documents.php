<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
$this->registerJsFile('@web/js/student.js');
?>
<?php
  echo Html::a('<button type="button" class="btn btn-primary ">Download All Documents</button>', ['student/downloadall', 'id' => $model->id], ['class' => 'btn btn-link']);
?>
<h3>Documents </h3>
<table class="table table-bordered">
    <tr>
        <td>Passport</td>
        <td>
            <?php
                $passport_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/passport")) {
                    $passport_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/passport", [
                        'caseSensitive' => false,
                        'recursive' => false,
                        'only' => ['passport.*']
                    ]);
                }
                if (count($passport_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-passport', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo FileInput::widget([
                    'name' => 'upload_passport',
                    'pluginOptions' => [
                        'uploadUrl' => Url::to(['/student/upload-passport']),
                        'showPreview'=> true,
                        'showCaption' => false,
                        'uploadExtraData' => [
                            'student_id' => $model->id,
                        ]
                    ]
                ]);
            ?>
        </td>
    </tr>
    <tr>
        <td>Transcripts</td>
        <td>
            <?php
                $transcripts_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/transcripts")) {
                    $transcripts_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/transcripts", [
                        'caseSensitive' => false,
                        'recursive' => false,
                    ]);
                }
                if (count($transcripts_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-transcripts', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo '<button type="button" class="btn btn-link" data-toggle="modal" data-target="#transcripts"><span class="glyphicon glyphicon-upload"></span></button>'; 
            ?>
        </td>
    </tr>
    <tr>
        <td>ACT/SAT/GRE/GMAT</td>
        <td>
            <?php
                $standard_tests_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/standard_tests")) {
                    $standard_tests_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/standard_tests", [
                        'caseSensitive' => false,
                        'recursive' => false,
                    ]);
                }
                if (count($standard_tests_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-standard-tests', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo '<button type="button" class="btn btn-link" data-toggle="modal" data-target="#documents"><span class="glyphicon glyphicon-upload"></span></button>';
            ?>
        </td>
    </tr>
    <tr>
        <td>Resume</td>
        <td>
            <?php
                $resume_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/resume")) {
                    $resume_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/resume", [
                        'caseSensitive' => false,
                        'recursive' => false,
                        'only' => ['resume.*']
                    ]);
                }
                
                if (count($resume_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-resume', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo FileInput::widget([
                    'name' => 'resume',
                    'pluginOptions' => [
                        'uploadUrl' => Url::to(['/student/upload-resume']),
                        'showPreview'=> true,
                        'showCaption' => false,
                        'uploadExtraData' => [
                            'student_id' => $model->id,
                        ]
                    ]
                ]);
            ?>
        </td>
    </tr>
    <tr>
        <td>Reference Letter</td>
        <td>
            <?php
                $reference_letter_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/reference_letter")) {
                    $reference_letter_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/reference_letter", [
                        'caseSensitive' => false,
                        'recursive' => false,
                        'only' => ['reference_letter.*']
                    ]);
                }

                if (count($reference_letter_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-reference-letter', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo FileInput::widget([
                    'name' => 'reference_letter',
                    'pluginOptions' => [
                        'uploadUrl' => Url::to(['/student/upload-reference-letter']),
                        'showPreview'=> true,
                        'showCaption' => false,
                        'uploadExtraData' => [
                            'student_id' => $model->id,
                        ]
                    ]
                ]);
            ?>
        </td>
    </tr>
    <tr>
        <td>Visa Details</td>
        <td>
            <?php
                $visa_details_path = [];
                if (is_dir("./../web/uploads/$model->id/documents/visa")) {
                    $visa_details_path = FileHelper::findFiles("./../web/uploads/$model->id/documents/visa", [
                        'caseSensitive' => false,
                        'recursive' => false,
                        'only' => ['visa.*']
                    ]);
                }
                
                if (count($visa_details_path) > 0) {
                   echo Html::a('<span class="glyphicon glyphicon-download"></span>', ['student/download-visa-details', 'id' => $model->id], ['class' => 'btn btn-link']);
                }

                echo FileInput::widget([
                    'name' => 'upload_visa',
                    'pluginOptions' => [
                        'uploadUrl' => Url::to(['/student/upload-visa-details']),
                        'showPreview'=> true,
                        'showCaption' => false,
                        'uploadExtraData' => [
                            'student_id' => $model->id,
                        ]
                    ]
                ]);
            ?>
        </td>
    </tr>    
</table>

<!-- Modal -->
<div class="modal fade" id="documents" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Standard Tests</h4>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="docs">
                <input type="hidden" name="student_id" value="<?= $model->id ?>" />
                <table class="table table-bordered" id="documents-form">
                    <tbody>
                        <tr>
                            <th>Test Name</th>
                            <th>Document</th>
                        </tr>
                        <?php
                            if (is_dir("./../web/uploads/$model->id/documents/standard_tests")) {
                                $standard_test_details = FileHelper::findFiles("./../web/uploads/$model->id/documents/standard_tests", [
                                    'caseSensitive' => false,
                                    'recursive' => false,
                                ]);
                                if(count($standard_test_details) > 0) {
                                    $i = 0;
                                    foreach($standard_test_details as $tests) {
                                        echo '<tr data-index="' . $i . '">';
                                            echo '<td><input name="test-' . $i . '" value="' . pathinfo($tests, PATHINFO_FILENAME) . '"/></td>';
                                            echo '<td><input name="document-' . $i++ . '" value="' . $tests . '" type="file"/></td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddDocumentClick(this)"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
        <button type="button" class="btn btn-primary" onclick="onUploadClick(this)">Upload</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="transcripts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Transcripts</h4>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data" id="trnscrpts">
                <input type="hidden" name="student_id" value="<?= $model->id ?>" />
                <table class="table table-bordered" id="transcripts-form">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Document</th>
                        </tr>
                        <?php
                            if (is_dir("./../web/uploads/$model->id/documents/transcripts")) {
                                $standard_test_details = FileHelper::findFiles("./../web/uploads/$model->id/documents/transcripts", [
                                    'caseSensitive' => false,
                                    'recursive' => false,
                                ]);
                                if(count($standard_test_details) > 0) {
                                    $i = 0;
                                    foreach($standard_test_details as $tests) {
                                        echo '<tr data-index="' . $i . '">';
                                            echo '<td><input name="test-' . $i . '" value="' . pathinfo($tests, PATHINFO_FILENAME) . '"/></td>';
                                            echo '<td><input name="document-' . $i++ . '" value="' . $tests . '" type="file"/></td>';
                                        echo '</tr>';
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddTranscriptClick(this)"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-transcripts-close">Close</button>
        <button type="button" class="btn btn-primary" onclick="onUploadTranscriptsClick(this)">Upload</button>
      </div>
    </div>
  </div>
</div>