<?php

namespace partner\modules\consultant\controllers;

use Yii;
use common\models\Invoice;
use partner\modules\consultant\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Student;
use common\models\StudentConsultantRelation;
use frontend\models\UserLogin;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\UniversityCourseList;
use yii\widgets\ActiveForm;
use common\models\FileUpload;
use yii\web\UploadedFile;
use common\models\University; 



/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->params['activeTab'] = 'invoice';
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'universities' => $this->getUniversityList(),
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    { 
        $id=$_POST['id'];
        $model = $this->findModel($id); 
        return $this->renderAjax('view', [
            'model' => $model, 
        ]);
       /* return $this->render('view', [
            'model' => $this->findModel($id),
        ]);*/
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $upload = new FileUpload();
        $id = Yii::$app->user->identity->id; 
        $student_id= '';        
        if(isset($_REQUEST['id'])){
                  $student_id = $_REQUEST['id'];  
             }
        if(isset($_REQUEST['task_id'])){
                  $task_id = $_REQUEST['task_id'];  
             }         
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
             
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }     
        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }*/
        if ($model->load(Yii::$app->request->post())) {
                $model->consultant_id = Yii::$app->user->identity->id;
                $model->agency_id = 1; 
                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->created_at = gmdate('Y-m-d H:i:s');
                $model->updated_at = gmdate('Y-m-d H:i:s');
                $datetimeStr = gmdate('Y-m-d H:i:s');
                $datetime = strtotime($datetimeStr); 
                $model->refer_number = 'GT'.$datetime.rand(10,100);
                
                if($model->save(false)){
                   $task_id = $_POST['task_id'];
                  Yii::$app->db->createCommand()
                   ->update('tasks', ['status' => 2], ['id' => $_POST['task_id']])
                   ->execute();
                 
                    $this->saveUploadAttachment($upload, $model);
                }
                 
                return $this->redirect(['index']);
        }
         else {
            return $this->renderAjax('create', [
                'model' => $model,
                'students' => $this->getAllAssignedStudent(),
                'student_id' => $student_id,
                'task_id' => $task_id,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
       public function actionUpdate($id)
    {
         
        
        Yii::$app->view->params['activeTab'] = 'invoice';
        $model = $this->findModel($id);
        $upload = new FileUpload();

        $student_id= '';        
        if(isset($_REQUEST['id'])){
                  $student_id = $_REQUEST['id'];  
             }

         if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;  
                return Json::encode(ActiveForm::validate($model)); 
            
         }  
          
          if ($model->load(Yii::$app->request->post())) {
            $model->consultant_id = Yii::$app->user->identity->id; 
            $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
            $model->updated_at = gmdate('Y-m-d H:i:s');

                $model->consultant_id = Yii::$app->user->identity->id;
                $model->agency_id = 1; 
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = gmdate('Y-m-d H:i:s');
                
                if($model->save(false)){
                 
                    /*$comment = new TaskComment();
                    $comment->task_id =$model->id;
                    $comment->consultant_id =$model->consultant_id;
                    $comment->action =$model->action;
                    $comment->status =$model->status;
                    $comment->comment =$model->comments;
                    $comment->created_by = $model->updated_by;
                    $comment->created_at = $model->updated_at;
                    $comment->save(false);
             
                    $this->saveUploadAttachment($upload, $model);*/
                }
         
             
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'students' => $this->getAllAssignedStudent(),
                'student_id' => $student_id,
                'upload' => $upload
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
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
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    private function getAllAssignedStudent() { 
        $id = Yii::$app->user->identity->id;  
        $students = StudentConsultantRelation::find()
        ->leftJoin('user_login', 'user_login.id = student_consultant_relation.student_id') 
        ->where('student_consultant_relation.consultant_id = '.$id . ' AND 
        user_login.status = 4')
        ->all();
     
        
        $studentData = array();     
        $i = 0;              
        foreach($students as $student){
    
        $studentProfile = $student->student->student;   
        $studentData[$i]['id'] = $studentProfile->student_id;   
        $studentData[$i]['name'] =  $studentProfile->first_name." ".$studentProfile->last_name;

        
        $i++;
        }
         
        $studentList = ArrayHelper::map($studentData, 'id', 'name');
        return $studentList;
    }
    public function actionGetstudentdetail($id) {
        if (isset($id)) {
            $StudentDet = Student::find()->where(['=', 'id', $id])->one();
            $UserDet = UserLogin::find()->where(['=', 'id', $id])->one();
           $detail = "<div class='row'><div class='col-sm-5'>
                       Student Name : <b>".$StudentDet->first_name.'&nbsp;'.$StudentDet->last_name."</b>
                        </div>
                        <div class='col-sm-5'> 
                           Address : <b>".$StudentDet->address."</b>
                        </div>
                      </div>
                      <div class='row'><div class='col-sm-5'>
                       Email : <b>".$StudentDet->email."</b>
                        </div>
                        <div class='col-sm-5'> 
                           Phone : <b>+".$UserDet->code.'&nbsp;'.$StudentDet->phone."</b>
                        </div>
                      </div><br>";
           return Json::encode(['result'=>$detail, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }
    public function actionProgram() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];

            if ($parents != null) {
                $cat_id = $parents[0];
                $selected = '';

                $out = UniversityCourseList::find()
                ->where(['university_id'=>$cat_id])
                ->select(['id as id','name as name'])
                ->orderBy('name')
                ->asArray()->all();
                //if(!empty($out)){
                    array_push($out,['id'=>'0', 'name'=>'Others']);  
                //}
                echo Json::encode(['output'=>$out, 'selected'=>'selected']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
        private function saveUploadAttachment($upload, $model) {
        $newFile = UploadedFile::getInstance($upload, 'attachment');
     
        if (isset($newFile)) {
            $upload->attachment = $newFile;
            $filename = $upload->uploadInvoiceAttachment($model);            
             
            if(isset($filename)){
        
            if(!empty($model)) {             
                    //$model->updated_by = Yii::$app->user->identity->id;
                   // $model->updated_at = gmdate('Y-m-d H:i:s'); 
                    $model->invoice_attachment = $filename; 
                    $model->save(false); 
            }       
                    return true;
            } else {
                return false;
            }
        }
        return true;
    }
     private function getUniversityList() {
        return ArrayHelper::map(University::find()->orderBy('name')->all(), 'id', 'name');
    }
    
}
