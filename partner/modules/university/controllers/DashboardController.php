<?php
namespace partner\modules\university\controllers;

use Yii;  
use common\models\University; 
use backend\models\UniversitySearch; 
use frontend\models\StudentShortlistedCourse;
use yii\db\Expression; 
use yii\web\UploadedFile;
use yii\helpers\FileHelper;  
use yii\web\Controller; 
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;   
use yii\base\ErrorException;
use yii\web\NotFoundHttpException;  
use yii\filters\AccessControl;
use common\components\Roles;
use common\components\AccessRule;
 
 
class DashboardController extends \yii\web\Controller
{
 
   
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
                        'actions' => ['index','analytics'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
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
	
	public function array_icount_values($arr,$lower=true) {
     $arr2=array();
     if(!is_array($arr['0'])){$arr=array($arr);}
     foreach($arr as $k=> $v){
      foreach($v as $v2){
      if($lower==true) {$v2=strtolower($v2);}
      if(!isset($arr2[$v2])){
          $arr2[$v2]=1;
      }else{
           $arr2[$v2]++;
           }
    }
    }
    return $arr2;
} 


	
   public function actionIndex()
    {
		 
		Yii::$app->view->params['activeTab'] = 'dashboard'; 
		$partner_id = Yii::$app->user->identity->partner_id; 
		 
		$university = new University();
		$university = University::find()->where(['=', 'id', $partner_id])->one();
	 	 
		
        $id = $partner_id;
        $model = $this->findModel($id); 
 
		$famousCourseUniModel = Yii::$app->db->createCommand("SELECT count(mc.id) as cnt, mc.course_id, uc.name , mc.view
		FROM most_viewed_courses as mc 
		INNER JOIN university_course_list as uc on uc.id = mc.course_id 
		WHERE mc.university_id = '".$id."'
		order by  mc.view DESC limit 0,7");
		$famousCourseUni = $famousCourseUniModel->queryAll();
            
		$famousCourseGTUModel = Yii::$app->db->createCommand("SELECT  mc.course_id, uc.name , mc.view as view
		FROM most_viewed_courses as mc 
		INNER JOIN university_course_list as uc on uc.id = mc.course_id  
        order by  mc.view DESC limit 0,7");
		$famousCourseGTU= $famousCourseGTUModel->queryAll();
        
		$mostShortListedUniversityModel = Yii::$app->db->createCommand("SELECT count(sc.id) as cnt, sc.course_id, uc.name 
		FROM student_favourite_courses as sc INNER JOIN university_course_list as uc on uc.id = sc.course_id 
		WHERE sc.university_id = '".$id."'
		GROUP BY sc.course_id HAVING cnt order by cnt DESC limit 0,7 ");
		$mostShortListedUni= $mostShortListedUniversityModel->queryAll();
            
		$mostShortListedGTUModel = Yii::$app->db->createCommand("SELECT count(sc.id) as cnt, sc.course_id, uc.name 
		FROM student_favourite_courses as sc INNER JOIN university_course_list as uc on uc.id = sc.course_id 
		GROUP BY sc.course_id HAVING cnt order by cnt DESC limit 0,7 ");
		$mostShortListedGTU= $mostShortListedGTUModel->queryAll();
		
		
		$selectPrefferedLoc = Yii::$app->db->createCommand("SELECT country_preference FROM user_login WHERE country_preference != ''");
		$getPrefferedLoc= $selectPrefferedLoc->queryAll();
		
		$values = array();
		foreach ($getPrefferedLoc as $loc){
			$values[] = explode(',',$loc['country_preference']);
		}		
		
	 
		/*echo "<pre>";
		print_r($values);
		$ar2 = $this->array_icount_values($values);
		print_r($ar2);
		echo "</pre>";
		*/
		 
		
        return $this->render('index', [ 
            'model' => $model, 
			'mostShortListedUni' => $mostShortListedUni, 
			'mostShortListedGTU' => $mostShortListedGTU, 
			'famousCourseUni' => $famousCourseUni, 
			'famousCourseGTU' => $famousCourseGTU,
			'university' => $university, 
        ]);
    }
	
	
	public function actionAnalytics()
    {
		 
		Yii::$app->view->params['activeTab'] = 'analytics'; 
		$partner_id = Yii::$app->user->identity->partner_id; 
		 
		$university = new University();
		$university = University::find()->where(['=', 'id', $partner_id])->one(); 
        $id = $partner_id;
        $model = $this->findModel($id); 
		
		$famousCourseGTUModel = Yii::$app->db->createCommand("SELECT  mc.course_id, uc.name , mc.view as view FROM most_viewed_courses as mc INNER JOIN university_course_list as uc on uc.id = mc.course_id order by  mc.view DESC limit 0,5");
		$famousCourseGTU= $famousCourseGTUModel->queryAll();
        
		
        return $this->render('analytics', [ 
		'model' => $model,
		'famousCourseGTU' => $famousCourseGTU,	
		]);
    }
	     
	protected function findModel($id)
    {
        if (($model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
