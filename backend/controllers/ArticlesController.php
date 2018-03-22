<?php

namespace backend\controllers;

use Yii;
use common\models\Articles;
use backend\models\ArticlesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use yii\helpers\FileHelper;
use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl;

 
class ArticlesController extends Controller
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

     
    public function actionIndex()
    {
        $searchModel = new ArticlesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
     public function actionCreate()
    {
        $model = new Articles();
        $statusList = Status::getActiveInactiveStatus();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->user->identity->id;
            $model->updated_by = Yii::$app->user->identity->id;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if( $model->save() && $this->saveIcon($model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusList' => $statusList
        ]);
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusList = Status::getActiveInactiveStatus();

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            if( $model->save() && $this->saveIcon($model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusList' => $statusList
        ]);
    }

    private function saveIcon($id) {
        if(!isset($_FILES['icon']['name'])) {
            return true;
        }
        $icon = $_FILES['icon'];
        if($icon['error'] == 0) {
            $sourcePath = $icon['tmp_name'];
            $ext = pathinfo($icon['name'], PATHINFO_EXTENSION);
            $targetPath = './../web/articles-uploads/' . $id . '/icon' . '.' . $ext;
            $failed_files = [];
            $result = is_dir('./../web/articles-uploads/' . $id);
            if (!$result) {
                $result = FileHelper::createDirectory('./../web/articles-uploads/' . $id);
            }
            if (move_uploaded_file($sourcePath,$targetPath)) {
                return true;
            }
            return false;
        }
    }

    /**
     * Deletes an existing Services model.
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
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeletePhoto(){
        $service = Yii::$app->request->post('service_id');
        $key = Yii::$app->request->post('key');
        if (unlink("./../web/articles-uploads/$service/$key")) {
            echo json_encode([]);
        } else {
            echo json_encode(['error' => 'Error deleting... ']);
        }
    }
}
