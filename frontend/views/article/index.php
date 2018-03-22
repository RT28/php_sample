<?php
use yii\helpers\Html; 
use yii\helpers\FileHelper;
use common\models\Articles; 

$articles = Articles::find()->orderBy(['id' => 'DESC'])->all();
?>
<?php
    $this->title = 'Articles';
    $this->context->layout = 'index';
?>
<div id="wrapper-content"><!-- PAGE WRAPPER-->
   
 <div class="section-padding">
<div class="container">
<div class="group-title-index">
<h1><?= Yii::t('gtuarticles', 'Our') ?></br> <?= Yii::t('gtuarticles', 'Articles') ?></h1>
</div>
<div class="row">
 
<?php foreach($articles as $article): ?>
<?php
$src = '';
if ( is_dir( "./../../backend/web/articles-uploads/$article->id/" ) ) {
	$imgPath = FileHelper::findFiles( "./../../backend/web/articles-uploads/$article->id/", [
		'caseSensitive' => true,
		'recursive' => false,
	] );
	if ( count( $imgPath ) > 0 ) {
		$src = $imgPath[ 0 ];
	}
}
?>
							
<div class="col-sm-4">





<div class="thumbnail articles-block-home">
                    <div class="articles-block-image"> <img src="<?php echo $src; ?>" title="<?php echo $article->name;?>" > </div>
                    <div class="caption">
                      <h3>
                        <?php echo $article->name;?>
                      </h3>
                      <div class="articles-content-short">
                        <?php echo $article->short_description;?>
                      </div>
                      <div class="thumbnail-footer">
                        <div class="row">
                          <div class="col-xs-6"> <span><i class="fa fa-clock-o" aria-hidden="true"></i>
                            <?php echo $article->view_duration; ?>
                            min</span> <span><i class="fa fa-eye" aria-hidden="true"></i>
                            <?php echo $article->view_count; ?>
                            </span> </div>
                          <div class="col-xs-6">
                            <div class="text-right"> <a href="/article/view?id=<?php echo $article->id;?>" class="read-artical">Read More</a> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
 </div>
 <?php endforeach; ?>
 </div>
 </div>
  
</div>
</div>
  
