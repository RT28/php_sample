<?php
    $this->title = 'Application Form';
    $this->context->layout = 'profile';
?>

<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#d2" aria-controls="d2" role="tab" data-toggle="tab">School Details</a></li>
            <li role="presentation"><a href="#d3" aria-controls="d3" role="tab" data-toggle="tab">College Details</a></li>
            <li role="presentation"><a href="#d4" aria-controls="d4" role="tab" data-toggle="tab">Subject Details</a></li>
            <li role="presentation"><a href="#d5" aria-controls="d5" role="tab" data-toggle="tab">English Language Proficiency</a></li>
            <li role="presentation"><a href="#d6" aria-controls="d6" role="tab" data-toggle="tab">Standard Tests</a></li>
			 <a href="?r=application-form/create" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-school">Create Application</a>
        </ul>
    </div>
    <div class="dashboard-detail applications">
        <div class="tab-content">

            <!-- SCHOOL DETAILS -->
            <div role="tabpanel" class="tab-pane fade" id="d2">
                <div class="row" id="tab-school">
                    <div class="col-sm-12">
                    <div class="">
                        <a href="?r=student/update-school-details" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-school">UPDATE</a>
                        <?php foreach($schools as $key => $school): ?>
                            <div class="school-details">
                                <p><strong>Name:</strong> <?= $school->name; ?></p>
                                <p><strong>From Date:</strong> <?= $school->from_date; ?></p>
                                <p><strong>To Date:</strong> <?= $school->to_date; ?></p>
                                <p><strong>Curriculum:</strong> <?= $school->curriculum; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>

            <!-- COLLEGE DETAILS -->
            <div role="tabpanel" class="tab-pane fade" id="d3">
                <div class="row" id="tab-college">
                    <div class="col-sm-12">
                    <div class="">
                        <a href="?r=student/update-college-details" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-college">UPDATE</a>
                        <?php foreach($colleges as $key => $college): ?>
                            <div class="college-details">
                                <p><strong>Name:</strong> <?= $college->name; ?></p>
                                <p><strong>From Date:</strong> <?= $college->from_date; ?></p>
                                <p><strong>To Date:</strong> <?= $college->to_date; ?></p>
                                <p><strong>Curriculum:</strong> <?= $college->curriculum; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>


            <!-- SUBJECT DETAILS -->
            <div role="tabpanel" class="tab-pane fade" id="d4">
                <div class="row" id="tab-subject">
                    <div class="col-sm-12">
                    <div class="">
                        <a href="?r=student/update-subject-details" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-subject">UPDATE</a>
                        <?php foreach($subjects as $key => $subject): ?>
                            <div class="subject-details">
                                <p><strong>Name:</strong> <?= $subject->name; ?></p>
                                <p><strong>Marks Obtained:</strong> <?= $subject->marks_obtained; ?></p>
                                <p><strong>Maximum Marks:</strong> <?= $subject->maximum_marks; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>


            <!-- ENGLISH PROFICIENCY DETAILS -->
            <div role="tabpanel" class="tab-pane fade" id="d5">
                <div class="row" id="tab-english">
                    <div class="col-sm-12">
                        <div class="">
                            <a href="?r=student/update-english-proficiency" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-english">UPDATE</a>
                            <?php foreach($englishProficiency as $key => $test): ?>
                                <div class="english-details">
                                    <p><strong>Name:</strong> <?= $test->test_name; ?></p>
                                    <p><strong>Reading:</strong> <?= $test->reading_score; ?></p>
                                    <p><strong>Writing:</strong> <?= $test->writing_score; ?></p>
                                    <p><strong>Listening:</strong> <?= $test->listening_score; ?></p>
                                    <p><strong>Speaking:</strong> <?= $test->speaking_score; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>


            <!-- STANDARD TESTS DETAILS -->
            <div role="tabpanel" class="tab-pane fade" id="d6">
                <div class="row" id="tab-tests">
                    <div class="col-sm-12">
                        <div class="">
                            <a href="?r=student/update-standard-tests" class="btn btn-primary btn-blue float-right btn-update" data-container="tab-tests">UPDATE</a>
                            <?php foreach($standardTests as $key => $test): ?>
                                <div class="tests-details">
                                    <p><strong>Name:</strong> <?= $test->test_name; ?></p>
                                    <p><strong>Verbal:</strong> <?= $test->verbal_score; ?></p>
                                    <p><strong>Quantitative:</strong> <?= $test->quantitative_score; ?></p>
                                    <p><strong>IR:</strong> <?= $test->integrated_reasoning_score; ?></p>
                                    <p><strong>DI:</strong> <?= $test->data_interpretation_score; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
