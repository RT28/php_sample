<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
	use common\models\AccessList;
	use common\components\Commondata;  
	$id = Commondata::encrypt_decrypt('encrypt', $model->id);
?>
 
<div class="student-profile-tests"> 
<div class="dashboard-detail">
<div class="tab-content">
<!-- PROFILE TAB -->
<div role="tabpanel" class="tab-pane fade in active" id="d1">
<div class="row" id="tab-tests">

 <?php 
$accessAuth = AccessList::accessActions('tests');  
if($accessAuth ==true){   
	 ?>
<a class="btn btn-primary btn-blue btn-update-tests" href="<?php
echo '?r=consultant/students/tests&id=' . $id; 
?>" data-container="tab-tests">Add/Update Tests</a>
	 <?php
} 
?>
			



</div> 

    <!--  standard tests -->
    <h3>Standard tests</h3>
	<?php if(count($standardTests)>0){?>
    <table class="table table-bordered">
        <th>Name</th>
        <th>Test Authority</th>
        <th>Test Date</th>
        <th>Verbal</th>
        <th>Quantitative</th>
        <th>Integrated Reasoning</th>
        <th>Data Interpretation</th>
        <?php foreach($standardTests as $test): ?>
            <tr>
                <td><?= $test->test_name; ?></td>
                <td><?= $test->test_authority; ?></td>
                <td><?= $test->test_date; ?></td>
                <td><?= $test->verbal_score; ?></td>
                <td><?= $test->quantitative_score; ?></td>
                <td><?= $test->integrated_reasoning_score; ?></td>
                <td><?= $test->data_interpretation_score; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php }else{?>
<h3> Student hasn't added any test record.</h3>
<?php
	
} ?>
</div>

</div>
</div>
</div>