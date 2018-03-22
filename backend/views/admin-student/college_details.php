<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$this->context->layout = 'profile';
?>

<h3>College Details </h3>
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>From Date</th>
        <th>To Date</th>
        <th>Major</th>
    </tr>
    <?php foreach ($colleges as $college): ?>
        <tr>
            <td><?= $college->name ?></td>
            <td><?= $college->from_date ?></td>            
            <td><?= $college->to_date ?></td>
            <td><?= $college->curriculum ?></td>
        </tr>
    <?php endforeach; ?>
</table>
