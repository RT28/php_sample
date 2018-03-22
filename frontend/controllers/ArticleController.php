<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Articles; 
use yii\helpers\FileHelper;

/**
 * HomeSearchController
 */
class ArticleController extends Controller
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
        return $this->render('index');
    }

    
	 public function actionView()
    { 
        $id = Yii::$app->request->get('id');
        return $this->render('view', [
            'model' => $this->findModel($id),
			'articles' => $articles = Articles::find()->where(['not',['id'=>$id]])->orderBy(['id' => 'DESC'])->limit(5)->all() 
        ]);
    }
	 protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}