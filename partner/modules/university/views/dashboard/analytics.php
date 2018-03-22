<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use partner\models\Chart;
use yii\web\JsExpression;

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
<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i>Top 7 Programs on GTU</h3>
</div> 
<div class="panel-body">

<?php  
 
$i=0;
foreach ($famousCourseGTU as $shortlisted){  
$data[$i]['name'] =$shortlisted['name'];    
$data[$i]['y'] = (int)$shortlisted['view'];	   
$data[$i]['color'] = new JsExpression('Highcharts.getOptions().colors['.$i.']');   
$i++;
}  
$title = 'Pie Chart';
echo Chart::PieChart($title,$data);
 
?>

</div>
</div>
</div>
	
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i>Top 7 Programs on GTU</h3>
</div> 
<div class="panel-body">

<?php  
 
$i=0;
foreach ($famousCourseGTU as $shortlisted){  
$val = array();
$line[$i]['name'] =$shortlisted['name'];
$view = (int)$shortlisted['view'];	
array_push($val,$i);  
$a = $i+$view;
array_push($val,$a);   
array_push($val,$view);   
$line[$i]['data'] =  $val;  
  
$i++;
}  
$title = 'Line Chart';
echo Chart::LineChart($title,$line);
 
?>

</div>
</div>
</div>
	
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-pie-chart" aria-hidden="true"></i>Top 7 Programs on GTU</h3>
</div> 
<div class="panel-body">

<?php  
 
$i=0;
foreach ($famousCourseGTU as $shortlisted){  
$val = array();
$line[$i]['name'] =$shortlisted['name'];
$view = (int)$shortlisted['view'];	
//array_push($val,null);  
array_push($val,$i);  
$a = $i+$view;
array_push($val,$a);   
array_push($val,$view);   
$line[$i]['data'] =  $val;  
  
$i++;
}  
$title = 'Area Chart';
echo Chart::AreaChart($title,$line);
 
?>

</div>
</div>
</div>	
		 
</div>
</div>
	 