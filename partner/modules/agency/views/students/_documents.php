<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
	use yii\widgets\Pjax;
?>
<?php  

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
<?php if(count($path)>0){?>
    <a href="?r=consultant/students/download-all&id=<?= $model->student_id; ?>" class="btn btn-success"/>Download All</a>
<?php } ?>
</div>
