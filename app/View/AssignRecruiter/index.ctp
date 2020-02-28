<?php if(isset($positionInformation)){?>
<div class="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		Position Information
		<?php  $title_for_layout;?>
	</div>
	<div class="hide" id="toggleCreateshow">&nbsp;</div>
</div>

<?php echo $this->Form->create("AssignRecruiter",array("url"=>"/AssignRecruiter/index/","type"=>"file")); ?>
<?php }?>
<div class="bodyconrarea">
	<?php if(isset($positionInformation)){?>
	<div class="content" id="createUserSection">
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
											<td rowspan="2">Client
											</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><?php echo $this->Form->select("AssignRecruiter.ClientID",$clientList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionInformation['Position']['ClientID'],"disabled"=>true,"style"=>"color:black;"));?></td>
											<td rowspan="2">Project Code,Name
											</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><?php echo $this->Form->select("AssignRecruiter.ProjectID",$projectList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionInformation['Position']['ProjectID'],"disabled"=>true,"style"=>"color:black"));?>
											</td>
											<td>Req Number
											</td>
											<td>:</td>
											<td width="22%"><?php echo $this->Form->select("AssignRecruiter.Position",$positionList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionInformation['Position']['ID'],"disabled"=>true,"style"=>"color:black"));?>
											<?php echo $this->Form->hidden("AssignRecruiter.PositionID",array("label"=>false,"type"=>"text","value"=>$positionInformation['Position']['ID']));?>
											</td>
										</tr>
										<tr>
											<td>Client Requisition Ref</td>
											<td>:</td>
											<td><label id="AssignRecruiterClientRequisitionReference"><?php echo $positionInformation['Position']['ClientRequisitionRef']?>
											</label>
											</td>
										</tr>
										<tr>
											<td>Location</td>
											<td>:</td>
											<td><label id="AssignRecruiterLocation"><?php echo $positionInformation['Position']['WorkLocation']?>
											<?php 
											$split = explode(',',$positionInformation['Position']['WorkLocation']);
											if((isset($split[2]))&&($split[2]=="")&&(isset($split[1]))&&($split[1]!="")) {
												$ss = $split[1];
											}
											else if((isset($split[2]))&&($split[2]=="")&&(isset($split[1]))&&($split[1]=="")) {
												$ss = $split[0];
											}
											else {
												$ss = $split[2];
											}
											echo $this->Form->input("AssignedCountry", array("type" => "hidden","id"=>"assignedcountry","value"=>$ss));?>
											</label>
											</td>
											<td>Role</td>
											<td>:</td>
											<td><label id="AssignRecruiterRole"><?php echo $positionInformation['Position']['Role']?>
											</label>
											</td>
											<td>Track</td>
											<td>:</td>
											<td><label id="AssignRecruiterTrack"><?php echo $positionInformation['Position']['Track']?>
											</label>
											</td>
										</tr>
										<tr>
											<td rowspan="2">Project Start</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><label id="AssignRecruiterProjectStartDate"><?php echo $positionInformation['Project']['StartDate']?>
											</label>
											</td>
											<td rowspan="2">Project End</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><label id="AssignRecruiterProjectEndDate"><?php echo $positionInformation['Project']['EndDate']?>
											</label>
											</td>
											<td>Primary Recruiter<span class="errorMandatory">*</span></td>
											<td>:</td>
											<td><?php echo $this->Form->select("AssignRecruiter.RecruiterId",$recruiterList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionInformation['Position']['RecruiterId']));?>
											</td>
										</tr>
										<tr>
										<td>Secondary Recruiter</td>
											<td>:</td>
											<td><?php echo $this->Form->select("AssignRecruiter.SecondaryRecruiterId",$recruiterList,array("empty"=>"--Select--","class"=>"select-small","value"=>$positionInformation['Position']['SecondaryRecruiterId']));?>
											</td>
										</tr>
										<tr>
											<td>Total Positions</td>
											<td>:</td>
											<td><label id="AssignRecruiterTotalPositions"><?php echo $positionInformation['Position']['NoOfPosition']?>
											</label>
											</td>
											<td>Confirmed Positions</td>
											<td>:</td>
											<td><?php if(count($ConfirmedStatus) > 0){?><a href="javascript:" class="assignment_status" data-val="Confirmed">
											<?php echo count($ConfirmedStatus);}else{ echo '0'; }?> </a>
											</td>
											<td>Open Positions</td>
											<td>:</td>
											<td><label id="AssignRecruiterOpenPositions"><?php echo (($positionInformation['Position']['NoOfPosition'])-(count($ConfirmedStatus)));?>
											</label>
											</td>
										</tr>
										<tr>
											<td>Notes</td>
											<td>:</td>
											<td colspan="7"><label id="AssignRecruiterNotes"><?php echo $positionInformation['Position']['Notes']?></label>
										
										</tr>
									</table>

								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="buttonalign">
			<?php
			echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/save-but.png","div"=>false));
			?>
			&nbsp;
			<?php 
			echo $this->Html->link(
						    $this->Html->image("cancel-inner-but.png", array("alt" => "Cancel")),
						    "/AssignRecruiter/index/",
						    array('escape' => false)
						);?>
		</div>
	</div>

</div>
<?php echo $this->Form->end();?>
<?php } ?>
<?php echo $this->element("searchAssignRecruiter");?>
<?php echo $this->element("candidateStatusPopup");?>
<script>
$("#candidatestatus").hide();
$(document).ready(function(){
	$("#searchbox").chosen();
	$("#UserNamelist").chosen();	
	$("#toggleshow").bind("click",function(){
		$("#searchAssignRecruiter").toggle();
		$("#toggleshow").toggleClass("show hide");		
	});
	$("#toggleCreateshow,#toggleCreateshow1").bind("click",function(){
		$("#createUserSection").toggle();
		$("#toggleCreateshow").toggleClass("show hide");		
	});	
});

$("#AssignRecruiterClientID").change(function(){
	 $("#AssignRecruiterProjectID").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { PositionId:$("#AssignRecruiterClientID").val() }
		 }).done(function( msg ) {
			 $("#AssignRecruiterProjectID").html(msg);
	 });
});

$("#AssignRecruiterProjectID").change(function(){
	 $("#AssignRecruiterPositionID").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Position/getRequest");?>",
		 data: { ProjectId:$("#AssignRecruiterProjectID").val(),ClientId:$("#AssignRecruiterClientID").val() }
		 }).done(function( msg ) {
			 $("#AssignRecruiterPositionID").html(msg);
	 });
});

$("#AssignRecruiterPositionID").change(function(){
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/AssignRecruiter/getPositionDetails");?>",
		 data: { PositionId:$("#AssignRecruiterPositionID").val() }
		 }).done(function( msg ) {
			 var data = jQuery.parseJSON(msg);
			 $('#AssignRecruiterLocation').text(data.Position.WorkLocation);
			 $('#AssignRecruiterRole').text(data.Position.Role);
			 $('#AssignRecruiterProjectStartDate').text(data.Project.StartDate);
			 $('#AssignRecruiterProjectEndDate').text(data.Project.EndDate);
			 $('#AssignRecruiterTrack').text(data.Position.Track);
			 $('#AssignRecruiterTotalPositions').text(data.Position.NoOfPosition);
	 });
});

$("#AssignRecruiterIndexForm").validate({
	 rules: {
		"data[AssignRecruiter][RecruiterId]":{
			required:true,
		//	notEqual: "#AssignRecruiterSecondaryRecruiterId"
		},
		"data[AssignRecruiter][SecondaryRecruiterId]":{
			required:false,
			notEqual: "#AssignRecruiterRecruiterId"
		}
	 }
});

jQuery.validator.addMethod("notEqual", function(value, element, param) {
	 return this.optional(element) || value != $(param).val();
	 }, "This field has to be different from primary recruiter");
	 
</script>
<style>

.error {
    color: #FF0000;
    float: inherit;
    font-size: 12px;
    left: 10px;
    text-align: left;
}
</style>