<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->context->layout = 'profile';
?>

<h3>School Details </h3>
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>From Date</th>
        <th>To Date</th>
        <th>Curriculum</th>
    </tr>
    <?php foreach ($schools as $school): ?>
        <tr>
            <td><?= $school->name ?></td>
            <td><?= $school->from_date ?></td>            
            <td><?= $school->to_date ?></td>
            <td><?= $school->curriculum ?></td>
        </tr>
    <?php endforeach; ?>
</table>
