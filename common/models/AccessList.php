<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\components\Commondata;
use common\models\StudentConsultantRelation;
/**
 * This is the model class for table "access_control".
 *
 * @property integer $id
 * @property string $name
 * @property string $controller
 * @property string $actions
 */
class AccessList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_control';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'controller', 'actions'], 'required'],
            [['name', 'controller', 'actions'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'controller' => 'Controller',
            'actions' => 'Actions',
        ];
    }
	
	public static function getAllAccessLIst() {
        $list = AccessList::find()->orderBy(['name'=>'ASC'])->all();
        return ArrayHelper::map($list, 'id', 'name');
    }
	
	public static function getAllAccessListActions() {
        $list = AccessList::find()->orderBy(['name'=>'ASC'])->all();
        return   $list;
    }
	
	public static function accessActions($action ) {
		
		 
	$controller = Yii::$app->controller->id;
		  
		
	if($action){
		$actionName = $action;
		$consultant_id = Yii::$app->user->identity->id;
		$id = Yii::$app->request->get('id');
		$student_id = Commondata::encrypt_decrypt('decrypt', $id);

		$SCR = StudentConsultantRelation::find()->where(['AND',
		['=', 'consultant_id', $consultant_id],
		['=', 'student_id',$student_id],
		['=', 'is_sub_consultant', '1']
		]
		)->one();
		if(isset($SCR)){
			
			if(!empty($SCR->access_list)){
				$array = array();
				$array = explode(',',$SCR->access_list);  

		if(isset($array)){
				 
		$accesslist = AccessList::find()->where(['in', 'id', $array])->all();
		if(isset($accesslist)){		
			foreach($accesslist as $list){ 
				 if($list->controller  == $controller){ 
				   $conervtedArray  = explode(',',$list->actions);
				   if(isset($accesslist)){	
					   foreach($conervtedArray as $key=>$value){ 
							$actionsArray[] = $value; 
					   }
				   }									
				}  
			}
		}
		
				} 
			
			} 
		}		
	}
		 
		$authority = true;	
		if(isset($actionsArray)){   										
			if (in_array($actionName, $actionsArray)) { 			 
				$authority = true; 
			}else{			 
				$authority = false; 
			} 
		} 
		return	$authority;
		
	}
	
}
