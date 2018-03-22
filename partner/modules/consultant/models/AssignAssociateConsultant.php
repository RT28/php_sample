<?php

namespace partner\modules\consultant\models;

use Yii;
use yii\base\Model; 

use common\models\StudentConsultantRelation;

 

/**
 * ConsultantTasksSearch represents the model behind the search form about `common\models\ConsultantTasks`.
 */
class AssignAssociateConsultant extends StudentConsultantRelation
{
	 public $student_id, $consultant_id,
	$comment_by_consultant, $access_list,$accessoption,
	$start_date,
	$end_date ;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
	return [
		[['student_id', 'consultant_id','comment_by_consultant',  'start_date', 'end_date','access_list' ], 'required'],  
		 //[['access_list'], 'optValidation', 'on' => 'submit'],
		];
    }
	
	
	public function optValidation($attribute, $params) {
    foreach ($attribute as $attr){
        if ($attr == 1) {
            $return = true;
        }
        else {
            $return = false;
        }
    }
    if (!$return) {
        $this->addError($attribute, 'At least one checkbox has to be selected!');   
    }
}
 
}
