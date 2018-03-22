<?php

use yii\helpers\Html;
use common\components\Notifications;
use common\models\PackageOfferings;
use common\components\PackageLimitType;
use common\models\Consultant;
$this->context->layout = 'profile'; 
$this->title = 'My Packages'; 
    $defaultClass = 'dashboard-checklist-item';
    $completeClass = 'dashboard-checklist-item dashboard-checklist-item-done';
?>
<div class="col-sm-12"> 
    <?= $this->render('_student_common_details', []); ?>
     <?php if(sizeof($models) === 0): ?>
          <h2> You haven't bought any packages yet.</h2>
           <div class="col-xs-12 text-center">
		
            <a class="btn btn-blue" href="/packages/index">View Packages</a>
        </div>
    <?php else: ?>
	<div class="row">
	  
        <?php foreach($models as $model): ?>
            <div class="col-xs-12">
                <h2><?= $model->packagetype->name ?></h2>
				You bought the package on 
				<?= Yii::$app->formatter->asDate($model->created_at,'php: d M, Y H:i:s A'); ?>
				. Click <a href="/packages/view?id=<?= $model->packagetype->id;?>">here</a> for details of the package.  
                <?php if($model->packagetype->id != 6): 
				if(isset($model->packageSubtype->name)){?>
                    <p>Name: <?= $model->packageSubtype->name; ?></p>
                    <?php
                        $offerings = [];
                        if(isset($model->package_offerings)) {
                            $temp = explode(',', $model->package_offerings);
                            $offerings = PackageOfferings::find()->where(['in', 'id', $temp])->all();
                        }

                        $temp = [];
                        foreach($offerings as $offering) {
                            array_push($temp, $offering->name);
                        }
                        $offerings = implode(',', $temp);
                    ?>
                    <p>Selected Services: <?= $offerings; ?></p>
                    <?php if(isset($model->consultant_id)):?>
                        <?php
                            $name = '';
                            $consultant = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
                            if(!empty($consultant)) {
                                $name = $consultant->name;
                            }
                        ?>
                        <p>Consultant: <?= $model->consultant->consultant->name; ?></p>
                    <?php endif; ?>
                    <p>Limit Pending: <?= $model->limit_pending; ?> <?= PackageLimitType::getPackageLimitTypeName($model->limit_type);?></p>
                <?php } endif; ?>
                <hr style="border-top-color: #777777;"/>
            </div>
        <?php endforeach; ?>
		  
    </div>
  <?php endif; ?>
	
</div>
</div>
</div>
