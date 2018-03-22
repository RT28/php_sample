<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->context->layout = 'profile';
?>

<h3>English Language Proficiency</h3>
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Reading</th>
        <th>Writing</th>
        <th>Listening</th>
        <th>Speaking</th>        
    </tr>
    <?php foreach ($englishProficiency as $test): ?>
        <tr>
            <td><?= $test->test_name ?></td>
            <td><?= $test->reading_score ?></td>            
            <td><?= $test->writing_score ?></td>
            <td><?= $test->listening_score ?></td>
            <td><?= $test->speaking_score ?></td>
        </tr>
    <?php endforeach; ?>
</table>
