<div id="candidate_assignment" title="Candidate Assignment Status">
	<h1
		style="font-size: 100%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
		<label id="candidateName" style="font-size: 130%;"></label> Details:
	</h1>
	<?php
	if(!empty($positionId)){
			$id = $positionId;
			}
?>
	<?php echo $this->Form->create("CandidateAssignmentFrm",array("url"=>array("controller"=>"CandidateAssignment","action"=>"index?positionid=".$id)));?>
	<table callspacing="5" cellpadding="5">
		<tr>
			<td>Assignment Status</td>
			<td>:</td>
			<td><?php echo $this->Form->select("AssignmentStatus",Configure::read("CandidateAssignment.Status"),array("empty"=>false,"class"=>"select-small"));?>
			</td>
		</tr>
		<tr>
			<td>Interview Date<span style="float: none;" class="error1">*</span></td>
			<td>:</td>
			<td><?php echo $this->Form->input("InterviewDate",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small datepicker","div"=>false));?>
			<span class="error1">Please enter valid date</span>
			</td>
		</tr>
		<tr>
			<td>Interview Time<span class="error" style="float: none;">*</span></td>
			<td>:</td>
			<td><?php echo $this->Form->input("InterviewTime",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:100px","placeholder"=>"hh:mm"));?>
			<?php echo $this->Form->select("InterviewSession",Configure::read("Time.Session"),array("empty"=>"-Select-","class"=>"select-small","style"=>"width:80px;margin-left:2%;margin-top:0.5%"));?>
			<label class="error" id="timesession" style="margin-left: 0;float: left;">Please enter correct time</label>
			</td>
		</tr>	
		<tr>
			<td>Interview Level</td>
			<td>:</td>
			<td><?php echo $this->Form->select("InterviewLevel",Configure::read("CandidateAssignment.InterviewLevel"),array("empty"=>"--Select--","class"=>"select-small"));?>
			</td>
		</tr>
		<tr>
			<td>Notes</td>
			<td>:</td>
			<td><?php echo $this->Form->textarea("Notes",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>2,"cols"=>"25"));?>
			</td>
			<td><?php echo $this->Form->hidden("CandidateID",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?></td>
		</tr>
	</table>
	<div class="buttonalign" style="margin-left: 22%">
		<?php
		echo $this->Form->submit("login",array("type"=>"image","onclick"=>"return loginclass()","src"=>$this->Html->url("/")."img/save-but.png","div"=>false,"style"=>"margin-left:30%;"));
		?>&nbsp;
		<?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"return closePopup()","style"=>"margin-right:8%;margin-top:1%"));?>
	</div>
	<?php echo $this->Form->end();?>
	<p></p>
	<p></p>
</div>

<script type="text/javascript">
$("#candidate_assignment").hide();
$(".datepicker").datepicker({dateFormat: 'yy-mm-dd', minDate: 0, changeYear:true, changeMonth:true});
$(".error,.error1").hide();

$('.can_assignment').click( function() {
	var id=$(this).attr("data-val");
	$.get( window.location+"&candidateid="+id ,  function ( data ) {
		var obj = jQuery.parseJSON(data);
		$("#candidateName").text(obj.Candidate.FirstName+" "+obj.Candidate.LastName);
		$("#CandidateAssignmentFrmAssignmentStatus").val(obj.CandidateAssignment.AssignmentStatus);
		$("#CandidateAssignmentFrmInterviewDate").val(obj.CandidateAssignment.Date);
		$("#CandidateAssignmentFrmInterviewTime").val(obj.CandidateAssignment.Time);
		$("#CandidateAssignmentFrmInterviewSession").val(obj.CandidateAssignment.Session);
		$("#CandidateAssignmentFrmCandidateID").val(obj.CandidateAssignment.CandidateID);
		$("#CandidateAssignmentFrmNotes").val(obj.CandidateAssignment.Notes);
		$("#CandidateAssignmentFrmInterviewLevel").val(obj.CandidateAssignment.InterviewLevel);
	
	$(function() {
		 $( "#candidate_assignment" ).dialog({
		 width:'auto',
		 modal: true
			 });
	 	});
	 });
});

function loginclass(){
	if($("#CandidateAssignmentFrmInterviewDate").val() != ''){
		if($("#CandidateAssignmentFrmInterviewTime").val() == '' || $("#CandidateAssignmentFrmInterviewSession").val() == ''){
			$(".error").show();
		return false;
		}else{
			$(".error").hide();
			return true;
		}
	}else{
		if($("#CandidateAssignmentFrmInterviewTime").val() != '' || $("#CandidateAssignmentFrmInterviewSession").val() != ''){
				$(".error1").show();
				return false;
		}else{
		$(".error,.error1").hide();
		return true;
		}
	}
}

$("#CandidateAssignmentFrmIndexForm").validate({
	 rules: {
		 "data[CandidateAssignmentFrm][InterviewTime]" : {
			 time:true
		 }
	 }
});
jQuery.extend(jQuery.validator.messages, {
    time: "Please enter a valid time, between 00:00 and 11:59",	
});

function closePopup(){
	$('.ui-front').remove();
	return false;
}
</script>

<style>
select {
    float: none;
    height: 27px;
    padding: 2px;
    width: 81%;
}
.error1 {
    color: #FF0000;
    float: left;
    font-size: 12px;
    left: 10px;
    text-align: left;
}
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    height: 0%;
    width: 45%;
    padding:0;
    margin-left: 3%;
}
</style>
