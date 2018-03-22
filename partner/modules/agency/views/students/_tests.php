<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
?>
 
<div>
     
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
