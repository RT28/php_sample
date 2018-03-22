<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Student; 
use common\models\Currency;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Consultant;
use common\models\Agency;
/* @var $this yii\web\View */
/* @var $model common\models\Invoice */

$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

$consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
$consultantname = $consultantProfile->first_name." ".$consultantProfile->last_name;

$agencyProfile = Agency::find()->where(['=', 'partner_login_id', $model->agency_id])->one();
$agencyname = $agencyProfile->name;

$currency = Currency::find()->where(['=', 'id', $model->currency])->one();
$gross_amount = $model->gross_tution_fee." ".$currency->iso_code;

if($model->net_fee_paid==''){
$net_amount = '--';
} else {
$net_amount = $model->net_fee_paid." ".$currency->iso_code; 
}

$university = University::find()->where(['=', 'id', $model->university])->one();
$university_name = $university->name;
$university_address = $university->address;


$this->title = 'Invoice Requisition : '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$timestamp = strtotime($model->created_at); 
$createddate = date('d-m-Y', $timestamp); 

$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

$consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
$consultantname = $consultantProfile->first_name." ".$consultantProfile->last_name;

$agencyProfile = Agency::find()->where(['=', 'partner_login_id', $model->agency_id])->one();
$agencyname = $agencyProfile->name;

$currency = Currency::find()->where(['=', 'id', $model->currency])->one();
$gross_amount = $model->gross_tution_fee." ".$currency->iso_code;
$final_net_amount = $model->net_fee_paid." ".$currency->iso_code;

$university = University::find()->where(['=', 'id', $model->university])->one();
$university_name = $university->name;

if($model->programme == 0){
$programme_name = $model->custom_programme;     
} else {
$programme = UniversityCourseList::find()->where(['=', 'id', $model->programme])->one();
$programme_name = $programme->name;
}
?>
<div class="invoice-view">

    


    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>

                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                
<p><strong>Created Date :</strong> <?= $createddate;?></p> 
<p><strong>Student Name:</strong> <?= $studentname; ?></p>
<p><strong>Invoice #:</strong> <?= $model->refer_number; ?></p>
<p><strong>Payment Date:</strong> <?= $model->payment_date ?></p>
<p><strong>University:</strong> <?= $university_name; ?></p>
<p><strong>Program:</strong> <?= $programme_name; ?></p>
<p><strong>Intake:</strong> <?= $model->intake; ?></p>
<p><strong>Scholarshipt:</strong> <?= $model->scholarship; ?></p>
<p><strong>Gross Amount:</strong> <?= $gross_amount; ?></p>
<p><strong>Final Net Amount:</strong> <?= $final_net_amount; ?></p>
<p><strong>Comment:</strong> <?= $model->comment; ?></p>
<p>
<a href="?r=invoice/downloadattachment&name=<?php echo $model->invoice_attachment; ?>&id=<?php echo $model->id ?>" class="btn btn-primary" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download Attachment</a>
</p>
                
             </div>
        </div>
    </div>
</div>
