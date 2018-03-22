<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->context->layout = 'profile';
?>

<h3>Standard Test Details </h3>
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Verbal</th>
        <th>Quantitative</th>
        <th>IR</th>
        <th>DI</th>        
    </tr>
    <?php foreach ($standardTests as $test): ?>
        <tr>
            <td><?= $test->test_name ?></td>
            <td><?= $test->verbal_score ?></td>            
            <td><?= $test->quantitative_score ?></td>
            <td><?= $test->integrated_reasoning_score ?></td>
            <td><?= $test->data_interpretation_score ?></td>
        </tr>
    <?php endforeach; ?>
</table>
