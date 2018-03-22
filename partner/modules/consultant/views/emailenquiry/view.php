<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Emailenquiry */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Emailenquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emailenquiry-view">

    <!-- <table class="table table-bordered">
        <th>Created at</th> 
        <th>Created by</th>
        <th>Mail Recipients</th>
    <tr>
    <td><?= $model->created_at; ?></td>
    <td><?= $model->created_by; ?></td>
    <?php $recipients = '';
    if($model->is_to_student==1) { $recipients.= "student";}
    if($model->is_to_father==1) { $recipients.= ",father";}
    if($model->is_to_mother==1) { $recipients.= ",mother";} ?>
    <td><?= $recipients; ?></td>
    </tr>
    </table> -->

    <?php if($model->email_source == 1){ ?>
            <div class="col-sm-14 text-left" style="width:100px;" >
            <?php $recipients = '';
            if($model->is_to_student==1) { $recipients.= "student";}
            if($model->is_to_father==1) { $recipients.= ",father";}
            if($model->is_to_mother==1) { $recipients.= ",mother";} ?>
            <label>Mail Recipients</label>
            <p><?= $recipients; ?></p>
            </div>

            <label>Subject</label>
            <p><?= $model->subject; ?></p>

            <?php if(!empty($model->consultant_message)){ ?>
            
            <label>Message by consultant</label>
            <p><?= $model->consultant_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->student_message)){ ?>
            <label>Message by Student</label>
            <p><?= $model->student_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->father_message)){ ?>
            <label>Message by Student Father</label>
            <p><?= $model->father_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->mother_message)){ ?>
            <label>Message by Student Mother</label>
            <p><?= $model->mother_message; ?></p>
            <?php } ?>

    <?php } else { ?>


            <label>Subject</label>
            <p><?= $model->subject; ?></p>
            
            <?php if(!empty($model->student_message)){ ?>
            <label>Message by Student</label>
            <p><?= $model->student_message; ?></p>
            <?php } ?>

            <?php if(!empty($model->consultant_message)){ ?>
            <label>Message by consultant</label>
            <p><?= $model->consultant_message; ?></p>
            <?php } ?>

    <?php } ?>
    
</div>
