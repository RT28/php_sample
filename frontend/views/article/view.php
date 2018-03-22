<?php
use yii\helpers\Html; 
use yii\helpers\FileHelper; 
use common\models\Advertisement;
use common\components\ConnectionSettings;

$TodayDate = date('Y-m-d');
$path= ConnectionSettings::BASE_URL.'backend';

    $this->title = $model->name;
    $this->context->layout = 'index';
?>
<?php
$src = '';
if ( is_dir( "./../../backend/web/articles-uploads/$model->id/" ) ) {
	$imgPath = FileHelper::findFiles( "./../../backend/web/articles-uploads/$model->id/", [
		'caseSensitive' => true,
		'recursive' => false,
	] );
	if ( count( $imgPath ) > 0 ) {
		$src = $imgPath[ 0 ];
    //$src = str_replace("\\","/",$src);
	}
}
?>

<div id="wrapper-content"><!-- PAGE WRAPPER-->
  <div id="page-wrapper"><!-- MAIN CONTENT-->
    <div class="main-content"><!-- CONTENT-->
      <div class="content"><!-- SLIDER BANNER-->
        <div class="articles-block">
                <div class="article-img" style="background-image: url(<?php echo $src; ?>);">  </div>
          <div class="container">
            <div class="row">
              <div class="col-sm-9">
                <h1 class="article-detail-title"><?php echo $model->name;?></h1>
                <div class="article-text"> <?php echo $model->description;?> </div>
              </div>
              <div class="col-sm-3 right-side-addblocks">
                <?php 
                $Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'university'],
                ['=', 'status',  '1' ],['=', 'section',  'right' ],
                ['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all(); 
                ?>
                <div class="ad-blocks">
                  <?php foreach($Ads as $ad): ?>
                  <a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="height: <?= $ad->height;?>px; width: <?= $ad->width;?>px;"/> </a>
                  <p style="height: 8px;">&nbsp;</p>
                  <?php   ?>
                  <?php endforeach; ?>
                <!-- <div class="ad-blocks"> <a href="http://www.gotouniversity.com/frontend/web/index.php/university%2Fview?id=673" target="_blank" title="Middlesex London"> <img src="http://www.gotouniversity.com/backend/web/uploads/advertisements/12/MFMbannerad11510846512.png" alt="Middlesex London" height="576px;" width="292px;"> </a> </div> -->
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="slider-home-artical">
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
                  <div class="thumbnail articles-block-home">
                    <div class="articles-block-image"> <img src="<?= $src; ?>" alt="" height="232px;"> </div>
                    <div class="caption">
                      <h3>
                        <?= $article->name; ?>
                      </h3>
                      <div class="articles-content-short">
                        <?= $article->short_description; ?>
                      </div>
                      <div class="thumbnail-footer">
                        <div class="row">
                          <div class="col-xs-6"> <span><i class="fa fa-clock-o" aria-hidden="true"></i>
                            <?= $article->view_duration; ?>
                            min</span> <span><i class="fa fa-eye" aria-hidden="true"></i>
                            <?= $article->view_count; ?>
                            </span> </div>
                          <div class="col-xs-6">
                            <div class="text-right"> <a href="/article/view?id=<?= $article->id;?>" class="read-artical" onclick="CheckArticleViewed(<?= $article->id;?>);">Read More</a> </div>
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
        </div>
      </div>
    </div>
  </div>
</div>
