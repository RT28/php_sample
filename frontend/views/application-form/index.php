<?php
use yii\helpers\Html;
use yii\helpers\Json;
    $this->title = 'Standard Tests';
    $this->context->layout = 'profile';
?>

<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>

    <div class="dashboard-detail applications">
                        <div class="standerd-test-list">
                        
							<div class="row">
                            <div class="col-sm-6">
                        <h3 class="standerd-test-title"> Standard Test</h3>
                            <!--<a href="http://gotouniversity.com/student/update-standard-tests" class="btn btn-primary btn-blue" data-container="tab-tests">Update</a>--></div>
                            <div class="col-sm-6">
                            <button type="button" class="btn btn-primary btn-blue pull-right btn-login" data-toggle="modal" data-target="#login-modal" value="/student-standard-test-detail/create">Add Score</button>
                            </div>
                            </div>
							<div class="row">
                            <?php foreach($standardTests as $key => $test): ?>
                                <div class="tests-details col-sm-12">
                                    <div class="standerd-test-block">
                                        <div class="test-block-head">
                                        	<div class="name"><?= $test->test_name; ?></div>
                                            <div class="actions-date">
                                            	<span class="test-date"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $test->test_date; ?></span>
                                            	<button type="button" class="btn-login" data-toggle="modal" data-target="#login-modal" value="/student-standard-test-detail/update?id=<?= $test->id; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['student-standard-test-detail/delete', 'id' => $test->id], [
                                        'class' => '',
                                        'data' => [
                                            'confirm' => 'Are you absolutely sure ?',
                                            'method' => 'post',
                                        ],
                                    ]); ?>
                                            </div>
                                        </div>
                                        <div class="test-block-body">
                                        <div class="row">
                                        	<?php 
                                            $marks = Json::decode($test->test_marks); 
                                            if(is_array($marks)){
                                                foreach($marks as $key => $value){
													echo '<div class="col-sm-4">';
													echo '<div class="sub-tile">';
                                                    echo '<span class="count">' . $value['score'] . '</span>' . '<span class="subject">'.$value['name'] . '</span>';
													echo '</div>';
													echo '</div>';
                                                }  
                                            }else{
                                              echo $test->test_marks;
                                            }
                                        ?>
                                        </div>
                                        <div class="last-update"><strong>Last Update :</strong>  <?= $test->updated_at ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        </div>
    </div>
</div>
</div>
</div>
