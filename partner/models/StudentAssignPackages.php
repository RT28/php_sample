<?php
namespace partner\models;
use yii;
use yii\base\Model;

class StudentAssignPackages extends Model 
{
	public $packagestype; 
	
	public function rules() 
	{
		return [
			[['packagestype'], 'required'], 
		];
	}

	 
}