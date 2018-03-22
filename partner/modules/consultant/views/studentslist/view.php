<?php
    $this->context->layout = 'main';
    $this->title = $model->first_name . ' ' . $model->last_name;
?>

<div class="consultant-student-view col-sm-10">
    <h1><?= $this->title; ?></h1>

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
            <li role="presentation"><a href="#tests" aria-controls="tests" role="tab" data-toggle="tab">Tests</a></li>
            <li role="presentation"><a href="#documents" aria-controls="documents" role="tab" data-toggle="tab">Documents</a></li>
            <li role="presentation"><a href="#associates" aria-controls="associates" role="tab" data-toggle="tab">Associates</a></li>
            <li role="presentation"><a href="#packages" aria-controls="packages" role="tab" data-toggle="tab">Packages</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="profile">
                <?= $this->render('_profile', [
                    'model' => $model
                ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="tests">
                <?= $this->render('_tests', [
                    'model' => $model,
                    'englishTests' => $englishTests,
                    'standardTests' => $standardTests,
                ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="documents">
                <?= $this->render('_documents', [
                    'model' => $model,
                ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="associates">
                <?= $this->render('_associates', [
                    'model' => $model,
                    'associates' => $associates,
                    'consultantAssociates' => $consultantAssociates
                ]); ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="packages">
                <?= $this->render('_packages', [
                    'model' => $model,
                    'packages' => $packages
                ]); ?>
            </div>
        </div>
    </div>
</div>
