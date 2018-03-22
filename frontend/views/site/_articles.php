<?php
use yii\helpers\Html; 
use yii\helpers\FileHelper;
use common\models\Articles; 

$articles = Articles::find()->orderBy(['id' => 'DESC'])->limit(5)->all();
?>
<div class="section section-padding articles">
<div class="container">
<div class="group-title-index">
<h1><?= Yii::t('gtuhome', 'Our') ?> </br><?= Yii::t('gtuhome', 'Articles') ?></h1>
</div>
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
      <div class="articles-block-image">
      	<img src="<?= $src; ?>" alt="" height="232px;">
      </div>
      <div class="caption">
        <h3><?= $article->name; ?></h3>
        <div class="articles-content-short"><?= $article->short_description; ?></div>
        <div class="thumbnail-footer">
        	<div class="row">
            	<div class="col-xs-6">
                	<span><i class="fa fa-clock-o" aria-hidden="true"></i> <?= $article->view_duration; ?> min</span>
                	<span><i class="fa fa-eye" aria-hidden="true"></i> <?= $article->view_count; ?></span>
                </div>
            	<div class="col-xs-6">
                <div class="text-right">
                    <!-- <?php 
                    $res = strtolower($article->name);
                    $url_key = str_replace(" ", "-", $res);
                    $url_key = rawurlencode($url_key);
                    ?>
                    <a href="/article/view/<?= $url_key;?>" class="read-artical" onclick="CheckArticleViewed(<?= $article->id;?>);">Read More</a> -->
                    <a href="/article/view?id=<?= $article->id;?>" class="read-artical" onclick="CheckArticleViewed(<?= $article->id;?>);">Read More</a>
                    
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
<?php endforeach; ?>


<!--<div class="thumbnail articles-block-home">
      <img src="/images/package-img.png" alt="">
      <div class="caption">
        <h3>Always Invest In Your Education</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
        <div class="thumbnail-footer">
        	<div class="row">
            	<div class="col-xs-6">
                	<span><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Min</span>
                	<span><i class="fa fa-eye" aria-hidden="true"></i> 112</span>
                </div>
            	<div class="col-xs-6">
                <div class="text-right">
                	<a href="#" class="read-artical">Read More</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
<div class="thumbnail articles-block-home">
      <img src="/images/package-img.png" alt="">
      <div class="caption">
        <h3>Always Invest In Your Education</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
        <div class="thumbnail-footer">
        	<div class="row">
            	<div class="col-xs-6">
                	<span><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Min</span>
                	<span><i class="fa fa-eye" aria-hidden="true"></i> 112</span>
                </div>
            	<div class="col-xs-6">
                <div class="text-right">
                	<a href="#" class="read-artical">Read More</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    
<div class="thumbnail articles-block-home">
      <img src="/images/package-img.png" alt="">
      <div class="caption">
        <h3>Always Invest In Your Education</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
        <div class="thumbnail-footer">
        	<div class="row">
            	<div class="col-xs-6">
                	<span><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Min</span>
                	<span><i class="fa fa-eye" aria-hidden="true"></i> 112</span>
                </div>
            	<div class="col-xs-6">
                <div class="text-right">
                	<a href="#" class="read-artical">Read More</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
<div class="thumbnail articles-block-home">
      <img src="/images/package-img.png" alt="">
      <div class="caption">
        <h3>Always Invest In Your Education</h3>
        <p>Get assigned your personal counselor without any cost and discuss in detail the universities, courses, fees, scholarships and narrow down to the perfect institution.</p>
        <div class="thumbnail-footer">
        	<div class="row">
            	<div class="col-xs-6">
                	<span><i class="fa fa-clock-o" aria-hidden="true"></i> 5 Min</span>
                	<span><i class="fa fa-eye" aria-hidden="true"></i> 112</span>
                </div>
            	<div class="col-xs-6">
                <div class="text-right">
                	<a href="#" class="read-artical">Read More</a>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>-->
    
<!--<?php foreach($articles as $article): ?>
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
							
<div class="articles-block">
<div class="row">
	<div class="col-sm-6">
		<div class="article-img"> <img src="<?php echo $src; ?>" /> </div>
	</div>
	<div class="col-sm-6">
		<div class="article-text">
			<div class="ic-cots"> <i class="fa fa-quote-right" aria-hidden="true"></i> </div>
			<?php echo $article->description;?>
			<a href="?r=article/view&id=<?php echo $article->id;?>" class="btn btn-blue">Read More</a>
		</div>
	</div>
</div>
</div>
 
 <?php endforeach; ?>-->
 
</div>
</div>
</div>
<script type="text/javascript">
function CheckArticleViewed(id) {
$.ajax({
url: '/site/articleviewed',
method: 'POST',
data: {
article_id: id,
},
success: function(response, data) {
response = JSON.parse(response);
if(response.status == 'success') {
alert(response);
}
},
error: function(error) {
console.log(error);
}
});
}
</script>
