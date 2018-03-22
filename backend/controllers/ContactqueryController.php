<?php

namespace backend\controllers;

use Yii;
use common\models\ContactQuery;
use backend\models\ContactQuerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Roles;
use common\components\AccessRule;
use yii\filters\AccessControl; 
use backend\models\SiteConfig;
use common\components\Status;
use yii\helpers\ArrayHelper; 
use common\models\Others; 
use common\components\Commondata;

class ContactqueryController extends Controller
{
    /**
     * @inheritdoc
     */
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
                        'actions' => ['index', 'view', 'changestatus'],
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
     * Lists all ContactQuery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactQuerySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 	
        ]);
    }

    /**
     * Displays a single ContactQuery model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		   return $this->render('view', [
            'model' => $this->findModel($id),
			'institutionType' => $this->getOthers('institution_type'),	
			//'countries' => $countries,
        ]);
    }
 
 
	private function getOthers($name) {
        $model = [];
        if (($model = Others::findBySql('SELECT value FROM others WHERE name="' . $name . '"')->one()) !== null) {
            $model = explode(',', $model->value);
            return $model;
        }
    }
	

    /**
     * Updates an existing ContactQuery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
 
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model, 
				'countries' => $countries,
            ]);
        }
    } 
	
	public function actionChangestatus($id)
    {
        $model = $this->findModel($id);   
		$helpemail = SiteConfig::getConfigHelpEmail(); 
		
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
		 
			$to = $model->email;
			$user = $model->first_name; 		
			$subject = $user.', Your Enquiry has been updated.';
			$template = 'general_enquiry_status_change';   
			$data = array('name' => $user,'status' => $model->status,'comment' => $model->comment,'reply' => $model->reply);	
			
			$mailsent = Commondata::sendCreateLoginLink($to,$subject,$data,$template);

			if($mailsent==true){ 
				Yii::$app->getSession()->setFlash('Success', 'Your Enquiry has been updated.');
				 
			} else { 
				
				Yii::$app->getSession()->setFlash('Error', 'Error processing your request. Please send email to '.$helpemail);  
			} 
			
            return $this->redirect(['index']);
        } else {
            return $this->render('changestatus', [
                'model' => $model,  
            ]);
        }
    }

    /**
     * Deletes an existing ContactQuery model.
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
     * Finds the ContactQuery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ContactQuery the loaded model
     * @return ContactQuery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ContactQuery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
