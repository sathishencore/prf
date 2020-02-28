<div class="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		Position Information
		<?php $title_for_layout;?>
	</div>
	<div class="show" id="toggleCreateshow">&nbsp;</div>
</div>
<?php echo $this->Form->create("CandidateAssignment",array("url"=>"/CandidateAssignment/index"));?>
<div class="bodyconrarea">
	<div class="content" id="createUserSection" style="display:;">
		<div class="content-mid">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							align="center">
							<tr>
								<td width="94%">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td>Client<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ 
												echo $this->Form->select("CandidateAssignment.ClientID",$clientList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionData['Position']['ClientID']));
											}
											else {echo $this->Form->select("CandidateAssignment.ClientID",$clientList,array("empty"=>"--Select--","class"=>"select-small"));
}?>
											</td>
											<td>Project Code,Name<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ 
												echo $this->Form->select("CandidateAssignment.ProjectID",$projectList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionData['Position']['ProjectID']));
											}
											else{ echo $this->Form->select("CandidateAssignment.ProjectID",$projectList,array("empty"=>"--Select--","class"=>"select-small"));
}?>
											</td>
											<td>Req Number<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ 
												echo $this->Form->select("CandidateAssignment.PositionID",$positionList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionData['Position']['ID']));
											}
											else{ echo $this->Form->select("CandidateAssignment.PositionID",$positionList,array("empty"=>"--Select--","class"=>"select-small"));
}?>
											</td>
										</tr>
										<tr>
											<td>Role</td>
											<td>:</td>
											<td><label id="Role"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['Role'];
											}?> </label>
											</td>
											<td>Project Start</td>
											<td>:</td>
											<td><label id="ProjectStartDate"><?php if(!empty($positionData)){ 
												echo $positionData['Project']['StartDate'];
											}?> </label>
											</td>
											<td>Status</td>
											<td>:</td>
											<td><label id="PositionStatus"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['Status'];
											}?> </label>
											</td>
										</tr>
										<tr>
											<td>Location</td>
											<td>:</td>
											<td><label id="Location"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['WorkLocation'];
											}?> </label>
											</td>
											<td>Project End</td>
											<td>:</td>
											<td><label id="ProjectEndDate"><?php if(!empty($positionData)){ 
												echo $positionData['Project']['EndDate'];
											}?> </label>
											</td>
											<td>Billing Type</td>
											<td>:</td>
											<td><label id="BillingType"><?php if(!empty($positionData)){ 
												echo $positionData['Project']['BillingType'];
											}?> </label>
											</td>
										</tr>
										<tr>
											<td>Hiring Manager</td>
											<td>:</td>
											<td><label id="HiringManager"><?php if(!empty($positionData)){ 
												echo $positionData['User']['fullName'];
											}?> </label>
											</td>
											<td>Screening Manager</td>
											<td>:</td>
											<td><label id="ScreeningManager"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['ScreeningManager'];
											}?> </label>
											</td>
											<td>Project Manager</td>
											<td>:</td>
											<td><label id="ProjectManager"><?php if(!empty($positionData)){ 
												echo $positionData['Project']['ProjectManager'];
											}?> </label>
											</td>
										</tr>
										<tr>
											<td>Total Positions</td>
											<td>:</td>
											<td><label id="TotalPositions"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['NoOfPosition'];
											}?> </label>
											</td>
											<td>Confirmed Positions</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($ConfirmedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Confirmed"> 
												<?php echo count($ConfirmedStatus);}else{ echo '0'; }}?>
											
											</a>
											</td>
											<td>Open Positions</td>
											<td>:</td>
											<td><label id="OpenPositions"><?php if(!empty($positionData)){ 
												echo (($positionData['Position']['NoOfPosition'])-(count($ConfirmedStatus)));
											}?>
											</label>
											</td>
										</tr>
										<tr>
											<td>Candidate Assigned</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($AssignedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Assigned">
												<?php echo count($AssignedStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
											<td>Resumes Submitted</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($SubmittedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Submitted">
												<?php echo count($SubmittedStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
											<td>Interviews Scheduled</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($InterviewScheduledStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Interview Scheduled"> 
												<?php echo count($InterviewScheduledStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
										</tr>
										<tr>
											<td>Interviews Done</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($InterviewDoneStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Interview Done"> 
												<?php echo count($InterviewDoneStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
											<td>Candidates Selected</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($SelectedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Selected">
												<?php echo count($SelectedStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
											<td>Candidates Rejected</td>
											<td>:</td>
											<td><?php if(!empty($positionData)){ if(count($RejectedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Rejected"> 
												<?php echo count($RejectedStatus);}else{ echo '0'; }
											}?>
											</a>
											</td>
										</tr>
										<tr>
											<td>Notes</td>
											<td>:</td>
											<td><label id="Notes"><?php if(!empty($positionData)){ 
												echo $positionData['Position']['Notes'];
											}?></label>
										
										</tr>
									</table>

								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php if(!empty($candidateAssignmentList)){ 
	echo $this->element("CandidateAssignment");
}?>
<?php echo $this->element("searchCandidateAssignment");?>
<?php echo $this->element("candidateStatusPopup");?>

<script type="text/javascript">
$(".can_name").hide();
$("#candidatestatus").hide();
$(document).ready(function(){
	$("#searchbox").chosen();
	$("#UserNamelist").chosen();	
	$("#toggleshow").bind("click",function(){
		$("#searchCandidateAssignment").toggle();
		$("#toggleshow").toggleClass("show hide");		
	});
	$("#toggleCreateshow,#toggleCreateshow1").bind("click",function(){
		$("#createUserSection").toggle();
		$("#toggleCreateshow").toggleClass("show hide");		
	});	
	$("#toggleshows").bind("click",function(){
		$("#CandidateAssignment").toggle();
		$("#toggleshows").toggleClass("show hide");		
	});
});

$("#CandidateAssignmentClientID").change(function(){
	 $("#CandidateAssignmentProjectID").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { PositionId:$("#CandidateAssignmentClientID").val() }
		 }).done(function( msg ) {
			 $("#CandidateAssignmentProjectID").html(msg);
	 });
});

$("#CandidateAssignmentProjectID").change(function(){
	 $("#CandidateAssignmentPositionID").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Position/getRequest");?>",
		 data: { ProjectId:$("#CandidateAssignmentProjectID").val(),ClientId:$("#CandidateAssignmentClientID").val() }
		 }).done(function( msg ) {
			 $("#CandidateAssignmentPositionID").html(msg);
	 });
});

$("#CandidateAssignmentPositionID").change(function(){
	window.location.href = "<?php echo $this->Html->url("/CandidateAssignment/index")?>?positionid="+$("#CandidateAssignmentPositionID").val(); 
	
/*	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/AssignRecruiter/getPositionDetails");?>",
		 data: { PositionId:$("#CandidateAssignmentPositionID").val() }
		 }).done(function( msg ) {
			 var data = jQuery.parseJSON(msg);
			 $('#Location').text(data.Position.WorkLocation);
			 $('#Role').text(data.Position.Role);
			 $('#ProjectStartDate').text(data.Project.StartDate);
			 $('#ProjectEndDate').text(data.Project.EndDate);
			 $('#BillingType').text(data.Project.BillingType);
			 $('#TotalPositions').text(data.Position.NoOfPosition);
			 $('#HiringManager').text(data.User.fullName);
			 $('#ScreeningManager').text(data.Position.ScreeningManager);
			 $('#ProjectManager').text(data.Project.ProjectManager);
			 $('#PositionStatus').text(data.Position.Status);
	 });*/
});
	
</script>
