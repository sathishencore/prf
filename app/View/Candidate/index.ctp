<div class="titlebg" id="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		<?php echo $title_for_layout;?>
	</div>
	<div class="hide" id="toggleCreateshow">&nbsp;</div>
</div>
<?php
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
}else{
		$id='';
	}
	echo $this->Form->create("Candidate",array("url"=>"/Candidate/index/$id","type"=>"file"));
	?>
<div class="bodyconrarea">
	<div class="content" id="createCandidateSection" <?php if(!$id){?>
		style="display:none;" <?php }?>>
		<div class="content-mid">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							align="center">
							<tr>
								<td width="100%">
									<table width="100%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td width="33%">
												<table width="94%" border="0" cellspacing="0"
													cellpadding="4" align="center" class="textfield-cmntxt">
													<tr>
														<td style="">Candidate Name<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php							 
														echo $this->Form->input("Candidate.FirstName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:81px","placeholder"=>"First name"));
														?> <?php
														echo $this->Form->input("Candidate.LastName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:81px;margin-left:3px;","placeholder"=>"Last name"));
														?>
														</td>
													</tr>
													<tr>
														<td>Contact Phone #<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.ContactPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Email<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Email",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>City<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.City",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>State<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.State",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Country<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Country",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Postal Code</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.PostalCode",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Willing to Travel<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td>
															<table style="width: 100%">
																<tr>
																	<td style="width: 44%"><?php echo $this->Form->radio("Candidate.WillingToTravel",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false, "onclick"=>"checkTravelRequired()"));?>
																	</td>
																	<td class="TravelReq" style="width: 35%">Travel % :</td>
																	<td class="TravelReq"><?php 
																	echo $this->Form->select("Candidate.TravelPercent",Configure::read("Position.TravelPercent"),array("empty"=>false,"class"=>"select-small","style"=>"width:100%;"));
																	?>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td>Willing
														to
														Relocate
														?<span
														class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php
														echo
														$this->Form->radio("Candidate.RelocationRequired",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Source</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Source",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Have legal right to work in the country ?</td>
														<td>:</td>
														<td><?php echo $this->Form->radio("Candidate.LegalRightsToWork",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false,"onclick"=>"towork()"));?>
														</td>
													</tr>
													<tr class="futurevisa">
														<td>Will you now or in the future require visa sponsorship for employment from Encore?</td>
														<td>:</td>
														<td><?php echo $this->Form->radio("Candidate.FutureVisaSponsorship",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false,"onclick"=>"towork()"));?>
														</td>
													</tr>
													<tr class="worksponsorship">
														<td>What kind of sponsorship will you need?</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.WhatKindOfSponsorship",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Work sponsorship needed (now or in future)</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.WorkSponsorship",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
												</table>
											</td>
											<td width="33%" style="vertical-align: top;">
												<table width="94%" border="0" cellspacing="0"
													cellpadding="4" align="center" class="textfield-cmntxt">
													<tr>
														<td style="">Role<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Role",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Years Of Experience<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php										
														$attributes=array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false);
														echo $this->Form->input("Candidate.YearsOfExperience",$attributes);
														?>
														</td>
													</tr>
													<tr>
														<td>Education Summary</td>
														<td>:</td>
														<td><?php echo $this->Form->textarea("Candidate.HighestEducationLevel",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>2,"cols"=>"25","placeholder"=>"enter education such as BE (Comp Sc), MBA (Finance)"));?>
														</td>
													</tr>
													<tr>
														<td>Field of Study</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.FieldOfStudy",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Lead time for Interview<span class="errorMandatory">*</span></td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.LeadTimeForInterview",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Lead time for joining<span class="errorMandatory">*</span></td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.LeadTime",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td colspan="3" style="font-weight: bold;">Salary</td>
													</tr>
													<tr>
														<td style="float: right">Currency<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Currency",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td style="float: right">Amount<span class="errorMandatory">*</span></td>
														<td>:</td>
														<?php if(!empty($id) && !empty($this->data['Candidate']['Amount'])) { $amount =  number_format($this->data['Candidate']['Amount'], 2, '.', ',');}else{$amount  ="";};?>
														<td><?php echo $this->Form->input("Candidate.Amount1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"onblur"=>"return noFormat(this)","value"=>$amount));?>
														</td>
													</tr>
													<tr>
														<td style="float: right">Compensation Type<span class="errorMandatory">*</span></td>
														<td>:</td>
														<td><?php echo $this->Form->select("Candidate.CompensationPeriod",Configure::read("Candidate.Compensation"),array("empty"=>"--Select--","class"=>"select-small",));?>
														</td>
													</tr>
													<tr>
														<td style="width: 30%" >Background check done ?<span class="errorMandatory">*</span></td>
														<td>:</td>
														<td><?php echo $this->Form->radio("Candidate.BackgroundCheck",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false,"onChange"=>"disableresult(this.value);"));?>
														</td>
													</tr>
													<tr>
														<td>Background check result ?<span class="errorMandatory">*</span></td>
														<td>:</td>
														<td><?php echo $this->Form->select("Candidate.BackgroundCheckResult",array('Passed'=>"Passed","Failed"=>"Failed"),array("empty"=>"--Select--","class"=>"select-small","id"=>"result"));;?>
														</td>
													</tr>
																		
												</table>
											</td>
											<td width="33%" style="vertical-align: top;">
												<table width="94%" border="0" cellspacing="0"
													cellpadding="4" align="center" class="textfield-cmntxt">
													<tr>
														<td style="">Status<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php if(!$id){
															$value='Pending';
														}else{
													$value=$this->data['Candidate']['Status'];
												}
												echo $this->Form->select("Candidate.Status",Configure::read("Candidate.Status"),array("empty"=>"--Select--","class"=>"select-small","value"=>$value));
												?>
														</td>
													</tr>
													<tr>
														<td>Primary/Technical Skills<span class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->textarea("Candidate.PrimarySkills",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25"));?>
														</td>
													</tr>
													<tr>
														<td>Secondary/Soft Skills</td>
														<td>:</td>
														<td><?php echo $this->Form->textarea("Candidate.SecondarySkills",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25"));?>
														</td>
													</tr>
													<tr>
														<td>Certification</td>
														<td>:</td>
														<td><?php echo $this->Form->input("Candidate.Certification",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
														</td>
													</tr>
													<tr>
														<td>Comments<span id="comments" class="errorMandatory">*</span>
														</td>
														<td>:</td>
														<td><?php echo $this->Form->textarea("Candidate.InterviewComments",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25"));?>
														</td>
													</tr>
													<tr>
														<td>Resume</td>
														<td>:</td>
														<?php if(!empty($id)){?>
														<td class="fileDocument" style="text-align: left;"><?php if(!empty($this->data['Candidate']['ResumeName'])){
															if(file_exists(WWW_ROOT . 'files' . DS . $this->data['Candidate']['ResumeName'])){
																	echo "<a href='".$this->Html->url("/files/").$this->data['Candidate']['ResumeName']."'>".$this->Html->image("word-text.png")."</a>"." (".
																			$this->Html->link("change",array(),array("onclick"=>"return changeResume()")).")";
																}?>
														</td>
														<td class="browseFile"><?php 
														echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false))." ".
											$this->Html->link("hide",array(),array("onclick"=>"return existingResume()","style"=>"margin-left:-16%"));?>
															<?php 
														}
														else{
														echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false));
														}?>
														</td>
														<?php }
													else{?>
														<td style="text-align: left;"><?php echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false));?>
														</td>
														<?php }?>

													</tr>
													
												</table>
											</td>
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
						    "/Candidate/index/",
			array('escape' => false)
			);?>
			&nbsp;
			<?php if(!empty($id) && $delete == 0){ 
				echo $this->Html->link(
						    $this->Html->image("delete-but.png", array("alt" => "Delete","class"=>"Delete")),
						    "/Candidate/delete/$id",
						    array('escape' => false)
						);
}?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php echo $this->element("searchCandidate");?>
<script>

$("#CandidateContactPhone").mask("+1 (888) 888-8888");
$(".browseFile").hide();
$(".futurevisa").hide();
$(".worksponsorship").hide();

window.onload = onload();
function onload(){
	towork();
}

function towork(){
if($("input[name='data[Candidate][LegalRightsToWork]']:checked").val() == 'No'){
	$(".futurevisa").show();
		if($("input[name='data[Candidate][FutureVisaSponsorship]']:checked").val() == 'Yes'){
			$(".worksponsorship").show();
		}else{
			$(".worksponsorship").hide();
			$("#CandidateWhatKindOfSponsorship").val('');
		}
	}
else{
	$(".futurevisa").hide();
	$(".worksponsorship").hide();
	$("input[name='data[Candidate][FutureVisaSponsorship]']").attr('checked',false);
	$("#CandidateWhatKindOfSponsorship").val('');
}
}

function changeResume(){
	$(".browseFile").show();
	$(".fileDocument").hide();
	return false;
}
function existingResume(){
	$(".browseFile").hide();
	$(".fileDocument").show();
	return false;
}

$("#comments").hide();

$("#CandidateStatus").change( function(){
	if($("#CandidateStatus").val() == "Unsuitable"){
		$("#comments").show();
		$("#CandidateInterviewComments").attr("placeholder","Enter unsuitability reasons");
	}
	else{
		$("#comments").hide();
		$("#CandidateInterviewComments").attr("placeholder","");
	}
});

$(document).ready(function(){
	<?php $year=date('Y')-18;?>
	$(".dobDatepicker").datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true,changeYear: true,yearRange: '1950:<?php echo $year;?>'});
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0});
	 $("#toggleCreateshow,#toggleCreateshow1").click(function(){
		 $("#createCandidateSection").toggle();
		 $("#toggleCreateshow").toggleClass("show hide");	
	 });
	 $(".datepicker").attr("readonly","readonly");
	 $("#toggleshow").click(function(){
		 $("#searchCandidate").toggle();
		 $("#toggleshow").toggleClass("show hide");
	 });
	
	 $("#CandidateIndexForm").validate({
		 rules: {
			"data[Candidate][FirstName]":{
				required:true
			},
			"data[Candidate][LastName]":"required",
			"data[Candidate][Role]":"required",
			"data[Candidate][YearsOfExperience]":{
				required:true,
				number:true,
				min: 1
			},
			"data[Candidate][ContactPhone]":"required",
			"data[Candidate][Salary]":"required",
			"data[Candidate][ClientID]":"required",
			"data[Candidate][ProjectID]":"required",
			"data[Candidate][PositionID]":"required",
			"data[Candidate][InterviewDate1]":"required",
			"data[Candidate][InterviewPerson]":"required",
			"data[Candidate][RelocationRequired]":"required",
			"data[Candidate][InterviewRate]":{				
				number:true,
				min:1,
				max:10
			},
			"data[Candidate][Status]":"required",
			"data[Candidate][City]":"required",
			"data[Candidate][State]":"required",
			"data[Candidate][WillingToTravel]":"required",
			"data[Candidate][Currency]":"required",
			"data[Candidate][CompensationPeriod]":"required",
			"data[Candidate][Amount1]":"required",
			"data[Candidate][Country]":"required",
			"data[Candidate][PrimarySkills]":"required",
			"data[Candidate][LeadTimeForInterview]":"required",
			"data[Candidate][LeadTime]":"required",
			"data[Candidate][BackgroundCheck]":"required",
			"data[Candidate][BackgroundCheckResult]":"required",
			"data[Candidate][Email]":{
				required:true,
				email:true
			},
			"data[Candidate][InterviewComments]": {
				required:function(element) {
					 if(jQuery.trim($("#CandidateStatus").val())!='Unsuitable'){
					        return false;
				        }else{
					        return true;
				        } 
			     },
			},
			"data[Candidate][ResumeNames]":{
				extension: "doc|docx"
			}
		 },
		 messages:{
			 "data[Candidate][ResumeNames]":{
				 extension : "Please upload a document file"
			 },"data[Candidate][FirstName]":{
					required:"*"
				},
				"data[Candidate][LastName]":"*",
			 
		 }
			 
	 });
	 jQuery.extend(jQuery.validator.messages, {
		   // required: "*",	
		//    remote:"Your request already either is being processed or was approved on the interval"
		});
		
	 $("#CandidateClientID").change(function(){
		 $("#CandidateProjectID").html('');
		 $("#CandidatePositionID").html('');
		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Client/getProject");?>",
			 data: { PositionId:$("#CandidateClientID").val() }
			 }).done(function( msg ) {
				 $("#CandidateProjectID").html(msg);
		 });
	 });

	 $("#CandidateProjectID").change(function(){
		 $("#CandidatePositionID").html('');
		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Position/getRequest");?>",
			 data: { ProjectId:$("#CandidateProjectID").val(),ClientId:$("#CandidateClientID").val() }
			 }).done(function( msg ) {
				 $("#CandidatePositionID").html(msg);
		 });
	 });
});

window.onload = onLoad;
function onLoad(){
	checkTravelRequired();
}

var checkTravelRequired=function(){		 
	if($("#CandidateWillingToTravelNo").is(":checked")){
		$('#CandidateTravelPercent').val("0");
		 $('.TravelReq').hide();
	 }else{
		 $('.TravelReq').show();
	 }
};

$(".Delete").click( function(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
});

function noFormat(data){
	vals = data.value;
	var newvals = vals.replace(/[,]+/g, "");
	if(vals != ''){
	$("#"+data.id).val((parseFloat(newvals)).format());
	}
	else{
		$("#"+data.id).val('');
	}

}

Number.prototype.format = function() {
    return this.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
};

function disableresult(value){
	//alert(value);
	if (value == 'No') {
		document.getElementById("result").disabled='disabled';
		
	}
	else{
		document.getElementById("result").disabled=false;
	}
}

</script>

