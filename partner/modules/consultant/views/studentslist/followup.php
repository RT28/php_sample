
<?php use kartik\datetime\DateTimePicker; 
use kartik\date\DatePicker;?>
<style>
.messagepop {
  background-color:#FFFFFF;
  border:1px solid #999999;
  cursor:default;
  /*display:none*/;
  margin-top: 15px;
  position:absolute;
  text-align:left;
  width:36%;
  z-index:50;
  padding: 25px 25px 20px;
  cursor: move;
}

label {
  display: block;
  margin-bottom: 3px;
  padding-left: 15px;
  text-indent: -15px;
}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
.fl_sub{
      width: 100%;
    height: 100px;
    /* background: aqua; */
   /* margin: auto;*/
    padding: 10px;
}
.fl_list_sub{
 /* margin-left: 100px;*/
    /*height: 200px;*/
    float: left;
    width: 320px;
    padding: 10px;
}
.red_star{
  color: red;
  font-size: 15px;
  font-weight: bold;
}
</style>
<div class="messagepop pop" >
<a class="close" onclick="fn_closefollowup();">Close</a>
<?php if($followup_det){ ?>

<p><a style="cursor: pointer;" onclick="fn_toggleHistory();">Followup History:</a></p>
<div class="fp_history" style="display: none;max-height: 250px;overflow-y: scroll;">
<?php foreach($followup_det as $followup){ ?>
<div  style="background-color: rgba(0, 255, 66, 0.36); border-radius: 10px;padding: 1px;">
<?php if($followup['status']==1){ ?>
<p><i style="color: red;">Created on : <?php echo $followup['created_at']; ?></i></p>
<p>Comment : <b><?php echo $followup['comment']; ?></b><i>(on <?php echo $followup['comment_date']; ?>)</i> <i style="color: red; float: right;">Mode : <?php echo $followup['mode']; ?></i></p>
<p><img src="images/new_followup.png" height="20px;" width="20px;" title="New Followup">Next followup Comment : <b><?php echo $followup['next_follow_comment']; ?></b><i style="color: red; float: right; font-weight: bold;">Next Followup on : <?php echo $followup['next_followup']; ?></i></p>
<?php } else if($followup['status']==2){ 
if($followup['reason_code']==1) { $reason='Not Intersted'; }
else if($followup['reason_code']==2) { $reason='Price not reasonable'; }
else if($followup['reason_code']==3) { $reason='Not now'; } else { $reason=''; }	?>
<p><i style="color: red;">Created on : <?php echo $followup['created_at']; ?></i></p>
<p>Comment : <b><?php echo $followup['comment']; ?></b><i>(on <?php echo $followup['comment_date']; ?>)</i> <i style="color: red; float: right;">Mode : <?php echo $followup['mode']; ?></i></p>
<p><b><img src="images/inactive.png" height="20px;" width="20px;" title="Inactive/Closed Followup"> Student Inactive</b><i style="color: red;">(<?php echo $reason; ?>)</i></p>
<?php } else if($followup['status']==3){ ?>
<p><i style="color: red;">Created on : <?php echo $followup['created_at']; ?></i></p>
<p>Comment : <b><?php echo $followup['comment']; ?></b><i>(on <?php echo $followup['comment_date']; ?>)</i><i style="color: red; float: right;">Mode : <?php echo $followup['mode']; ?></i></p>
<p><b><img src="images/access_send.png" height="20px;" width="20px;" title="Access Sent"> Package Link Send</b></p>
<?php } else if($followup['status']==4){ ?>
<p><i style="color: red;">Created on : <?php echo $followup['created_at']; ?></i></p>
<p>Comment : <b><?php echo $followup['comment']; ?></b><i>(on <?php echo $followup['comment_date']; ?>)</i> <i style="color: red; float: right;">Mode : <?php echo $followup['mode']; ?></i></p>
<p><b><img src="images/other_followup.png" height="20px;" width="20px;" title="Other Followup"> Other followups</b></p>
<?php } else if($followup['status']==6){ ?>
<p><i style="color: red;">Created on : <?php echo $followup['created_at']; ?></i></p>
<p>Comment : <b><?php echo $followup['comment']; ?></b><i>(on <?php echo $followup['comment_date']; ?>)</i> <i style="color: red; float: right;">Mode : <?php echo $followup['mode']; ?></i></p>
<p><b><img src="images/other_followup.png" height="20px;" width="20px;" title="Other Followup"> Closed followups</b></p>
<?php } ?>
</div><br>	
<?php } ?> </div> <?php } ?>
<form name="folloup_form" id="folloup_form">
<input type="hidden" name="student_id" id="student_id" value="<?php echo $_POST['student_id']; ?>">
<div class="fl_sub">
<div class="fl_list_sub">
          <label><span class="red_star"></span>Student Followup</label>
        </div>
        <div class="fl_list_sub">
          <label><span class="red_star">*</span>Comment</label><textarea name="follow_comment" id="follow_comment" cols="35"></textarea>
        </div>
        <div class="fl_list_sub">
          <label><span class="red_star">*</span>Date</label>
          <?php echo DatePicker::widget([
              'name' => 'comment_date',
              'id' => 'comment_date',
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
          <label><span class="red_star">*</span>Mode</label>
          <select id="fl_mode" name="mode">
          <option value="0">--select--</option>
          <option value="Telephone">Telephone</option>
          <option value="Email">Email</option>
          <option value="Face to face">Face to face</option>
          </select>
        </div>
</div>
<div class="fl_sub">
        <div class="fl_list_sub">
          <label><span class="red_star">*</span>Response: </label>
      		<select name="follow_status" id="st_714230" onchange="fn_followstatus(this.value);">
      			<option value="0">--Select--</option>
      			<option value="1">Follow up again</option>
      			<option value="2">Not Interested</option>
            <option value="3">Send Package Link</option>
            <option value="4">Other Followups</option>
            <option value="6">Close Followup</option>
      		</select>
		    </div>
</div>    
<div id="flp_714234" class="fl_sub" style="display: none;">
        <div class="fl_list_sub">
        <label><span class="red_star">*</span>Next Follow up date</label>
            <?php echo DateTimePicker::widget([
                'name' => 'next_followup',
                'id' => 'next_followup',
                'options' => ['placeholder' => 'Select date and time ...'],
                //'convertFormat' => true,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd hh:ii',
                    //'startDate' => '01-Mar-2014 12:00 AM',
                    'autoclose'=>true,
                    'todayHighlight' => true
                ]
            ]); ?>
        </div>
        <div class="fl_list_sub">
        <label><span class="red_star">*</span>Next Follow up comment</label>
        <textarea name="next_follow_comment" id="next_follow_comment" cols="35"></textarea>
        </div>
</div>
<div id="rsn_714234" class="fl_sub" style="display: none;">
        <div class="fl_list_sub">
        <label><span class="red_star">*</span>Reason</label>
        <select name="reason_code" id="reason_code">
        	<option value="0">--select--</option>
    			<option value="1">Not Intersted</option>
    			<option value="2">Price not reasonable</option>
    			<option value="3">Not now</option>
    		</select>
        </div>
</div>
</form>   
<div class="fl_sub">
        <div class="fl_list_sub">
        <input style="display: none;" type="submit" value="Save" name="commit" id="message_submit" onclick="fn_savefoloowUp();" /> 
        <input style="display: none;" type="submit" value="Send" name="commit" id="package_send" onclick="fn_savefoloowUp();" /> 
        </div>
</div>
<script type="text/javascript">
    function fn_toggleHistory(){
        $('.fp_history').toggle();
    }
    $( function() {
    $( ".messagepop" ).draggable();
  } );
</script>


