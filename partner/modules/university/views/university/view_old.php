<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model common\models\University */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php        
        $rankings = Json::decode($model->institution_ranking);
        $i = 0;       
    ?>    
    <?php    
        if(is_dir("./../web/uploads/$model->id/cover_photo")) {
            $cover_photo_path = FileHelper::findFiles("./../web/uploads/$model->id/cover_photo", [
                'caseSensitive' => true,
                'recursive' => false,
                'only' => ['cover.*']
            ]);       
            
            if (count($cover_photo_path) > 0) {
                echo Html::img($cover_photo_path[0], ['alt' => $model->name , 'class' => 'cover-photo']);
            }
        }
        
        if(is_dir("./../web/uploads/$model->id/logo")) {
            $logo_path = FileHelper::findFiles("./../web/uploads/$model->id/logo", [
                'caseSensitive' => true,
                'recursive' => false,
                'only' => ['logo.*']
            ]);       
            
            if (count($logo_path) > 0) {
                echo Html::img($logo_path[0], ['alt' => $model->name , 'class' => 'cover-photo']);
            }
        }        
    ?>
    
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'name',
            'establishment_date',
            'address',
            [
                'label' => 'City',
                'value' => $model->city->name
            ],
            [
                'label' => 'State',
                'value' => $model->state->name
            ],
            [
                'label' => 'Country',
                'value' => $model->country->name
            ],
            'pincode',
            'email:email',
            'website',
            'description:ntext',
            'fax',
            'phone_1',
            'phone_2',
            'contact_person',
            'contact_person_designation',
            'contact_mobile',
            'contact_email:email',
            'location',
            'institution_type',
            'establishment',
            'no_of_students',
            'no_of_international_students',
            'no_faculties',
            'cost_of_living',
            'accomodation_available:boolean',
            'hostel_strength',            
            'video:ntext',
            'virtual_tour:ntext',
            'avg_rating',
            'comments:ntext',
            'status',
        ],
    ]) ?>

    <table class="table table-bordered" id="institution-rankings">
        <tr>
            <th>Rank</th>
            <th>Source</th>
        </tr>
        <?php if(isset($rankings)) { foreach ($rankings as $rank): ?>
            <tr data-index="<?= $i++; ?>">
                <td><?= $rank['rank'] ?></td>
                <td><?= $rank['source'] ?></td>
            </tr>
        <?php endforeach; }?>
    </table>

</div>
