<?php
namespace partner\modules\consultant\controllers;

use common\models\Consultant;
use common\models\StudentConsultantRelation;
use common\models\Student;
use common\models\StudentEnglishLanguageProficienceyDetails;
use common\models\StudentStandardTestDetail;
use common\models\Degree;
use common\models\Majors;
use common\models\User;
use common\models\PackageType;
use yii\helpers\FileHelper;
use common\models\StudentAssociateConsultants;
use common\models\AssociateConsultants;
use common\models\StudentPackageDetails;
use common\models\StudentLeadFollowup;
use yii\helpers\ArrayHelper;
use partner\models\StudentAssignPackages;
use common\components\ConnectionSettings;
use backend\models\SiteConfig;
use common\models\Country; 
use common\components\AccessRule;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\UserLogin;
use Yii;

class StudentslistController extends \yii\web\Controller
{
    public function actionIndex() {
        $id = Yii::$app->user->identity->id;  
        Yii::$app->view->params['activeTab'] = 'leads';
        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one();
        //$degrees = Degree::find()->orderBy('name')->all();
        //$degrees = ArrayHelper::map($degrees, 'id', 'name');
        //$majors = Majors::find()->orderBy('name')->all();
       // $majors = ArrayHelper::map($majors, 'id', 'name');
        
        return $this->render('index', [
            'consultant' => $consultant,
            
            //'majors' => $majors,
        ]);
    }
    public function actionStudentlist() {


        $id = Yii::$app->user->identity->id;  
        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one();
        $consultant_id = $consultant->consultant_id;
        $status = $_POST['status'];
        $check_condition = "";
        //$new_signup=array('3','4');
        /*$name = "Harshit";
        $query_name = "AND `user_login`.`first_name` LIKE '%".$name."%'";*/
        $rows = (new \yii\db\Query())
        ->select(['student_id'])
        ->from('lead_followup')
        ->distinct()
        ->all();
        if($rows){
                $new_signup=array();
                foreach ($rows as $row) { 
                    array_push($new_signup,$row['student_id']);
                }
                if($status==0){
                    $check_condition = "AND `user_login`.`id` NOT IN (" . implode(",", $new_signup) . ")";
                    $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND  `user_login`.`status` != 3 AND `user_login`.`status` != 4 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                     
                } else if($status==1 OR $status==2) {
                    $check_condition = "AND `user_login`.`id` IN (" . implode(",", $new_signup) . ")";
                    $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = "'.$status.'" AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();

                } else if($status==5) {
                    if($_POST['date_range']=='today'){
                        $rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->Where(['like','next_followup',date("Y-m-d")])
                    ->distinct()
                    ->all();
                   
                } else if($_POST['date_range']=='month'){
                    $rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->Where(['=','YEAR(next_followup)',date("Y")])
                    ->andWhere(['=','MONTH(next_followup)',date("m")])
                    ->distinct()
                    ->all();
                    
                }
                else if($_POST['date_range']=='btweendates'){
                    $start_date = $_POST['start_date']; 
                    $end_date = $_POST['end_date'];
                    $rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->where('next_followup between "'.$start_date.'" AND "'.$end_date.'"' )
                    ->distinct()
                    ->all();
                    
                }
                    if($rows_today){
                        $tday_followup=array();
                        foreach ($rows_today as $today) { 
                         array_push($tday_followup,$today['student_id']);
                        }
                        $check_condition = "AND `user_login`.`id` IN (" . implode(",", $tday_followup) . ")";
                        $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                    } else {
                        $students="";
                    }
                    
                }

                else {
                    $check_condition = "";
                    $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = "'.$status.'" AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                }

        } else {
                if($status==0){
                    $check_condition = "";
                    $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND  `user_login`.`status` != 3 AND `user_login`.`status` != 4 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();

                    } else if($status==1 OR $status==2){ 
                        $students ="";
                    }
                    else { $students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND  `user_login`.`status` = "'.$status.'"  AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                    }

        }
       
        /*$students = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = "'.$status.'" AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'"')->all();*/
        $degrees = Degree::find()->orderBy('name')->all();
        $degrees = ArrayHelper::map($degrees, 'id', 'name');   
        $countries = Country::getAllCountries();
        $countries = ArrayHelper::map($countries, 'id', 'name');

        return $this->renderAjax('student-list', [
             
            'consultant' => $consultant,
            'students' => $students,
            'status' => $status,
            'degrees' => $degrees, 
            'countries' => $countries,
        ]);
    }

        public function actionFollowup() {
        $id = Yii::$app->user->identity->id;  
        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one();
        $followup_det = StudentLeadFollowup::find()->where(['=', 'student_id', $_POST['student_id']])->all();
        //$degrees = Degree::find()->orderBy('name')->all();
        //$degrees = ArrayHelper::map($degrees, 'id', 'name');
        //majors = Majors::find()->orderBy('name')->all();
        //$majors = ArrayHelper::map($majors, 'id', 'name');

        return $this->renderAjax('followup', [
             
            'consultant' => $consultant,
            'followup_det' => $followup_det,
            //'degrees' => $degrees,
            //'majors' => $majors,
        ]);
    }

    public function actionSavefollowup(){
        $id = Yii::$app->user->identity->id;  
        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one();
        $model = new StudentLeadFollowup(); 
       
            Yii::$app->db->createCommand()
             ->update('lead_followup', ['today_status' => 2], 'student_id = '.$_POST['student_id'].'')
             ->execute();
        $model->student_id = $_POST['student_id'];
        $model->consultant_id = $consultant->consultant_id;
        $model->created_by = $consultant->consultant_id;
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->status = $_POST['follow_status'];
        if($_POST['next_followup']=='') { 
        $model->next_followup = "0000-00-00 00:00:00";
         } else {
        $model->next_followup = $_POST['next_followup'];
        //echo date("Y-m-d", strtotime($_POST['next_followup']));
        }
        $model->next_follow_comment = $_POST['next_follow_comment'];
        $model->comment = $_POST['follow_comment'];
        $model->comment_date = $_POST['comment_date'];
        $model->mode = $_POST['mode'];
        $model->reason_code = $_POST['reason_code'];
        if ($model->save()) {
            $student_current_status = UserLogin::find()->where(['=', 'id', $_POST['student_id']])->all();

                foreach ($student_current_status  as $row_status){ 
                $status_val_now = $row_status['status']; 
                }
                if($_POST['follow_status']==3) {$send_package = 'yes';} else {$send_package = 'no';}
                if($status_val_now==1 OR $status_val_now==2 OR $status_val_now==4){
                     Yii::$app->db->createCommand()
                     ->update('user_login', ['status' => $_POST['follow_status']], 'id = '.$_POST['student_id'].'')
                     ->execute();
                     return json_encode(['status' => 'success','status_message' => $_POST['follow_status'],'student_id' => $_POST['student_id'],'send_package' => $send_package]);
                 } else {
                    return json_encode(['status' => 'success','status_message' => $status_val_now,'student_id' => $_POST['student_id'],'send_package' => $send_package]);
                 }

            
        } 
        return json_encode(['status' => 'failure']);
    }
    function actionGetslistcount(){
        $id = Yii::$app->user->identity->id;  
        $consultant = Consultant::find()->where(['=', 'consultant_id', $id])->one(); 
        $consultant_id = $consultant->consultant_id;
        $check_condition = "";
        $rows = (new \yii\db\Query())
        ->select(['student_id'])
        ->from('lead_followup')
        ->distinct()
        ->all();
        if($rows){
                $new_signup=array();
                foreach ($rows as $row) { 
                    array_push($new_signup,$row['student_id']);
                }
                $check_condition = "AND `user_login`.`id` NOT IN (" . implode(",", $new_signup) . ")";
                $check_condition_1 = "AND `user_login`.`id` IN (" . implode(",", $new_signup) . ")";
                    $students_new = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND  `user_login`.`status` != 3 AND `user_login`.`status` != 4 AND  `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                
                 $students_active = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 1 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition_1.'' )->all();
                 $students_inactive = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 2 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition_1.'' )->all();
                 $students_subscribed = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 3 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();
                 $students_accesssend = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 4 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();
                 $students_closed = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 6 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();


                    //if($status==5) {
                    /*$rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->Where(['>=','next_followup','DATEADD(DAY, DATEDIFF(DAY, 0, GETDATE()) / 7 * 7, 0)'])
                    ->andWhere(['>=','next_followup','DATEADD(DAY, DATEDIFF(DAY, -1, GETDATE()), 0)'])
                    ->distinct()
                    ->all();*/
                    $rows_today = (new \yii\db\Query())
                    ->select(['student_id'])
                    ->from('lead_followup')
                    ->Where(['like','next_followup',date("Y-m-d")])
                    ->distinct()
                    ->all();
                    if($rows_today){
                        
                        $tday_followup=array();
                        foreach ($rows_today as $today) {
                         array_push($tday_followup,$today['student_id']);
                        }
                        $check_condition = "AND `user_login`.`id` IN (" . implode(",", $tday_followup) . ")";
                    $students_today = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" '.$check_condition.'')->all();
                    $count_today =  count($students_today);
                    } else {
                        $count_today =  0;
                    }
                    
                //}


        $count_new =  count($students_new); 
        $count_active =  count($students_active);
        $count_inactive =  count($students_inactive);
        $count_subscribed =  count($students_subscribed);
        $count_accesssend =  count($students_accesssend);
        //$count_closed =  count($students_closed);
        

        } else {
                $students_new = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND  `user_login`.`status` != 3 AND `user_login`.`status` != 4 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ')->all();
                $count_new =  count($students_new); 

                $students_subscribed = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 3 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();
                $students_accesssend = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 4 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();
                $students_closed = StudentConsultantRelation::find()->innerJoin('user_login', '`user_login`.`id` = `student_consultant_relation`.`student_id` AND `user_login`.`status` = 6 AND `student_consultant_relation`.`consultant_id` = "'.$consultant_id.'" ' )->all();
        $count_active =  0;
        $count_inactive =  0;
        $count_subscribed =  count($students_subscribed);
        $count_accesssend =  count($students_accesssend);
        $count_accesssend =  count($students_closed);
        $count_today =  0;

        }
         
        //$count_new =  count($students_new);
        
        return json_encode(['count_new' => $count_new,'count_active' => $count_active,'count_inactive' => $count_inactive,'count_subscribed' => $count_subscribed,'count_accesssend' => $count_accesssend,'count_today' => $count_today]);
    }

/*    public function actionView($id) {
        $model = Student::findOne($id);
        $englishTests = StudentEnglishLanguageProficienceyDetails::find()->where(['=', 'student_id', $model->student_id])->all();
        $standardTests = StudentStandardTestDetail::find()->where(['=', 'student_id', $model->student_id])->all();
        $associates = StudentAssociateConsultants::find()->where(['=','student_id', $model->student_id])->all();
        $consultantAssociates = AssociateConsultants::find()->where(['=', 'parent_consultant_id', Yii::$app->user->identity->id])->all();
        $packages = StudentPackageDetails::find()->where(['=', 'consultant_id', Yii::$app->user->identity->id])->all();

        return $this->render('view', [
            'model' => $model,
            'englishTests' => $englishTests,
            'standardTests' => $standardTests,
            'associates' => $associates,
            'consultantAssociates' => $consultantAssociates,
            'packages' => $packages
        ]);
    }

    public function actionDownload($id) {
        $fileName = $_GET['name'];
        if (is_dir("./../../frontend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../frontend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
        }
    }

    public function actionDownloadAll($id) {
        if (is_dir("./../../frontend/web/uploads/$id")) {
            $path = FileHelper::findFiles("./../../frontend/web/uploads/$id", [
                'caseSensitive' => false,
                'recursive' => true,
            ]);
            if (count($path) > 0) {
                $files = $path;
                $result = is_dir("./../../frontend/web/uploads/$id");
                if (!$result) {
                    FileHelper::createDirectory("./../../frontend/web/uploads/$id");
                } 
                $zipname = './../../frontend/downloads/documents'.$id.'.zip';
                $zip = new \ZipArchive();
                $zip->open($zipname, \ZipArchive::CREATE);
                $k = 0;
                foreach ($files as $file) {
                    $normalized = FileHelper::normalizePath($file,'/');
                    $filename = explode($id.'/', $normalized);
                    //print_r($filename[1]);
                       $zip->addFile($normalized,$filename[1]);
                       $k++;
                }
                $zip->close();
                Yii::$app->response->sendFile($zipname);
            }
        } else {
            echo json_encode(['error']);
            return;
        }
    }

    public function actionDisconnectAssociate() {
        $consultant = $_POST['consultant'];
        $student = $_POST['student'];

        $model = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'associate_consultant_id', $consultant]])->one();

        if(empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Student and consultant are not connected']);
        }
        if($model->delete()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'messsage' => 'Error disconnecting student and associate']);
    }

    

    public function actionConnectAssociate() {
        $consultant = $_POST['consultant'];
        $student = $_POST['student'];

        $model = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'associate_consultant_id', $consultant]])->one();

        if(!empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Student and consultant are already connected']);
        }
        $model = new StudentAssociateConsultants();
        $model->student_id = $student;
        $model->associate_consultant_id = $consultant;
        $model->parent_consultant_id = Yii::$app->user->identity->id;
        $model->created_at = gmdate('Y-m-d H:i:s');
        $model->updated_at = gmdate('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->identity->id;
        $model->updated_by = Yii::$app->user->identity->id;
        if($model->save()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'messsage' => 'Error disconnecting student and associate']);
    }

    public function actionChangePackageLimt() {
        $id = $_POST['id'];
        $value = $_POST['value'];

        $model = StudentPackageDetails::findOne($id);

        if(empty($model)) {
            return json_encode(['status' => 'error', 'message' => 'Package details not found']);
        }

        $model->limit_pending = $value;
        $model->updated_by = Yii::$app->user->identity->id;
        $model->updated_at = gmdate('Y-m-d H:i:s');

        if($model->save()) {
            return json_encode(['status' => 'success']);
        }
        return json_encode(['status' => 'error', 'message' => 'Error saving changes']);
    }

    public function actionDisconnect() {
        $student = $_POST['student'];
        $id = Yii::$app->user->identity->id;

        // disconnect all accosiates first.

        $associates = StudentAssociateConsultants::find()->where(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]])->all();

        if(sizeof($associates) > 0) {
            $transaction = \Yii::$app->db->beginTransaction();
            $count = StudentAssociateConsultants::deleteAll(['AND', ['=', 'student_id', $student], ['=', 'parent_consultant_id', $id]]);
            if ($count == sizeof($associates)) {
                $model = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $student], ['=', 'consultant_id', Yii::$app->user->identity->id]])->one();
                if(empty($model)) {
                    $transaction->rollBack();
                    return json_encode(['status' => 'error', 'message' => 'Error disconneting consultant. No relation found']);
                }
                if ($model->delete()) {
                    $transaction->commit();
                    return json_encode(['status' => 'success']);
                }
                $transaction->rollBack();
                return json_encode(['status' => 'error', 'message' => 'Error disconneting consultant. No relation found']);
            } else {
                $transaction->rollBack();
                return json_encode(['status' => 'error', 'message' => 'Error disconnecting one or more associates']);
            }
        }
    }*/
}
