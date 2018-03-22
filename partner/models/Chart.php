<?php
namespace partner\models;
use yii;
use yii\base\Model;
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\web\JsExpression;
 
class Chart extends Model 
{
	 
	public function ColumnChart($name,$data){
		
	$ColumnChart = Highcharts::widget(
    [ 'scripts' => ['modules/exporting', 'themes/grid-light',],
      'options' => [
	  'chart' => [ 'type' => 'column' ],
        'title' => [
            'text' => ' ',
        ],
        'xAxis' => [
            'categories' => $name,
			'labels' => [
            'enabled' => false,
			],
        ],  
		 'yAxis' => [
            'title' => [
            'text' => ' ',
			],  
        ], 
		 'series' => $data		 
		]
	]); 
		return $ColumnChart;
	}
	
	public function PieChart($title,$data) {
	
	$PieChart =   Highcharts::widget(
	[ 'scripts' => ['modules/exporting', 'themes/grid-light',],
      'options' => [
		'chart' => [  
			'type' => 'pie'
		],
        'title' => [
            'text' => $title,
        ],
	 	'tooltip' => [
            'pointFormat' =>  '{series.name}: <b>{point.percentage:.1f}%</b>',
        ],         
		'plotOptions' => [
            'pie' => [
			'allowPointSelect' => true,
			'cursor' =>  'pointer',
				'dataLabels' =>   [
					'enabled' => true,
					'format' =>  '{point.percentage:.1f} %',
					'style' => [
						'color' => '(Highcharts.theme &&  Highcharts.theme.contrastTextColor) || black',
						],
				],
			],
        ],      
        'series' => [[   
					'name' => 'Brands', 
					'colorByPoint' => true,  
					'data' => $data ],
					], 
		]
	]);
	return $PieChart; 
	
	}
	
	
	public function LineChart($title,$data){
		
	$LineChart =   Highcharts::widget(
	[ 'scripts' => ['modules/exporting', 'themes/grid-light',],
    'options' => [
		'chart' => [  
			'type' => 'line'
		],
        'title' => [
            'text' => $title,
        ],  
		'legend' => [
            'layout' => 'vertical',
			'align' => 'right',
			'verticalAlign' => 'middle',
        
		], 		
		'yAxis' => [
            'title' => [
            'text' =>  $title,
			],
        ],  		 
        'series' =>   $data		  
		]
	]); 
	
	return $LineChart;
	
	}
	
	public function AreaChart($title,$data){
		
	$AreaChart =   Highcharts::widget(
	[ 'scripts' => ['modules/exporting', 'themes/grid-light',],
    'options' => [
		'chart' => [  
			'type' => 'area'
		],
        'title' => [
            'text' => $title,
        ],   	
		'xAxis' => [
			'allowDecimals' =>  false, 
        ], 	
		'yAxis' => [
            'title' => [
            'text' =>  $title,
			], 
        ],  	
		'tooltip' => [
            'pointFormat' => '{series.name} produced <b>{point.y:,.0f}</b><br/>warheads in {point.x}',
        ],         
		'plotOptions' => [
            'area' => [
			'pointStart' => 1940, 
			'marker' => [  		 
				'enabled' => false,
				'symbol' =>  'circle',
				'radius' =>  2,
				'states' => ['hover' => ['enabled' => false,],],
				], 
			],
        ], 		
        'series' =>    $data
 	
		]
	]); 
	
	return $AreaChart;
	
	}
	
}