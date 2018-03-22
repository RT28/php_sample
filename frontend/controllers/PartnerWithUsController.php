<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use partner\models\PartnerForm;
use partner\models\PartnerLoginForm;
use common\components\Roles;
use backend\models\GeneralEnquiry;  
use common\models\Country;
use backend\models\SiteConfig; 
use yii\helpers\ArrayHelper;
use common\components\Commondata;
use backend\models\UniversityEnquiry;
use backend\models\UniversityEnquirySearch;
use common\models\Others;  
use common\models\ConsultantEnquiry;
use common\models\Degree;
use common\components\Status;

/**
 * Site controller
 */
class PartnerWithUsController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {  
        return $this->render('index');
    }
    
    public function actionGeneral()
    {
        $helpemail = SiteConfig::getConfigHelpEmail();
           
        $model = new GeneralEnquiry(); 
        $message = '';
        if(Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $exists = GeneralEnquiry::find()->where(['=', 'email', $model->email])->all();
            
            $count = count($exists); 
            if($count>=3) {  
            
                Yii::$app->getSession()->setFlash('Error', 'We have already received your queries and our team is working on it and we will revert back to you shortly.');  
            
            }else{
                
                if($model->save(false)) {   
                        
                    $to = $model->email;
                    $user = $model->name;       
                    $subject = 'Leave Message To GoToUniversity';
                    $template = 'leaveus_message';  
                    $data = array('user' => $user);

                    //$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
                    $mailsent = Commondata::sendContactQuery($to,$subject,$data,$template);

                    /*mail details to gtu*/
                    $enquiry_from = $to;
                    $subject = 'General Eenquiry Received';
                    $first_name = $user;
                    $template = 'leaveus_message_details';
                    $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->phone ,'message' => $model->message);
                    $maildetails = Commondata::sendContactQueryDetails($enquiry_from,$subject,$data,$template);

                    if($mailsent==true AND $maildetails==true){
                        
                    Yii::$app->getSession()->setFlash('Success', 'Thanks for submitting your query. A GTU team member will contact you shortly.');
                    return $this->redirect(['/partner-with-us/general']);
                     
                } else { 
                    
                    Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please send email to '.$helpemail);  
                } 
                
                }
            } 
            //return $this->render('message');
        }       
         
        return $this->render('general_enquiry', [
            'model' => $model,           
        ]);
        
    }

    public function actionUniversityEnquiry()
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
            return $this->redirect(['/partner-with-us/university-enquiry']);
           // return $this->render('message');
        }       
        return $this->render('university', [
            'model' => $model,
            'institutionType' => $this->getOthers('institution_type'),              
            'countries' => $countries,
            'message' => $message
        ]);
        
    }
 
    public function actionAgencyEnquiry()
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
            return $this->redirect(['/partner-with-us/agency-enquiry']);
           // return $this->render('message');
        }       
        return $this->render('university', [
            'model' => $model,
            'institutionType' => $this->getOthers('institution_type'),              
            'countries' => $countries,
            'message' => $message
        ]);
        
    }

    public function actionConsultantEnquiry()
    {
        $helpemail = SiteConfig::getConfigHelpEmail();
        
        $model = new ConsultantEnquiry(); 
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name');
        $message = '';
        if(Yii::$app->request->post()) { 
            $model->load(Yii::$app->request->post());
            $exists = ConsultantEnquiry::find()->where(['=', 'email', $model->email])->all();
            
            $count = count($exists); 
            if($count>=3) {  
            
                Yii::$app->getSession()->setFlash('Error', 'We have already received your queries and our team is working on it and we will revert back to you shortly.');  
            
            }else{ 
                    $model->status = Status::STATUS_NEW; 
                    $model->created_at = gmdate('Y-m-d H:i:s');
                    $model->updated_at = gmdate('Y-m-d H:i:s');
                 
                    if($model->save(false)) {
                        
                    $to = $model->email;
                    $user = $model->title.''.$model->first_name.' '.$model->last_name;          
                    $subject = $user.', Thanks for your query.';
                    $template = 'consultant_enquiry';  

                    $data = array('name' => $user);     
                    //$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
                    $mailsent = Commondata::sendConsultantQuery($to,$subject,$data,$template);
                    /*mail details to gtu*/
                    $enquiry_from = $to;
                    $subject = 'Consultant Enquiry Received';
                    $first_name = $user;
                    $template = 'consultant_enquiry_details';
                    $data = array('user' => $user , 'email' => $enquiry_from , 'code' => $model->code, 'phone' => $model->mobile ,'message' => $model->description,'country' => $model->country_id);
                    //$data = array('user' => $user , 'model' => $model);
                    $maildetails = Commondata::sendConsultantQueryDetails($enquiry_from,$subject,$data,$template);

                    if($mailsent==true AND $maildetails==true){
                    
                        Yii::$app->getSession()->setFlash('Success', 'Consultant Enquiry successfull. Our administrator will verify you and get back to you shortly.'); 
                        
                    } else {
                        Yii::$app->getSession()->setFlash('Error', 'Error in processing your request. Please send email to '.$helpemail);
                    } 
                }
            }  
            return $this->redirect(['/partner-with-us/consultant-enquiry']);
            //return $this->redirect(['/site/message']);
        }
        return $this->render('consultant', [
            'model' => $model, 
            'countries' => $countries,
            'degrees' => Degree::getAllDegrees(), 
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
