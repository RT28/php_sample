<?php

namespace backend\controllers;

use Yii;
use backend\models\GtuBugs;
use backend\models\GtuBugsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GtubugsController implements the CRUD actions for GtuBugs model.
 */
class GtubugsController extends Controller
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
     * Lists all GtuBugs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GtuBugsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GtuBugs model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GtuBugs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GtuBugs();
            $username = Yii::$app->user->identity->username; 
            $model->gt_createdby=$username;
           // Yii::trace('qwertty123');

        if ($model->load(Yii::$app->request->post()) ) {
            
           // \Yii::beginProfile('login');
            date_default_timezone_set("Asia/Kolkata");
            $model->gt_createdon=date("Y-m-d H:i:s");
            if(!empty($model->gt_platform)){
              $model->gt_platform=implode(',', $model->gt_platform);
            }
            if(!empty($model->gt_operatingsystem)){
              $model->gt_operatingsystem=implode(',', $model->gt_operatingsystem);
            }
            if(!empty($model->gt_browser)){
              $model->gt_browser=implode(',', $model->gt_browser);
            }
           /* $model->gt_screenshot = UploadedFile::getInstance($model, 'gt_screenshot');
           if($model->gt_screenshot == ''){
                $model->gt_screenshot ='';
                    }else{
                    if(isset($model->gt_sreenshot))
                    $model->upload();
                }*/

            //upload multiple files    
          


            $model->gt_status='Open';
            if($model->save(false)){/*
                 Yii::$app->mailer->compose()
                ->setFrom('akshay.gymtrekker@gmail.com')
                ->setTo('akshay.pakhare@gmail.com')
                ->setSubject('New Bug')
                ->setTextBody('new bug is created')
                ->setHtmlBody('<br />New Bug has been Created,<b><br />Subject :'.$model->gt_subject .'<br /> Description:'. $model->gt_description .'<br /> Step To Reproduce:'. $model->gt_steptoreproduce .
                        '<br /> Platform:'. $model->gt_platform .'<br /> Browser:'. $model->gt_browser .'<br /> Url:'. $model->gt_url .
                        '<br /> Severity:'. $model->gt_severity .'<br /> Created By:'. $model->gt_createdby .'<br /> Created On:'. $model->gt_createdon . '<br /> Click to<a href=http://localhost/bugrecord/backend/web/index.php?r=bugs%2Fview&id=3> Update</a> Status </b>')
                ->send();*/
               // return $this->redirect(['view', 'id' => $model->gt_id]);
            }


             $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                          if (isset($model->imageFiles)&&$model->imageFiles != ''){
                              $model->uploads();
                          }
            return $this->redirect(['view', 'id' => $model->gt_id]);
         //   \Yii::endProfile('login');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Bugs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //\Yii::beginProfile('_view');
        $model = $this->findModel($id);
        //$model->gt_screenshot = UploadedFile::getInstances($model, 'gt_screenshot');

        $model->gt_platform = explode(',', $model->gt_platform);
        $model->gt_operatingsystem = explode(',', $model->gt_operatingsystem);
        $model->gt_browser = explode(',', $model->gt_browser);
        
        if ($model->load(Yii::$app->request->post())) {
                /*$model->gt_screenshot = UploadedFile::getInstance($model, 'gt_screenshot');
                //print_r($model->gt_screenshot);
                //die();
                if($model->gt_screenshot == ''){
                $command=Bugs::find()->select('gt_screenshot')->where(['gt_id'=>$id])->one();
                $screenshot=$command['gt_screenshot']; 
                $model->gt_screenshot =$screenshot;
                    //echo $model->gt_screenshot;
                }else{
                    if(isset($model->gt_screenshot))
                    $model->upload();
                }*/
                $username = Yii::$app->user->identity->username;
                //echo $email = Yii::$app->user->identity->email;
                $model->gt_createdby=$username;
                
                date_default_timezone_set("Asia/Kolkata");
                $model->gt_lastmodified=date("Y-m-d H:i:s");
                $model->gt_modifiedby=$username;

                if(!empty($model->gt_platform)){
                  $model->gt_platform=implode(',', $model->gt_platform);
                }
                if(!empty($model->gt_operatingsystem)){
                  $model->gt_operatingsystem=implode(',', $model->gt_operatingsystem);
                }
                if(!empty($model->gt_browser)){
                  $model->gt_browser=implode(',', $model->gt_browser);
                }
                /*
                if($model->gt_screenshot=='') {
                $command=Bugs::find()->select('gt_screenshot')->where(['gt_id'=>$id])->one();
                $screenshot=$command['gt_screenshot']; 
                $model->gt_screenshot =$screenshot;
                    echo $model->gt_screenshot;
                 }else{ 
                    echo "else part";
                }
                die();
                */
               // $model->gt_screenshot = UploadedFile::getInstance($model, 'gt_screenshot');
               // if ( ( is_object($model->gt_screenshot) && get_class( $model->gt_screenshot ) === 'UploadedFile' ))
                //$model->gt_screenshot = UploadedFile::getInstance($model, 'gt_screenshot');
                $model->gt_status='Open';
                
                  /*
                   $zip = new ZipArchive();
                if ($zip->open('C:wamp/www/bugrecord/backend/runtime/logs/DB1/',  ZipArchive::CREATE)) {
                    //$zip->addFile('zip/test.txt', 'newname.txt');
                    $zip->addFile('C:wamp/www/bugrecord/backend/runtime/logs/DB1/5.5.2016.log');
                    $zip->close();
                    echo 'Archive created!';
                } else {
                    echo 'Failed!';
                }         
                die();
                */

                 

                if($model->save(false)){/*
                        $dir = 'C:wamp/www/bugrecord/backend/runtime/logs/DB1/';
                       
                        $files=array_slice(scandir('C:wamp/www/bugrecord/backend/runtime/logs/DB1/'),2);
                        $string = implode(', C:wamp/www/bugrecord/backend/runtime/logs/DB1/',$files);
                       Yii::$app->mailer->compose()
                    ->setFrom('akshay.gymtrekker@gmail.com')
                    ->setTo($emailto)
                    ->setSubject('Bug Updated')
                    ->setTextBody('new bug is created')
                    ->setHtmlBody('<br />Bug has been updated,<b><br />Subject :'.$model->gt_subject .'<br /> Description:'. $model->gt_description .'<br /> Step To Reproduce:'. $model->gt_steptoreproduce .
                        '<br /> Platform:'. $model->gt_platform .'<br /> Browser:'. $model->gt_browser .'<br /> Url:'. $model->gt_url .
                        '<br /> Severity:'. $model->gt_severity .'<br /> Created By:'. $model->gt_createdby .'<br /> Created On:'. $model->gt_createdon .'<br /> Status:'. $model->gt_status . 
                        '<br /> Verified By:'.$model->gt_verifiedby .'<br /> Verified On:'. $model->gt_verifiedon .'<br /> Modified By:'. $model->gt_modifiedby .'<br /> Last Modified:'. $model->gt_lastmodified. '<br /> Click to<a href=http://localhost/bugrecord/backend/web/index.php?r=bugs%2Fview&id=3> Update</a> Status </b>')
                   // ->attach('C:wamp/www/bugrecord/backend/runtime/logs/DB1/'.$string)
                    ->send();*/
             //   return $this->redirect(['view', 'id' => $model->gt_id]);
                }

                 $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                              if(isset($model->imageFiles)&&$model->imageFiles != ''){
                                    $model->uploads();
                                }
                 return $this->redirect(['view', 'id' => $model->gt_id]);
            } else {
                return $this->render('update', [
                'model' => $model,
                ]);
            }
           // \Yii::endProfile('_view');
    }
      
    public function actionDisplayimage($id){
        $model = $this->findModel($id);
        //$path_Gallery = Yii::getAlias('@webroot');
        $path = Yii::getAlias('@webroot'). '/uploads/bugs/'.$id.'/';
        $path_images=Yii::$app->request->BaseUrl;
       // Open a directory, and read its contents
        if (is_dir($path)){
          if($dh=opendir($path)){
            $b=readdir($dh);
            while($file = readdir($dh)){
             // echo "filename:" . $file . "<br>";
                  $images[] = $file;

            }
           closedir($dh);
          }
        }
               
            
              foreach ($images as $image){
            if($image != '.' && $image != '..'){

                echo '<div class="photo">'. Html::img($path_images.'/uploads/bugs/'.$id.'/'.$image, ['class'=>'file-preview-image img imgList','width'=>150,'height'=>150]);
                echo "<i id='cross' class='fa fa-times remove_img'>X</i>".'</div>';
              }
             } 
            
        echo "<script type='text/javascript'>

          $('.photo').find('#cross').click(function(){

          var src = $(this).parent().find('.imgList').attr('src');
        

        $.ajax({

          url: '".$path_images."/index.php?r=bugs/remove',
          data: {'file' : src },

          success: function (response) {

          },

          error: function () {

             // do something

          }

        });

    
     $(this).parent().remove();
            

            }); 
  window.alert(file);
       </script>";
       
    }

     public function actionRemove($file){

        $url = parse_url($file);
        $link='C:/wamp/www';
        $path= $link.$url['path'];
        unlink($path);
        /*if(unlink($path)){
            //\Yii::$app->getSession()->setFlash('success', 'Updated Successfully.');
            //return $this->redirect(['view', 'id' => $model->gt_id]);
        }*/
    }  

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }
    public function actionAdmindashboard()
    {
        return $this->render('admindashboard');    
    }
    public function actionDevdashboard()
    {
        $searchModel = new GtuBugsSearch();
        $dataProvider = $searchModel->searchDevdashboard(Yii::$app->request->queryParams);

        return $this->render('devdashboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     public function actionApproverdashboard()
    {
        $searchModel = new GtuBugsSearch();
        $dataProvider = $searchModel->searchApproverdashboard(Yii::$app->request->queryParams);

        return $this->render('approverdashboard', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionResolved($id)
    {   
        $model = new GtuBugs();
        $model = $this->findModel($id);
        $summary=$model->gt_summary;
        if ($model->load(Yii::$app->request->post()) ) {
            $status=$model->gt_status;
            
            if($status=='Resolved')
                {
                    $model->gt_status='Resolved';
                }elseif($status=='Duplicate'){
                    $model->gt_status='Duplicate';
                }
                date_default_timezone_set("Asia/Kolkata");
                $model->gt_lastmodified=date("Y-m-d H:i:s");
                $model->gt_resolvedon=date("Y-m-d H:i:s");
               
            $username = Yii::$app->user->identity->username; 
            $model->gt_resolvedby=$username;
            $model->gt_modifiedby=$username;
            $newsummary=$model->gt_summary;
            $model->gt_summary=$summary . "<br>" . $username . "&nbsp;&nbsp;". date("Y-m-d H:i:s") . "<br>" . $model->gt_status . "<br>" . $newsummary . "<br>" ;
            /*$email_ids= Employees::find()->select('gt_email')->where(['role'=>[20,40],])->all();
                $i=0;
                foreach($email_ids as $value){ 
                $emailto[$i++]= $value['gt_email'];
                }    */
            if($model->save()){
              /* Yii::$app->mailer->compose()
                ->setFrom('akshay.gymtrekker@gmail.com')
                ->setTo('akshay.pakhare@gmail.com')
                ->setSubject('Bug Resolved')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<br />1 Bug has been Resolved,<b><br />Subject :'.$model->gt_subject .'<br /> Description:'. $model->gt_description .'<br /> Step To Reproduce:'. $model->gt_steptoreproduce .
                        '<br /> Platform:'. $model->gt_platform .'<br /> Browser:'. $model->gt_browser .'<br /> Url:'. $model->gt_url .
                        '<br /> Severity:'. $model->gt_severity .'<br /> Created By:'. $model->gt_createdby .'<br /> Created On:'. $model->gt_createdon .'<br /> Status:'. $model->gt_status .
                        '<br /> Modified By:'. $model->gt_modifiedby .'<br /> Last Modified:'. $model->gt_lastmodified.'<br /> Resolved By:'. $model->gt_resolvedby .'<br />Resolved On:'. $model->gt_resolvedon. '<br /> Click to<a href=http://localhost/bugrecord/backend/web/index.php?r=bugs%2Fview&id=3> Update</a> Status </b>')
                ->send();*/
             return $this->render('view', [
            'model' => $model,
            ]);
        }
            
        }else{ 
        return $this->render('statusmodify', [
            'model' => $model,
        ]);
        }   
    }
    public function actionVerified($id)
        {  
            $model = new GtuBugs();
            $model = $this->findModel($id);
            $summary=$model->gt_summary;
            if($model->load(Yii::$app->request->post()) ) {
            $status=$model->gt_status;
         
            if($status=='Verified')
                {
                $model->gt_status='Verified';
                }elseif($status=='Open'){
                   $model->gt_status='Open';
                }
            date_default_timezone_set("Asia/Kolkata");
            $model->gt_lastmodified=date("Y-m-d H:i:s");
            $model->gt_verifiedon=date("Y-m-d H:i:s");
            $username = Yii::$app->user->identity->username; 
            $model->gt_modifiedby=$username;
            $model->gt_verifiedby=$username;
            $newsummary=$model->gt_summary;
            $model->gt_summary=$summary . "<br>" . $username . "&nbsp;&nbsp;". date("Y-m-d H:i:s") . "<br>". $model->gt_status . "<br>" . $newsummary . "<br>" ;
            if($model->save()){
               Yii::$app->mailer->compose()
                ->setFrom('akshay.gymtrekker@gmail.com')
                ->setTo('akshay.pakhare@gmail.com')
                ->setSubject('Bug Verified')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<br />1 Bug has been Verified,<b><br />Subject :'.$model->gt_subject .'<br /> Description:'. $model->gt_description .'<br /> Step To Reproduce:'. $model->gt_steptoreproduce .
                        '<br /> Platform:'. $model->gt_platform .'<br /> Browser:'. $model->gt_browser .'<br /> Url:'. $model->gt_url .
                        '<br /> Severity:'. $model->gt_severity .'<br /> Created By:'. $model->gt_createdby .'<br /> Created On:'. $model->gt_createdon .'<br /> Status:'. $model->gt_status . 
                        '<br /> Verified By:'.$model->gt_verifiedby .'<br /> Verified On:'. $model->gt_verifiedon .
                        '<br /> Modified By:'. $model->gt_modifiedby .'<br /> Last Modified:'. $model->gt_lastmodified. '<br /> Click to<a href=http://localhost/bugrecord/backend/web/index.php?r=bugs%2Fview&id=3> Update</a> Status </b>')
                ->send();
            return $this->render('view', [
            'model' => $model,
            ]);
        }
        }else{
        return $this->render('statusmodify', [
            'model' => $model,
        ]);
        }
    }
     public function actionClose($id)
     { $model = new GtuBugs();
        $model = $this->findModel($id);
         $summary=$model->gt_summary;
        if ($model->load(Yii::$app->request->post()) ) {
            $status=$model->gt_status;
            $username = Yii::$app->user->identity->username; 
            $newsummary=$model->gt_summary;
            $model->gt_summary=$summary . "<br>" . $username . "&nbsp;&nbsp;". date("Y-m-d H:i:s") . "<br>". $model->gt_status . "<br>" . $newsummary . "<br>" ;
            date_default_timezone_set("Asia/Kolkata");
            $model->gt_lastmodified=date("Y-m-d H:i:s");
            $model->gt_modifiedby=$username;
            if($model->save()){
              /*  Yii::$app->mailer->compose()
                ->setFrom('akshay.gymtrekker@gmail.com')
                ->setTo('akshay.pakhare@gmail.com')
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>HTML content</b>')
                ->send(); */
             return $this->render('view', [
            'model' => $model,
            ]);
            }
        }else{
        return $this->render('statusmodify', [
            'model' => $model,
        ]);
        }
    }
    public function actionAdmin($id)
     { $model = new GtuBugs();
        $model = $this->findModel($id);
         $summary=$model->gt_summary;
        if ($model->load(Yii::$app->request->post()) ) {
            $status=$model->gt_status;
           
                if($status=='Close'){
                  $model->gt_status='Close';
                }elseif($status=='Duplicate'){
                  $model->gt_status='Duplicate';
                }elseif($status=='Verified'){
                  $model->gt_verifiedby=$username;
                }elseif($status=='Open'){
                  $model->gt_status='Open';
                }elseif($status=='Resolved'){
                  $model->gt_status='Resolved';
                }elseif($status=='Duplicate'){
                  $model->gt_status='Duplicate';
                }
            $username = Yii::$app->user->identity->username; 
            $newsummary=$model->gt_summary;
            $model->gt_summary=$summary . "<br>" . $username . "&nbsp;&nbsp;". date("Y-m-d H:i:s") . "<br>". $model->gt_status . "<br>" . $newsummary . "<br>" ;
            date_default_timezone_set("Asia/Kolkata");
            $model->gt_lastmodified=date("Y-m-d H:i:s");
            $model->gt_modifiedby=$username;
            $model->save();
            return $this->render('view', [
            'model' => $model,
        ]);
        }else{
        return $this->render('statusmodify', [
            'model' => $model,
        ]);
        }
    }
    /**
     * Deletes an existing GtuBugs model.
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
     * Finds the GtuBugs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GtuBugs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GtuBugs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
