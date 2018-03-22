<?php
    use common\models\Consultant;
    use yii\widgets\DetailView;

    $this->context->layout = 'main';
    $this->title = $model->name;
?>

<div class="consultant-associates-view col-sm-10">
    <h1><?= $this->title; ?></h1>
    <a class="btn btn-primary" href="?r=consultant/associates/update&id=<?= $model->consultant_id; ?>">Update</a>
    <a class="btn btn-danger" href="?r=consultant/associates/delete&id=<?= $model->consultant_id; ?>">Delete</a>

    <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'date_of_birth',
                'email',
                'gender',
                'mobile',
                [   
                    'label' => 'Country',
                    'value' => $model->country->name
                ],
                'speciality',
                'description',
                'experience',
                'skills'
            ],
        ]);
    ?>
</div>
