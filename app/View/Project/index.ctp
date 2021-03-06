<?php
if(isset($this->params['pass'][0])){
	$id=$this->params['pass'][0];
	$startDate=$this->data['Project']['StartDate'];
	$endDate=$this->data['Project']['EndDate'];
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
	<?php if($title_for_layout=='Update Project') {
	?>
	<div class="hide" id="toggleCreateshow">&nbsp;</div>
	<?php } else { ?>
	<div class="show" id="toggleCreateshow">&nbsp;</div>
	<?php } ?>
</div>
<?php

echo $this->Form->create("Project",array("url"=>"/Project/index/$id"));
?>
<div class="bodyconrarea">
	<div class="content" id="createProjectSection" <?php if(!$id){?>
		style="display: none;" <?php }?>>
		<div class="content-mid">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0"
							align="center">
							<tr>
								<td width="100%">
									<table width="94%" border="0" cellspacing="0" cellpadding="4"
										align="center" class="textfield-cmntxt">
										<tr>
											<td style="width: 13%">Client Name<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php
											if(!$id){
												echo $this->Form->select("Project.ClientID",$clientList,array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"1"));
											}else
												echo $clientList[$this->data['Project']['ClientID']];
											?>
											</td>
											<td>Client Project Owner<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Project.ClientContactID",$clientContactList,array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"7"));?>
											</td>
											<td>Billing type<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php
											echo $this->Form->select("Project.BillingType",Configure::Read("Project.BillingType"),array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"11"));
											?>
											</td>
										</tr>
										<tr>
											<td style="width: 13%">Project Code</td>
											<td>:</td>
											<td><?php
											if(!$id){
													$attr = array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"2");
											}else{
													$attr = array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"disabled"=>true,"tabindex"=>"2");
												}
												echo $this->Form->input("Project.Code",$attr);
												?>
											</td>
											<td>Client Project Manager<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Project.ProjectManagerID",$clientContactList,array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"8"));?>
											</td>
											<td>Billing Frequency<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php
											echo $this->Form->select("Project.BillingFrequency",Configure::Read("Project.BillingFrequency"),array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"12"));
											?>
											</td>
										</tr>
										<tr>
											<td style="width: 13%">Project Name<span
												class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Project.Name",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"3"));?>
											</td>

											<td>Encore BD<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Project.EncoreContact",$encoreContactList,array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"9"));?>
											</td>
											<td>Bill to</td>
											<td>:</td>
											<td><?php echo $this->Form->select("Project.BillTo",$clientContactList,array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"13"));?>
											</td>

										</tr>
										<tr>
											<td>Start Date<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Project.StartDate1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small datepicker","div"=>false,"value"=>$startDate,"readonly"=>true,"tabindex"=>"4"));?>
											</td>
											<td rowspan="2">Scope Of Work<span class="errorMandatory">*</span>
											</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><?php echo $this->Form->textarea("Project.ScopeOfWork",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>2,"cols"=>"25","tabindex"=>"10"));?>
											</td>
											<td rowspan="2">Additional Billing Information</td>
											<td rowspan="2">:</td>
											<td rowspan="2"><?php echo $this->Form->input("Project.AdditionalBillingInformation",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small","div"=>false,"tabindex"=>"14"));?>
											</td>

										</tr>
										<tr>
											<td>End Date</td>
											<td>:</td>
											<td><?php echo $this->Form->input("Project.EndDate1",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small datepicker","div"=>false,"value"=>$endDate,"tabindex"=>"5"));?>
											</td>
										</tr>
										<tr>
											<td>Project Status<span class="errorMandatory">*</span>
											</td>
											<td>:</td>
											<td><?php
											echo $this->Form->select("Project.SalesStatus",Configure::Read("Project.SaleStatus"),array("empty"=>"--Select--","class"=>"select-small","tabindex"=>"6"));
											?>
											</td>
											<td colspan="3"></td>
											<td>Notes</td>
											<td>:</td>
											<td><?php echo $this->Form->textarea("Project.Notes",array("label"=>false,"style"=>"float:left","div"=>false,"rows"=>2,"cols"=>"25","tabindex"=>"15"));?>
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
			echo $this->Form->submit("login",array("type"=>"image","src"=>$this->Html->url("/")."img/save-but.png","div"=>false,"tabindex"=>"16"));
			?>
			&nbsp;
			<?php 
			echo $this->Html->link(
						    $this->Html->image("cancel-inner-but.png", array("alt" => "Cancel","tabindex"=>"17")),
						    "/Project/index/",
						    array('escape' => false)
						);?>
			&nbsp;
			<?php if(!empty($id) && $delete == 0){
				echo $this->Html->link(
						    $this->Html->image("delete-but.png", array("alt" => "Delete","class"=>"Delete","tabindex"=>"18")),
						    "/Project/delete/$id",
						    array('escape' => false)
						);
}?>
		</div>
	</div>
</div>
<?php echo $this->Form->end();?>
<?php }?>
<?php echo $this->element("searchProject");?>
<script>
$(document).ready(function(){
	
	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd',changeYear:true,changeMonth:true });
	 $("#toggleCreateshow,#toggleCreateshow1").click(function(){
		 $("#createProjectSection").toggle();
		 $("#toggleCreateshow").toggleClass("show hide");	
	 });
	 $("#toggleshow").click(function(){
		 $("#searchProject").toggle();
		 $("#toggleshow").toggleClass("show hide");
	 });
	 $("#ProjectClientID").change(function(){
		updateProj();
	 });

	if ($("#ProjectClientID").val() != '') {
		updateProj();
	}
	$("#ProjectIndexForm").validate({
		 rules: {
			"data[Project][ClientID]":"required",
			"data[Project][NoOfPosition]":{
				required:true,
				number:true,
				min: 1
			},
			"data[Project][ScopeOfWork]":{
			required:true,
			maxlength: 200
			},
			"data[Project][Name]":"required",
			"data[Project][StartDate1]":"required",
			"data[Project][PositionDetails]":"required",
			"data[Project][Name]":"required",
			"data[Project][BillingType]":"required",
			"data[Project][BillingFrequency]":"required",
			"data[Project][EncoreContact]":"required",
			"data[Project][ClientContactID]":"required",
			"data[Project][ProjectManagerID]":"required",
			"data[Project][SalesStatus]":"required"
		 }
	 });
});

$(".Delete").click( function(){
	var x = confirm("Do you want to delete this record ?");
			if(x)
				return true;
			else
				return false;
});

function updateProj() {
	$("#ProjectClientContactID").html('');
	$("#ProjectBillTo").html('');
	$("#ProjectProjectManagerID").html('');	
	<?php 
	if(!isset($this->data['Project']['ClientID'])){ 
	?>	 
	if($("#ProjectClientID").val()){
	<?php }else{ ?>
	if(<?php echo $this->data['Project']['ClientID']; ?>){
	<?php } ?>

		$.ajax({
			type: "POST",
			url: "<?php echo $this->HTML->url("/");?>Project/checkCode",
			<?php 
			if(isset($this->data['Project']['ClientID'])){ 
			?>
			data: { ClientId : <?php echo $this->data['Project']['ClientID']; ?> }
			<?php
			}else{
			?>
			data: { ClientId : $("#ProjectClientID").val() }
			<?php } ?>
			}).done(function( msg ) {
			var obj = jQuery.parseJSON(msg);
			<?php 
			if(!isset($this->data['Project']['ClientID'])){ 
			?>
			$("#ProjectCode").val(obj.Code);
			<?php } ?>
			var optionstr='<option value="">--Select--</option>';
			for(x in obj.contactList){
				optionstr+="<option value="+x+">"+obj.contactList[x]+"</option>";
			}	
			$("#ProjectClientContactID").html(optionstr);
			$("#ProjectBillTo").html(optionstr);
			$("#ProjectProjectManagerID").html(optionstr);
			<?php 
			if(isset($this->data['Project']['ClientID'])){ 
			?>
				$("#ProjectClientContactID").val(<?php echo $this->data['Project']['ClientContactID'] ?>);
				$("#ProjectBillTo").val(<?php echo $this->data['Project']['BillTo'] ?>);
				$("#ProjectProjectManagerID").val(<?php echo $this->data['Project']['ProjectManagerID'] ?>);
			<?php
			}
			?>
		});	
	}else{
		$("#ProjectCode").val('');
	}
}
</script>
<style>
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year {
    height: 0%;
    width: 45%;
    padding:0;
    margin-left: 3%;
}
</style>
