<?php

namespace frontend\controllers;

use Yii;
use common\models\WebinarCreateRequest;
use frontend\models\WebinarCreateRequestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Status;
use backend\models\SiteConfig;
use common\components\ConnectionSettings;
use yii\helpers\ArrayHelper;




/**
 * WebinarController implements the CRUD actions for WebinarCreateRequest model.
 */
class WebinarController extends Controller
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

    /**
     * Lists all WebinarCreateRequest models.
     * @return mixed
     */
   /* public function actionIndex()
    {
        $searchModel = new WebinarCreateRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'home';
        $webinars = WebinarCreateRequest::find()->where(['=', 'status', '1'])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index', [
            'webinars' => $webinars
            
        ]);
    }

    /**
     * Displays a single WebinarCreateRequest model.
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
     * Creates a new WebinarCreateRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebinarCreateRequest();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->status = Status::STATUS_NEW;
            $model->created_at = gmdate('Y-m-d H:i:s');
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->created_by = $model->author_name;
            $model->updated_by = $model->author_name;
            $user = $model->author_name;
            $model->save();

            if($this->sendActivationLink($model->id, $model->email, $user)) {
                        return $this->render('create', [
                        'model' => $model, 
                        'status' => 'success', 'id' => $model->id]);
                    }
          
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

        private function sendActivationLink($id, $email, $user) {
        $cc = SiteConfig::getConfigGeneralEmail();
        $from = SiteConfig::getConfigFromEmail();   
                
        $time = time();
        Yii::$app->mailer->compose(['html' => '@common/mail/webinar-author-regis'],[
                'user' => $user,
                'consultantname' => 'consultantname',
                'packagestype' => 'df',
                'link' => ConnectionSettings::BASE_URL . 'webinar/update?id=' . $id . '&timestamp=' . strtotime('+2 days', $time),
            ])
            ->setFrom($from)
            ->setTo($email)
            //->setCc($cc)
            ->setSubject('GoToUniversity Consult a Webinar')
            ->send();
        return true;
    }

    /**
     * Updates an existing WebinarCreateRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->status = Status::STATUS_ACTIVE;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,

            ]);
        }
    }

    /**
     * Deletes an existing WebinarCreateRequest model.
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
     * Finds the WebinarCreateRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebinarCreateRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebinarCreateRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
