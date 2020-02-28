<?php
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
	$startDate=$this->data['Position']['StartDate'];
	$endDate=$this->data['Position']['EndDate'];
}else{
	$id='';
	$startDate='';
	$endDate='';
}
if($editAction) {
	?>
<div class="titlebg" id="titlebg">
	<div class="titletxt" id="toggleCreateshow1" style="cursor: pointer;">
		<?php echo $title_for_layout;?>
	</div>
	<?php if($title_for_layout=='Update Position') {
	?>
	<div class="hide" id="toggleCreateshow">&nbsp;</div>
	<?php } else { ?>
	<div class="show" id="toggleCreateshow">&nbsp;</div>
	<?php } ?>
</div>
<?php		
echo $this->Form->create("Position",array("url"=>"/Position/index/$id"));
?>
<div class="bodyconrarea">
	<div class="content" id="createPositionSection" <?php if(!$id){?>
		style="display:none;" <?php }?>>
		<div class="content-mid">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							align="center">
							<tr>
								<td width="33%" style="vertical-align: top;">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td style="width: 35%">Client Name<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											$searchClient = $this->Session->read("PositionIndexForm.ClientID");
											echo $this->Form->select("Position.ClientID",$clientList,array("empty"=>"--Select--","class"=>"select-small","value"=>$searchClient));?>
											</td>
										</tr>
										<tr>
											<td style="width: 13%">Project Name<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											$searchProj = $this->Session->read("PositionIndexForm.ProjectName");
											echo $this->Form->select("Position.ProjectID",$projectList,array("empty"=>"--Select--","class"=>"select-small","value"=>$searchProj));?>
											</td>
										</tr>
										<tr>
											<?php if(!empty($RequisitionNumber)) { ?>
											<td>Requisition Number</td>
											<td>:</td>
											<td><label><?php echo substr_replace($RequisitionNumber, "-", -3,0); ?> </label>
											</td>
											<?php }?>
										</tr>
										<tr>
											<td>Start Date<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
if ($this->Session->check("PositionIndexForm.StartDate")){
	$startDate = $this->Session->read("PositionIndexForm.StartDate");
}

echo $this->Form->input("Position.StartDate1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small datepicker","div"=>false,"value"=>$startDate,"readonly"=>true,"tabindex"=>"4"));?>
											</td>
										</tr>
										<tr>
											<td>End Date</td>
											<td>:</td>
											<td><?php
if ($this->Session->check("PositionIndexForm.EndDate")){
	$endDate = $this->Session->read("PositionIndexForm.EndDate");
}
 echo $this->Form->input("Position.EndDate1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small datepicker","div"=>false,"value"=>$endDate,"tabindex"=>"5"));?>
											</td>
										</tr>
										<tr>
											<td style="width: 13%">Client Requisition Ref</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Position.ClientRequisitionRef",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
											</td>
										</tr>
										<tr>
											<td style="width: 13%">Role<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											 $new_role = array('NEWRole' => 'Create New Role');
											 $role_arr =  array('NEWRole' => "Create New Role" ) + $roles;
											
											 echo $this->Form->input('Position.RoleId',array('type' => 'select', "empty"=>"---Select---","style"=>"width:200px;","class"=>"select-small", "label"=>false,'options' => $role_arr)); ?>
											</td>
										</tr>
										<tr>
											<td>Track<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Position.Track",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
											</td>
										</tr>
										<tr>
											<td>Work Location<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											 $new_arr = array('NEWLocation' => 'Create New Location');
											 $result_arr = array_merge($new_arr, $worklocationdistinctList);
											 echo $this->Form->select("Position.WorkLocation",$result_arr,array("empty"=>"---Select---","style"=>"width:200px;","class"=>"select-small"));
										//input("Position.WorkLocation",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false)); ,"onChange"=>"check(this);"?>
											</td>
										</tr>
										<tr>
											<td>Client Hiring Manager</td>
											<td>:</td>
											<td><div id="ClientContactName"><?php if(!empty($ClientContact)) { 
												//echo $ClientContact;
												if(isset($ClientContacts))
													echo $this->Form->select("Position.HiringManagerID1",$ClientContacts,array("empty"=>false,"class"=>"select-small"));
												else{
													echo $ClientContact;													
												}												
											}?> </div>
											<?php echo $this->Form->hidden("Position.HiringManagerID",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:100px"));?>
											</td>
										</tr>
										<tr>
											<td>Encore Screening Manager<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Position.ScreeningManager",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
											</td>
										</tr>
										<tr>
											<td>Number Of Positions<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Position.NoOfPosition",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false));?>
											</td>
										</tr>
										<tr>
											<td>Primary Recruiter</td>
											<td>:</td>
											<td><label id=""><?php if(!empty($PositionData['Position']['RecruiterId']) && !isset($ClientContacts)) { 
												//echo $RecruiterList[$PositionData['Position']['RecruiterId']];
											if(isset($RecruiterList[$PositionData['Position']['RecruiterId']])) {
													echo $RecruiterList[$PositionData['Position']['RecruiterId']];
												}
												else {
												 echo "";
												}
											}?> </label>
											</td>
										</tr>
										<tr>
											<td>Secondary Recruiter</td>
											<td>:</td>
											<td><label id=""><?php if(!empty($PositionData['Position']['SecondaryRecruiterId']) && !isset($ClientContacts)) {
												if(isset($RecruiterList[$PositionData['Position']['SecondaryRecruiterId']])) {
													echo $RecruiterList[$PositionData['Position']['SecondaryRecruiterId']];
												}
												else {
												 echo "";
												}
												
											}?> </label>
											</td>
										</tr>
										<tr>
											<td>Priority</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Position.Priority",Configure::read("Position.Priority"),array("empty"=>"--Select--","class"=>"select-small"));?>
											</td>
										</tr>
										<tr>
											<td>Position Status<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											echo $this->Form->select("Position.Status",Configure::read("Position.Status"),array("empty"=>"--Select--","class"=>"select-small"));
											?>
											</td>
										</tr>
									</table>
								</td>
								<td width="33%" style="vertical-align: top;">
									<table width="94%" style="margin-top:0px;" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td colspan="3" style="font-weight: bold;">Billing Rate</td>
										</tr>
										<tr>
											<td style="float: right;">Rate<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Position.BillingRate",array("label"=>false,"class"=>"textfield-cmn calculation textfield-cmn-small","div"=>false,"onkeyup"=>"salaryCalculation()"));?>
											</td>
										</tr>
										<tr>
											<td style="float: right">Unit of Measure<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Position.UnitOfMeasure",Configure::read("Position.UnitOfMeasure"),array("empty"=>false,"class"=>"select-small"));?>
											</td>
										</tr>
										<tr>
											<td style="font-weight: bold">Cost Rate</td>
										</tr>
										<tr>
											<td style="float: right">Minimum Margin<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td style="float: left"><?php echo $this->Form->input("Position.MinimumMargin",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small calculation","div"=>false,"style"=>"width:80%","onkeyup"=>"salaryCalculation()"));?>%
											</td>
										</tr>
										<tr>
											<td style="float: right">Currency<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td style="float: left"><?php echo $this->Form->input("Position.Currency",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:85%"));?>
											</td>
										</tr>
										<tr>
											<td style="float: right;">Salary Annual FT</td>
											<td>:</td>
											<?php if(!empty($id) && !empty($this->data['Position']['SalaryFt'])) { $salaryFt =  number_format($this->data['Position']['SalaryFt'], 2, '.', ',');}else{$salaryFt="";};?>
											<td style="float: left;"><?php echo $this->Form->input("Position.SalaryFt",array("label"=>false,"type"=>"text","class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:85%","value"=>$salaryFt));?>
											</td>
										</tr>
										<tr>
											<td style="float: right">Salary Hourly</td>
											<td>:</td>
											<?php if(!empty($id) && !empty($this->data['Position']['SalaryHourly'])) { $salaryHourly =  number_format($this->data['Position']['SalaryHourly'], 2, '.', ',');;}else{$salaryHourly="";};?>
											<td style="float: left"><?php echo $this->Form->input("Position.SalaryHourly",array("label"=>false,"type"=>"text","class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:85%","value"=>$salaryHourly));?>
											</td>
										</tr>
										<tr>
											<td style="float: right">Corp-to-Corp Hourly</td>
											<td>:</td>
											<?php if(!empty($id) && !empty($this->data['Position']['CorpToCorp'])) { $salaryC2C=  number_format($this->data['Position']['CorpToCorp'], 2, '.', ',');;}else{$salaryC2C="";};?>
											<td style="float: left"><?php echo $this->Form->input("Position.CorpToCorp",array("label"=>false,"type"=>"text","class"=>"textfield-cmn textfield-cmn-small","div"=>false,"style"=>"width:85%","value"=>$salaryC2C));?>
											</td>
										</tr>

									</table>
								</td>
								<td width="33%">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td width="30%">Background Check Required</td>
											<td>:</td>
											<?php $attr=array('hiddenField' => false,"type"=>"checkbox");?>
											<td><?php if(isset($this->data['Position']) && $this->data['Position']['BackgroundCheckRequired']== 'Yes'){
															$attr['value']=1;
															$attr['checked']="checked";
														}else{
															$attr['value']=0;
												} 
											 echo $this->Form->check('Position.BackgroundCheckRequired',$attr);?>
											</td>
										</tr>
										<tr>
											<td>Relocation Required?<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->radio("Position.RelocationRequired",array("Yes"=>"Yes","No"=>"No"),array("legend"=>false));?>
											</td>
										</tr>
										<tr>
											<td>Travel Required?<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td>
												<table>
													<tr>
														<td><?php echo $this->Form->radio("Position.TravelRequired",array("Yes"=>"Yes","No"=>"No"),array("legend"=>false,"onclick"=>"checkTravelRequired()"));?>
														</td>
														<td>&nbsp;</td>
														<td class="TravelReq">Travel % :</td>
														<td class="TravelReq"><?php 
														echo $this->Form->select("Position.TravelPercent",Configure::read("Position.TravelPercent"),array("empty"=>false,"class"=>"select-small","style"=>"width:100%;"));
														?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>Travel Billable<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><table>
													<tr>
														<td><?php echo $this->Form->radio("Position.Billable",array("Yes"=>"Yes","No"=>"No"),array("legend"=>false,"onclick"=>"checkBillable()"));?>
														</td>
														<td>&nbsp;</td>
														<td class="TravelBill">Travel % :</td>
														<td class="TravelBill"><?php 
														echo $this->Form->select("Position.BillablePercent",Configure::read("Position.TravelPercent"),array("empty"=>false,"class"=>"select-small","style"=>"width:100%;"));
														?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td>Core Skill<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php 
											 $new_skill = array('NEWSkill' => 'Create New Skill');
											 $skill_arr =  array('NEWSkill' => "Create New Skill" ) + $skills;
											
												echo $this->Form->input('Position.CoreSkills',array('type' => 'select', "empty"=>"---Select---","style"=>"width:200px;","class"=>"select-small", 'options' => $skill_arr, "label"=>false,'selected'=>$core_skill));	?>										 
											</td>
										</tr>
										<tr>
											<td>Essential Skills<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php
											 $new_skill = array('NEWSkill' => 'Create New Skill');
											 $skill_arr =  array('NEWSkill' => "Create New Skill" ) + $skills;
												echo $this->Form->input('Position.EssentialSkills',array('type' => 'select', "empty"=>"---Select---","style"=>"width:200px;","class"=>"select-small", 'options' => $skill_arr, 'selected' => $essential_skill,'multiple' => 'true',"label"=>false,'required'=>'true'));											 
											?>
											</td>
										</tr>
										<tr>
											<td>Desirable Skills</td>
											<td>:</td>
											<td><?php
											  $new_skill = array('NEWSkill' => 'Create New Skill');
											 $skill_arr =  array('NEWSkill' => "Create New Skill" ) + $skills;
												echo $this->Form->input('Position.DesirableSkills',array('type' => 'select', "empty"=>"---Select---","style"=>"width:200px;","class"=>"select-small", 'options' => $skill_arr, 'selected' => $desirable_skill,'multiple' => 'true',"label"=>false));											 
											?>
											</td>
										</tr>
										<tr>
											<td>Notes</td>
											<td>:</td>
											<td><?php echo $this->Form->textarea("Position.Notes",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>2,"cols"=>"25"));?>
											</td>
										</tr>
										<tr>
											<td>Job Description</td>
											<td>:</td>
											<td><?php echo $this->Form->textarea("Position.JobDescription",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>9,"cols"=>"25"));?>
											</td>
										</tr>

									</table>
								</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>
			<table style="font: arial;font-size: 12px">
				<tr>
					<td width="13%" >Preferred Source</td>
					<td>:</td>
					<td colspan="3"><?php
					$usattr=array('hiddenField' => false,'label'=>'US-Based Employee',"type"=>"checkbox");
					$usattr1=array('hiddenField' => false,'label'=>'OffShore Employee-Offshore',"type"=>"checkbox");
					$usattr2=array('hiddenField' => false,'label'=>'OffShore Employee-Onsite',"type"=>"checkbox");
					$usattr3=array('hiddenField' => false,'label'=>'New-hire full time',"type"=>"checkbox");
					$usattr4=array('hiddenField' => false,'label'=>'Project Hire',"type"=>"checkbox");
					$usattr5=array('hiddenField' => false,'label'=>'Sub contractor',"type"=>"checkbox");
					$usattr6=array('hiddenField' => false,'label'=>'Contract to Hire',"type"=>"checkbox");
					$usattr7=array('hiddenField' => false,'label'=>'No preference',"type"=>"checkbox");
					$usattr8=array('hiddenField' => false,'label'=>'Direct Hire by Client',"type"=>"checkbox");
					
					//USBased
					if(isset($this->data['Position']) && $this->data['Position']['USBased']== 'Yes'){
														$usattr['value']=1;
														$usattr['checked']="checked";
												}else{
														$usattr['value']=0;
														$usattr['checked']=false;

												}
												echo $this->Form->input('Position.USBased',$usattr);

												//	OffShoreOffshore
												if(isset($this->data['Position']) && $this->data['Position']['OffShoreOffshore']=='Yes'){
													$usattr1['value']=1;
													$usattr1['checked']="checked";
												}else{
													$usattr1['value']=0;
													$usattr1['checked']=false;
												}
												echo $this->Form->input('Position.OffShoreOffshore',$usattr1);

												//OffShoreOnsite
												if(isset($this->data['Position']) && $this->data['Position']['OffShoreOnsite']=='Yes'){
												 	$usattr2['value']=1;
												 	$usattr2['checked']="checked";
												 }else{
												 	$usattr2['value']=0;
                                                    $usattr2['checked']=false;
                                                }
												 echo $this->Form->input('Position.OffShoreOnsite', $usattr2);

												 //NewHireFullTime
												 if(isset($this->data['Position']) && $this->data['Position']['NewHireFullTime']=='Yes'){
												 	$usattr3['value']=1;
												 	$usattr3['checked']="checked";
												 }else{
												 	$usattr3['value']=0;
                                                     $usattr3['value']=false;
												 }
												 echo $this->Form->input('Position.NewHireFullTime',$usattr3);

												 //ProjectHire
												 if(isset($this->data['Position']) && $this->data['Position']['ProjectHire']=='Yes'){
												 	$usattr4['value']=1;
												 	$usattr4['checked']="checked";
												 }else{
												 	$usattr4['value']=0;
                                                     $usattr4['value']=false;
												 }
												 echo $this->Form->input('Position.ProjectHire',$usattr4);

												 //SubContractor
												 if(isset($this->data['Position']) && $this->data['Position']['SubContractor']=='Yes'){
												 	$usattr5['value']=1;
												 	$usattr5['checked']="checked";
												 }else{
												 	$usattr5['value']=0;
                                                     $usattr5['value']=false;
												 }
												 echo $this->Form->input('Position.SubContractor', $usattr5);

												 //ContractToHire
												 if(isset($this->data['Position']) && $this->data['Position']['ContractToHire']=='Yes'){
												 	$usattr6['value']=1;
												 	$usattr6['checked']="checked";
												 }else{
												 	$usattr6['value']=0;
                                                     $usattr6['value']=false;
												 }
												 echo $this->Form->input('Position.ContractToHire',$usattr6);
												 
												 //DirectHireByClient
												 if(isset($this->data['Position']) && $this->data['Position']['DirectHireByClient']=='Yes'){
												 	$usattr8['value']=1;
												 	$usattr8['checked']="checked";
												 }else{
												 	$usattr8['value']=0;
                                                     $usattr8['value']=false;
												 }
												 echo $this->Form->input('Position.DirectHireByClient', $usattr8);

												 //NoPreference
												 if(isset($this->data['Position']) && $this->data['Position']['NoPreference']=='Yes'){
												 	$usattr7['value']=1;
												 	$usattr7['checked']="checked";
												 }else{
												 	$usattr7['value']=0;
                                                     $usattr7['value']=false;
												 }
												 echo $this->Form->input('Position.NoPreference', $usattr7);
												 ?>
												 
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
						    "/Position/index/",
						    array('escape' => false)
						);?>
			&nbsp;
			<?php if(!empty($id) && $delete == 0){ 
				echo $this->Html->link(
						    $this->Html->image("delete-but.png", array("alt" => "Delete","class"=>"Delete")),
						    "/Position/delete/$id",
						    array('escape' => false)
						);
}?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php }?>
<?php echo $this->element("searchPosition");?>
<div id="dialog-modal-create" title="Add New Location">&nbsp;</div>
<div id="dialog-modal-success" title="Add New Location">
&nbsp;
<h1 style="font-size: 100%;margin-left: 7px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
New Location Added Successfully</h1></div>
<div id="dialog-skill-create" title="Add New Skill">&nbsp;</div>
<div id="dialog-skill-success" title="Add New Skill">
&nbsp;
<h1 style="font-size: 100%;margin-left: 7px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
New Skill Added Successfully</h1></div>
<div id="dialog-Eskill-create" title="Add New Skill">&nbsp;</div>
<div id="dialog-Eskill-success" title="Add New Skill">
&nbsp;
<h1 style="font-size: 100%;margin-left: 7px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
New Skill Added Successfully</h1></div>
<div id="dialog-Dskill-create" title="Add New Skill">&nbsp;</div>
<div id="dialog-Dskill-success" title="Add New Skill">
&nbsp;
<h1 style="font-size: 100%;margin-left: 7px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
New Skill Added Successfully</h1></div>

<div id="dialog-role-create" title="Add New Role">&nbsp;</div>
<div id="dialog-role-success" title="Add New Role">
&nbsp;
<h1 style="font-size: 100%;margin-left: 7px;margin-bottom: 1%;margin-top: auto;color: #DA6709;">
New Role Added Successfully</h1></div>
<script>
//$('.TravelReq').hide();
//$('.TravelBill').hide();
window.onload = onLoad;
function onLoad(){
	checkTravelRequired();
	checkBillable();	
}
$('#PositionWorkLocation').on('change', function() {
	var users = ""; 

	if($(this).val()=='NEWLocation') {
		 users +="<form name='loc_form' id='loc_form'><label style='font-size: 110%;margin-left:4%;color: #be5e00;'></label></h1>";
         users +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
     users += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>City</td><td>:</td><td><input type='text' name='City' id='City' class='Location'></td></tr>";
     users += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>State</td><td>:</td><td><input type='text' name='State' id='State' class='Location'></td></tr>";
     users += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Country</td><td>:</td><td><input type='text' name='Country' id='Country' class='Location'></td></tr>";
     users +="<tr><td colspan='3'><input type='button' style='float:right;' name='Loc' id='Loc' value='Create'  ></td></tr></table></form>";
     
     $('#dialog-modal-create').html(users); 
     
	     $(function() {
				
			 $( "#dialog-modal-create" ).dialog({
				 width:400,
				 height:400,
			 	 modal: true
			 });
		});
	}
	$("#Loc").click(function(){
		//alert('Yes');
		var City = $("#City").val();
		var State = $("#State").val();
		var Country = $("#Country").val();
		// Returns successful data submission message when the entered information is stored in database.
		var dataString = 'City='+ City + '&State='+ State + '&Country='+ Country;
		if(City==''||State==''||Country=='')
		{
		alert("Please Fill All Fields");
		}
		else if((Country!='India')&&(Country!='USA')) {
			alert("Country should be either USA or India");
		}
		else
		{
		// AJAX Code To Submit Form.
		$.ajax({
		type: "POST",
		data: dataString,
		url: "<?php echo $this->Html->url("/Position/add_location");?>",
		success: function(result){
			//alert(result);
			$("#dialog-modal-create").dialog('close');
			
			$(function() {
				
				 $( "#dialog-modal-success" ).dialog({
					 width:320,
					 height:120,
				 	 modal: true
				 });
			});
			setTimeout(function(){ $("#dialog-modal-success").dialog("close")}, 1000);
		}
		});

		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Position/workLoc");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#PositionWorkLocation").html('');
				 $("#PositionWorkLocation").html(msg);
				 $("#PositionWorkLocation").trigger("liszt:updated");
		 });
		}
		return false;
		});
	
	
	  
});
$('#PositionCoreSkills').on('change', function() {
	var skills = ""; 
	if($(this).val()=='NEWSkill') {
		 skills +="<form name='skill_form' id='loc_form'><label style='font-size: 110%;margin-left:4%;color: #be5e00;'></label></h1>";
         skills +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
		 skills += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Skill</td><td>:</td><td><input type='text' name='Skill' id='Skill' class='coreSkills'></td></tr>";
		 skills +="<tr><td colspan='3'><input type='button' style='float:right;' name='Addskill' id='Addskill' value='Create'  ></td></tr></table></form>";
     
     $('#dialog-skill-create').html(skills); 
     
	     $(function() {
				
			 $( "#dialog-skill-create" ).dialog({
				 width:400,
				 height:200,
			 	 modal: true
			 });
		});
	}
	$("#Addskill").click(function(){
		var skill = $("#Skill").val();
		var dataString = 'skill='+ skill;
		if(skill=='')
		{
			alert("Please Fill Skill Field");
		}
		else
		{
		if(dataString.length > 50){
			alert("Please input CoreSkill value  between 0 and 50 characters long");
		}else{
		// AJAX Code To Submit Form.
		$.ajax({
		type: "POST",
		data: dataString,
		url: "<?php echo $this->Html->url("/Skill/add_skill");?>",
		success: function(result){
			if(result =='true'){
			$("#dialog-skill-create").dialog('close');
			
			$(function() {
				 $( "#dialog-skill-success" ).dialog({
					 width:320,
					 height:120,
				 	 modal: true
				 });
			});
			setTimeout(function(){ $("#dialog-skill-success").dialog("close")}, 1000);
		}
		else{
			alert("Skill already exist in database");
				$("#dialog-skill-create").dialog('close');
		}
		}
		});

		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#PositionCoreSkills").html('');
				 $("#PositionCoreSkills").html(msg);
				 $("#PositionCoreSkills").trigger("liszt:updated");
		 }); 
		}
		}
		return false;
		});
});
$('#PositionRoleId').on('change', function() {
	var roles = ""; 
	if($(this).val()=='NEWRole') {
		 roles +="<form name='role_form' id='loc_form'><label style='font-size: 110%;margin-left:4%;color: #be5e00;'></label></h1>";
         roles +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
		roles += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Role</td><td>:</td><td><input type='text' name='Role' id='Role' class='NewRole'></td></tr>";
		roles +="<tr><td colspan='3'><input type='button' style='float:right;' name='AddRole' id='AddRole' value='Create'  ></td></tr></table></form>";
     
     $('#dialog-role-create').html(roles); 
     
	     $(function() {
				
			 $( "#dialog-role-create" ).dialog({
				 width:400,
				 height:200,
			 	 modal: true
			 });
		});
	}
	$("#AddRole").click(function(){
		//alert('Yes');
		var role = $("#Role").val();
		var dataString = 'role='+ role;
		if(role=='')
		{
			alert("Please Fill Role Field");
		}
		else
		{
		
			// AJAX Code To Submit Form.
			$.ajax({
			type: "POST",
			data: dataString,
			url: "<?php echo $this->Html->url("/ProjectRole/add_role");?>",
			success: function(result){
				if(result == 'true'){
					$("#dialog-role-create").dialog('close');			
					$(function() {
						 $( "#dialog-role-success" ).dialog({
							 width:320,
							 height:120,
							 modal: true
						 });
					});
					setTimeout(function(){ $("#dialog-role-success").dialog("close")}, 1000);
				}
				else{
					alert("Role already exist in database");
					$("#dialog-role-create").dialog('close');
			}
			}
			});
			 $.ajax({
				 type: "POST",
				 url: "<?php echo $this->Html->url("/ProjectRole/role_list");?>",
				 data: { user:"yes" }
				 }).done(function( msg ) {
					 //alert(msg);
					 $("#PositionRoleId").html('');
					 $("#PositionRoleId").html(msg);
					 $("#PositionRoleId").trigger("liszt:updated");
			 }); 
		}
		return false;
		});
});
$('#PositionEssentialSkills').on('change', function() {
	var skills = ""; 
	if($(this).val()=='NEWSkill') {
		skills +="<form name='skill_form' id='loc_form'><label style='font-size: 110%;margin-left:4%;color: #be5e00;'></label></h1>";
        skills +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
		skills += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Skill</td><td>:</td><td><input type='text' name='Skill' id='EssentialSkill' class='essentialSkills'></td></tr>";
		skills +="<tr><td colspan='3'><input type='button' style='float:right;' name='AddEssentialSkill' id='AddEssentialSkill' value='Create'  ></td></tr></table></form>";
     
     $('#dialog-Eskill-create').html(skills); 
	     $(function() {
				
			 $( "#dialog-Eskill-create" ).dialog({
				 width:400,
				 height:200,
			 	 modal: true
			 });
		});
	}
	$("#AddEssentialSkill").click(function(){
		//alert('Yes');
		var EssentialSkill = $("#EssentialSkill").val();
		var dataString = 'skill='+ EssentialSkill;
		if(EssentialSkill =='')
		{
			alert("Please Fill Skill Field");
		}
		else
		{
		if(dataString.length > 50){
		alert("Please input the EssentialSkill value  between 0 and 50 characters long");
		}else{
		// AJAX Code To Submit Form.
		$.ajax({
		type: "POST",
		data: dataString,
		url: "<?php echo $this->Html->url("/Skill/add_skill");?>",
		success: function(result){
			if(result == 'true'){
			$("#dialog-Eskill-create").dialog('close');
			$(function() {
				
				 $( "#dialog-Eskill-success" ).dialog({
					 width:320,
					 height:120,
				 	 modal: true
				 });
			});
			setTimeout(function(){ $("#dialog-Eskill-success").dialog("close")}, 1000);
		}
		else{
			alert("Skill already exist in database");
			$("#dialog-Eskill-create").dialog('close');
		}
		}
		});

		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
			     $("#PositionEssentialSkills").html('');
				 $("#PositionEssentialSkills").html(msg);
				 $("#PositionEssentialSkills").trigger("liszt:updated");
		 }); 
		}
		}
		return false;
		});
});
$('#PositionDesirableSkills').on('change', function() {
	var skills = ""; 
	if($(this).val()=='NEWSkill') {
		skills +="<form name='skill_form' id='loc_form'><label style='font-size: 110%;margin-left:4%;color: #be5e00;'></label></h1>";
        skills +="<br><table cellspacing='7' cellpadding='7' style='margin-left: 4%;margin-top:4%;'>";
		skills += "<tr><td style='font-weight: bold;font-size:14px;color: #be5e00;'>Skill</td><td>:</td><td><input type='text' name='Skill' id='Skill' class='desirableSkill'></td></tr>";
		skills +="<tr><td colspan='3'><input type='button' style='float:right;' name='AddDesirableSkill' id='AddDesirableSkill' value='Create'  ></td></tr></table></form>";    
     $('#dialog-Dskill-create').html(skills); 
	     $(function() {
				
			 $( "#dialog-Dskill-create" ).dialog({
				 width:400,
				 height:200,
			 	 modal: true
			 });
		});
	}
	$("#AddDesirableSkill").click(function(){
		var DesirableSkill = $("#Skill").val();
		var dataString = 'skill='+ DesirableSkill;
		if(DesirableSkill =='')
		{
			alert("Please Fill Skill Field");
		}
		else
		{
		if(dataString.length > 50){
			alert("Please input the DesirableSkill value  between 0 and 50 characters long");
		}else{
		// AJAX Code To Submit Form.
		$.ajax({
		type: "POST",
		data: dataString,
		url: "<?php echo $this->Html->url("/Skill/add_skill");?>",
		success: function(result){
			if(result =='true'){
			$("#dialog-Dskill-create").dialog('close');
			
			$(function() {
				
				 $( "#dialog-Dskill-success" ).dialog({
					 width:320,
					 height:120,
				 	 modal: true
				 });
			});
			setTimeout(function(){ $("#dialog-Dskill-success").dialog("close")}, 1000);
		}
		else{
			alert("Skill already exist in database");
			$("#dialog-Dskill-create").dialog('close');
		}
		}
		});

		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
			     $("#PositionDesirableSkills").html('');
				 $("#PositionDesirableSkills").html(msg);
				 $("#PositionDesirableSkills").trigger("liszt:updated");
		 }); 
		}
	}
		return false;
		});
});
$(document).ready(function(){
	$("#dialog-modal-success").hide();
	$("#dialog-skill-success").hide();
	$("#dialog-Eskill-success").hide();
	$("#dialog-Dskill-success").hide();
	$("#dialog-role-success").hide();
	checkSubcontract();	 
	$( "#dialog-modal-create" ).on( "dialogclose", function( event, ui ) {
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Position/workLoc");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#PositionWorkLocation").html('');
				 $("#PositionWorkLocation").html(msg);
				 $("#PositionWorkLocation").trigger("liszt:updated");
		 });
	} );
	$( "#dialog-skill-create" ).on( "dialogclose", function( event, ui ) {
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#PositionCoreSkills").html('');
				 $("#PositionCoreSkills").html(msg);
				 $("#PositionCoreSkills").trigger("liszt:updated");
		 });
	} );
	$( "#dialog-Eskill-create" ).on( "dialogclose", function( event, ui ) {
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
			     $("#PositionEssentialSkills").html('');
				 $("#PositionEssentialSkills").html(msg);
				 $("#PositionEssentialSkills").trigger("liszt:updated");
		 });
	} );
	$( "#dialog-Dskill-create" ).on( "dialogclose", function( event, ui ) {
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Skill/skill_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
			     $("#PositionDesirableSkills").html('');
				 $("#PositionDesirableSkills").html(msg);
				 $("#PositionDesirableSkills").trigger("liszt:updated");
		 });
	} );
	$( "#dialog-role-create" ).on( "dialogclose", function( event, ui ) {
		
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/ProjectRole/role_list");?>",
			 data: { user:"yes" }
			 }).done(function( msg ) {
			     $("#PositionRoleId").html('');
				 $("#PositionRoleId").html(msg);
				 $("#PositionRoleId").trigger("liszt:updated");
		 });
	} );
	$("#PositionHiringManagerID1").val($("#PositionHiringManagerID").val());

	  $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd',changeYear:true,changeMonth:true });
	 		 
	 $("#toggleCreateshow,#toggleCreateshow1").click(function(){
		 $("#createPositionSection").toggle();
		 $("#toggleCreateshow").toggleClass("show hide");	
	 });
	 $("#toggleshow").click(function(){
		 $("#searchPosition").toggle();
		 $("#toggleshow").toggleClass("show hide");
	 });

	 $("#PositionIndexForm").validate({
		 rules: {
			"data[Position][ClientID]":"required",
			"data[Position][ProjectID]":"required",
			"data[Position][Level]":"required",
			"data[Position][StartDate1]":"required",
			"data[Position][NoOfPosition]":{
				required:true,
				number:true,
				min: 1
			},
			"data[Position][RoleId]":{
				required:true
			},
			"data[Position][CoreSkills]":"required",
			"data[Position][EssentialSkills]":"required",
			"data[Position][DesirableSkills]":"required",
			"data[Position][Track]":"required",
			"data[Position][RecruiterId]":"required",
			"data[Position][EssentialSkills]":"required",
			"data[Position][TravelPercent]":"required",
			"data[Position][WorkLocation]":"required",
			"data[Position][Status]":"required",
			"data[Position][TravelRequired]":"required",
			"data[Position][Billable]":"required",
			"data[Position][BillingRate]":{
				required:true,
				number:true,
				min:0
			},			
			"data[Position][UnitOfMeasure]":"required",
			"data[Position][RelocationRequired]":"required",
			"data[Position][Currency]":"required",
			"data[Position][MinimumMargin]":{
				required:true,
				number:true,
				maxlength:2,
				min:0
			},			
			"data[Position][ScreeningManager]":"required"
		 }
	 });

	 jQuery.extend(jQuery.validator.messages, {
		    min: "Please enter a value greater than 0.",	
		});
		
	 $("#PositionClientID").change(function(){
		 $("#PositionProjectID").html('');
		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Client/getProject");?>",
			 data: { PositionId:$("#PositionClientID").val() }
			 }).done(function( msg ) {
				 $("#PositionProjectID").html(msg);
		 });
	 });

	 $("#PositionProjectID").change(function(){
		 $.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Project/getHiringManager");?>",
			 data: { ProjectId:$("#PositionProjectID").val() }
			 }).done(function( msg ) {
				 var obj = jQuery.parseJSON(msg);
				 $("#ClientContactName").text(obj.name);
				 $("#PositionHiringManagerID").val(obj.id);
				 $("#PositionStartDate1").val(obj.startdate);
				 $("#PositionEndDate1").val(obj.enddate);
		 });
	 });
});
var checkSubcontract=function(){		 
	if($("#PositionSubContractorYes").is(":checked")){
		 $(".subContractclass").removeAttr("readonly");
	 }else{
		 $(".subContractclass").attr("readonly","readonly");
	 }
};
var checkTravelRequired=function(){		 
	if($("#PositionTravelRequiredNo").is(":checked")){
		$('#PositionTravelPercent').val("0");
		 $('.TravelReq').hide();
	 }else{
		 $('.TravelReq').show();
	 }
};
var checkBillable=function(){		 
	if($("#PositionBillableNo").is(":checked")){
		$('#PositionBillablePercent').val("0");
		 $('.TravelBill').hide();
	 }else{
		 $('.TravelBill').show();
	 }
};

$(".Delete").click( function(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
});

$(".calculation").keypress( function(){
	salaryCalculation();
});
$(".calculation").keydown( function(){
	salaryCalculation();
});
$("#PositionUnitOfMeasure").change(function(){
	salaryCalculation();
});

function salaryCalculation(){
	if($("#PositionMinimumMargin").val() != '' && $("#PositionBillingRate").val() != '' && $("#PositionUnitOfMeasure").val() != ''){
		var unit = $("#PositionUnitOfMeasure").val();
		var margin = $("#PositionMinimumMargin").val();
		var rate = $("#PositionBillingRate").val();
		var HY = <?php echo  Configure::read("SalaryCalculation.HY");?>;
		var MF= <?php echo  Configure::read("SalaryCalculation.MF");?>;
		margin = (100-margin)/100;
		if(unit == "Daily"){
			rate = rate / (HY/240);
		}
		if(unit == "Weekly"){
			rate = rate / (HY/48);
		}
		if(unit == "Monthly"){
			rate = rate / (HY/12);
		}
		var C2C = (rate*margin);
		var salaryHourly = (rate*margin)/MF;
		salaryFT = ((rate*margin)/MF)*HY;
		$("#PositionSalaryFt").val((Math.round(salaryFT).format()));
		$("#PositionSalaryHourly").val(salaryHourly.format());
		$("#PositionCorpToCorp").val(C2C.format());			
	}else{
		$("#PositionSalaryFt").val('0');
		$("#PositionSalaryHourly").val('0');
		$("#PositionCorpToCorp").val('0');
	}
		
	return false;
}

$("#PositionHiringManagerID1").change(function(){
	$("#PositionHiringManagerID").val($(this).val());	
});



Number.prototype.format = function() {
    return this.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
};

</script>
<style>
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    height: 0%;
    width: 45%;
    padding:0;
    margin-left: 3%;
}
</style>
