<div class="titlebg" id="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		<?php echo $title_for_layout;?>
	</div>
	<div class="show" id="toggleCreateshow">&nbsp;</div>
</div>
<?php
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
	$DOB=$this->data['Candidate']['DateOfBirth'];
}else{
		$id='';
		$DOB='';
	}
	echo $this->Form->create("Candidate",array("url"=>"/Candidate/index/$id","type"=>"file"));
	?>
<div class="bodyconrarea">
	<div class="content" id="createCandidateSection" <?php if(!$id){?>
		style="display: none;" <?php }?>>
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
											<td style="width: 10%;">Candidate Name<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php							 
											echo $this->Form->input("Candidate.FirstName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:81px","placeholder"=>"First name","tabindex"=>"1"));
											?> <?php
											echo $this->Form->input("Candidate.LastName",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:81px;margin-left:3px;","placeholder"=>"Last name","tabindex"=>"2"));
											?>
											</td>
											<td style="width: 10%;">Role<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Role",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"14"));?>
											</td>
											<td style="width: 11%;">Status<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php if(!$id){
												$value='Pending';
											}else{
													$value=$this->data['Candidate']['Status'];
												}
												echo $this->Form->select("Candidate.Status",Configure::read("Candidate.Status"),array("empty"=>"--Select--","class"=>"select-small","value"=>$value,"tabindex"=>"22"));
												?>
											</td>
										</tr>
										<tr>
											<td>Contact Phone #<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.ContactPhone",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"3"));?>
											</td>
											<td>Years Of Experience<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php										
											$attributes=array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"15");
											echo $this->Form->input("Candidate.YearsOfExperience",$attributes);
											?></td>
											<td rowspan="3">Primary/Technical Skills<span
												class="errorMandatory">*</span>
											</td>
											<td rowspan="3">:</td>
											<td rowspan="3"><?php echo $this->Form->textarea("Candidate.PrimarySkills",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25","tabindex"=>"23"));?>
											</td>
										</tr>
										<tr>
											<td>Email<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Email",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"4"));?>
											</td>
											<td>Education Summary</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.HighestEducationLevel",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"placeholder"=>"enter education such as BE (Comp Sc), MBA (Finance)","tabindex"=>"16"));?>
											</td>
										</tr>
										<tr>
											<td>City<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.City",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"5"));?>
											</td>
											<td>Lead time for joining</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.LeadTimeForJoining",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"17"));?>
											</td>
										</tr>
										<tr>
											<td>State<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.State",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"6"));?>
											</td>
											<td colspan="3" style="font-weight: bold;">Salary</td>
											<td rowspan="3">Secondary/Soft Skills</td>
											<td rowspan="3">:</td>
											<td rowspan="3"><?php echo $this->Form->textarea("Candidate.SecondarySkills",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25","tabindex"=>"24"));?>
											</td>
										</tr>
										<tr>
											<td>Country<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Country",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"7"));?>
											</td>
											<td>Currency<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Currency",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"18"));?>
											</td>
										</tr>
										<tr>
											<td>Postal Code</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.PostalCode",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"8"));?>
											</td>
											<td style="float: right">Salary FT Annual</td>
											<td>:</td>
											<td style="float: left"><?php echo $this->Form->input("Candidate.SalaryFt",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:100px","tabindex"=>"19"));?>
											</td>
										</tr>
										<tr>
											<td>Willing to Travel<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td>
												<table>
													<tr>
														<td><?php echo $this->Form->radio("Candidate.WillingToTravel",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false, "onclick"=>"checkTravelRequired()","tabindex"=>"9"));?>
														</td>
														<td>&nbsp;</td>
														<td class="TravelReq">Travel % :</td>
														<td class="TravelReq"><?php 
														echo $this->Form->select("Candidate.TravelPercent",Configure::read("Position.TravelPercent"),array("empty"=>false,"class"=>"select-small","style"=>"width:100%;","tabindex"=>"10"));
														?>
														</td>
													</tr>
												</table>
											</td>
											<td style="float: right">Salary Hourly</td>
											<td>:</td>
											<td style="float: left"><?php echo $this->Form->input("Candidate.SalaryHourly",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:100px","tabindex"=>"20"));?>
											</td>
											<td>Certification</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Certification",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"25"));?>
											</td>
										</tr>
										<tr>
											<td>Willing to Relocate ?<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->radio("Candidate.RelocationRequired",array("Yes"=>"Yes","No"=>"No"),array("label"=>false,"legend"=>false,"div"=>false,"tabindex"=>"11"));?>
											</td>
											<td style="float: right">Corp-to-Corp Hourly</td>
											<td>:</td>
											<td style="float: left"><?php echo $this->Form->input("Candidate.CorpToCorp",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:100px","tabindex"=>"21"));?>
											</td>
											<td rowspan="2">Comments<span id="comments"
												class="errorMandatory">*</span>
											</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><?php echo $this->Form->textarea("Candidate.InterviewComments",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>3,"cols"=>"25","tabindex"=>"26"));?>
											</td>

										</tr>
										<tr>
											<td>Source</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Candidate.Source",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"13"));?>
											</td>
										</tr>
										<tr>
											<td colspan="6"></td>
											<td>Resume</td>
											<td>:</td>
											<?php if(!empty($id)){?>
											<td class="fileDocument" style="text-align: left;" colspan=4>
												<?php if(!empty($this->data['Candidate']['ResumeName'])){
													if(file_exists(WWW_ROOT . 'files' . DS . $this->data['Candidate']['ResumeName'])){
																	echo "<a href='".$this->Html->url("/files/").$this->data['Candidate']['ResumeName']."'>".$this->Html->image("word-text.png")."</a>"." (".
																			$this->Html->link("change",array(),array("onclick"=>"return changeResume()")).")";
}?>
											</td>
											<td class="browseFile"><?php 
											echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false,"tabindex"=>"27"))." ".
											$this->Html->link("hide",array(),array("onclick"=>"return existingResume()","style"=>"margin-left:-16%"));?>
												<?php 
												}
												else{
														echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false,"tabindex"=>"27"));
														}?>
											</td>
											<?php }
													else{?>
											<td style="text-align: left;" colspan=4><?php echo $this->Form->file("Candidate.ResumeNames",array("label"=>false,"style"=>"float:left","div"=>false,"tabindex"=>"27"));?>
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
		</div>
		<div class="buttonalign">
			<?php
			echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/save-but.png","div"=>false,"tabindex"=>"28"));
			?>
			&nbsp;
			<?php
			echo $this->Html->link(
			$this->Html->image("cancel-inner-but.png", array("alt" => "Cancel","tabindex"=>"29")),
						    "/Candidate/index/",
			array('escape' => false)
			);?>
			&nbsp;
			<?php if(!empty($id) && $delete == 0){ 
				echo $this->Html->link(
						    $this->Html->image("delete-but.png", array("alt" => "Delete","class"=>"Delete","tabindex"=>"30")),
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

$(".browseFile").hide();
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
	}
	else{
		$("#comments").hide();
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
			"data[Candidate][Country]":"required",
			"data[Candidate][PrimarySkills]":"required",
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

</script>
