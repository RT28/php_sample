<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PackageType;
use common\components\Status;
use common\models\PackageSubtype;
use common\models\PackageOfferings;
use common\models\Consultant;
use common\models\StudentPackageDetails;
use common\models\StudentConsultantRelation;
use common\components\Roles;

/**
 * CourseController
 */
class PackagesController extends Controller
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
     * Lists all StudentUniveristyApplication models.
     * @return mixed
     */
    public function actionIndex()
    {   
	 
		Yii::$app->view->params['activeTab'] = 'package';
        $packages = PackageType::find()->where(['=', 'status', Status::STATUS_ACTIVE])->orderBy(['rank' => 'ASC'])->all();
        return $this->render('index', [
            'packages' => $packages
        ]);
    }

	
	 /**
     * Renders details of a Course.
     * @return mixed
     */
    public function actionFreesession() {
		Yii::$app->view->params['activeTab'] = 'package'; 
        return $this->render('freesession' );
    }
    /**
     * Renders details of a Course.
     * @return mixed
     */
    public function actionView($id) {
		Yii::$app->view->params['activeTab'] = 'package';
        $package = PackageType::findOne($id);
        $models = PackageSubtype::find()->where(['AND', ['=', 'package_type_id', $id], ['=', 'status', Status::STATUS_ACTIVE]])->orderBy(['rank' =>'ASC'])->all();
        $packages = PackageType::find()->where(['=', 'status', Status::STATUS_ACTIVE])->orderBy(['rank' => 'ASC'])->all();
        

        return $this->render('view', [
            'package' => $package,
            'models' => $models,
            'packages' => $packages,
            'error' => isset($_GET['error']) ? $_GET['error'] : null
        ]);
    }

    public function actionOfferings($id) {
			Yii::$app->view->params['activeTab'] = 'package';
        $subPackage = PackageSubtype::findOne($id);
        $package = $subPackage->packageType;
        $offerings = [];
        $package_offerings = $subPackage->package_offerings;
        if(!empty($package_offerings)) {
            $package_offerings = explode(',', $subPackage->package_offerings);
            $offerings = PackageOfferings::find()->where(['in', 'id', $package_offerings])->all();
        }

        return $this->render('offerings', [
            'subPackage' => $subPackage,
            'offerings' => $offerings,
            'package' => $package
        ]);
    }

    public function actionSelectPackage() {
		Yii::$app->view->params['activeTab'] = 'package';
        $package = $_POST['package'];
        $subPackage = $_POST['subPackage'];
        $offerings = $_POST['offerings'];
        $cost = $_POST['cost'];
        $time = $_POST['time'];

        return $this->redirect(['select-consultant', 'package' => $package, 'subPackage' => $subPackage, 'offerings' => $offerings, 'cost' => $cost, 'time' => $time]);
    }

    public function actionSelectConsultant() {
			Yii::$app->view->params['activeTab'] = 'package';
        $package = $_GET['package'];
        $subPackage = $_GET['subPackage'];
        $offerings = $_GET['offerings'];
        $cost = $_GET['cost'];
        $time = $_GET['time'];
        $offeringIds = $offerings;
        $consultant = Consultant::find()->innerJoin('partner_login', '`partner_login`.`id` = `consultant`.`consultant_id` AND `partner_login`.`role_id` = ' . Roles::ROLE_CONSULTANT)->all();

        return $this->render('select-consultant',[
            'package' => PackageType::findOne($package),
            'subPackage' => PackageSubtype::findOne($subPackage),
            'offerings' => PackageOfferings::find()->where(['in', 'id', $offerings])->all(),
            'consultants' => $consultant,
            'offeringIds' => $offeringIds,
            'cost' => $cost,
            'time' => $time
        ]);
    }

    public function actionBuy() {
			Yii::$app->view->params['activeTab'] = 'package';
        $package = $_POST['package'];
        $subPackage = $_POST['subPackage'];
        $offerings = $_POST['offerings'];
        $consultant = $_POST['consultant'];
        $cost = $_POST['cost'];
        $time = $_POST['time'];

        $subPackage = PackageSubtype::findOne($subPackage);

        $studentPackage = new StudentPackageDetails();
        $studentPackage->student_id = Yii::$app->user->identity->id;
        $studentPackage->consultant_id = $consultant;
        $studentPackage->package_type_id = $package;
        $studentPackage->package_subtype_id = $subPackage->id;
        $studentPackage->package_offerings = $offerings;
        $studentPackage->limit_type = $subPackage->limit_type;
        $studentPackage->limit_pending = $time;
        $studentPackage->total_fees = $cost;
        $studentPackage->created_by = Yii::$app->user->identity->id;
        $studentPackage->updated_by = Yii::$app->user->identity->id;
        $studentPackage->created_at = gmdate('Y-m-d H:i:s');
        $studentPackage->updated_at = gmdate('Y-m-d H:i:s');

        if($studentPackage->save()) {
            $user = Yii::$app->user->identity->id;
            $studentConsultant = StudentConsultantRelation::find()->where(['AND', ['=', 'student_id', $user],['=', 'consultant_id', $consultant]])->one();
            if(empty($studentConsultant)) {
                $studentConsultant = new StudentConsultantRelation();
                $studentConsultant->student_id = $user;
                $studentConsultant->consultant_id = $consultant;
                $studentConsultant->created_by = $user;
                $studentConsultant->updated_by = $user;
                $studentConsultant->created_at = gmdate('Y-m-d H:i:s');
                $studentConsultant->updated_at = gmdate('Y-m-d H:i:s');
                if($studentConsultant->save()) {
                    return json_encode(['status' => 'success']);        
                }
            }
            return json_encode(['status' => 'success']);
        }

        return json_encode(['status' => 'error', 'message' => $studentPackage->errors]);
    }
}
