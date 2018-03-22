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
    
    <!--  english tests -->
    <h3>English Language Proficiency</h3>
    <table class="table table-bordered">
        <th>Name</th>
        <th>Reading</th>
        <th>Writing</th>
        <th>Listening</th>
        <th>Speaking</th>
        <?php foreach($englishTests as $test): ?>
            <tr>
                <td><?= $test->test_name; ?></td>
                <td><?= $test->reading_score; ?></td>
                <td><?= $test->writing_score; ?></td>
                <td><?= $test->listening_score; ?></td>
                <td><?= $test->speaking_score; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!--  standard tests -->
    <h3>Standard tests</h3>
    <table class="table table-bordered">
        <th>Name</th>
        <th>Verbal</th>
        <th>Quantitative</th>
        <th>Integrated Reasoning</th>
        <th>Data Interpretation</th>
        <?php foreach($standardTests as $test): ?>
            <tr>
                <td><?= $test->test_name; ?></td>
                <td><?= $test->verbal_score; ?></td>
                <td><?= $test->quantitative_score; ?></td>
                <td><?= $test->integrated_reasoning_score; ?></td>
                <td><?= $test->data_interpretation_score; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
