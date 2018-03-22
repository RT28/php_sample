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


$programme = UniversityCourseList::find()->where(['=', 'id', $model->programme])->one();
$programme_name = $programme->name;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-view">

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
<p>
<a href="?r=invoice/downloadattachment&name=<?php echo $model->invoice_attachment; ?>&id=<?php echo $model->id ?>" class="btn btn-primary" role="button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download Attachment</a>
</p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'student_id',
            'consultant_id',
            'agency_id',
            'refer_number',
            'payment_date',
            'university',
            'programme',
            'intake',
            'gross_tution_fee',
            'discount',
            'scholarship',
            'net_fee_paid',
            'invoice_attachment',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'approved',
            'approved_by',
        ],
    ]) ?>

</div>
