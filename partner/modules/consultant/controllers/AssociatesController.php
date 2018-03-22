<?php
namespace partner\modules\consultant\controllers;

use Yii;
use common\models\StudentConsultantRelation;  
use partner\models\PartnerLogin;
use yii\helpers\ArrayHelper; 
use common\components\AccessRule; 
use common\components\Roles;
use yii\filters\AccessControl;

/**
 * Default controller for the `consultant` module
 */
class AssociatesController extends \yii\web\Controller
{
	 public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::classname(),
				'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
               
                'rules' => [   
					[
							'actions' => ['index','create', 'view', 'update'],
							'allow' => true, 
							'roles' => [Roles::ROLE_CONSULTANT]
					], 
					[
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_CONSULTANT]
                    ]
							
                    ],
                   
            ],
            
        ];
    } 
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $consultant_id = Yii::$app->user->identity->id; 
        $associates = StudentConsultantRelation::find()->where(['AND', 
		['=','parent_consultant_id', $consultant_id],
		['=','is_sub_consultant', 1], 
		])->all();
        return $this->render('index', [
            'associates' => $associates
        ]);
    }

    
}
