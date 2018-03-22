<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
?>
<?php
    $cover_photo_path = [];
    $src = './noprofile.gif';
    $user = $model->student_id;
    if(is_dir("./../../frontend/web/uploads/$user/profile_photo")) {
        $cover_photo_path = FileHelper::findFiles("./../../frontend/web/uploads/$user/profile_photo", [
            'caseSensitive' => true,
            'recursive' => false,
            'only' => ['profile_photo.*']
        ]);
    }
    if (count($cover_photo_path) > 0) {
        $src = $cover_photo_path[0];
    }
?>
<div>
    <h2><?= $model->first_name?> <?= $model->last_name; ?></h2>
    <img src="<?= $src; ?>" alt="<?= $model->first_name?> <?= $model->last_name; ?>" style="max-height: 200px;"/>
    <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'first_name',
                'last_name',
                'nationality',
                'date_of_birth',
                'gender',
                [   
                    'label' => 'Country',
                    'value' => $model->country0->name
                ],
            ],
        ]);
    ?>
</div>
