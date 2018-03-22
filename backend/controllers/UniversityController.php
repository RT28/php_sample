<?php

namespace backend\controllers;

use Yii;
use common\models\University;
use backend\models\UniversitySearch;
use backend\models\SiteConfig;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\models\Degree;
use common\models\Majors; 
use common\models\UniversityAdmission;
use common\components\Roles;
use common\components\AccessRule;
use common\models\UniversityCourseList;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\UploadedFile;
use common\models\FileUpload;
use backend\models\UniversityDepartments;
use common\components\Model;
use common\models\Others;
use common\models\DegreeLevel;
use yii\helpers\FileHelper;
use common\models\Currency;
use common\components\Status;
use common\models\StandardTests;
use yii\base\ErrorException;
use common\models\UniversityBrochures;
use common\models\UniversityGallery;
use common\components\ConnectionSettings;
use yii\db\IntegrityException; 
use common\components\Commondata;

/**
 * UniversityController implements the CRUD actions for University model.
 */
class UniversityController extends Controller
{
    /**
     * @inheritdoc
     */    
    
    private $failed_bulk_models;
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
                        'actions' => ['index', 'view', 'create', 'update', 'dependent-states', 'dependent-cities', 'dependent-courses', 'upload-photos', 'delete-photo', 'delete-logo','delete-coverphoto', 'dependent-courses', 'dependent-majors', 'upload-university', 'upload-programs', 'upload-admissions', 'createlogin','getdocumentlist','upload-documents','deletedocument','download','download-all'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN, Roles::ROLE_EDITOR]
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMIN]
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

    /**
     * Lists all University models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//$message = '';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			//'message' =>  $message,
        ]);
    }

    /**
     * Displays a single University model.
     * @param integer $id
     * @return mixed
     */
        public function actionView($id)
    {
        $model = $this->findModel($id);
        $upload = new FileUpload();
        $courses = $model->universityCourseLists;
        $univerityAdmisssions = $model->universityAdmissions;
        $currentTab = 'Profile';
        $tabs = ['Profile', 'About', 'Misc', 'Department', 'Gallery', 'Admissions','Documents'];
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');
		
		$query = "SELECT * FROM university_brochures where  university_id='$id' AND status = 1 AND active = 1 ";

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
                'currentTab' => 'Department',
                'tabs' => ['Profile', 'About', 'Misc', 'Department']
            ],
            'Profile,About,Misc,Department' => [
                'currentTab' => 'Gallery',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery']
            ],
            'Profile,About,Misc,Department,Gallery' => [
                'currentTab' => 'Admissions',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery','Admissions']
            ],
            'Profile,About,Misc,Department,Gallery,Admissions' => [
                'currentTab' => 'Documents',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery','Admissions','Documents']
            ],
			 'Profile,About,Misc,Department,Gallery,Admissions,Documents' => [
                'currentTab' => 'Documents',
                'tabs' => ['Profile', 'About', 'Misc', 'Department','Gallery','Admissions','Documents']
            ],
			
			 
        ];

        return $map[$tabs];
    }

    /**
     * Creates a new University model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        ini_set('max_execution_time', 300);
        $model = Yii::$app->request->post('id');
        if (!empty($model)) {
            $model = $this->findModel($model); 
        } else {
            $model = new University();
        }
		

        $model->institution_ranking = '[{"rank":"","source":"http://www.usnews.com/education","name":"U.S.News"},{"rank":"","source":"http://www.topuniversities.com/university-rankings","name":"QS World Ranking"}]';
        $upload = new FileUpload();
        $courses = $model->universityCourseLists;
        $univerityAdmisssions = $model->universityAdmissions;
        $currentTab = 'Profile';
        $tabs = ['Profile'];
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');
        $standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
		 

        $DocumentModel = new UniversityBrochures();
		
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		
        if ($model->load(Yii::$app->request->post())) {
            $currentTab = Yii::$app->request->post('currentTab');
            $tabs = explode(',', Yii::$app->request->post('tabs'));
            $result = $this->validateForm($tabs, $model);
            if ($result['action'] === 'next') {
                $isModelSaved = false;
                if ($result['count'] >= 3 ) {
                    $this->setSpatialPoints($model, Yii::$app->request->post()['University']['location']);
                    $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                    $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                    $model->created_at = gmdate('Y-m-d H:i:s');
                    $model->updated_at = gmdate('Y-m-d H:i:s');
                    $model->institution_ranking = $_POST['university-rankings'];
                    $isModelSaved = $model->save(false);
                }
                if ($isModelSaved||$isModelSaved != '') {
                    $dependentUpdates = false;
                    if($result['count'] >= 4) {
                    //    $dependentUpdates = $this->updateCourses($courses, $model);
					 $dependentUpdates = true;
                    }
                    if ($dependentUpdates && $result['count'] >= 5) {
                        $dependentUpdates = $this->saveCoverPhoto($upload, $model);
                        $dependentUpdates = $this->saveLogo($upload, $model);
                        $dependentUpdates = $this->savePhotos($upload, $model);
						if(isset($_POST['university-videos'])){
							$model->video = $_POST['university-videos'];
						}
                    }
                    if ($dependentUpdates && $result['count'] >= 6) {
                        $model = $this->findModel($model->id);
                      //  $dependentUpdates = $this->updateAdmissions($univerityAdmisssions, $model);
					   $dependentUpdates = true;
                        
                    }
					if ($result['count'] >= 7) {  
							$brouchersUpdates = false;  						
							if(isset($_FILES)){
								unset($_FILES['FileUpload']);
								$fileData = $_FILES;
							}
							if(isset($postData['document'])){
								$dData = $postData['document'];
								$model = $this->findModel($model->id);
								$brouchersUpdates = $this->saveBrochures($fileData, $model,$dData);
							} 
					}
						
						
  

						if($dependentUpdates) {
                            return $this->redirect(['view', 'id' => $model->id]);
                        }
						
                }
				
				
                $tabs = $this->getCurrentTabAndTabs(implode(',', $tabs));
                $currentTab = $tabs['currentTab'];
                $tabs = $tabs['tabs'];
            }
        }
        return $this->render('create', [
            'id' => isset($model->id) ? $model->id : null,
            'model' => $model,
            'institutionType' => $this->getOthers('institution_type'),
            'establishment' => $this->getOthers('establishment'),
            'courseType' => $this->getOthers('course_type'),
            'languages' => $this->getOthers('languages'),
            'durationType' =>$this->getOthers('duration_type'),
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
            'standardTests' => $standardTests,
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,
        ]);
    }

    /**
     * Updates an existing University model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        ini_set('max_execution_time', 300);
        $model = $this->findModel($id);
        $upload = new FileUpload();
        $courses = $model->universityCourseLists;
        $univerityAdmisssions = $model->universityAdmissions;
        
        $currentTab = 'Profile';
        if (empty($courses)) {
                $tabs = ['Profile', 'About', 'Misc', 'Department', 'Gallery','Admissions','Documents'];
        }else{
            $tabs = ['Profile', 'About', 'Misc', 'Department', 'Gallery', 'Admissions','Documents'];
        }
        $countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'name', 'iso_code', 'symbol');       
        $standardTests = StandardTests::find()->orderBy(['name' => 'ASC'])->all();
        $standardTests = ArrayHelper::map($standardTests, 'id', 'name');
		
		$query = "SELECT * FROM university_brochures where  university_id ='$id' AND status = 1 AND active = 1";

        $DocumentModel = UniversityBrochures::findBySql($query)->all();
		$allArs = array('brouchres'=>'Brochures', 'university_application'=>'University Application', 'other'=>'Other Documents');
		
		
        if ($model->load(Yii::$app->request->post())) {
			
			$postData=Yii::$app->request->post();
			
            if (empty($courses)) {
                $tabs = ['Profile', 'About', 'Misc', 'Department', 'Gallery', 'Admissions','Documents'];
            }
            $result = $this->validateForm($tabs, $model);
			
		
            if ($result['action'] === 'next') {
                $isModelSaved = false;
                if ($result['count'] >= 3 ) { 
                    $this->setSpatialPoints($model, Yii::$app->request->post()['University']['location']);
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->updated_at = gmdate('Y-m-d H:i:s');
                    $model->institution_ranking = $_POST['university-rankings'];
					
                    $isModelSaved = $model->save(false);
                }
                if ($isModelSaved) {
                    $dependentUpdates = false;
                    if($result['count'] >= 4) {
                        if(sizeof($courses) > 0 || isset($_POST['UniversityCourseList'])) {
                            //$dependentUpdates = $this->updateCourses($courses, $model);
                            $dependentUpdates = true;
                        } else {
                            $dependentUpdates = true;
                        }
                    }
                    if ($dependentUpdates && $result['count'] >= 5) {
                        
                        $dependentUpdates = $this->saveCoverPhoto($upload, $model);
                        $dependentUpdates = $this->saveLogo($upload, $model);
                        $dependentUpdates = $this->savePhotos($upload, $model);
						
						if(isset($_POST['university-videos'])){
							$model->video = $_POST['university-videos'];
						}
					   $isModelSaved = $model->save(false);
					 
                    }
                    if ($dependentUpdates && $result['count'] >= 6) {
                        $model = $this->findModel($model->id);
                        if(sizeof($univerityAdmisssions) > 0) {
                            $dependentUpdates = $this->updateAdmissions($univerityAdmisssions, $model);
                        }
                    }
					
					if ($result['count'] >= 7) {  
							$brouchersUpdates = false;  						
							if(isset($_FILES)){
								unset($_FILES['FileUpload']);
								$fileData = $_FILES;
							}
							if(isset($postData['document'])){
								$dData = $postData['document'];
								$model = $this->findModel($model->id);
								$brouchersUpdates = $this->saveBrochures($fileData, $model,$dData);
							}
							  
/*echo "<pre>";
print_r($postData);
//print_r($_FILES);
die; */
						}
						
						 
                    if($dependentUpdates) {
  
					
                        return $this->redirect(['view', 'id' => $model->id]);
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
            'courses' => (empty($courses)) ? [new UniversityCourseList] : $courses,
            'univerityAdmisssions' => (empty($univerityAdmisssions)) ? [new UniversityAdmission] : $univerityAdmisssions,
            'degreeLevels' => DegreeLevel::getAllDegreeLevels(),
            'currencies' => $currencies,
            'standardTests' => $standardTests,
			'documentlist' => $DocumentModel,
			'doclist' => $allArs,
        ]);
    }

	public function actionDownload() {
        ini_set('max_execution_time', 5*60); // 5 minutes
        $id = $_GET['id'];
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
	
	 public function actionDownloadAll($id) { 
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
		 
        $message=array();
		$data = Yii::$app->request->get(); 
		$fileName = $data['name'];
		$id = $data['studocuid'];
		$model = UniversityBrochures::findOne($id); 
		$uid = $model->university_id;
		if($id!="" && $fileName!=""){
		$path = "./../../backend/web/uploads/$uid/documents/$fileName."; 
			if($model->delete()){
				@unlink($path);
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
	
	private function saveBrochures($files,$university,$DocumentData){
         ini_set('max_execution_time', 5*60); 
		 
		$uid = $university->id; 
		$message=array();
        $i = 1;
		
		$data = array(); 
		  
		$path = Yii::getAlias('@backend'); 
		$result = is_dir($path."/web/uploads/$uid/documents");
		if (!$result) {
			$result = FileHelper::createDirectory($path."/web/uploads/$uid/documents");
		}
		
		$filecount =  count($DocumentData);
	 

        while($i<=$filecount) {
			 
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
					$document->status = 1;
					$document->active = 1;
					$document->created_at = gmdate('Y-m-d H:i:s');
					$document->created_by =  Yii::$app->user->identity->id;;
					$document->save(false); 
					// print_r($document );
                }
                else {
                     
                    return false;
                }
            } 
            $i++;
        } 
		
		
		/*echo "<pre>";
		//print_r($postData);
		print_r($_FILES);*/
		 
        return true;
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
  
	 private function saveCoverPhoto($image, $university) {
        $newFile = UploadedFile::getInstance($image, 'imageFile');        
        if (isset($newFile)) {            
            $image->imageFile = UploadedFile::getInstance($image, 'imageFile');   
			$filename = $image->upload($university);			
         	 
			if(isset($filename)){
				$coverPhoto = $filename;			
				$uid = $university->id;
				 
				$Cover_Photo =  UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid],				
				['=', 'photo_type',  'cover_photo' ], 
				])->one(); 
				 
				/*if(!empty($UGallery)) {		 			
					$path = Yii::getAlias('@backend'); 				 
					unlink($path."/web/uploads/$uid/cover_photo/".$UGallery->filename);
				} */ 
				
				 if(isset($Cover_Photo)){ 
					if($Cover_Photo->delete()){
						$file = $Cover_Photo->filename;
						$uid = $Cover_Photo->university_id; 
					}      
			   }
				if(empty($Cover_Photo)) {			 
					$Cover_Photo = new UniversityGallery();
					$Cover_Photo->created_by = Yii::$app->user->identity->id;
					$Cover_Photo->created_at = gmdate('Y-m-d H:i:s');
				} 	
				$Cover_Photo->updated_by = Yii::$app->user->identity->id;
				$Cover_Photo->updated_at = gmdate('Y-m-d H:i:s');
				$Cover_Photo->university_id = $uid;
				$Cover_Photo->photo_type = 'cover_photo';
				$Cover_Photo->filename = $coverPhoto;
				$Cover_Photo->status = 1;
				$Cover_Photo->active = 1;
				$Cover_Photo->save(); 			 
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    private function savePhotos($image, $university) {
        $files = UploadedFile::getInstances($image, 'universityPhotos');
        if(isset($files) && sizeof($files) > 0) {
            $image->universityPhotos = $files;
            $filenames = $image->uploadUniversityPhotos($university);
			 
			if(isset($filenames)){ 
				foreach ($filenames as $file) { 
				 
					$coverPhoto =  $file;			
					$uid = $university->id;
					 
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
					$UGallery->status = 1;
					$UGallery->active = 1;
					$UGallery->save(false); 
				  
				}
			 
					
			}
			
			return $filenames;
        }
        return true;
    }

    private function saveLogo($image, $university) {
        $newFile = UploadedFile::getInstance($image, 'logoFile');
        if (isset($newFile)) {
            $image->logoFile = $newFile;
			
			$filename = $image->uploadLogo($university);			
         	 
			if(isset($filename)){
				
				$LogoPhoto = $filename;
				$uid = $university->id;
				
				$Logo = UniversityGallery::find()->where(['AND',
				['=', 'university_id', $uid], 
				['=', 'photo_type',  'logo' ] 
				])->one();  
				
			   if(isset($Logo)){ 
					if($Logo->delete()){
						$file = $Logo->filename;
						$uid = $Logo->university_id; 
					}      
			   }
				  
				if(empty($Logo)) {			 
					$Logo = new UniversityGallery();
					$Logo->created_by = Yii::$app->user->identity->id;
					$Logo->created_at = gmdate('Y-m-d H:i:s');
				} 	
				$Logo->updated_by = Yii::$app->user->identity->id;
				$Logo->updated_at = gmdate('Y-m-d H:i:s');
				$Logo->university_id = $uid;
				$Logo->photo_type = 'logo';
				$Logo->filename = $LogoPhoto;
				$Logo->status = 1;
				$Logo->active = 1;
				$Logo->save(false);  
			 
                return true;
            } else {
                return false;
            }
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

    private function updateCourses($courses, $university) {
        $post_data = $_POST['UniversityCourseList'];
        if (sizeof($post_data) === 1 && empty($post_data[0]['name'])) {
            return true;
        }
        $oldIDs = ArrayHelper::map($courses, 'id', 'id');
        $courses = Model::createMultiple(UniversityCourseList::classname(), $courses);
        $result = Model::loadMultiple($courses, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($courses, 'id', 'id')));
        $flag = true;
        // validate all models
        $valid = Model::validateMultiple($courses, ['name', 'degree_id', 'major_id', 'degree_level_id']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                if (!empty($deletedIDs)) {
                    UniversityCourseList::deleteAll(['id' => $deletedIDs]);
                }
				
					foreach ($courses as $course) {
						if(!empty($course->program_code)) {
							$course->program_code = $course->program_code;
						}else{
							$course->program_code(false);
						}	
						if(!empty($course->standard_test_list)  && isset($course->standard_test_list)) {
					  
								$course->standard_test_list = implode(',',  (array)$course->standard_test_list);
							 
							 
						}
						$course->university_id = $university->id;
						$course->created_by = Yii::$app->user->identity->id;
						$course->updated_by = Yii::$app->user->identity->id;
						$course->created_at = gmdate('Y-m-d H:i:s');
						$course->updated_at = gmdate('Y-m-d H:i:s');
						if (! ($flag = $course->save())) {
							$transaction->rollBack();
							break;
						}
					}
				 
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return false;
            }
        }
    }

    private function updateAdmissions($univerityAdmisssions, $university) {
        $oldIDs = ArrayHelper::map($univerityAdmisssions, 'id', 'id');
        $univerityAdmisssions = Model::createMultiple(UniversityAdmission::classname(), $univerityAdmisssions);
        $result = Model::loadMultiple($univerityAdmisssions, Yii::$app->request->post());
        $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($univerityAdmisssions, 'id', 'id')));
        // validate all models
        $valid = Model::validateMultiple($univerityAdmisssions, ['degree_level_id']);
        if ($valid) {
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = true;
            try {
                if (!empty($deletedIDs)) {
                    UniversityAdmission::deleteAll(['id' => $deletedIDs]);
                }
                foreach ($univerityAdmisssions as $admission) {
                    $admission->university_id = $university->id;
                    $admission->created_by = Yii::$app->user->identity->id;
                    $admission->updated_by = Yii::$app->user->identity->id;
                    $admission->created_at = gmdate('Y-m-d H:i:s');
                    $admission->updated_at = gmdate('Y-m-d H:i:s');
                    if (! ($flag = $admission->save())) {
                        $transaction->rollBack();
                        break;
                    }
                }
                if ($flag) {
                    $transaction->commit();
                    return true;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return false;
            }
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

    public function actionDeletePhoto() {
        $university = Yii::$app->request->post('university_id');
        $key = Yii::$app->request->post('key');
		
		     
        if (unlink("./../web/uploads/$university/photos/$key")) {
			$delete_Photo =  UniversityGallery::find()->where(['AND',
			['=', 'university_id', $university],				
			['=', 'photo_type',  'photos' ], 
			['=', 'filename',  $key ], 
			])->one(); 
			   
			if(isset($delete_Photo)){ 
			 
				 $delete_Photo->delete();     
		   }
            echo json_encode([]);
        } else {
            echo json_encode(['error' => 'Processing request ']);
        }
    }
	public function actionDeleteCoverphoto($university_id,$key) {
           
        if (unlink("./../web/uploads/$university_id/cover_photo/$key")) {
			$delete_Photo =  UniversityGallery::find()->where(['AND',
			['=', 'university_id', $university_id],				
			['=', 'photo_type',  'cover_photo' ], 
			['=', 'filename',  $key ], 
			])->one(); 
			   
			if(isset($delete_Photo)){ 
			 
				 $delete_Photo->delete();
			 				 
		   } 
            echo json_encode([]);
        } else {
             echo json_encode(['error' => 'Processing request ']);
        }
    }
	
    public function actionDeleteLogo($university_id,$key) {
           
        if (unlink("./../web/uploads/$university_id/logo/$key")) {
			$delete_Photo =  UniversityGallery::find()->where(['AND',
			['=', 'university_id', $university_id],				
			['=', 'photo_type',  'logo' ], 
			['=', 'filename',  $key ], 
			])->one(); 
			   
			if(isset($delete_Photo)){ 
			 
				 $delete_Photo->delete();
			 				 
		   } 
            echo json_encode([]);
        } else {
             echo json_encode(['error' => 'Processing request ']);
        }
    }

    public function actionUploadUniversity() {
        ini_set('max_execution_time', 300);
        if(Yii::$app->request->post()) {
            $sourcePath = $_FILES['university']['tmp_name'];
            $ext = pathinfo($_FILES['university']['name'], PATHINFO_EXTENSION);
            $targetPath = "./uploads/Data.$ext";
            $failed_models = [];

            if (move_uploaded_file($sourcePath,$targetPath)) {
                $csvFile = file($targetPath);
                $length = sizeof($csvFile);
                $countries = [];
                $states = [];
                $cities = [];
                $currencies = [];
                $tests = [];
                $institutionType = $this->getOthers('institution_type');
                $establishment = $this->getOthers('establishment');
				$RowCount = 1;
                for($count = 1; $count < $length; $count++) {
                    $data = explode(',', $csvFile[$count]);
                    foreach($data as $key => $value) { 
                       $data[$key] = str_replace(array('!','~','?'), array(',','',' '), $value);
                    }
                    $name = trim($data[0]);
                    

                    # check if university exists.
                    $model = University::find()->where(['=', 'name', $name])->one();
                    if(empty($model)) {
                        $model = new University();
                        $model->created_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                        $model->created_at = gmdate('Y-m-d H:i:s');
                    }
                    $model->name = $name;
                    $model->establishment_date = trim($data[1]);
                    $model->address = trim($data[2]);

                    # add country id to university model.
                    $countryName = trim($data[5]);
					
					 
                    if(empty($countries[$countryName])) {
                        $country = Country::find()->where(['=', 'name', $countryName])->one();
                        if(empty($country)) {
                            $country = new Country();
                            $country->name = $countryName;
                           if($country->save()) {
                                $countries[$countryName] = $country->id;
                                $model->country_id = $country->id;
                            } else {
                                $model->addError('country_id', 'Erorr adding country: ' . $countryName);
                                array_push($failed_models, $model);
                                continue;
                            }
                        } else {
                            $model->country_id = $country->id;
                        }
                    } else {
                        $model->country_id = $countries[$countryName];
                    }

                    # add state id to university model.
                    $stateName = trim($data[4]);
                    $stateKey = $countryName . ',' . $stateName;
                    if(empty($states[$stateKey])) {
                        $state = State::find()->where(['AND', ['=', 'country_id', $model->country_id], ['=', 'name', $stateName]])->one();
                        if(empty($state)) {
                            $state = new State();
                            $state->name = $stateName;
                            $state->country_id = $model->country_id;
                            if($state->save()) {
                                $states[$stateKey] = $state->id;
                                $model->state_id = $state->id;
                            } else {
                                $model->addError('state_id', 'Error adding state: ', $stateName);
                                array_push($failed_models, $model);
                                continue;
                            }
							$model->addError('state_id', 'Row : '.$RowCount.' Error adding state: ', $stateName);
                                array_push($failed_models, $model);
                                continue;
                        } else {
                            $model->state_id = $state->id;
                        }
                    } else {
                        $model->state_id = $states[$stateKey];
                    }

                    # add city id to university model.
                    $cityName = trim($data[3]);
                    $cityKey = $countryName . ',' . $stateName . ',' . $cityName;
                    if(empty($cities[$cityKey])) {
                        $city = City::find()->where(['AND', ['=', 'country_id', $model->country_id], ['=', 'state_id', $model->state_id], ['=', 'name', $cityName]])->one();
                        if(empty($city)) {
                            $city = new City();
                            $city->name = $cityName;
                            $city->state_id = $model->state_id;
                            $city->country_id = $model->country_id;
                            if($city->save()) {
                                $cities[$cityKey] = $city->id;
                                $model->city_id = $city->id;
                            } else {
                                $model->addError('city_id', 'Error adding city: ', $cityName);
                                array_push($failed_models, $model);
                                continue;
                            } 
                        } else {
                            $model->city_id = $city->id;
                        }
                    } else {
                        $model->city_id = $cities[$cityKey];
                    }

                    $model->pincode = trim($data[6]);
                    $model->email = empty($data[7]) ? 'info@gotouniversity.com' : trim($data[7]);
                    $model->website = empty($data[8]) ? 'www.gotouniversity.com' : trim($data[8]);
                    $model->description = empty($data[9]) ? $model->description : trim($data[9]);
                    $model->fax = trim($data[10]);
                    $model->phone_1 = empty($data[11]) ? '-' : trim($data[11]);
                    $model->phone_2 = trim($data[12]);
                    $model->contact_person = trim($data[13]);
                    $model->contact_person_designation = trim($data[14]);
                    $model->contact_mobile = trim($data[15]);
                    $model->contact_email = trim($data[16]);

                    # parse university location if any
                    if (!empty(trim($data[17]))) {
						$location = trim($data[17]);
                        $location = str_replace(['POINT', '(', ')'], '', $location);
                        $this->setSpatialPoints($model, $location);
                    }

                    # set university institution type.
					if(!empty(trim($data[18]))){
                    $index = array_search(trim($data[18]), $institutionType);
                    if($index === false) {
                        $institutionTypeModel = Others::find()->where(['=', 'name', 'institution_type'])->one();
                        $others = explode(',', $institutionTypeModel->value);
                        array_push($others, trim($data[18]));
                        $others = implode(',', $others);
                       /* if($institutionTypeModel->save()) {
                            $institutionType = $others;
                            $model->institution_type = sizeof($institutionType) - 1;
                        } else {
                            $model->addError('institution_type', 'Row : '.$RowCount.' Error adding Institution Type: ', $data[18]);
                            array_push($failed_models, $model);
                            continue;
                        }*/ 
                    } else {
                        $model->institution_type = $index;
                    }
					}

                    # set university establishment.
                    $index = false;
                    $index = array_search(trim($data[19]), $establishment);
                    if($index === false) {
                        $establishmentModel = Others::find()->where(['=', 'name', 'establishment'])->one();
                        $others = explode(',', $establishmentModel->value);
                        array_push($others, trim($data[19]));
                        $others = implode(',', $others);
                        /*if($establishmentModel->save()) {
                            $establishmentModel = $others;
                            $model->establishment = sizeof($establishmentModel) - 1;
                        } else {
                            $model->addError('establishment', 'Row : '.$RowCount.' Error adding Establishment: ', $data[19]);
                            array_push($failed_models, $model);
                            continue;
                        }*/
						$model->addError('establishment', 'Row : '.$RowCount.' Error adding Establishment: ', $data[19]);
                            array_push($failed_models, $model);
                            continue;
                    } else {
                        $model->establishment = $index;
                    }
                 
                    $model->no_of_students = trim($data[20]);
                    $model->no_of_undergraduate_students = trim($data[21]);
                    $model->no_of_post_graduate_students = trim($data[22]);
                    $model->no_of_international_students = trim($data[23]);
                    $model->no_faculties = trim($data[24]);
                    $model->no_of_international_faculty = trim($data[25]);

                    # set currency
                    $currencyKey = trim($data[26]);
                    if (empty($currencies[$currencyKey])) {
                        $currency = Currency::find()->where(['=', 'iso_code', $currencyKey])->one();
                        if(empty($currency)) {
                            $currency = new Currency();
                            $currency->name = $currencyKey;
                            $currency->iso_code = $currencyKey;
                            $currency->country_id = $model->country_id;
                            $currency_symbol = $currencyKey;
                            $currency->created_by = Yii::$app->user->identity->id;
                            $currency->updated_by = Yii::$app->user->identity->id;
                            $currency->created_at = gmdate('Y-m-d H:i:s');
                            $currency->updated_at = gmdate('Y-m-d H:i:s');
                            if($currency->save()) {
                                $currencies[$currencyKey] = $currency->id;
                                $model->currency_id = $currency->id;
                            } else {
                                $model->addError('currency_id', 'Row : '.$RowCount.' Error adding Local Currency: ', $data[26]);
                                array_push($failed_models, $model);
                                continue;
                            }
                        } else {
                            $model->currency_id = $currency->id;
                        }
                    } else {
                        $model->currency_id = $currencies[$currencyKey];
                    }

                    # set international currency. 
                    if(empty($data[27])) {
                        $model->currency_international_id = $model->currency_id;
                    } else {
                        $currencyKey = trim($data[27]);
                        if (empty($currencies[$currencyKey])) {
                            $currency = Currency::find()->where(['=', 'iso_code', $currencyKey])->one();
                            if(empty($currency)) {
                                $currency = new Currency();
                                $currency->name = $currencyKey;
                                $currency->iso_code = $currencyKey;
                                $currency->country_id = $model->country_id;
                                $currency_symbol = $currencyKey;
                                $currency->created_by = Yii::$app->user->identity->id;
                                $currency->updated_by = Yii::$app->user->identity->id;
                                $currency->created_at = gmdate('Y-m-d H:i:s');
                                $currency->updated_at = gmdate('Y-m-d H:i:s');
                                if($currency->save()) {
                                    $currencies[$currencyKey] = $currency->id;
                                    $model->currency_international_id = $currency->id;
                                } else {
                                    $model->addError('currency_id', 'Row : '.$RowCount.' Error adding Local Currency: ', $data[27]);
                                    array_push($failed_models, $model);
                                    continue;
                                }
                            } else {
                                $model->currency_international_id = $currency->id;
                            }
                        } else {
                            $model->currency_international_id = $currencies[$currencyKey];
                        }
                    }

                    $model->cost_of_living = trim($data[28]);
                    $model->undergarduate_fees = trim($data[29]);
                    $model->undergraduate_fees_international_students = empty($data[30]) ? $model->undergarduate_fees : trim($data[30]);
                    $model->post_graduate_fees = trim($data[31]);
                    $model->post_graduate_fees_international_students = empty($data[32]) ? $model->post_graduate_fees : trim($data[32]);
                    $model->accomodation_available = (trim($data[33]) === 'Yes') ? 1 : 0;
                    $model->hostel_strength = trim($data[34]);

                    # set institution ranking;
					if(!empty(trim($data[35]))){
                    $rankings = [];
                    $ranking = split(',', trim($data[35]));
                    for($i = 0; $i < sizeof($ranking); $i++) {
                        $str = split(':', $ranking[$i]);
						if(isset($str[1])){
                        array_push($rankings, [
                            'rank' => $str[1],
                            'name' => $str[0],
                            'source' => ($str[0] === 'U.S.News') ? 'http://www.usnews.com/education' : ($str[0] === 'QS World Ranking') ? 'http://www.topuniversities.com/university-rankings' : ''
                        ]);
					}
                    }
                    $rankings = json_encode($rankings);
                    $model->institution_ranking = $rankings;
					}

                    $model->video = trim($data[36]);
                    $model->virtual_tour = trim($data[37]);
                    $model->avg_rating = trim($data[38]);
                    $model->standard_tests_required = (trim($data[39]) === 'Yes') ? 1 : 0;

                    $model->achievements = empty($data[40]) ? $model->achievements : trim($data[40]) ;
                    $model->comments = null;
                    $model->status = Status::STATUS_ACTIVE;
                    $model->updated_by = Yii::$app->user->identity->username.'-'.Yii::$app->user->identity->tableName();
                    $model->updated_at = gmdate('Y-m-d H:i:s');
         
				
			try { 
				 
					if (!$model->save()) { 
                        $model->addError('id', '[Row] ' .$RowCount);
                        array_push($failed_models, $model);                         
                        continue;
                    }

				}catch (IntegrityException $e) { 
						if(isset($e->errorInfo[0]) && $e->errorInfo[0] == '23000') {
                            $model->addError('name', 'Duplicate row');
                        }
						
						$model->addError('id', '[Row] ' .$RowCount .  $e->getMessage());
                        array_push($failed_models, $model);                         
                        continue;


				}catch (Exception $e) {
  
						$model->addError('id', '[Row] ' .$RowCount .  $e->getMessage());
                        array_push($failed_models, $model);                         
                        continue;


				}

				$RowCount ++;
				
                }
                if(sizeof($failed_models) === 0) {
                    return $this->render('upload-university', [
                        'success' => 'All Universities uploaded.'
                    ]);
                } else {
					echo "<pre>"; 
			foreach($failed_models as $value) {

			$data = $value->getErrors(); 	

			foreach($data as $key => $value) {
			?>
			<li>
			<?php
			echo $key. " : ". $value[0] . "";
			?>
			</li>
			<?php
			}
			$count++;		
			} 
					
                   die();
                    return $this->redirect(['upload-university', 'model' => $failed_models]);
					 
                }
            } else {
                return $this->render('upload-university', [
                    'error' => 'Error uploading file', 'model' => $failed_models
                ]);
            }
        }        
        return $this->render('upload-university');
    }

    public function actionUploadPrograms() {
        if(Yii::$app->request->post()) {
            ini_set('max_execution_time', 300);
            $sourcePath = $_FILES['programs']['tmp_name'];
            $ext = pathinfo($_FILES['programs']['name'], PATHINFO_EXTENSION);
            $targetPath = "./uploads/Data.$ext";
            $failed_models = [];

            if (move_uploaded_file($sourcePath,$targetPath)) {
                $csvFile = file($targetPath);
                $length = sizeof($csvFile);
                $countries = [];
                $states = [];
                $cities = [];
                $degrees = [];
                $majors = [];
                $degreeLevels =[];
                $tests = [];
                $courseTypes = $this->getOthers('course_type');
                $languages = $this->getOthers('languages');
                $type = $this->getOthers('course_type');
                $intakes = $this->getOthers('intake');
                $durationTypes = $this->getOthers('duration_type');

                /*$date = date_create();
                $unixtimestamp = date_format($date, 'U');
                number_format($unixtimestamp);*/ 
                $dataCount = count($csvFile);  
                if(count($csvFile)>501){ 
                    return $this->render('upload_programs', [ 'error' => '('.$dataCount.') Records should not be greater 500.']);
                }
                else{
                $RowCount = 1;
                for($count = 1; $count < $length; $count++) {
					 $RowCount++;
                    $data = explode(',', $csvFile[$count]);
						 
                    foreach($data as $key => $value) { 
					
						$value = $this->clean_string($value);
                       $data[$key] = str_replace(array('!','~','?'), array(',','',' '), $value);
					 
                    } 

					  
                    $model = new UniversityCourseList();
                    $name = trim($data[1]);
                    $query = University::find()->where(['=', 'name', $name]);

                         
                    
                    
                    # check if country exists;
                    $countryName = trim($data[4]);
                    if(isset($countryName)) {
                        if (empty($countries[$countryName])) {
                            $country = Country::find()->where(['=', 'name', $countryName])->one();
                            if(empty($country)) {
                               /* $country = new Country();
                                $country->name = $countryName;
                                if ($country->save()) {
                                    $countries[$countryName] = $country->id;
									  $query = $query->andWhere(['=', 'country_id', $country->id]);
                                } else {
                                    $model->addError('university_id', '[Row] ' . $RowCount . ' => Country ' . $countryName . ' no found. Cannot create program, assuming University and country combination does not exist');
                                    array_push($failed_models, $model);
                                    continue;
                                }*/
								
                                  
									$model->addError('university_id', '[Row] ' . $RowCount . ' => Country ' . $countryName . ' no found. Cannot create program, assuming University and country combination does not exist');
                                    array_push($failed_models, $model);
                                    continue;
                            } else {
                                $countries[$countryName] = $country->id;
                                $query = $query->andWhere(['=', 'country_id', $country->id]);
                            }
                        } else {
                            $query = $query->andWhere(['=', 'country_id', $countries[$countryName]]);
                        }
                    }

                    if(!empty($countries[$countryName])) {
                        $university = $query->andWhere(['=', 'country_id', $countries[$countryName]]);
                    }

                    $university = $query->one();


                    if(empty($university)) {
                        $model->addError( 'Row : ' . $RowCount . ' Coulmn No : 2 - ',  $name . ' does not exist');
                        array_push($failed_models, $model);
                        continue;
                    }

                    # set discipline.
                    $degreeName = trim($data[5]);
                    if(empty($degrees[$degreeName])) {
                        $degree = Degree::find()->where(['=', 'name', $degreeName])->one();
                        if(empty($degree)) {
                           /* $degree = new Degree();
                            $degree->name = $degreeName;
                            $degree->created_by = Yii::$app->user->identity->id;
                            $degree->updated_by = Yii::$app->user->identity->id;
                            $degree->created_at = gmdate('Y-m-d H:i:s');
                            $degree->updated_at = gmdate('Y-m-d H:i:s');
                            if ($degree->save()) {
                                $degrees[$degreeName] = $degree->id;
                            } else {
                                $model->addError( '[Row] ' . $RowCount .' degree_id', 'Discipline ' . $degreeName . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                            }*/
							$model->addError( '[Row] ' . $RowCount .' degree_id', 'Discipline ' . $degreeName . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                        } else {
                            $degrees[$degreeName] = $degree->id; 
                        }
                    }

                    #set sub discipline
                    $majorName = trim($data[6]);
                    $majorKey = $degreeName . ',' . $majorName;
                    if(empty($majors[$majorKey])) {
                        $major = Majors::find()->where(['AND', ['=', 'name', $majorName], ['=', 'degree_id', $degrees[$degreeName]]])->one();
                        if(empty($major)) {
                            /*$major = new Majors();
                            $major->name = $majorName;
                            $major->degree_id = $degrees[$degreeName];
                            $major->created_by = Yii::$app->user->identity->id;
                            $major->updated_by = Yii::$app->user->identity->id;
                            $major->created_at = gmdate('Y-m-d H:i:s');
                            $major->updated_at = gmdate('Y-m-d H:i:s');
                            if ($major->save()) {
                                $majors[$majorKey] = $major->id;
                            } else {
                                $model->addError( '[Row] ' . $RowCount .' major_id', 'Sub-Discipline ' . $majorName . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                            }*/
							$model->addError( '[Row] ' . $RowCount .' major_id', 'Sub-Discipline ' . $majorName . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                        } else {
                            $majors[$majorKey] = $major->id; 
                        }
                    }

                    # set degree level
                  $degreeLevelName = trim($data[7]);
				  
                    if(empty($degreeLevels[$degreeLevelName])) {
						      $degreeLevel = DegreeLevel::find()->where(['=', 'name', $degreeLevelName])->one();
                        if(empty($degreeLevel)) {
                           /* $degreeLevel = new DegreeLevel();
                            $degreeLevel->name = $degreeLevelName;
                            $degreeLevel->created_by = Yii::$app->uder->identity->id;
                            $degreeLevel->updated_by = Yii::$app->uder->identity->id;
                            $degreeLevel->created_at = gmdate('Y-m-d H:i:s');
                            $degreeLevel->updated_at = gmdate('Y-m-d H:i:s');
                            if($degreeLevel->save()) {
                                $degreeLevels[$degreeLevelName] = $degreeLevel->id;
                            } else {
                                $model->addError( '[Row] ' . $RowCount . ' degree_level_id', 'Degree Level ' . $degreeLevel . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                            }*/
								$model->addError( '[Row] ' . $RowCount . ' degree_level_id', 'Degree Level ' . $degreeLevel . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                        } else {
							echo $degreeLevel->id;
							echo "<br>";
                            $degreeLevels[$degreeLevelName] = $degreeLevel->id;
                        }
                    }

			        # set language
					
					$trimeedLang = ''; 
                    $languages = explode(',', trim(ucfirst($data[11])));
                    foreach($languages as $lang) {
						$trimeedLang[] = trim($lang);
					}
					//echo "<br> trimeedLang : ";
					//print_r($trimeedLang);
					
					$languageModel = Others::find()->where(['=', 'name', 'languages'])->one();
					$temp = array();
					if($languageModel->value!=''){
						$existLanguages = trim($languageModel->value);
						$existLanguages = ucfirst($existLanguages);
						$existLanguages = explode(',', $existLanguages);
					}					
					//echo "<br><br> existLanguages : "; 
					//print_r($existLanguages);					
										
					//echo "<br><br> Difference : ";
					$notFound = array_diff($trimeedLang, $existLanguages);
					//print_r($notFound); 
					if(count($notFound)>0){
						$notFoundLang = implode(',',$notFound);
						$model->addError( '[Row] ' . $RowCount .' language', 'Language- ' . $notFoundLang . ' not found. Please add Language before upload programs.');
						array_push($failed_models, $model);
						continue;
					}else{
						//echo "<br><br> LanguagesFound : "; 
						$Found = array_intersect($trimeedLang, $existLanguages);
						//print_r($Found);
						$langList= '';
						foreach($Found as $key=>$value) {
							$langList[] = $key;
						}
						$stringList = implode(',',$langList);
						//echo $stringList ;
					    $model->language = $stringList;
						
					}
					  
				 
                 
                    # set course type
                    $type = trim($data[16]);
					if(!empty($type)){
                    $type = ucfirst($type);
                    $index = array_search($type, $courseTypes);   
                    if ($index === false) {
                        $courseTypeModel = Others::find()->where(['=', 'name', 'course_type'])->one();
                        $temp = array();
                        if($courseTypeModel->value!='')
                        $temp = explode(',', $courseTypeModel->value);
                        $model->type = count($temp); 
                        array_push($temp, $type);
                        $courseTypeModel->value = implode(',', $temp); 
						 $model->addError( '[Row] ' . $RowCount .' type', 'Course Type-' . $type . ' creation failed.');
                            array_push($failed_models, $model);
                            continue;
                    } else {
                        $model->type = $index;
                    }
					}
					
					
					  # set duration type
                    $durationType = trim($data[15]);
					if(!empty($durationType)){
                    $durationType = ucfirst($durationType);
                    $index = array_search($durationType, $durationTypes);   
                    if ($index === false) {
                        $durationTypeModel = Others::find()->where(['=', 'name', 'duration_type'])->one();
                        $temp = array();
                        if($durationTypeModel->value!='')
                        $temp = explode(',', $durationTypeModel->value);
                        $model->duration_type = count($temp); 
                        //array_push($temp, $durationType);
                        $durationTypeModel->value = implode(',', $temp); 
						 $model->addError( '[Row] ' . $RowCount .' durationType', 'duration  Type-' . $durationType . ' creation failed.');
                            array_push($failed_models, $model);
                             continue;
                    } else {
                        $model->duration_type = $index;
                    }
				 
					}
					
                     # find course if it exists;
                    $course = UniversityCourseList::find()->where(['AND', 
					['=', 'program_code', trim($data[0])],
					['=', 'university_id', $university->id], 
					['=', 'degree_id', $degrees[$degreeName]],
					['=', 'major_id', $majors[$majorKey]], 
					['=', 'degree_level_id', $degreeLevels[$degreeLevelName]], 
					['=', 'language', $model->language], 
					['=', 'type', $model->type], 
					['=', 'name', trim($data[8])]])->one();
 
 
 
//echo $course->createCommand()->rawSql;


                    if(empty($course)) {
                        $course = new UniversityCourseList();
                        $course->created_by = Yii::$app->user->identity->id;
                        $course->created_at = gmdate('Y-m-d H:i:s');
                    } 

					 
					
                    # set standard_tests
                    $test_list = explode(',', trim(ucwords($data[19])));
                    $stop = false;
                    $arr = [];
                    $sterr = [];   
					 
                    foreach($test_list as $test) {
					if(!empty($test)){ 
                        if(empty($tests[$test])) {
							 
                            $test = trim($test);
                            $testName = StandardTests::find()->where(['=', 'name', $test])->one();
                            if(empty($testName)) {
                                $stop = true;
                                array_push($sterr, $test);
                                break;
                            } else {
                                $tests[$test] = $testName->id;
                                array_push($arr, $testName->id);
                            }
                        } else {
                            array_push($arr, $tests[$test]);
                        }
					}
                    }
                    if($stop === true) {
                        $sterr1 = implode(',', $sterr);
                        $course->addError('[Row] ' . $RowCount .' standard_test_list', 'Error adding Standard Test List: '. $sterr1);
                        array_push($failed_models, $course);
                        continue;
                    } else {
                        $course->standard_test_list = implode(',', $arr);
                    }
					 
					
                    $course->updated_by = Yii::$app->user->identity->id;
                    $course->updated_at = gmdate('Y-m-d H:i:s');
                    $course->university_id = $university->id;
                    $course->degree_id = trim($degrees[$degreeName]);
                    $course->major_id = trim($majors[$majorKey]);
                    $course->degree_level_id = trim($degreeLevels[$degreeLevelName]);
					
                    $course->name = trim($data[8]);
                    $course->language = trim($model->language);
                    $course->description = (!empty($data[9]) ? trim($data[9]) : $course->description );
                    $course->intake = trim($data[10]);
                    $course->fees = trim($data[12]);
                    $course->fees_international_students = trim($data[13]);
                    $course->duration = trim($data[14]);
                    $course->duration_type =  trim($model->duration_type);
                    $course->type = trim($model->type);
                    $course->careers = (!empty($data[17]) ? trim($data[17]) : $course->careers );
                    $course->eligibility_criteria = (!empty($data[18]) ? trim($data[18]) : $course->eligibility_criteria );
                    $course->application_fees = (!empty($data[22]) ? trim($data[22]) : $course->application_fees ); 
                    $course->application_fees_international = 
					(!empty($data[23]) ? trim($data[23]) : $course->application_fees_international );
                    
                   // $unixtimestamp ++;          
                    
                    $course->program_code =  trim($data[0]);                  
                    $course->program_website = trim($data[26]); 
					$course->rolling = trim($data[27]); 					
 
				  /*echo"<pre>";  
				  	print_r($course); 
				print_r($failed_models); 
				
				echo"</pre>";
				die; */
 			
				try { 
				 
					if (!$course->save()) { 
                        $course->addError('id', '[Row] ' .$RowCount);
                        array_push($failed_models, $course);                         
                        continue;
                    }

				}catch (IntegrityException $e) { 
						$course->addError('id', '[Row] ' .$RowCount .  $e->getMessage());
                        array_push($failed_models, $course);                         
                        continue;


				}catch (Exception $e) {
  
						$course->addError('id', '[Row] ' .$RowCount .  $e->getMessage());
                        array_push($failed_models, $course);                         
                        continue;


				}

                    
                    
                    
                    // create admissions

                    $endDate = date('Y-m-d', strtotime(trim($data[21])));
                    if (!empty($endDate)) {
                        $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $course->university_id], ['=', 'degree_level_id', $course->degree_level_id],['=', 'course_id', $course->id]])->one();

                        if(empty($admission)) {
                            $admission = new UniversityAdmission();
                            $admission->created_by = Yii::$app->user->identity->id;
                            $admission->created_at = gmdate('Y-m-d H:i:s');
                        }

                        $admission->university_id = $course->university_id;
                        $admission->degree_level_id = $course->degree_level_id;
                        $admission->course_id = $course->id;
                        if (!empty($data[20])) {
                            $admission->start_date = date('Y-m-d H:i:s', strtotime(trim($data[20])));
                        }
                        $admission->end_date = $endDate;
                        
                        # set intake.
                        $index = array_search(trim($data[25]), $intakes);
                        if ($index === false) {
                            $intakeModel = Others::find()->where(['=', 'name', 'intake'])->one();
                            $temp = explode(',', $intakeModel->value);
                            array_push($temp, trim($data[25]));
                            $intakeModel->value = implode(',', $temp);
                            /*if($intakeModel->save()) {
                                $intakes = $temp;
                                $admission->intake = sizeof($intakes) - 1;
                            } else {
                                $admission->addError('[Row] ' . $RowCount .' intake', 'Intake cannot be created' . $data[25] . ' creation failed.');
                                array_push($failed_models, $admission);
                                continue;
                            }*/
							 $admission->addError('[Row] ' . $RowCount .' intake', 'Intake cannot be created ' . $data[25] . ' creation failed.');
                                array_push($failed_models, $admission);
                                continue;
                        } else {
                            $admission->intake = $index;
                        }

                        $admission->admission_link = trim($data[24]);
                        $admission->updated_by = Yii::$app->user->identity->id;
                        $admission->updated_at = gmdate('Y-m-d H:i:s');

                        if (!$admission->save()) {
                            array_push($failed_models, $admission);
                            continue;
                        }
                    }
                    
                }
               
                }
				
				 
            if(sizeof($failed_models) === 0) {
                    return $this->render('upload_programs', [
                        'success' => 'All programs uploaded.'
                    ]);
                } else { 
                    return $this->render('upload_programs', ['modelerror' => $failed_models]); 
                }
            } else {
                return $this->render('upload_programs', [
                    'error' => 'Error uploading file'
                ]);
            }
        }
        return $this->render('upload_programs', []);
    }

    public function actionUploadAdmissions() {
        if(Yii::$app->request->post()) {
            ini_set('max_execution_time', 300);
            $sourcePath = $_FILES['admissions']['tmp_name'];
            $ext = pathinfo($_FILES['admissions']['name'], PATHINFO_EXTENSION);
            $targetPath = "./uploads/Data.$ext";
            $failed_models = [];

            if (move_uploaded_file($sourcePath,$targetPath)) {
                $csvFile = file($targetPath);
                $length = sizeof($csvFile);
                $countries = [];
                $degreeLevels =[];
                $intakes = $this->getOthers('intake');

                for($count = 1; $count < $length; $count++) {
                    $data = explode(',', $csvFile[$count]);
                    foreach($data as $key => $value) {
                        $data[$key] = str_replace('!', ',', $value);
                    }
                    $model = new UniversityAdmission();
                    $name = trim($data[0]);
                    $query = University::find()->where(['=', 'name', $name]);

                    # check if country exists;
                    $countryName = trim($data[1]);
                    if(isset($countryName)) {
                        if (empty($countries[$countryName])) {
                            $country = Country::find()->where(['=', 'name', $countryName])->one();
                            if(empty($country)) {
                                $country = new Country();
                                $country->name = $countryName;
                                if ($country->save()) {
                                    $countries[$countryName] = $country->id;
                                    $query = $query->andWhere(['=', 'country_id', $country->id]);
                                } else {
                                    $model->addError('university_id', '[Row] ' . $RowCount . ' => Country ' . $countryName . ' no found. Cannot create program, assuming University and country combination does not exist');
                                    array_push($failed_models, $model);
                                    continue;
                                }
                            } else {
                                $countries[$countryName] = $country->id;
                                $query = $query->andWhere(['=', 'country_id', $country->id]);
                            }
                        } else {
                            $query = $query->andWhere(['=', 'country_id', $countries[$countryName]]);
                        }
                    }

                    if(!empty($countries[$countryName])) {
                        $university = $query->andWhere(['=', 'country_id', $countries[$countryName]]);
                    }

                    $university = $query->one();

                    if(empty($university)) {
                        $model->addError('university_id', 'University ' . $name . ' does not exist');
                        array_push($failed_models, $model);
                        continue;
                    }

                    # set degree level
                    $degreeLevelName = trim($data[6]);
                    if(empty($degreeLevels[$degreeLevelName])) {
                        $degreeLevel = DegreeLevel::find(['=', 'name', $degreeLevelName])->one();
                        if(empty($degreeLevel)) {
                            $degreeLevel = new DegreeLevel();
                            $degreeLevel->name = $degreeLevelName;
                            $degreeLevel->created_by = Yii::$app->uder->identity->id;
                            $degreeLevel->updated_by = Yii::$app->uder->identity->id;
                            $degreeLevel->created_at = gmdate('Y-m-d H:i:s');
                            $degreeLevel->updated_at = gmdate('Y-m-d H:i:s');
                            if($degreeLevel->save()) {
                                $degreeLevels[$degreeLevelName] = $degreeLevel->id;
                            } else {
                                $model->addError('degree_level_id', 'Row => ' . $count . ' .Degree Level ' . $degreeLevelName . ' creation failed.');
                                array_push($failed_models, $model);
                                continue;
                            }
                        } else {
                            $degreeLevels[$degreeLevelName] = $degreeLevel->id;
                        }
                    }

                    # find course if it exists;
                    $course;
                    $courseId = 0;
                    if(!empty($data[3]) && $data[3] !== 'All') {
                        $course = UniversityCourseList::find()->where(['AND', ['=', 'university_id', $university->id], ['=', 'degree_level_id', $degreeLevels[$degreeLevelName]], ['=', 'name', trim($data[3])]])->one();

                        if(empty($course)) {
                            $model->addError('course_id', 'Row => '. $count . '. Course ' . $data[4] . ' does not exist.');
                            array_push($failed_models, $model);
                            continue;
                        }
                        $courseId = $course->id;
                    }
                    
                    $endDate = date('Y-m-d', strtotime(trim($data[5])));
                    if (!empty($endDate)) {
                        $admission = UniversityAdmission::find()->where(['AND', ['=', 'university_id', $university->id], ['=', 'degree_level_id', $degreeLevels[$degreeLevelName]],['=', 'course_id', $courseId]])->one();

                        if(empty($admission)) {
                            $admission = new UniversityAdmission();
                            $admission->created_by = Yii::$app->user->identity->id;
                            $admission->created_at = gmdate('Y-m-d H:i:s');
                        }

                        $admission->university_id = $university->id;
                        $admission->degree_level_id = $degreeLevels[$degreeLevelName];
                        $admission->course_id = $courseId;
                        if (!empty($data[4])) {
                            $admission->start_date = date('Y-m-d H:i:s', strtotime(trim($data[4])));
                        }
                        $admission->end_date = $endDate;

                        # set intake.
                        $index = array_search(trim($data[9]), $intakes);
                        if ($index === false) {
                            $intakeModel = Others::find()->where(['=', 'name', 'intake'])->one();
                            $temp = explode(',', $intakeModel->value);
                            array_push($temp, trim($data[9]));
                            $intakeModel->value = implode(',', $temp);
                            if($intakeModel->save()) {
                                $intakes = $temp;
                                $admission->intake = sizeof($intakes) - 1;
                            } else {
                                $admission->addError('intake', 'Intake cannot be created ' . $data[9] . ' creation failed.');
                                array_push($failed_models, $admission);
                                continue;
                            }
                        } else {
                            $admission->intake = $index;
                        }

                        $admission->admission_link = trim($data[8]);
                        $admission->admission_fees_international = trim($data[7]);
                        $admission->admission_fees = trim($data[6]);
                        $admission->updated_by = Yii::$app->user->identity->id;
                        $admission->updated_at = gmdate('Y-m-d H:i:s');

                        if (!$admission->save()) {
                            array_push($failed_models, $admission);
                            continue;
                        }
                    } else {
                        $admission->addError('intake', 'Row => ' . $count . ' .End date cannot be blank.');
                        array_push($failed_models, $admission);
                        continue;
                    }
                }
                if(sizeof($failed_models) === 0) {
                    return $this->render('upload_admissions', [
                        'success' => 'All admissions uploaded.'
                    ]);
                } else {
                    var_dump($failed_models);
                    die();
                }
            } else {
                return $this->render('upload_admissions', [
                    'error' => 'Error uploading file'
                ]);
            }
        }
        return $this->render('upload_admissions', []);
    }
	
	public function clean_string($string) {
	
	  // Replace Single Curly Quotes
  $search[]  = chr(226).chr(128).chr(152);
  $replace[] = "'";
  $search[]  = chr(226).chr(128).chr(153);
  $replace[] = "'";
  // Replace Smart Double Curly Quotes
  $search[]  = chr(226).chr(128).chr(156);
  $replace[] = '"';
  $search[]  = chr(226).chr(128).chr(157);
  $replace[] = '"';
  // Replace En Dash
  $search[]  = chr(226).chr(128).chr(147);
  $replace[] = '--';
  // Replace Em Dash
  $search[]  = chr(226).chr(128).chr(148);
  $replace[] = '---';
  // Replace Bullet
  $search[]  = chr(226).chr(128).chr(162);
  $replace[] = '*';
  // Replace Middle Dot
  $search[]  = chr(194).chr(183);
  $replace[] = '*';
  // Replace Ellipsis with three consecutive dots
  $search[]  = chr(226).chr(128).chr(166);
  $replace[] = '...';
  // Apply Replacements
  $string = str_replace($search, $replace, $string);
  // Remove any non-ASCII Characters
  $string = preg_replace("/[^\x01-\x7F]/"," ", $string);
  return $string; 
  
	}
	
/*	public function clean_string($string) {
  $s = trim($string);
  $s = iconv("UTF-8", "UTF-8//IGNORE", $s); // drop all non utf-8 characters

$normal_characters = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
    $normal_text = preg_replace("/[^$normal_characters]/", '', $s);

    return $normal_text;
	
  return $normal_text;
}*/
/*
public function clean_string($orig_text) {

    $text = $orig_text;

    // Single letters
    $text = preg_replace("/[∂άαáàâãªä]/u",      "a", $text);
    $text = preg_replace("/[∆лДΛдАÁÀÂÃÄ]/u",     "A", $text);
    $text = preg_replace("/[ЂЪЬБъь]/u",           "b", $text);
    $text = preg_replace("/[βвВ]/u",            "B", $text);
    $text = preg_replace("/[çς©с]/u",            "c", $text);
    $text = preg_replace("/[ÇС]/u",              "C", $text);        
    $text = preg_replace("/[δ]/u",             "d", $text);
    $text = preg_replace("/[éèêëέëèεе℮ёєэЭ]/u", "e", $text);
    $text = preg_replace("/[ÉÈÊË€ξЄ€Е∑]/u",     "E", $text);
    $text = preg_replace("/[₣]/u",               "F", $text);
    $text = preg_replace("/[НнЊњ]/u",           "H", $text);
    $text = preg_replace("/[ђћЋ]/u",            "h", $text);
    $text = preg_replace("/[ÍÌÎÏ]/u",           "I", $text);
    $text = preg_replace("/[íìîïιίϊі]/u",       "i", $text);
    $text = preg_replace("/[Јј]/u",             "j", $text);
    $text = preg_replace("/[ΚЌК]/u",            'K', $text);
    $text = preg_replace("/[ќк]/u",             'k', $text);
    $text = preg_replace("/[ℓ∟]/u",             'l', $text);
    $text = preg_replace("/[Мм]/u",             "M", $text);
    $text = preg_replace("/[ñηήηπⁿ]/u",            "n", $text);
    $text = preg_replace("/[Ñ∏пПИЙийΝЛ]/u",       "N", $text);
    $text = preg_replace("/[óòôõºöοФσόо]/u", "o", $text);
    $text = preg_replace("/[ÓÒÔÕÖθΩθОΩ]/u",     "O", $text);
    $text = preg_replace("/[ρφрРф]/u",          "p", $text);
    $text = preg_replace("/[®яЯ]/u",              "R", $text); 
    $text = preg_replace("/[ГЃгѓ]/u",              "r", $text); 
    $text = preg_replace("/[Ѕ]/u",              "S", $text);
    $text = preg_replace("/[ѕ]/u",              "s", $text);
    $text = preg_replace("/[Тт]/u",              "T", $text);
    $text = preg_replace("/[τ†‡]/u",              "t", $text);
    $text = preg_replace("/[úùûüџμΰµυϋύ]/u",     "u", $text);
    $text = preg_replace("/[√]/u",               "v", $text);
    $text = preg_replace("/[ÚÙÛÜЏЦц]/u",         "U", $text);
    $text = preg_replace("/[Ψψωώẅẃẁщш]/u",      "w", $text);
    $text = preg_replace("/[ẀẄẂШЩ]/u",          "W", $text);
    $text = preg_replace("/[ΧχЖХж]/u",          "x", $text);
    $text = preg_replace("/[ỲΫ¥]/u",           "Y", $text);
    $text = preg_replace("/[ỳγўЎУуч]/u",       "y", $text);
    $text = preg_replace("/[ζ]/u",              "Z", $text);

    // Punctuation
    $text = preg_replace("/[‚‚]/u", ",", $text);        
    $text = preg_replace("/[`‛′’‘]/u", "'", $text);
    $text = preg_replace("/[″“”«»„]/u", '"', $text);
    $text = preg_replace("/[—–―−–‾⌐─↔→←]/u", '-', $text);
    $text = preg_replace("/[  ]/u", ' ', $text);

    $text = str_replace("…", "...", $text);
    $text = str_replace("≠", "!=", $text);
    $text = str_replace("≤", "<=", $text);
    $text = str_replace("≥", ">=", $text);
    $text = preg_replace("/[‗≈≡]/u", "=", $text);


    // Exciting combinations    
    $text = str_replace("ыЫ", "bl", $text);
    $text = str_replace("℅", "c/o", $text);
    $text = str_replace("₧", "Pts", $text);
    $text = str_replace("™", "tm", $text);
    $text = str_replace("№", "No", $text);        
    $text = str_replace("Ч", "4", $text);                
    $text = str_replace("‰", "%", $text);
    $text = preg_replace("/[∙•]/u", "*", $text);
    $text = str_replace("‹", "<", $text);
    $text = str_replace("›", ">", $text);
    $text = str_replace("‼", "!!", $text);
    $text = str_replace("⁄", "/", $text);
    $text = str_replace("∕", "/", $text);
    $text = str_replace("⅞", "7/8", $text);
    $text = str_replace("⅝", "5/8", $text);
    $text = str_replace("⅜", "3/8", $text);
    $text = str_replace("⅛", "1/8", $text);        
    $text = preg_replace("/[‰]/u", "%", $text);
    $text = preg_replace("/[Љљ]/u", "Ab", $text);
    $text = preg_replace("/[Юю]/u", "IO", $text);
    $text = preg_replace("/[ﬁﬂ]/u", "fi", $text);
    $text = preg_replace("/[зЗ]/u", "3", $text); 
    $text = str_replace("£", "(pounds)", $text);
    $text = str_replace("₤", "(lira)", $text);
    $text = preg_replace("/[‰]/u", "%", $text);
    $text = preg_replace("/[↨↕↓↑│]/u", "|", $text);
    $text = preg_replace("/[∞∩∫⌂⌠⌡]/u", "", $text);


    //2) Translation CP1252.
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans['f'] = '&fnof;';    // Latin Small Letter F With Hook
    $trans['-'] = array(
        '&hellip;',     // Horizontal Ellipsis
        '&tilde;',      // Small Tilde
        '&ndash;'       // Dash
        );
    $trans["+"] = '&dagger;';    // Dagger
    $trans['#'] = '&Dagger;';    // Double Dagger         
    $trans['M'] = '&permil;';    // Per Mille Sign
    $trans['S'] = '&Scaron;';    // Latin Capital Letter S With Caron        
    $trans['OE'] = '&OElig;';    // Latin Capital Ligature OE
    $trans["'"] = array(
        '&lsquo;',  // Left Single Quotation Mark
        '&rsquo;',  // Right Single Quotation Mark
        '&rsaquo;', // Single Right-Pointing Angle Quotation Mark
        '&sbquo;',  // Single Low-9 Quotation Mark
        '&circ;',   // Modifier Letter Circumflex Accent
        '&lsaquo;'  // Single Left-Pointing Angle Quotation Mark
        );

    $trans['"'] = array(
        '&ldquo;',  // Left Double Quotation Mark
        '&rdquo;',  // Right Double Quotation Mark
        '&bdquo;',  // Double Low-9 Quotation Mark
        );

    $trans['*'] = '&bull;';    // Bullet
    $trans['n'] = '&ndash;';    // En Dash
    $trans['m'] = '&mdash;';    // Em Dash        
    $trans['tm'] = '&trade;';    // Trade Mark Sign
    $trans['s'] = '&scaron;';    // Latin Small Letter S With Caron
    $trans['oe'] = '&oelig;';    // Latin Small Ligature OE
    $trans['Y'] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
    $trans['euro'] = '&euro;';    // euro currency symbol
    ksort($trans);

    foreach ($trans as $k => $v) {
        $text = str_replace($v, $k, $text);
    }

    // 3) remove <p>, <br/> ...
    $text = strip_tags($text);

    // 4) &amp; => & &quot; => '
    $text = html_entity_decode($text);


    // transliterate
     if (function_exists('iconv')) {
     $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }

    // remove non ascii characters
     $text =  preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);      

    return $text;
} */
	
	  /**
     * Displays a single UniversityEnquiry model.
     * @param integer $id
     * @return mixed
     */
    public function actionCreatelogin($id)
    {
	 
	    $searchModel = new UniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
		$model = $this->findModel($id);
		$email = $model->email;

		$model = $this->findModel($id); 
		$to = $model->email;
		$user = $model->name;
		
		$subject = 'University Login credentilas link';
		$template = 'createlogin_university';
		$time = time();	
		$timestring = strtotime('+2 days', $time);
		$timestamp = Commondata::encrypt_decrypt('encrypt',$timestring);
		$encryptedid = Commondata::encrypt_decrypt('encrypt', $id);
		
		$link = ConnectionSettings::BASE_URL . 'partner/web/index.php?r=university/university/create&id=' . $encryptedid . '&timestamp=' .$timestamp; 
	   
		$data = array('user' => $user, 'link' => $link);		
		$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);
	
		if($mailsent==true){ 
			Yii::$app->getSession()->setFlash('Success', 'You have successfully sent the university dashboard credentials link to '.$user); 
		}else{
			Yii::$app->getSession()->setFlash('Error', 'Email not sent.');  
		}
			
		return $this->redirect('?r=university/index');  
    }
	
	
	  public function beforeAction($action)
    {            
        if ($action->id == 'preview') {
				Yii::$app->controller->enableCsrfValidation = false;        
		}
        return parent::beforeAction($action);
    }
	
}
