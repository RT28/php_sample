<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
?>
<?php
    $cover_photo_path = [];
    $src = './noprofile.gif';
    $user = $model->student_id;
    if(is_dir("./../../frontend/web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../../frontend/web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);
    }
    if (count($cover_photo_path) > 0) {
        $src = $cover_photo_path[0];
    }
?>
<div>
    <h2><?= $model->first_name?> <?= $model->last_name; ?></h2>
    <img src="<?= $src; ?>" alt="<?= $model->first_name?> <?= $model->last_name; ?>" style="max-height: 200px;"/>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#connect-associates">
        Connect Associates
    </button>
    <table class="table table-bordered">
        <th>Name</th>
        <th>Skills</th>
        <th>Experience (Yrs)</th>
        <th>Actions</th>
        <?php foreach($associates as $associate): ?>
            <tr>
                <?php
                    $consultant = $associate->associateConsultant->consultant;
                ?>
                <td><?= $consultant->name; ?></td>
                <td><?= $consultant->skills; ?></td>
                <td><?= $consultant->experience; ?></td>
                <td>
                    <button class="btn btn-danger btn-associate-disconnect" data-consultant="<?= $consultant->consultant_id; ?>" data-student="<?= $model->student_id; ?>">Disconnect</button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<div class="modal fade" id="connect-associates" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Connect Associates</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <select class="form-control" id="consultant">
                <option value="-1">Select...</option>
                <?php foreach($consultantAssociates as $associate): ?>
                    <option value="<?= $associate->consultant_id; ?>" data-parent="<?= $associate->parent_consultant_id; ?>"><?= $associate->consultant->consultant->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-associate-connect" data-student="<?= $model->student_id; ?>">Connect</button>
      </div>
    </div>
  </div>
</div>

<?php
    $this->registerJsFile('js/associates.js');
?>
