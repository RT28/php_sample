<?php
namespace partner\modules\university\controllers;

use Yii;
//use partner\models\Partner; 
use common\models\University;
use backend\models\UniversitySearch; 
use yii\db\Expression; 
use yii\web\UploadedFile;
use yii\helpers\FileHelper;  
use yii\web\Controller; 
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper; 
use yii\helpers\Json;
use yii\filters\AccessControl;
use common\components\AccessRule;
use yii\base\ErrorException;
use yii\web\NotFoundHttpException; 
use common\models\Country;
use common\models\State ; 
use common\models\City;
use common\models\Degree;
use common\models\Majors;
use common\models\UniversityAdmission;  
use common\models\UniversityCourseList;
use common\models\FileUpload;
use backend\models\UniversityDepartments;
use common\components\Status;
use common\components\Roles;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;
use common\models\Currency; 
use common\models\StandardTests;
use common\models\UniversityGallery;
use common\models\UniversityBrochures;
use common\models\StudentUniveristyApplication;
use partner\modules\university\models\StudentUniversityApplicationSearch;
use backend\models\SiteConfig;
use partner\models\PartnerLogin; 
use partner\models\PartnerSignup; 
use common\components\CalendarEvents;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use common\components\ConnectionSettings;
use common\components\Commondata;
use common\models\UniversityTemp;

 
class UniversityController extends \yii\web\Controller
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
                        'actions' => [ 'view', 'update', 'dependent-states', 'dependent-cities','dependent-majors','dependent-courses',
						'upload-photos','delete-photo','getdocumentlist','upload-documents','deletedocument','download','download-all'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_UNIVERSITY]
                    ],
					[
                        'actions' => ['create'],
                        'allow' => true,
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
    public function actionIndex() {
        $model = Yii::$app->user->identity->university;
        return $this->render('index', [
            'model' => $model
        ]);
		 Yii::$app->view->params['activeTab'] = 'profile';
        return $this->redirect(['view']);
    }

	 

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {
		 
		Yii::$app->view->params['activeTab'] = 'profile'; 
		$partner_id = Yii::$app->user->identity->partner_id; 
		 
		$university = new University();
		$university = University::find()->where(['=', 'id', $partner_id])->one();
		 	 
		$Currency = Currency::getCurrencyData($university->country_id);

        $id = $partner_id;
        $model = $this->findModel($id);
        $upload = new FileUpload();
        $courses = $model->universityCourseLists;
        $univerityAdmisssions = $model->universityAdmissions;
        $currentTab = 'Profile';
         $tabs = ['Profile', 'About', 'Misc', 'Gallery', 'Brochures'];
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');
		
		$query = "SELECT * FROM university_brochures where university_id='$partner_id' AND status = 1 AND active = 1";

        $DocumentModel = UniversityBrochures::findBySql($query)->all();
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		
        return $this->render('viewuniversity', [
            'id' => $id,
            'model' => $model,
            'institutionType' => $this->getOthers('institution_type'),
            'establishment' => $this->getOthers('establishment'),
            'courseType' => $this->getOthers('course_type'),
            'languages' => $this->getOthers('languages'),
            'intake' => $this->getOthers('intake'),
            'upload' => $upload,
            'currentTab' => $currentTab,
            'tabs' => $tabs,
            'countries' => $countries,
            'degree' => $this->getDegreeList(),
            'majors' => $this->getMajorsList(),
            'courses' => (empty($courses)) ? [new UniversityCourseList] : $courses,
            'univerityAdmisssions' => (empty($univerityAdmisssions)) ? [new UniversityAdmission] : $univerityAdmisssions,
            'degreeLevels' => DegreeLevel::getAllDegreeLevels(),
            'currencies' => $currencies,
			'Currency' => $Currency,
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,
        ]);
    }
	
	private function validateForm($tabs, $model)
    {
        $rules = [
            'Profile' => ['name', 'establishment_date', 'institution_type', 'establishment', 'address', 'country_id',
                          'state_id', 'city_id', 'pincode', 'email', 'website', 'phone_1', 'phone_2', 'contact_person',
                          'contact_person_designation', 'contact_email', 'contact_mobile', 'fax'],
            'About' => ['description'],
            'Misc' => ['location']
        ];     
        
        $flag = true;
        foreach($tabs as $tab) {
            if(isset($rules[$tab]) && !$model->validate($rules[$tab])) {
                $flag = false;
                break;
            }
        }

        if ($flag) {
            return [
                'action' => 'next',
                'count' => count($tabs)
            ];
        }
        return [
            'action' => 'same'
        ];
    }

    private function getCurrentTabAndTabs($tabs) {
        $map = [
            'Profile' => [
                'currentTab' => 'About',
                'tabs' => ['Profile', 'About']
            ],
            'Profile,About' => [
                'currentTab' => 'Misc',
                'tabs' => ['Profile', 'About', 'Misc']
            ],
            'Profile,About,Misc' => [
                'currentTab' => 'Gallery',
                'tabs' => ['Profile', 'About', 'Misc', 'Gallery']
            ],
            'Profile,About,Misc,Gallery' => [
                'currentTab' => 'Brochures',
                'tabs' => ['Profile', 'About', 'Misc', 'Gallery','Brochures']
            ],
            'Profile,About,Misc,Gallery,Brochures' => [
                'currentTab' => 'Brochures',
                'tabs' => ['Profile', 'About', 'Misc', 'Gallery','Brochures']
            ], 
        ];

        return $map[$tabs];
    }
	
	 /**
     * Updates an existing University model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
		$actionStatus='update';
		Yii::$app->view->params['activeTab'] = 'profile'; 
        $partner_id = Yii::$app->user->identity->partner_id;
		
		$partner1= new UniversityTemp();
		$partner1= UniversityTemp::find()->where(['=','university_id',$partner_id])->one();
		
		$query = "SELECT * FROM university_brochures where university_id='$partner_id' AND status = 1 AND active = 1";

        $DocumentModel = UniversityBrochures::findBySql($query)->all();
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		
		
		if(!empty($partner1)){
			$model = new UniversityTemp();
			$model = UniversityTemp::find()->where(['=', 'university_id', $partner_id])->one();
		
			$model = $this->findModelTemp($partner_id);
			$Currency = Currency::getCurrencyData($model->country_id);
			
			$id = $partner_id;
			ini_set('max_execution_time', 300);
			 
			$upload = new FileUpload(); 
			$currentTab = 'Profile';
			if (empty($courses)) {
				$tabs = ['Profile', 'About', 'Misc', 'Gallery','Brochures'];
			}else{
				$tabs = ['Profile', 'About', 'Misc',  'Gallery','Brochures'];
			}
			$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
			$currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');       
			$standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
			$standardTests = ArrayHelper::map($standardTests, 'id', 'name');
		 
			   // print_r($_POST);
				
				
			if ($model->load(Yii::$app->request->post())) {
				
				$postData=Yii::$app->request->post();
				 
				$getPostData=$postData['UniversityTemp'];
				
				
				if (empty($courses)) {
					$tabs = ['Profile', 'About', 'Misc','Gallery','Brochures'];
				}
				$result = $this->validateForm($tabs, $model);
			 
				if ($result['action'] === 'next') {
					$isModelSaved = false;
					if ($result['count'] >= 3 ) {
						//echo "i am in condition";
						$this->setSpatialPoints($model, Yii::$app->request->post()['UniversityTemp']['location']);
						$model->university_id = $id;
						$model->name	= $getPostData['name'];
						$model->is_partner = $getPostData['is_partner'];
						$model->establishment_date = $getPostData['establishment_date'];
						$model->address = $getPostData['address'];
						$model->city_id = $getPostData['city_id'];
						$model->state_id = $getPostData['state_id'];
						$model->country_id = $getPostData['country_id'];
						$model->pincode = $getPostData['pincode'];
						$model->email = $getPostData['email'];
						$model->website = $getPostData['website'];
						$model->description = $getPostData['description'];
						$model->fax = $getPostData['fax'];
						$model->phone_1 = $getPostData['phone_1'];
						$model->phone_2 = $getPostData['phone_2'];
						$model->contact_person =$getPostData['contact_person'];
						$model->contact_person_designation = $getPostData['contact_person_designation'];
						$model->contact_mobile = $getPostData['contact_mobile'];
						$model->contact_email = $getPostData['contact_email'];
						//$partner->location = $getPostData['location'];
						$model->institution_type = $getPostData['institution_type'];
						$model->establishment = $getPostData['establishment'];
						$model->no_of_students = $getPostData['no_of_students'];
						$model->no_of_undergraduate_students = $getPostData['no_of_undergraduate_students'];
						$model->no_of_post_graduate_students = $getPostData['no_of_post_graduate_students'];
						$model->no_of_international_students = $getPostData['no_of_international_students'];
						$model->no_faculties = $getPostData['no_faculties'];
						$model->no_of_international_faculty = $getPostData['no_of_international_faculty'];
						/*$model->cost_of_living = $getPostData['cost_of_living'];
						$model->undergarduate_fees = $getPostData['undergarduate_fees'];
						$model->undergraduate_fees_international_students = $getPostData['undergraduate_fees_international_students'];
						$model->post_graduate_fees = $getPostData['post_graduate_fees'];
						$model->post_graduate_fees_international_students = $getPostData['post_graduate_fees_international_students'];
						$model->accomodation_available = $getPostData['accomodation_available'];
						$model->hostel_strength = $getPostData['hostel_strength']; */
						$model->video = $getPostData['video'];
						$model->virtual_tour = $getPostData['virtual_tour'];
						//$partner->avg_rating = $getPostData['name'];
						$model->standard_tests_required = $getPostData['standard_tests_required'];
						//$partner->standard_test_list = $getPostData['name'];
						//$model->achievements = $getPostData['achievements'];
						$model->comments = $getPostData['name'];
						$model->currency_id = $getPostData['currency_id'];
						$model->currency_international_id = $getPostData['currency_international_id'];
						$model->application_requirement = $getPostData['application_requirement'];
						$model->fees = $getPostData['fees'];
						$model->deadlines = $getPostData['deadlines'];
						$model->cost_of_living_text = $getPostData['cost_of_living_text'];
						$model->accommodation = $getPostData['accommodation'];
						$model->status =2;
						$model->updated_by = Yii::$app->user->identity->username;
						$model->updated_at = gmdate('Y-m-d H:i:s');
						$model->institution_ranking = $_POST['university-rankings'];
						$isModelSaved =$model->save(false);
					} 
					if ($isModelSaved) {
						$dependentUpdates = false;   
						
						if ($result['count'] >= 4) {						
							$dependentUpdates = $this->saveCoverPhotoTemp($upload, $model);
							$dependentUpdates = $this->saveLogoTemp($upload, $model);
							$dependentUpdates = $this->savePhotosTemp($upload, $model); 
						}   
		
						if ($result['count'] >= 5) {  
							$brouchersUpdates = false;  						
							if(isset($_FILES)){
								$fileData = $_FILES;
							}
							if(isset($postData['document'])){
								$dData = $postData['document'];
								$brouchersUpdates = $this->saveBrochuresTemp($fileData, $model,$dData);
							}
							  
 
							
						}  
					   
						if($dependentUpdates) {
							return $this->redirect(['view', 'id' => $model->id]);
						}
					}
					 
				}
			}	
		 
		}
		
		else{

			$model = new University();
			$model = University::find()->where(['=', 'id', $partner_id])->one();		
		    $model = $this->findModel($partner_id);

			$Currency = Currency::getCurrencyData($model->country_id);
				
			$id = $partner_id;
			ini_set('max_execution_time', 300);
			
			$upload = new FileUpload(); 
			$currentTab = 'Profile';
			if (empty($courses)){
				$tabs = ['Profile', 'About', 'Misc', 'Gallery','Brochures'];
			}else{
				$tabs = ['Profile', 'About', 'Misc',  'Gallery','Brochures'];
			}
			$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
			$currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');       
			$standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
			$standardTests = ArrayHelper::map($standardTests, 'id', 'name');
			
			$partner= new UniversityTemp();
			
			if (Yii::$app->request->post()) {

			
				if (empty($courses)) {
					$tabs = ['Profile', 'About', 'Misc',   'Gallery','Brochures'];
				}
				$postData=Yii::$app->request->post();
				$getPostData=$postData['University'];
				 
				
				$result = $this->validateForm($tabs, $model);
			
				if($result['action']	==='next') {
					$isModelSaved = false;
					if($result['count'] >= 3 ) {
						//$this->setSpatialPoints($model, Yii::$app->request->post()['UniversityTemp']['location']);
						$partner->university_id = $id;
						$partner->name	= $getPostData['name'];
						$partner->is_partner = $getPostData['is_partner'];
						$partner->establishment_date = $getPostData['establishment_date'];
						$partner->address = $getPostData['address'];
						$partner->city_id = $getPostData['city_id'];
						$partner->state_id = $getPostData['state_id'];
						$partner->country_id = $getPostData['country_id'];
						$partner->pincode = $getPostData['pincode'];
						$partner->email = $getPostData['email'];
						$partner->website = $getPostData['website'];
						$partner->description = $getPostData['description'];
						$partner->fax = $getPostData['fax'];
						$partner->phone_1 = $getPostData['phone_1'];
						$partner->phone_2 = $getPostData['phone_2'];
						$partner->contact_person =$getPostData['contact_person'];
						$partner->contact_person_designation = $getPostData['contact_person_designation'];
						$partner->contact_mobile = $getPostData['contact_mobile'];
						$partner->contact_email = $getPostData['contact_email'];
						//$partner->location = $getPostData['location'];
						$partner->institution_type = $getPostData['institution_type'];
						$partner->establishment = $getPostData['establishment'];
						$partner->no_of_students = $getPostData['no_of_students'];
						$partner->no_of_undergraduate_students = $getPostData['no_of_undergraduate_students'];
						$partner->no_of_post_graduate_students = $getPostData['no_of_post_graduate_students'];
						$partner->no_of_international_students = $getPostData['no_of_international_students'];
						$partner->no_faculties = $getPostData['no_faculties'];
						$partner->no_of_international_faculty = $getPostData['no_of_international_faculty'];
						/*$partner->cost_of_living = $getPostData['cost_of_living'];
						$partner->undergarduate_fees = $getPostData['undergarduate_fees'];
						$partner->undergraduate_fees_international_students = $getPostData['undergraduate_fees_international_students'];
						$partner->post_graduate_fees = $getPostData['post_graduate_fees'];
						$partner->post_graduate_fees_international_students = $getPostData['post_graduate_fees_international_students'];
						$partner->accomodation_available = $getPostData['accomodation_available']; */
						$partner->hostel_strength = $getPostData['hostel_strength'];
						$partner->video = $getPostData['video'];
						$partner->virtual_tour = $getPostData['virtual_tour'];
						//$partner->avg_rating = $getPostData['name'];
						$partner->standard_tests_required = $getPostData['standard_tests_required'];
						//$partner->standard_test_list = $getPostData['name'];
						$partner->achievements = $getPostData['achievements'];
						$partner->comments = $getPostData['name'];
						$partner->currency_id = $getPostData['currency_id'];
						$partner->currency_international_id = $getPostData['currency_international_id'];
						$partner->application_requirement = $getPostData['application_requirement'];
						$partner->fees = $getPostData['fees'];
						$partner->deadlines = $getPostData['deadlines'];
						$partner->cost_of_living_text = $getPostData['cost_of_living_text'];
						$partner->accommodation = $getPostData['accommodation'];
						$partner->status =2;
						$partner->updated_by = Yii::$app->user->identity->username;
						$partner->updated_at = gmdate('Y-m-d H:i:s');
						$partner->institution_ranking = $_POST['university-rankings'];
						$isModelSaved =$partner->save(false);
					}
					if ($isModelSaved) {
						$dependentUpdates = false;   
						if ($result['count'] >= 4) {  
							$dependentUpdates = $this->saveCoverPhotoTemp($upload, $partner);
							$dependentUpdates = $this->saveLogoTemp($upload, $partner);
							$dependentUpdates = $this->savePhotosTemp($upload, $partner);
						}  
						
						if ($result['count'] >= 5) {   
							$brouchersUpdates = false;  						
							if(isset($_FILES)){
							$fileData = $_FILES;
							} 
 
							if(isset($postData['document'])){
								$dData = $postData['document'];
								$brouchersUpdates = $this->saveBrochuresTemp($fileData,  $partner,$dData);
							}
							
						}  
						  
						
						if($dependentUpdates) {
							return $this->redirect(['view', 'id' => $model->id]);
						}
					}
					  
				}
			}	
		} 
		 
        return $this->render('update', [
            'id' => $id,
            'model' => $model,
            'institutionType' => $this->getOthers('institution_type'),
            'establishment' => $this->getOthers('establishment'),
            'courseType' => $this->getOthers('course_type'),
            'languages' => $this->getOthers('languages'),
            'intake' => $this->getOthers('intake'),
            'durationType' =>$this->getOthers('duration_type'),
            'upload' => $upload,
            'currentTab' => $currentTab,
            'tabs' => $tabs,
            'countries' => $countries,
            'degree' => $this->getDegreeList(),
            'majors' => $this->getMajorsList(), 
			'degreeLevels' => DegreeLevel::getAllDegreeLevels(),
            'currencies' => $currencies,
            'standardTests' => $standardTests,
			'Currency' => $Currency,
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,
        ]);
    }

    private function setSpatialPoints($model, $location) {
        $location = str_replace(['POINT', '(', ')'], '', $location);
        $location = explode(',', $location);
        if(sizeof($location) >= 2) {
            $location[0] = floatval($location[0]);
            $location[1] = floatval($location[1]);
            $model->location = new Expression("GeomFromText('POINT($location[0] $location[1])')");
        }
    }

    private function saveCoverPhotoTemp($image, $university) {
        $newFile = UploadedFile::getInstance($image, 'imageFile');        
        if (isset($newFile)) {            
            $image->imageFile = UploadedFile::getInstance($image, 'imageFile');   
			$filename = $image->uploadTemp($university);			
         	 
			if(isset($filename)){
				$coverPhoto = $filename;			
				$uid = $university->university_id;
				 
				$UGallery =  UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid],				
				['=', 'photo_type',  'cover_photo' ],
				['=', 'status',  '0' ],
				['=', 'active',  '0' ]
				])->one(); 
				 
				
				if(empty($UGallery)) {			 
					$UGallery = new UniversityGallery();
					$UGallery->created_by = Yii::$app->user->identity->id;
					$UGallery->created_at = gmdate('Y-m-d H:i:s');
				} 	
				$UGallery->updated_by = Yii::$app->user->identity->id;
				$UGallery->updated_at = gmdate('Y-m-d H:i:s');
				$UGallery->university_id = $uid;
				$UGallery->photo_type = 'cover_photo';
				$UGallery->filename = $coverPhoto;
				$UGallery->status = 0;
				$UGallery->save(); 			 
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

      private function saveLogoTemp($image, $university) {
        $newFile = UploadedFile::getInstance($image, 'logoFile');
        if (isset($newFile)) {
            $image->logoFile = $newFile;
			
			$filename = $image->uploadLogoTemp($university);			
         	 
			if(isset($filename)){
					$coverPhoto = $filename;	
				  			
					$uid = $university->university_id;
					 
					$UGallery = UniversityGallery::find()->where(['AND',
					['=', 'university_id', $uid], 
					['=', 'photo_type',  'logo' ],
					['=', 'status',  '0' ],
					['=', 'active',  '0' ]
					])->one(); 
				 
				/*if(!empty($UGallery)) {		 			
					$path = Yii::getAlias('@backend'); 				 
					unlink($path."/web/uploads/$uid/logo/".$UGallery->filename);
				}*/  
				if(empty($UGallery)) {			 
					$UGallery = new UniversityGallery();
					$UGallery->created_by = Yii::$app->user->identity->id;
					$UGallery->created_at = gmdate('Y-m-d H:i:s');
				} 	
				$UGallery->updated_by = Yii::$app->user->identity->id;
				$UGallery->updated_at = gmdate('Y-m-d H:i:s');
					$UGallery->university_id = $uid;
					$UGallery->photo_type = 'logo';
					$UGallery->filename = $coverPhoto;
					$UGallery->status = 0;
					$UGallery->save(false);  
			
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

	 private function savePhotosTemp($image, $university) {
        $files = UploadedFile::getInstances($image, 'universityPhotos');
        if(isset($files) && sizeof($files) > 0) {
            $image->universityPhotos = $files;
            $filenames = $image->uploadUniversityPhotosTemp($university);
            
			if(isset($filenames)){ 
				foreach ($filenames as $file) { 
				 
					$coverPhoto =  $file;			
					$uid = $university->university_id;
					 
					$UGallery = UniversityGallery::find()->where(['AND',
					['=', 'university_id', $uid],
					['=', 'filename', $coverPhoto ],					
					['=', 'photo_type',  'photos' ],
					['=', 'status',  '0' ],
					['=', 'active',  '0' ]
					])->one(); 
 
					if(empty($UGallery)) {			 
						$UGallery = new UniversityGallery();
						$UGallery->created_by = Yii::$app->user->identity->id;
						$UGallery->created_at = gmdate('Y-m-d H:i:s');
					} 	
					$UGallery->updated_by = Yii::$app->user->identity->id;
					$UGallery->updated_at = gmdate('Y-m-d H:i:s');			
					$UGallery->university_id = $uid;
					$UGallery->photo_type = 'photos';
					$UGallery->filename = $coverPhoto;
					$UGallery->status = 0;
					$UGallery->save(false); 
				  
            }
			 
					
			}
			
			return $filenames;
        }
        return true;
    }
	
	private function saveBrochuresTemp($files,$university,$DocumentData){
        
		$uid = $university->university_id; 
		$message=array();
        $i = 1;
		
		$data = array(); 
		  
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$uid/documents");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$uid/documents");
		}
		 
        while(isset($_FILES["document-".$i])) {
			
			if($_FILES["document-".$i]['error'] === 0) {
                $sourcePath = $_FILES["document-".$i]['tmp_name'];
				//$name=$_FILES["document-".$i]['name'];
				$rand= rand(4,1000);
				$name=$rand.'_'.$_FILES["document-".$i]['name'];
                $ext = pathinfo($_FILES["document-".$i]['name'], PATHINFO_EXTENSION);
                
				
				$targetPath = $path."/web/uploads/$uid/documents/".$name;  
				
                if(move_uploaded_file($sourcePath,$targetPath)) {
			 
					$document = new UniversityBrochures();
					$document->university_id = $uid;
					$document->document_type = $DocumentData[$i]['document_type_id'];
					$document->title = $DocumentData[$i]['title'];
					$document->filename = $name;
					$document->created_at = gmdate('Y-m-d H:i:s');
					$document->created_by =  Yii::$app->user->identity->id;;
					$document->save(false); 
					 
                }
                else {
                     
                    return false;
                }
            }
            $i++;
        }
		 
        return true;
    }

    private function findCourseModel($id)
    {
        if (($model = UniversityCourseList::findOne($id)) !== null) {
            return $model;
        } else {
            return null;
        }
    }

  

   
    /**
     * Deletes an existing University model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionDeletePhoto() {
        $university = Yii::$app->request->post('university_id');
		
        $key = Yii::$app->request->post('key'); 
	
	  $deletePhoto = UniversityGallery::find()->where(['AND',
					['=', 'university_id', $university],
					['=', 'filename', $key ],					
					['=', 'photo_type',  'photos' ], 
					])->one(); 
					 
		 
		if(!empty($deletePhoto)){   
				$deletePhoto->updated_by  = Yii::$app->user->identity->id;
				$deletePhoto->updated_at = gmdate('Y-m-d H:i:s'); 
				$deletePhoto->status = 2; 
				$deletePhoto->save();  
				echo json_encode([]);
			} else {
            echo json_encode(['error' => 'Processing request ']);
        }
    }


    /**
     * Finds the University model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return University the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = University::findBySql('SELECT *, AsText(location) AS location FROM university WHERE id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**/
	 protected function findModelTemp($id)
    {
        if (($model = UniversityTemp::findBySql('SELECT *, AsText(location) AS location FROM university_temp WHERE university_id=' . $id)->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
    public function actionDependentStates() {
	 
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $states = State::getStatesForCountry($country_id);
                echo Json::encode(['output'=>$states, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    public function actionDependentCities() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $state_id = $parents[1];
                $cities = City::getCitiesForCountryAndState($country_id, $state_id);
                echo Json::encode(['output'=>$cities, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
 
 public function actionDependentMajors() {
        if (isset($_POST['degree'])) {
            $degree_id = $_POST['degree'];
            $majors = Majors::find()->where(['=', 'degree_id', $degree_id])->all();
            return Json::encode(['result'=>$majors, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }

    private function getDegreeList() {
        return ArrayHelper::map(Degree::find()->orderBy('id')->all(), 'id', 'name');
    }

    private function getMajorsList() {
        return ArrayHelper::map(Majors::find()->orderBy('id')->all(), 'id', 'name');
    }

    private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }

    public function actionDependentCourses() {
        if (isset($_POST['degree']) && isset($_POST['university'])) {
            $degree_id = $_POST['degree'];
            $university_id = $_POST['university'];
            $courses = [['id' => '0', 'name' => 'ALL']];
            $temp = UniversityCourseList::find()->where(['and', ['=', 'degree_level_id', $degree_id],['=', 'university_id',  $university_id]])->all();
            foreach($temp as $course) {
                array_push($courses, ['id' => $course->id, 'name' => $course->name]);
            }
            return Json::encode(['result'=>$courses, 'status' => 'success']);
        }
        return Json::encode(['result'=>[], 'status' => 'failure']);
    }

    public function getCourses($department_id) {
        if (($model = UniversityDepartments::findBySql('SELECT id, name FROM university_admission WHERE department_id=' . $department_id)->all()) !== null) {
            return ArrayHelper::map($model, 'id', 'name');
        } else {
            return [];
        }
    }

    public function actionUploadPhotos() {
        $university = Yii::$app->request->post('university_id');
        $result = is_dir("./../web/uploads/$university/photos");
        if (!$result) {
            $result = FileHelper::createDirectory("./../web/uploads/$university/photos");
        }
        $sourcePath = $_FILES['photos']['tmp_name'];
        $ext = pathinfo($_FILES['photos']['name'], PATHINFO_EXTENSION);
        $targetPath = "./../web/uploads/$university/photos/" . date_timestamp_get(date_create()) . '.' . $ext; // Target path where file is to be stored
        if (move_uploaded_file($sourcePath,$targetPath)) {
            echo json_encode([]);
        }
        else {
            echo json_encode(['error' => 'Processing request ' . $sourcePath]);
        }
    }

    
  public function actionCreate($id,$timestamp)
    {
		$timestamp = Commondata::encrypt_decrypt('decrypt',$timestamp);
		$id = Commondata::encrypt_decrypt('decrypt', $id);
		
        $university = University::find()->where(['=', 'id', $id])->one(); 
		
        $partnerLogin = new PartnerLogin();
		$PartnerSignup = new PartnerSignup();
        $countries = ArrayHelper::map(Country::find()->orderBy(['name' => 'ASC'])->all(), 'id', 'name'); 
		
		$exists = PartnerLogin::find()->where(['=', 'partner_id', $university->id])
			->andWhere(['=', 'role_id', Roles::ROLE_UNIVERSITY]) 
			->one(); 
		 
		if(!empty($exists)) {
			$partnerLogin = $exists; 
			if($exists->status==PartnerLogin::STATUS_ACTIVE) {
				Yii::$app->getSession()->setFlash('Error', 'You are already activated. Please login with your credentials or contact to Administrator.');	
				return $this->redirect('?r=site/login'); 
			}
		} 
				 
        if($PartnerSignup->load(Yii::$app->request->post()) &&  $PartnerSignup->validate()) { 
			
			$password = $PartnerSignup->password;
			$partnerLogin->username = $PartnerSignup->username;
			$partnerLogin->email = $university->email; 
			$partnerLogin->setPassword($password);
			$partnerLogin->status = PartnerLogin::STATUS_ACTIVE;
			$partnerLogin->role_id = Roles::ROLE_UNIVERSITY;
			$partnerLogin->generatePasswordResetToken();
			$partnerLogin->generateAuthKey();
			$partnerLogin->partner_id =  $university->id;
			$partnerLogin->created_at = gmdate('Y-m-d H:i:s');
			$partnerLogin->updated_at = gmdate('Y-m-d H:i:s');
			
			if($partnerLogin->save(false)) { 

				$to = $university->email;
				$user = $university->name;
				$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=site/login';				
				$subject = $university->name.' created credentials successfully.';
				$template = 'welcome_email_university';  
				
				$data = array('name' => $user, 'link' => $link,'username' => $partnerLogin->username, 'password' => $password);		
				$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);

				if($mailsent==true){  
					Yii::$app->getSession()->setFlash('Success', 'Your login credentials has been created successfully. Please login here.'); 
					return $this->redirect('?r=site/login');
				
				}else{
					Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
				}
			  
			}else {
				Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please contact to Administrator.'); 
			}  
			
		} 
		 
				
        	 
		return $this->render('createsignup', [  
			'PartnerSignup' => $PartnerSignup, 
        ]);
    }
	
 public function actionDownload() {
        ini_set('max_execution_time', 5*60); // 5 minutes
        $id = Yii::$app->user->identity->partner_id;
        $fileName = $_GET['name'];
        if (is_dir("./../../backend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../backend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => false,
                'only' => [$fileName]
            ]);
            if (count($path) > 0) {
                Yii::$app->response->sendFile($path[0]);
            }
        }
    }
	
	 public function actionDownloadAll() {
         $id = Yii::$app->user->identity->partner_id;
		  
		$model = UniversityBrochures::find()->where(['=', 'university_id', $id])->all();  
		
        if (is_dir("./../../backend/web/uploads/$id/documents")) {
            $path = FileHelper::findFiles("./../../backend/web/uploads/$id/documents", [
                'caseSensitive' => false,
                'recursive' => true,
            ]);
            if(count($path) > 0) {
                $files = $path;
                $result = is_dir("./../../backend/web/downloads");
                if (!$result) {
                    FileHelper::createDirectory("./../../backend/web/downloads");
                } 
                $zipname = './../../backend/web/downloads/documents'.$id.'.zip';
                $zip = new \ZipArchive();
                $zip->open($zipname, \ZipArchive::CREATE);
                $k = 0;
				 
                foreach ($files as $file) {
                    $normalized = FileHelper::normalizePath($file,'/');
                    $filename = explode($id.'/', $normalized);
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
	
	 public function actionDeletedocument() {
        ini_set('max_execution_time', 5*60); // 5 minutes
       $uid  = Yii::$app->user->identity->partner_id;
		
        $message=array();
		$data = Yii::$app->request->get();
	
		$fileName = $data['name'];
		$id = $data['studocuid'];
		if($id!="" && $fileName!=""){
		$path = "./../../backend/web/uploads/$uid/documents/$fileName.";
		
		$model = UniversityBrochures::findOne($id);
		$model->updated_by  = Yii::$app->user->identity->id;
		$model->updated_at = gmdate('Y-m-d H:i:s'); 
		$model->status = 2; 
		$model->active = 2; 
				
			if($model->save()){
				unlink($path);
				$message=array('status' => 'success');
			}else{
				$message=array('status' => 'failed');
			}
		}
	 
		echo json_encode($message);return;
    }

	
	public function actionGetdocumentlist(){
		
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		$string = json_encode($allArs);
		echo '['.$string.']';
		return;
		
	}
	 
    public function beforeAction($action)
    {            
        if ($action->id == 'preview') {
				Yii::$app->controller->enableCsrfValidation = false;        
		}
        return parent::beforeAction($action);
    }  
}
