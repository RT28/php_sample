<?php


namespace backend\controllers;

use Yii;
use common\models\University;
use common\models\UniversityGallery;
use common\models\UniversityBrochures;
use common\models\UniversityTemp;
use backend\models\UniversityTempSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use yii\data\ActiveDataProvider;

/**
 * UniversityTempController implements the CRUD actions for UniversityTemp model.
 */
class UniversityTempController extends Controller
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
     * Lists all UniversityTemp models.
     * @return mixed
     */
    public function actionIndex()
    { 

		$searchModel = new UniversityTempSearch();		
		$query = UniversityTempSearch::find()->where(['status'=>'2']);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvider = new ActiveDataProvider([ 'query' => $query]);

		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

   
 
	/**
	* Updates an existing UniversityTemp model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id
	* @return mixed
	*/
	public function actionApproved($id)
	{
	$model = $this->findModel($id);



	if(!empty($model)){ 
		$partner = University::find()->where(['=', 'id', $model->university_id])->one();
			
		$partner->name	= $model->name;
		$partner->is_partner = $model->is_partner; 
		$partner->establishment_date = $model->establishment_date; 
		$partner->address = $model->address ;
		$partner->city_id = $model->city_id ;
		$partner->state_id = $model->state_id ;
		$partner->country_id = $model->country_id; 
		$partner->pincode = $model->pincode ;
		$partner->email = $model->email ;
		$partner->website = $model->website; 
		$partner->description = $model->description; 
		$partner->fax = $model->fax; 
		$partner->phone_1 = $model->phone_1; 
		$partner->phone_2 = $model->phone_2; 
		$partner->contact_person = $model->contact_person; 
		$partner->contact_person_designation =$model->contact_person_designation; 
		$partner->contact_mobile = $model->contact_mobile; 
		$partner->contact_email = $model->contact_email;  
		$partner->institution_type = $model->institution_type; 
		$partner->establishment = $model->establishment; 
		$partner->no_of_students = $model->no_of_students; 
		$partner->no_of_undergraduate_students =$model->no_of_undergraduate_students; 
		$partner->no_of_post_graduate_students = $model->no_of_post_graduate_students; 
		$partner->no_of_international_students = $model->no_of_international_students; 
		$partner->no_faculties = $model->no_faculties; 
		$partner->no_of_international_faculty = $model->no_of_international_faculty; 
		$partner->cost_of_living = $model->cost_of_living; 
		$partner->undergarduate_fees = $model->undergarduate_fees; 
		$partner->undergraduate_fees_international_students = $model->undergraduate_fees_international_students; 
		$partner->post_graduate_fees = $model->post_graduate_fees; 
		$partner->post_graduate_fees_international_students = $model->post_graduate_fees_international_students; 
		$partner->accomodation_available =$model->accomodation_available; 
		$partner->hostel_strength = $model->hostel_strength; 
		$partner->video = $model->video; 
		$partner->virtual_tour = $model->virtual_tour;  
		$partner->standard_tests_required = $model->standard_tests_required; 
		$partner->achievements = $model->achievements; 
		$partner->comments = $model->comments; 
		$partner->currency_id = $model->currency_id; 
		$partner->currency_international_id = $model->currency_international_id; 
		$partner->application_requirement = $model->application_requirement; 
		$partner->fees = $model->fees; 
		$partner->deadlines = $model->deadlines; 
		$partner->cost_of_living_text = $model->cost_of_living_text; 
		$partner->accommodation = $model->accommodation; 
		$partner->status =1;
		$partner->updated_by = Yii::$app->user->identity->username;
		$partner->updated_at = gmdate('Y-m-d H:i:s');
		$partner->institution_ranking = $model->institution_ranking; 

		if($partner->save(false)){
			$uid = $model->university_id;
			
			/*Delete all photos from directory and database which is removed by partner   
		      university_id. Partner University Status should be 2  */
			$deletePhotos = UniversityGallery::find()->where(['AND',['=', 'university_id',$uid], ['=', 'status',  '2'  ], ['=', 'photo_type',  'photos' ]])->all(); 			
			 
			if(!empty($deletePhotos)){ 
				foreach ($deletePhotos as $photo) {				
					$file = $photo['filename'];
					$id = $photo['id'];			 
					if(@unlink("./../web/uploads/$uid/photos/$file")){
						 $photo->delete();
					}  
				} 
			}
			
			$ActivePhotos = UniversityGallery::find()->where(['AND',['=', 'university_id',$uid], ['=', 'status',  '0'  ], ['=', 'photo_type',  'photos' ]])->all(); 			
			 
			if(!empty($ActivePhotos)){ 
				foreach ($ActivePhotos as $photo) {				
					$file = $photo['filename'];
					$id = $photo['id'];	
					$photo->status = 1;
					$photo->active = 1;
					$photo->reviewed_by  = Yii::$app->user->identity->id;
					$photo->reviewed_at = gmdate('Y-m-d H:i:s');
					$photo->save();   
				} 
			}
			  
		  /*Active and Inactive Logo */
		   $logo_new =  UniversityGallery::find()->where(['AND',['=', 'university_id',  $uid], 
				['=', 'photo_type',  'logo' ],['=', 'status',  0 ],['=', 'active',  0 ]])->one(); 
		 
		   if(isset($logo_new)){ 
			$logo_del = UniversityGallery::find()->where(['AND',['=', 'university_id',  $uid], 
				['=', 'photo_type',  'logo' ],['=', 'status',  1 ],['=', 'active',  1 ]])->one();
				if(isset($logo_del)){  
					if($logo_del->delete()){
						$file = $logo_del->filename;
						$uid = $logo_del->university_id;
						@unlink("./../../backend/web/uploads/$uid/logo/$file");
					}
				}
			$logo_new->status = 1;
			$logo_new->active = 1;
			$logo_new->reviewed_by  = Yii::$app->user->identity->id;
			$logo_new->reviewed_at = gmdate('Y-m-d H:i:s');
			$logo_new->save();    
		   } 
		   
		   
		   /*Active and Inactive Cover Photo */
		   $cover_new =  UniversityGallery::find()->where(['AND',['=', 'university_id',  $uid], 
				['=', 'photo_type',  'cover_photo' ],['=', 'status',  0 ],['=', 'active',  0 ]])->one(); 
		 
		   if(isset($cover_new)){ 
			$cover_del = UniversityGallery::find()->where(['AND',['=', 'university_id',  $uid], 
				['=', 'photo_type',  'cover_photo' ],['=', 'status',  1 ],['=', 'active',  1 ]])->one();
				if(isset($cover_del)){  
					if($cover_del->delete()){
						$file = $cover_del->filename;
						$uid = $cover_del->university_id;
						@unlink("./../../backend/web/uploads/$uid/cover_photo/$file");
					}
				}
			$cover_new->status = 1;
			$cover_new->active = 1;
			$cover_new->reviewed_by  = Yii::$app->user->identity->id;
			$cover_new->reviewed_at = gmdate('Y-m-d H:i:s');
			$cover_new->save();    
		   } 
			 

			/*Delete all Documents from directory and database which is removed by partner university_id. Partner University documents Status should be 2  */
			$deleteDocs = UniversityBrochures::find()->where(['AND',['=', 'university_id',$uid], ['=', 'status',  '2'  ]])->all(); 			
			 
			if(!empty($deleteDocs)){ 
				foreach ($deleteDocs as $doc) {				
					$file = $doc['filename'];
					$id = $doc['id'];			 
					if(@unlink("./../web/uploads/$uid/photos/$file")){
						 $doc->delete();
					}  
				} 
			}
			
			$ActiveDocs = UniversityBrochures::find()->where(['AND',['=', 'university_id',$uid], ['=', 'status',  '0'  ]])->all(); 			
			 
			if(!empty($ActiveDocs)){ 
				foreach ($ActiveDocs as $doc) {				
					$file = $doc['filename'];
					$id = $doc['id'];	
					$doc->status = 1;
					$doc->active = 1;
					$doc->reviewed_by  = Yii::$app->user->identity->id;
					$doc->reviewed_at = gmdate('Y-m-d H:i:s');
					$doc->save();   
				} 
			}
			
			$model->reviewed_by  = Yii::$app->user->identity->id;
			$model->reviewed_at = gmdate('Y-m-d H:i:s'); 
			$model->status =1;
			$model->save(false);
			
			
		}
	}


	  return $this->redirect(['index']);
	}

    /**
     * Deletes an existing UniversityTemp model.
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
     * Finds the UniversityTemp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UniversityTemp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UniversityTemp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
