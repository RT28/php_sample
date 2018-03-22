<?php

namespace partner\modules\employee\controllers;

use Yii;
use common\models\LeadFollowup;
use partner\modules\employee\models\LeadFollowupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\components\Roles; 
use yii\filters\AccessControl; 
use common\components\AccessRule;
/**
 * LeadFollowupController implements the CRUD actions for LeadFollowup model.
 */
class LeadFollowupController extends Controller
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
                            'actions' => ['index', 'create','view', 'update', 'delete','download',
                            'subcat', 'list', 'getdetail', 'reminder'],
                            'allow' => true, 
                            'roles' =>  [Roles::ROLE_EMPLOYEE,Roles::ROLE_TRAINER]
                    ], 
                            
                    ],
                   
            ],
           
        ];
    } 
    /**
     * Lists all LeadFollowup models.
     * @return mixed
     */
    public function actionIndex()
    { 
        $searchModel = new LeadFollowupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeadFollowup model.
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
     * Creates a new LeadFollowup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new LeadFollowup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }*/
        $model = new LeadFollowup();
        $id = Yii::$app->user->identity->id; 
        $student_id= '';        
        if(isset($_REQUEST['id'])){
                  $student_id = $_REQUEST['id'];  
             }      
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        if ($model->load(Yii::$app->request->post())) {
            if(isset($_POST['reason_code']) AND $_POST['reason_code']!=0){
                 $model->next_followup = "0000-00-00 00:00:00";
             }   
            
                $model->student_id = $student_id; 
                $model->consultant_id = Yii::$app->user->identity->id; 
                $model->created_by = Yii::$app->user->identity->username;
                $model->updated_by = Yii::$app->user->identity->username;
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                $datetimeStr = gmdate('Y-m-d H:i:s');
                Yii::$app->db->createCommand()
                 ->update('lead_followup', ['today_status' => 2], 'student_id = '.$model->student_id.'')
                 ->execute();
                if($model->save(false)){

                    if($model->status !=5){ 
                  Yii::$app->db->createCommand()
                   ->update('user_login', ['follow_status' => $model->status], ['id' => $student_id])
                   ->execute();
                }
                }
               /* if($model->status ==1){
                CalendarEvents::assignTaskcalender($model, $model->consultant_id, Roles::ROLE_CONSULTANT,CalendarEvents::TYPE_FOLLOWUP,CalendarEvents::MODE_EMAIL);
                }*/
                if($model->status ==5){
                return $this->redirect(['leads/index']);
                }
                else {
                    $link_redirect = "index.php?r=employee/leads/index&status=".$model->status; 
                    return $this->redirect($link_redirect);
                    
                }
        }
         else {
            return $this->renderAjax('create', [
                'model' => $model,
                //'students' => $this->getAllAssignedStudent(),
                'student_id' => $student_id,
                //'task_id' => $task_id,
                //'upload' => $upload
            ]);
        }
    }

    /**
     * Updates an existing LeadFollowup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LeadFollowup model.
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
     * Finds the LeadFollowup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadFollowup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadFollowup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
