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

    $id = $model->student_id;
    $path = [];
    if (is_dir("./../../frontend/web/uploads/$id/documents")) {
        $path = FileHelper::findFiles("./../../frontend/web/uploads/$id/documents", [
            'caseSensitive' => false,
            'recursive' => false,
        ]);
    }
?>
<div>
    <h2><?= $model->first_name?> <?= $model->last_name; ?></h2>
    <img src="<?= $src; ?>" alt="<?= $model->first_name?> <?= $model->last_name; ?>" style="max-height: 200px;"/>

    <table class="table table-bordered">
        <th>Name</th>
        <th>File</th>
        <?php foreach($path as $file): ?>
            <tr class="table-row">
                <td class="col-1"><span><?= pathinfo($file, PATHINFO_FILENAME); ?></span></td>
                <?php
                    $fileName = pathinfo($file, PATHINFO_FILENAME) . '.' . pathinfo($file, PATHINFO_EXTENSION);
                ?>
                <td class="col-2"><a href="?r=consultant/students/download&name=<?= $fileName; ?>&id=<?= $model->student_id; ?>"><?= $fileName; ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="?r=consultant/students/download-all&id=<?= $model->student_id; ?>" class="btn btn-success"/>Doenload All</a>
</div>
