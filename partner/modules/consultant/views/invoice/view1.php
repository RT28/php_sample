<?php

use yii\helpers\Html;
use yii\widgets\DetailView; 
use common\models\Student; 
use common\models\Currency;
use common\models\University;
use common\models\UniversityCourseList;
use common\models\Consultant;
use common\models\Agency;



//$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';

$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname = $studentProfile->first_name." ".$studentProfile->last_name;

$consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
$consultantname = $consultantProfile->first_name." ".$consultantProfile->last_name;

$agencyProfile = Agency::find()->where(['=', 'partner_login_id', $model->agency_id])->one();
$agencyname = $agencyProfile->name;

$currency = Currency::find()->where(['=', 'id', $model->currency])->one();
$gross_amount = $model->gross_tution_fee." ".$currency->iso_code;

$university = University::find()->where(['=', 'id', $model->university])->one();
$university_name = $university->name;

$programme = UniversityCourseList::find()->where(['=', 'id', $model->programme])->one();
$programme_name = $programme->name;
?>

<div class="university-course-list-view">


    <div id="page-wrap">
        <textarea id="header">INVOICE</textarea>
        <div id="identity">
            <textarea id="address">Brighter Admission Consultant 1602, 1 Lake Plaza Jumeirah Lakes Towers Dubai, UAE</textarea>
            <div id="logo">
             <img id="image" src="images/Brighter Admission logo png-01.png" alt="logo" />
            </div>
        </div>
        <div style="clear:both"></div>
        <div id="customer">
            <div id="meta" style="float: left;">
                    <p class="meta-head"><b>Student :</b> <?= $studentname; ?></p>
                    <p class="meta-head"><b>Consultant :</b> <?= $consultantname; ?></p>
                    <p class="meta-head"><b>Agency :</b> <?= $agencyname; ?></p>
                <!-- <tr>

                    <td class="meta-head">Consultant</td>
                    <td><textarea id="date"><?= $consultantname; ?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Agency</td>
                    <td><div class="due"><?= $agencyname; ?></div></td>
                </tr> -->
            </div>
            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea><?= $model->refer_number; ?></textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date"><?= $model->payment_date; ?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due"><?= $gross_amount; ?></div></td>
                </tr>
            </table>
        </div>
        
        <table id="items">
        
          <tr>
              <th>University</th>
              <th>Program</th>
              <th>Scholarshipt</th>
              <th>Scholarshipt</th>
              <th>Price</th>
          </tr>
          
          <tr class="item-row">
              <td class="item-name"><div class="delete-wpr"><textarea><?= $university_name; ?></textarea></div></td>
              <td class="description"><textarea><?= $programme_name; ?></textarea></td>
              <td><textarea class="cost"><?= $model->scholarship; ?></textarea></td>
              <td><textarea class="cost"><?= $model->scholarship; ?></textarea></td>
              <td><span class="price"><?= $gross_amount; ?></span></td>
          </tr>
          
          <tr id="hiderow">
            <td colspan="5"></td>
          </tr>
          
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Subtotal</td>
              <td class="total-value"><div id="subtotal"><?= $gross_amount; ?></div></td>
          </tr>
          <tr>

              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Total</td>
              <td class="total-value"><div id="total"><?= $gross_amount; ?></div></td>
          </tr>
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Amount Paid</td>

              <td class="total-value"><textarea id="paid">0.00<?= $currency->iso_code; ?></textarea></td>
          </tr>
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line balance">Balance Due</td>
              <td class="total-value balance"><div class="due"><?= $gross_amount; ?></div></td>
          </tr>
        
        </table>
        
        <div id="terms">
          <h5>Terms</h5>
          <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
        </div>
<style type="text/css">

#page-wrap { width: 800px; margin: 0 auto; }

textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
table { border-collapse: collapse; }
table td, table th { border: 1px solid black; padding: 5px; }

#header { height: 37px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

#address { width: 241px; height: 150px; float: left; }
#customer { overflow: hidden; }

#logo { text-align: right; float: right; position: relative; margin-top: -18px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }

#logohelp input { margin-bottom: 5px; }
.edit #logohelp { display: block; }
.edit #save-logo, .edit #cancel-logo { display: inline; }
.edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
#customer-title { font-size: 20px; font-weight: bold; float: left; }

#meta { margin-top: 1px; width: 300px; float: right; }
#meta td { text-align: right;  }
#meta td.meta-head { text-align: left; background: #eee; }
#meta td textarea { width: 100%; height: 20px; text-align: right; }

#items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
#items th { background: #eee; }
#items textarea { width: 80px; height: 50px; }
#items tr.item-row td { border: 0; vertical-align: top; }
#items td.description { width: 300px; }
#items td.item-name { width: 175px; }
#items td.description textarea, #items td.item-name textarea { width: 100%; }
#items td.total-line { border-right: 0; text-align: right; }
#items td.total-value { border-left: 0; padding: 10px; }
#items td.total-value textarea { height: 20px; background: none; }
#items td.balance { background: #eee; }
#items td.blank { border: 0; }

#terms { text-align: center; margin: 20px 0 0 0; }
#terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
#terms textarea { width: 100%; text-align: center;}


.delete-wpr { position: relative; }
.delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }
</style>
    
    </div>
    <div><input type="button" name="" value="Print" onclick="printDiv();"></div>


</div>
 
</div>
</div>

<script type="text/javascript">
    function printDiv() 
{

  var divToPrint=document.getElementById('page-wrap');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>