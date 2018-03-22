<?php
    use yii\helpers\Html; 
     
    $this->title ="Book your free session";
    $this->context->layout = 'index';
?>
 

<div id="wrapper-content"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content">
                <div class="container">
                    <div class="group-title-index">
                        <h1><?= Yii::t('gtuservice', 'Book your free session') ?></h1>
					
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= Yii::t('gtuservice', 'Content Coming soon') ?>
							<br>
							<br>
							<br>
							
								 <?php if(Yii::$app->user->isGuest): ?>
                        <?= Html::a('<button type="button" class="btn btn-info">Register for a free counselling session</button>', ['site/signup'], ['class' => '']); ?>
                    <?php endif;?>
						<?php
                        if(!Yii::$app->user->isGuest) {
                            
                         
                    ?> 
                        <a class="btn btn-blue" href="/site/register-for-free-counselling-session">Click here to get a free counselling session</a>
						<?php } ?>
					
					<br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJsFile('js/packages.js');
?>
