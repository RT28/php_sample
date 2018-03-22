<?php
use yii\helpers\Html; 
use yii\helpers\FileHelper;
use common\models\Articles; 

$articles = Articles::find()->orderBy(['id' => 'DESC'])->limit(5)->all();
?>
<div class="section section-padding articles">
<div class="container">
<div class="group-title-index">
<h1>Articles</h1>
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
 
 <?php endforeach; ?>
 
</div>
<a class="view-all-article" href="?r=article/index">View more</a>
</div>
</div>
