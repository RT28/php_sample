<?php
    use common\components\AdmissionWorkflow;
?>

<?php
    $user = Yii::$app->user->identity;
    $models = $user->studentUniversityApplications;
?>

<div class="row">
<div class="col-sm-12">
<div class="course-table">
<div class="outer-container">
<div class="inner-container">
<div class="table-header">
<table class="edu-table-responsive">
<thead>
<tr class="heading-table">
	<th class="col-1">Program</th>
	<th class="col-2">University</th>
	<th class="col-3">Status</th>
</tr>
</thead>
<tbody>
<?php foreach($models as $model): ?>
	<tr class="table-row">
		<td class="col-1"><span><a href="?r=university-applications/view&id=<?= $model->id;?>"><?= $model->course->name; ?></a></span></td>
		<td class="col-2"><a href="?r=university/view&id=<?= $model->university->id; ?>"><?= $model->university->name;?></a></td>
		<?php
			$status = AdmissionWorkflow::getStateName($model->status);
		?>
		<td class="col-3"><span><?= $status;?></span></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
