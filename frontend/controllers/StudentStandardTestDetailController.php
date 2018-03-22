<?php

namespace frontend\controllers;

use Yii;
use common\models\StudentStandardTestDetail;
use frontend\models\StudentStandardTestDetailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use common\models\StandardTests;
use common\models\TestSubject;
/**
 * StudentStandardTestDetailController implements the CRUD actions for StudentStandardTestDetail model.
 */
class StudentStandardTestDetailController extends Controller
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
     * Lists all StudentStandardTestDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentStandardTestDetailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentStandardTestDetail model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTestmodal($id)
    {
        return $this->render('testmodal');
    }

    /**
     * Creates a new StudentStandardTestDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentStandardTestDetail();

        $model->student_id = Yii::$app->user->identity->id;
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->updated_at = gmdate('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post())) {
            $arr_marks = $marks_details = [];
            if(isset($model->test_name) && $model->test_name!= 0){
                $model->test_id = $model->test_name;
                $subject_ids = StandardTests::find()->select(['test_subject_id','name'])->where(['id'=>$model->test_name])->asArray()->one();
                $explode_id = explode(',',$subject_ids['test_subject_id']);
                foreach($explode_id as $key => $value){
                    $postname = 'subject-'.$value;
                    $sub_name = TestSubject::find()->where(['id'=>$value])->one()->name;
                    if(isset($_POST[$postname]) && $_POST[$postname] != ''){
                        $marks_details['name'] = $sub_name;
                        $marks_details['score'] = $_POST[$postname];
                        $arr_marks[$value] = $marks_details;
                    }else{
                        $get_subjects = $this->actionGetsubjects($model->test_name,$model->test_marks);

                        return $this->renderAjax('create', [
                            'model' => $model,
                            'subjects'=>$get_subjects,
                            'marks_error'=>'Test Marks cannot be Blank',
                        ]);
                    }
                }
                $model->test_name = $subject_ids['name'];
            }else{
                $error1 = $error2 = $marks_error = '';
                if(isset($_POST['StudentStandardTestDetail']['other_test']) && $_POST['StudentStandardTestDetail']['other_test'] == ''){
                    $error1='Test Name cannot be Blank';
                }else{
                    $model->test_name = $_POST['StudentStandardTestDetail']['other_test'];
                }

                if(isset($_POST['StudentStandardTestDetail']['test_authority']) && $_POST['StudentStandardTestDetail']['test_authority'] == ''){
                    $error2='Test Authority cannot be Blank';
                }else{
                    $model->test_authority = $_POST['StudentStandardTestDetail']['test_authority'];
                }

                $model->test_id = 0;
                if(isset($_POST['other']) && $_POST['other'] != ''){
                    $marks_details['name'] = $_POST['StudentStandardTestDetail']['other_test'];
                    $marks_details['score'] = $_POST['other'];
                    $arr_marks[0] = $marks_details;
                }else{
                    $marks_error = 'Test Marks cannot be Blank';
                    $get_subjects = '<input type="text" id="other" name="other" class="form-control" placeholder="Test Marks" />';
                    return $this->renderAjax('create', [
                        'model' => $model,
                        'subjects'=>$get_subjects,
                        'marks_error'=>$marks_error,
                        'other_test'=>$error1,
                        'test_authority'=>$error2,
                    ]);
                }
            }
             
            $model->test_marks = Json::encode($arr_marks);
            $model->save();
    
            return $this->redirect(['application-form/index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionGetsubjects($test_id,$marks)
    {
        $marks_decode = [];
        $subjects = '';
        $marks_decode = Json::decode($marks);
        if(empty($marks_decode)){
            $subject_ids = StandardTests::find()->select(['test_subject_id'])->where(['id'=>$test_id])->asArray()->one();
            if(isset($subject_ids)){
                $explode_id = explode(',',$subject_ids['test_subject_id']);
                
                foreach($explode_id as $key => $value){
                    $sub_name = TestSubject::find()->select(['name'])->where(['id'=>$value])->asArray()->one();
                    if(isset($sub_name)){
                        $subjects .= '<tr><td>'.$sub_name['name'].'</td><td><input name="subject-'.$value.'" value="" class="form-control" /></td></tr>';
                    }
                }
            }else{
                return 1;
            }
        }else{
            foreach($marks_decode as $key => $value){
                $subjects .= '<tr><td>'.$key.'</td><td><input name="subject-'.$value.'" value="'.$value.'" class="form-control" /></td></tr>';
            }
        }

        return $subjects;
    }

    /**
     * Updates an existing StudentStandardTestDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $subjects = '';
        
        if(isset($model->test_marks)){
            $test_marks = Json::decode($model->test_marks);
            foreach($test_marks as $key => $value){
                if($model->test_id != 0){
                    $subjects .= '<tr><td>'.$value['name'].'</td><td><input name="subject-'.$key.'" value="'.$value['score'].'" class="form-control" /></td></tr>';
                }else{
                    $subjects = '<input name="other" id="other" value="'.$value['score'].'" class="form-control" />';
                }
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            if(isset($model->test_marks)){
                $marks = Json::decode($model->test_marks);
                foreach($marks as $key => $value){
                    if($key != 0){
                        $postname = 'subject-'.$key;
                        $marks[$key]['score'] = $_POST[$postname];
                    }else{
                        $marks[$key]['score'] = $_POST['other'];
                    }
                }
                $model->test_marks = Json::encode($marks);
            }
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = gmdate('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['application-form/index']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'subjects'=>$subjects,
            ]);
        }
    }

    /**
     * Deletes an existing StudentStandardTestDetail model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['application-form/index']);
    }

    /**
     * Finds the StudentStandardTestDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentStandardTestDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentStandardTestDetail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
