<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
    use common\components\PackageLimitType;
    use common\models\PackageType;
    use common\models\PackageSubtype;
    use common\models\PackageOfferings;
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
    <div class="alert alert-danger error-container hidden"></div>
    <img src="<?= $src; ?>" alt="<?= $model->first_name?> <?= $model->last_name; ?>" style="max-height: 200px;"/>
    <table class="table table-bordered">
        <th>Package</th>
        <th>Services</th>
        <th>Fees</th>
        <th>Limit Type</th>
        <th>Limit Pending</th>
        <?php foreach($packages as $package): ?>
            <tr>
                <?php
                    $packageType = PackageType::findOne($package->package_type_id);
                    $subpackageType = PackageSubtype::findOne($package->package_subtype_id);
                    $offerings = PackageOfferings::find()->where(['in', 'id', explode(',', $package->package_offerings)])->all();
                    $str_offerings = [];
                    foreach($offerings as $offering) {
                        array_push($str_offerings, $offering->name);
                    }
                    $str_offerings = implode(',', $str_offerings);
                ?>

                <td><?= $packageType->name; ?> - <?= $subpackageType->name; ?></td>
                <td><?= $str_offerings; ?></td>
                <td>$ <?= $package->total_fees; ?></td>
                <td><?= PackageLimitType::getPackageLimitTypeName($package->limit_type); ?></td>
                <?php if($package->limit_pending > 0): ?>
                    <td>
                        <input type="number" value="<?= $package->limit_pending?>" min="0" max="<?= $package->limit_pending; ?>"/>
                        <button class="btn btn-success btn-change-limit" data-id="<?= $package->id; ?>"><span class="fa fa-check"></button>
                    </td>
                <?php else: ?>
                    <td><?= $package->limit_pending; ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<?php
    $this->registerJsFile('js/packages.js');
?>
