<?php

namespace console\controllers; 
 
use Yii;
use yii\helpers\Url;
use yii\console\Controller;
use backend\models\SiteConfig;
use common\models\Student;
use common\models\Consultant;
use common\models\User;
use frontend\models\UserLogin;

class GeneralcronController  extends Controller {
 
	
	public function actionIndex() {
        echo "Yes, cron service is running.";
    }
 
 
    public function actionLogstatus()
    {
		$consultants = Consultant::find()->all();
        foreach($consultants as $consultant){
            $alertTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($consultant['last_active'])));
            if(gmdate('Y-m-d H:i:s') > $alertTime){
            $consultant_active = Consultant::find()->where(['consultant_id'=>$consultant['consultant_id']])->one();
            $consultant_active->logged_status = 0;                
            $consultant_active->save(false);
            } else { $active_con = 1; }
        }

        $students = User::find()->all();
        foreach($students as $student){
            $alertTime = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($student['last_active'])));
            echo 's'. $student['last_active'].'<br>';
            if(gmdate('Y-m-d H:i:s') > $alertTime){
            $student_active = User::find()->where(['id'=>$student['id']])->one();
            $student_active->logged_status = 0;                
            $student_active->save(false);
            } else { $active_con = 1; }
        }
		
    }

}
