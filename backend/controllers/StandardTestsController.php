<?php

namespace backend\controllers;

use Yii;
use common\models\StandardTests;
use backend\models\StandardTestsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl;

/**
 * StandardTestsController implements the CRUD actions for StandardTests model.
 */
class StandardTestsController extends Controller
{
    /**
     * @inheritdoc
     */
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
                        'actions' => ['index', 'view', 'create', 'update',],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_EDITOR]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN]
                    ]
                ]
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
     * Lists all StandardTests models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StandardTestsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StandardTests model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StandardTests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StandardTests();

		$message = '';
		if(Yii::$app->request->post()) {
		$model->load(Yii::$app->request->post());
		$exists = StandardTests::find()->where(['AND',['=', 'name', $model->name],
		['=', 'test_category_id', $model->test_category_id]])->one();
		if(empty($exists)) {  
            $test_subject_id = implode(',',$model->test_subject_id);
            $model->test_subject_id = $test_subject_id;
            
			$model->created_by = Yii::$app->user->identity->id;
			$model->updated_by = Yii::$app->user->identity->id;
			$model->created_at = gmdate("M d Y H:i:s");
			$model->updated_at = gmdate("M d Y H:i:s");
			$model->save();
			$message = 'Success! Standard Test added successfull.';
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			$message = 'Error! Standard Test already exists.';
			return $this->render('create', [
			'model' => $model,
			'message' => $message,  
		]);
		} 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StandardTests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->test_subject_id = explode(',',$model->test_subject_id);

        if ($model->load(Yii::$app->request->post())) {
            $test_subject_id = implode(',',$model->test_subject_id);
            $model->test_subject_id = $test_subject_id;
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StandardTests model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StandardTests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StandardTests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StandardTests::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
