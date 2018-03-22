<?php

namespace backend\controllers;

use Yii;
use frontend\models\FeaturedUniversities;
use backend\models\FeatureUniversitiesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\University;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;

/**
 * FeaturedUniversitiesController implements the CRUD actions for FeaturedUniversities model.
 */
class FeaturedUniversitiesController extends Controller
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
     * Lists all FeaturedUniversities models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeatureUniversitiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeaturedUniversities model.
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
     * Creates a new FeaturedUniversities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FeaturedUniversities();
        $universities = University::find()->orderBy(['name' => 'ASC'])->all();
        $universities = ArrayHelper::map($universities, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_by = Yii::$app->user->identity->id;
            if( $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'universities' => $universities
            ]);
        }
    }

    /**
     * Updates an existing FeaturedUniversities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $universities = University::find()->orderBy(['name' => 'ASC'])->all();
        $universities = ArrayHelper::map($universities, 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            if( $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'universities' => $universities
            ]);
        }
    }

    /**
     * Deletes an existing FeaturedUniversities model.
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
     * Finds the FeaturedUniversities model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FeaturedUniversities the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeaturedUniversities::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
