<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Services;
use common\models\PackageType;
use common\components\Status;

/**
 * HomeSearchController
 */
class ServiceController extends Controller
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
		Yii::$app->view->params['activeTab'] = 'services';
        $model = Services::findOne($id);
        $packages = PackageType::find()->where(['=', 'status', Status::STATUS_ACTIVE])->orderBy(['rank' => 'ASC'])->all();
        return $this->render('view', [
            'model' => $model,
            'packages' => $packages
        ]);
    }
}