<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PartnerEmployee;
use frontend\models\TraineeSearch;
use common\components\Roles;
use partner\models\PartnerLogin;

/**
 * HomeSearchController
 */
class TraineeController extends Controller
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

    public function actionView($id) {
    	
	$query = PartnerEmployee::find()->where(['partner_login_id'=>$id]);

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

}