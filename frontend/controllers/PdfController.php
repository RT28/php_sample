<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Student;
use frontend\models\Email;
use yii\web\Session;
use common\models\User;
use mPDF;
use moonland\phpexcel;

class PdfController extends \yii\web\Controller
{
    public function actionSend()
    {		
    	$id = Yii::$app->user->identity->student->id;
		$model = $this->findModel($id);
		$session = Yii::$app->session;			
		$session['model'] = $model;
		$this->actionCreatePdf();       
    }
	
      protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	/*protected function findModel($id)
    {
        if (($model = Email::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/
	
	
	public function actionCreatepdf()
    {	
	   $session = Yii::$app->session;
	   $model = $session['model'];
       $mpdf =new mPDF;
       $mpdf->WriteHTML(file_get_contents('./bootstrap/css/bootstrap.css'), 1);
	   $mpdf->WriteHTML( $this->renderPartial('view',['model'=>$model]),2);
	   $mpdf->Output('filename.pdf','D');
	  // $mpdf->Output('../pdfexport/filename1.pdf','F'); 
	   return $this->render('createpdf');
    }	
	
}
?>
