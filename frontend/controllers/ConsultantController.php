<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Consultant;
use frontend\models\ConsultantSearch;
use common\components\Roles;
use partner\models\PartnerLogin;

/**
 * HomeSearchController
 */
class ConsultantController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
		Yii::$app->view->params['activeTab'] = 'consultant';
		 
		 
		/*  $consultants = Consultant::find()->leftJoin('partner_login', '`partner_login`.`id` = `consultant`.`consultant_id` AND `partner_login`.`role_id` = ' . Roles::ROLE_CONSULTANT)->where(
		['AND',['is_active'=>1],
		['is_featured'=>1],
		['partner_login.status'=>PartnerLogin::STATUS_ACTIVE]
		])->all(); */
		
		
	$query = Consultant::find() 
		->leftJoin('partner_login', '`partner_login`.`id` = `consultant`.`consultant_id` AND `partner_login`.`role_id` = ' . Roles::ROLE_CONSULTANT)
		->leftJoin('country', '`country`.`id` = `consultant`.`country_id` ')
		->leftJoin('city', '`city`.`id` = `consultant`.`city_id` ')
		->where(['AND',['consultant.is_active'=>1],['partner_login.status'=>PartnerLogin::STATUS_ACTIVE]]);

	$sort = 'first_name';
	$order = 'ASC';
	if (isset($_GET['sort'])) {
	  $sort =	$_GET['sort']; 
    } 
	if (isset($_GET['order'])) {
		  $order = $_GET['order'];
	}  

	$query = $query->orderBy("$sort $order");
	 
 	$query = $query->all();
	return $this->render('index', ['models' => $query]); 
    }

    public function actionView($id) {
		$this->redirect('/consultant/index#'.$id);
    }
}