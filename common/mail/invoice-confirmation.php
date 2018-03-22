<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use common\models\Student;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Currency;
use common\models\Consultant;
use common\models\Agency;
/* @var $this yii\web\View */
/* @var $model common\models\Invoice */
/* @var $form yii\widgets\ActiveForm */

?>
<?php   
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

$timestamp = strtotime($model->created_at); 
$createddate = date('d-M-Y', $timestamp);  ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="http://nextstepwebs.com/images/logo.png" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                                Invoice #: <?= $model->refer_number?><br>
                                Created date: <?= $model->created_at?><br>
                                Due date: <?= $model->payment_date?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>Brighter Admission Consultant 1602,<br>
                                1 Lake Plaza Jumeirah Lakes Towers Dubai,<br>
                                UAE
                            </td>
                            
                            <td>
                                <?= $university_name; ?><br>
                                <?= $university_address; ?><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            <tr class="heading">
                <td>
                    University
                </td>
                
                <td>
                    Program
                </td>
                <td>
                    Scholarshipt
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    <?= $university_name;?>
                </td>
                
                <td>
                   <?= $programme_name;?>
                </td>
                 <td>
                    <?= $model->scholarship;?>
                </td>
                
                <td>
                   <?= $net_amount;?>
                </td>
            </tr>
            
            
            <!-- <tr class="total">
                <td></td>
                
                <td>
                   <?= $net_amount;?>
                </td>
            </tr> -->
        </table>
    </div>
</body>
</html>