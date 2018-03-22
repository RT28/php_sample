<?php
    use yii\widgets\DetailView;
    use yii\helpers\FileHelper;
    use common\components\PackageLimitType;
    use common\models\PackageType;
    use common\models\PackageSubtype;
    use common\models\PackageOfferings;
?>
 
<div>
       <div class="alert alert-danger error-container hidden"></div>
      <table class="table table-bordered">
        <th>Package</th>
        <th>Services</th>
        <th>Fees</th>
        <th>Limit Type</th>
        <th>Limit Pending</th>
        <?php foreach($packages as $package): ?>
            
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
				
				<tr>
                <td>
				<?= $packageType->name; ?>
				<?php  if(isset($subpackageType->name)){ ?> - 
				<?= $subpackageType->name; ?>	<?php } ?>
				</td>
                <td><?= $str_offerings; ?></td>
                <td>$ <?= $package->total_fees; ?></td>
                <td>
				<?php  if($package->limit_type!=0){ ?>
				<?= PackageLimitType::getPackageLimitTypeName($package->limit_type); ?>
				<?php } ?></td>
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
