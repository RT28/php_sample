<?php

namespace partner\modules\university\controllers;

use Yii;
use backend\models\UniversityEnquiry;
use backend\models\UniversityEnquirySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Country;
use common\models\Others;
use backend\models\SiteConfig;
use yii\filters\AccessControl;
use common\components\Roles;
use yii\helpers\ArrayHelper; 
use common\components\Commondata; 

/**
 * UniversityEnquiryController implements the CRUD actions for UniversityEnquiry model.
 */
class UniversityEnquiryController extends Controller
{
    /**
     * @inheritdoc
     */
      public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'error'],
                        'allow' => true,
						 'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
             
        ];
    }
 
    /**
     * Creates a new UniversityEnquiry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UniversityEnquiry();

		$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
		$message = '';
        if(Yii::$app->request->post()) {
			$model->load(Yii::$app->request->post());
            $exists = UniversityEnquiry::find()->where(['=', 'email', $model->email])->all(); 
			$count = count($exists); 
            if($count>=3) {  
			
				Yii::$app->getSession()->setFlash('Error', 'We have already received your queries and our team is working on it and we will revert back to you shortly.');  
			
			}else{
				if($model->save(false)) { 
				         

				$to = $model->email;
				$user = $model->name; 			
				$subject = $user.', Thanks for your query.';
				$template = 'university_enquiry';  
				
				$data = array('name' => $user);		
				//$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
                $mailsent = Commondata::sendUniversityQuery($to,$subject,$data,$template);
                /*mail details to gtu*/
                $enquiry_from = $to;
                $subject = 'University Enquiry Received';
                $first_name = $user;
                $template = 'university_enquiry_details';
                $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->phone ,'message' => $model->message,'institute_name' => $model->institute_name,'institute_website' => $model->institute_website,'institution_type' => $model->institution_type);
                //$data = array('user' => $user , 'model' => $model);
                $maildetails = Commondata::sendUniversityQueryDetails($enquiry_from,$subject,$data,$template);

				if($mailsent==true AND $maildetails==true){
					Yii::$app->getSession()->setFlash('Success', 'Thanks for submitting your query. A GTU team member will contact you shortly.');
				  		
                } else { 
					$helpemail = SiteConfig::getConfigHelpEmail();
					Yii::$app->getSession()->setFlash('Error', 'Error in processing your request. Please send email to '.$helpemail);  
					
                }  
				
				}
			
            }  
			return $this->redirect(['/site/message']);
        }       
		return $this->render('create', [
			'model' => $model,
			'institutionType' => $this->getOthers('institution_type'),				
			'countries' => $countries,
			'message' => $message
		]);
        
    }
	
	 private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }
 
}
