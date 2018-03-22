<?php
namespace partner\modules\consultant\controllers;

use common\models\StudentAssociateConsultants;
use common\components\AccessRule; 
use common\components\Roles;
use yii\filters\AccessControl;

class AssociateConsultantController extends \yii\web\Controller
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
							'actions' => ['index','create'],
							'allow' => true, 
							'roles' => [Roles::ROLE_CONSULTANT]
					], 		
                    ],
                   
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $user = Yii::$app->user->identity;
        $students = StudentAssociateConsultants::find()->where(['=', 'consultant_id', $user->id])->all();
        return $this->render('index', [
            'students' => $students,
        ]);
    }
    
}
