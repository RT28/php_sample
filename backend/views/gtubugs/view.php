<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\backend\GtuBugs;
use backend\models\GtuEnvironment;
use backend\models\GtuModule;

/* @var $this yii\web\View */
/* @var $model backend\models\Bugs */
$this->registerCssFile('css/style.css');
$this->registerCssFile('css/blueimp-gallery.css');
$this->registerJsFile('https://code.jquery.com/jquery-1.11.0.min.js');
$this->registerJsFile('js/blueimp-gallery.js');
//$this->registerCssFile('http://localhost/bugrecord/backend/css/blueimp-gallery.min.css'); 


$this->title = $model->gt_subject;
$this->params['breadcrumbs'][] = ['label' => 'Gtu Bugs', 'url' => ['/gtubugs']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>

<div class="bugs-view">

    
    <?php $environment = GtuEnvironment::find()->where(['gt_id' => $model->gt_envid])->one();
    //print_r($environment->gt_envid); 
      $module = GtuModule::find()->where(['gt_id' => $model->gt_bugmoduleid])->one();?>
    <h1><?= 'Status : '. $model->gt_status ;?></h1>
    <h1><?= 'Assign to : '. $model->gt_assignto;?></h1>
    <h1><?= 'Deadline : '. $model->gt_deadline;?></h1>
<?php
                            echo Html::a('Update', ['update', 'id' => $model->gt_id], ['class' => 'btn btn-primary']);
                            /*echo  Html::a('Delete', ['delete', 'id' => $model->gt_id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],  
                            ]);*/
                ?>
                <?php
                        //echo Html::a('Verify', ['/gtubugs/verified', 'id' => $model->gt_id], ['class'=>'btn btn-primary']); 
                        //echo Html::a('Resolve', ['/gtubugs/resolved', 'id' => $model->gt_id], ['class'=>'btn btn-primary']); 
                        //echo Html::a('Close', ['/gtubugs/close', 'id' => $model->gt_id], ['class'=>'btn btn-primary']);
                        echo Html::a('Update Status', ['/gtubugs/admin', 'id' => $model->gt_id], ['class'=>'btn btn-danger']);     
            ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'gt_id',
            'gt_subject',
            'gt_description:ntext',
            'gt_type',
            'gt_steptoreproduce:ntext',
            'gt_severity',
            [
            'label' => 'Environment',
            'value' => $environment->gt_name,
            ],
             [
            'label' => 'Module',
            'value' => $module->gt_name,
            ],
            'gt_url:url',
            'gt_operatingsystem',
            'gt_platform',
            'gt_browser',
            'gt_createdby',
            'gt_createdon',
            'gt_status',
            'gt_verifiedby',
            'gt_verifiedon',
            'gt_resolvedby',
            'gt_resolvedon',
            'gt_modifiedby',
            'gt_lastmodified',
        ],
    ]) ?>
    
      <?php  $path=Yii::$app->request->BaseUrl; 
       $path_Gallery = Yii::getAlias('@webroot');
                $path2 =$path_Gallery.'/uploads/bugs/' . $model->gt_id ;
                
                if($opendir = file_exists($path2.'/')){ 
                     if($opendir = opendir($path2.'/')){
                        if(count(glob($path2."/*")) === 0){}else{
                 ?>
                    <div id="links">
                                <?php while(($file2 = readdir($opendir)) !== FALSE){
                                                $images2[] = $file2;
                                            }
                                        //$photo_size = (isset($images2) && $images2 != '')?sizeof($images2):0;
                                        $more_size = (isset($images2) && $images2 != '')?sizeof($images2)-8-2:0;
                                        $i=0;
                                        foreach ($images2 as $image2 ) {
                                            if($image2 != '.' && $image2 != '..' && $image2 != ''){
                                                if($i<7){
                                                   
                                                    echo '<div class="left"><a href="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'">
                                                        <img class="mimages" src="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'"></a></div>';
                                                }elseif ($i==7) {
                                                    echo '<div class="pos-relative left">
                                                        <a href="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'">
                                                                    <img class="mimages" src="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'">
                                                                    <div class="pos-absolute resinfo-photo-overlay">
                                                                        <span class="white imgcount">+ '.$more_size.'</span>
                                                                    </div>
                                                        </a></div>';
                                                }else{
                                                    echo '<div class="left" style="display:none;"><a href="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'">
                                                        <img class="mimages" src="'.$path.'/uploads/bugs/'.$model->gt_id.'/'.$image2.'"></a></div>';
                                                }
                                                $i++;                                                           
                                            }
                                        }
                                ?>
                                </div>
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                            <script>
                                document.getElementById('links').onclick = function (event) {
                                    event = event || window.event;
                                    var target = event.target || event.srcElement,
                                        link = target.src ? target.parentNode : target,
                                        options = {index: link, event: event},
                                        links = this.getElementsByTagName('a');
                                    blueimp.Gallery(links, options);
                                };
                            </script>
                    <?php } 
                    }
                }
                ?>
                <br><br><br><br><br>
        <div>
                    <?php if($model->gt_summary!=''){?>
                        <div><font size='5'> <?php echo 'Summary: <br ></font>' . $model->gt_summary;?></font><br/><br/> </div>
                <?php }
                    $status = $model->gt_status;?>
            
    </div>
</div>