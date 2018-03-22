<?php
 use yii\helpers\Html;
 use kartik\select2\Select2;
 use yii\helpers\Json;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;

$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
$this->registerJsFile('@web/js/others.js');
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="panel panel-default">
            <div class="panel-heading">Course Type</div>
            <div class="panel-body">
                <div class="row">
        <div class="modal-body"> 
            <form method="post" enctype="multipart/form-data" id="trnscrpts">
               <?php /*<input type="hidden" name="student_id" value="<?= $model->value ?>" />*/ ?>
                <table class="table table-bordered" id="transcripts-form">
                    <tbody>
                        <tr>
                            <th>Course Type</th>
                            <th>Delete Course Type</th>
                        </tr>
                        <?php                            
                             $i = 0;
                            foreach($model as $coursetype) {
                                        echo '<tr data-index="'.$i.'">';
                                            echo '<td><input class="otherlist" name="test-'.$i.'" value="' .$model[$i]. '"/></td>';
                                            echo '<td><button data-index="'.$i.'" class="btn btn-danger" onclick="onDeleteRankingButtonClick(this)"><span class="glyphicon glyphicon-minus"></span></button></td>';
                                        echo '</tr>';
                                        $i++;
                                    }
                        ?>                    
                    </tbody>
                </table>
                <button type="button" class="btn btn-success" onclick="onAddTranscriptClick(this)"><span class="glyphicon glyphicon-plus"></button>
            </form>
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-transcripts-close">Close</button>
        <button type="button" class="btn btn-primary" onclick="onUploadTranscriptsClick(this)">Save Changes</button>
      </div>
                </div>
            </div>
        </div>
    </div>

    