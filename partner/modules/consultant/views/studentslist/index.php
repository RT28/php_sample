<?php
use common\models\Country;
use common\models\StudentUniveristyApplication;
use common\models\StudentAssociateConsultants;
use common\models\StudentPackageDetails;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
$this->context->layout = 'main';
$this->title = 'My Students';

$countries = Country::getAllCountries();
$countries = ArrayHelper::map($countries, 'phone_code', 'name');
 $accessStatus = array(0=>'Not Subscribed',1=>'Subscribed',2=>'Access Sent');
?>
<style type="text/css">
    .fl_sub{
      width: 100%;
    height: 100px;

    padding: 10px;
}
.fl_list_sub{
    float: left;
    width: 320px;
    padding: 10px;
}
</style>
<!-- <h1><?= $this->title; ?></h1>
 -->
<div class="consultant-dashboard-index col-sm-12">
 <h1>My Leads</h1>
<!--  <button>Sort the contents</button>
<p style="width: 400px; display: none;">
  <input type="text" name="search_sname" placeholder="Search by student name">
</p> -->
 
<script>
/*$( "button" ).click(function() {
  $( "p" ).slideToggle( "slow" );
});*/
</script>
 <form name="date_filter">
 <div id='btwn_dates' style="display: none;">
<div class="fl_sub" >
        <div class="fl_list_sub">
          <label>Start Date</label>
          <?php echo DatePicker::widget([
              'name' => 'start_date',
              'id' => 'start_date',
              'options' => ['placeholder' => 'Select date...'],
              //'convertFormat' => true,
              'pluginOptions' => [
                  'format' => 'yyyy-mm-dd',
                  'autoclose'=>true,
                  //'startDate' => '01-Mar-2014 12:00 AM',
                  'todayHighlight' => true
              ]
          ]); ?>
        </div>
        <div class="fl_list_sub">
          <label>End Date</label>
          <?php echo DatePicker::widget([
              'name' => 'end_date',
              'id' => 'end_date',
              'options' => ['placeholder' => 'Select date...'],
              //'convertFormat' => true,
              'pluginOptions' => [
                  'format' => 'yyyy-mm-dd',
                  'autoclose'=>true,
                  //'startDate' => '01-Mar-2014 12:00 AM',
                  'todayHighlight' => true
              ]
          ]); ?>
        </div>
        
</div>
<div class="fl_sub" >
<div class="fl_list_sub">
          <label>&nbsp;</label>
          <input type="button" value="Search"  name="" onclick="get_studetList(5,'btweendates');" >&nbsp;<input type="button" id="close_dtfilter" value="Cancel"  name="" >
        </div>
</div>
</div>
</form>
<!-- <div class="consultant-student-view col-sm-10">
 -->
<style type="text/css">
    .down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
}
.dwnarow {
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
      margin-top: 14px;
    float: left;
    margin-left: 3px;
     cursor: pointer;
}
.date_filter {
    background-color: #FFFFFF;
    border: 1px solid #999999;
    cursor: default;
     display: none; 
    margin-top: 0px;
    margin-left: 138px;
    position: absolute;
    text-align: left;
    width: 136px;
    z-index: 50;
    padding: 25px 25px 20px;
}

.date_filter p, .date_filter.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style> 


        <ul class="nav nav-tabs" role="tablist" >
            <li id="act_0" class="act_common" role="presentation"><a href="#active" aria-controls="tests" role="tab" data-toggle="tab" onclick="get_studetList(0);">New Entry<b style="color: red;">(<span id="cnt_0"></span>)</b></a></li>
            <li id="act_5" class="act_common" role="presentation"><a href="#active" aria-controls="tests" role="tab" data-toggle="tab" onclick="get_studetList(5,'today');">Today's Follow up <b style="color: red;">(<span id="cnt_5"></span>)</b></a></li>
            <li class="date_filter_arrow" style="display: none;"><span class="down dwnarow" id="7222017_dt"></span></li>
            <li id="act_1" class="act_common" role="presentation"><a href="#active" aria-controls="tests" role="tab" data-toggle="tab" onclick="get_studetList(1);">Active Follow up<b style="color: red;">(<span id="cnt_1"></span>)</b></a></li>
            <li id="act_2" class="act_common" role="presentation"><a href="#closed" aria-controls="documents" role="tab" data-toggle="tab" onclick="get_studetList(2);">Inactive/Closed Follow up<b style="color: red;">(<span id="cnt_2"></span>)</b></a></li>
            <li id="act_3" class="act_common" role="presentation"><a href="#access_send" aria-controls="associates" role="tab" data-toggle="tab" onclick="get_studetList(3);">Access sent<b style="color: red;">(<span id="cnt_3"></span>)</b></a></li>
            <li id="act_4" class="act_common" role="presentation"><a href="#subscribed" aria-controls="packages" role="tab" data-toggle="tab" onclick="get_studetList(4);">Subscribed<b style="color: red;">(<span id="cnt_4"></span>)</b></a></li>
            <li id="act_6" class="act_common" role="presentation"><a href="#close" aria-controls="packages" role="tab" data-toggle="tab" onclick="get_studetList(6);">Closed<b style="color: red;">(<span id="cnt_6"></span>)</b></a></li>
        </ul>
        <div class="date_filter pop">
            <!-- <p><a onclick="get_studetList(5,'week');">This Week</a></p> -->
            <p><a onclick="get_studetList(5,'month');">This Month</a></p>
            <p><a id="btwn_date_li">Between Dates</a></p>
        </div>

        <div id="stab_712330">
            <!-- <div role="tabpanel" class="tab-pane active" id="active">nfdgfh
            </div>
            <div role="tabpanel" class="tab-pane" id="tests">
                sdfds
            </div>
            <div role="tabpanel" class="tab-pane" id="documents">
                cxvcxv
            </div>
            <div role="tabpanel" class="tab-pane" id="associates">
                vcxv
            </div>
            <div role="tabpanel" class="tab-pane" id="packages">
               fds
            </div> -->
        </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        get_studetList(0);
        
    });
$(document).on('click', '#7222017_dt', function () {
   $('.date_filter').toggle();
});
</script>
<?php
    $this->registerJsFile('js/consultant.js');
?>
