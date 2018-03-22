<?php
    use common\models\StudentUniveristyApplication;
    $this->context->layout = 'main';
    $this->title = 'My Students';
?>

<div class="consultant-dashboard-index col-sm-10">
    <h1><?= $this->title; ?></h1>
    <div class="alert alert-danger error-container hidden"></div>
    <table class="table table-bordered">
        <thead>
            <th>Name</th>
            <th>Nationality</th>
            <th>Applications</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
                <tr>
                    <?php
                        $studentProfile = $student->student->student;
                        $applications = StudentUniveristyApplication::find()->where(['=', 'student_id', $student->student_id])->count();
                    ?>
                    <td><a href="?r=consultant/students/view&id=<?= $studentProfile->id; ?>"><?= $studentProfile->first_name; ?> <?= $studentProfile->last_name; ?></a></td>
                    <td><?= $studentProfile->nationality; ?></td>
                    <td><?= $applications; ?></td>
                    <td>
                        <button class="btn btn-danger btn-disconnect-consultant" data-student="<?= $studentProfile->student_id; ?>">Disconnect</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
    $this->registerJsFile('js/consultant.js');
?>
