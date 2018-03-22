<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use partner\models\Chart;
//use yii\web\JsExpression;
//HighchartsAsset::register($this)->withScripts(['highstock', 'modules/exporting', 'modules/drilldown']);

/* @var $this yii\web\View */
/* @var $searchModel partner\modules\university\models\UniversityCourseListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';
 
 $uniname = $model->name;	 
?>
<div role="tabpanel" class="tab-pane active" id="home">
                  <div class="row">
<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i> Top 7 Programs on GTU</h3>
</div> 
<div class="panel-body">

<?php  

$values = array();	 
$i=0;
foreach ($famousCourseGTU as $shortlisted){ 
$value = array(); 
$name[] = $shortlisted['name'];  	
$data[$i]['name'] =$shortlisted['name'];   
$view =  (int)$shortlisted['view'];	  
$data[$i]['data'] = array($view);   
$i++;
}  
echo Chart::ColumnChart($name,$data);


?>

</div>
</div>
</div>
					
<div class="col-sm-6">
<div class="panel panel-default">
  <div class="panel-heading">
	<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i> Top 7 Programs on <?php echo $uniname;?></h3>
  </div>
  <div class="panel-body">
		<?php  

$values = array();	 
$i=0;
foreach ($famousCourseUni as $shortlisted){ 
$value = array(); 
$name[] = $shortlisted['name'];  	
$data[$i]['name'] =$shortlisted['name'];   
$view =  (int)$shortlisted['view'];	  
$data[$i]['data'] = array($view); 
$values[] = $shortlisted['view']; 
$i++;
}  
echo Chart::ColumnChart($name,$data);
?>
  </div>
</div>
</div>

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-heading">

<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i> Most Shortlisted 7 Programs on GTU</h3>
</div> 
<div class="panel-body">

<?php  

$values = array();	 
$i=0;
foreach ($mostShortListedGTU as $shortlisted){ 
$value = array(); 
$name[] = $shortlisted['name'];  	
$data[$i]['name'] =$shortlisted['name'];   
$view =  (int)$shortlisted['cnt'];	  
$data[$i]['data'] = array($view);   
$i++;
}  
echo Chart::ColumnChart($name,$data);


?>

</div>
</div>
</div>

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i> Most Shortlisted 7 Programs on <?php echo $uniname;?></h3>
</div> 
<div class="panel-body">

<?php  

$values = array();	 
$i=0;
foreach ($mostShortListedUni as $shortlisted){ 
$value = array(); 
$name[] = $shortlisted['name'];  	
$data[$i]['name'] =$shortlisted['name'];   
$view =  (int)$shortlisted['cnt'];	  
$data[$i]['data'] = array($view);   
$i++;
}  
echo Chart::ColumnChart($name,$data);


?>

</div>
</div>
</div>

                     
                  </div>
              </div>
			  
  
<!--
<div class="university-course-list-index">
 
<div class="row"> 
 
<div class="col-sm-12">
<h3>GTU Stats</h3> 
</div>
	
	</div>
	
 <div class="basic-details"> 
<div class="row address"> 
   <div class="col-sm-6">
   <h3>Number of views on your Programs	</h3> 
   <div class="row">
   <div class="col-sm-9">
   <p><strong>Program</strong></p>
   <?php  
   if (count($famousCourseUni)>0) {
	   foreach ($famousCourseUni as $shortlisted){?>
   <p> <?php echo $shortlisted['name']; ?>  </p>   
   <?php }
   }else{
		echo "Not found famous programs for this University";
	}
	?>
	</div>
	
	<div class="col-sm-3">
	<p><strong>Views</strong></p>
 <?php  foreach ($famousCourseUni as $shortlisted){?>
   <p> <?php echo $shortlisted['view']; ?>  </p>   
   <?php }?>
	</div>
	</div>
	</div>
	
   <div class="col-sm-6">
   <h3>Famous Programs on GTU</h3> 
   <div class="row">
   <div class="col-sm-9">
   <p><strong>Program</strong></p>
    <?php  
   if (count($famousCourseGTU)>0) {
	   foreach ($famousCourseGTU as $shortlisted){?>
   <p> <?php echo $shortlisted['name']; ?>  </p>   
   <?php }
   }else{
		echo "Not found famous programs for this University";
	}
	?>
	</div>
	
	<div class="col-sm-3">
	<p><strong>Views</strong></p>
	 <?php  foreach ($famousCourseGTU as $shortlisted){?>
   <p> <?php echo $shortlisted['view']; ?>  </p>   
   <?php }?>
	</div>
	</div>
		</div>
</div>
</div> 
 
<div class="basic-details"> 
<div class="row address"> 
   <div class="col-sm-6">
   <h3>Your Shortlisted Programs		</h3> 
    <div class="row">
   <div class="col-sm-9">
   <p><strong>Programs</strong></p>
   <?php  
   if (count($mostShortListedUni)>0) {
	   foreach ($mostShortListedUni as $shortlisted){?>
   <p> <?php echo $shortlisted['name']; ?>  </p>   
   <?php }
   }else{
		echo "Not found shortlisted programs for this University";
	}
	?>
	</div>
	
	<div class="col-sm-3">
	<p><strong>Views</strong></p>
	  <?php  foreach ($mostShortListedUni as $shortlisted){?>
   <p> <?php echo $shortlisted['cnt']; ?>  </p>   
   <?php }?>
	</div>
		</div>
	</div>
	
	<div class="col-sm-6">
   <h3>Most Shortlisted Programs on GTU	</h3> 
    <div class="row">
   <div class="col-sm-9">
   <p><strong>Program</strong></p>
    <?php  if (count($mostShortListedGTU)>0) {
		foreach ($mostShortListedGTU as $shortlisted){?>
   <p> <?php echo $shortlisted['name']; ?>  </p>   
	<?php }
		}else{
		echo "No shortlisted programs for GTU";
	}?>
	</div>
	
	<div class="col-sm-3">
	<p><strong>Views</strong></p>
	  <?php  foreach ($mostShortListedGTU as $shortlisted){?>
   <p> <?php echo $shortlisted['cnt']; ?>  </p>   
   <?php }?>
	</div>
		</div>
	</div>
</div>
</div> 
 <br/>
  <br/>
   <br/>
    <br/>
</div>
-->