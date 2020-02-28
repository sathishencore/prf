<?php //echo "<pre>";
		//			print_r($projectList);die; ?>
					<div class="titlebg">
	<div class="titletxt">Search</div>
	<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchProject" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("ProjectFrm",array("url"=>array("controller"=>"Project","action"=>"index")));?>
			<table>
				<tr>
					<td>Client Name : &nbsp;</td>
					<td><?php echo $this->Form->select("ClientId",$allClientList,array("class"=>"searchbox","style"=>"width:220px;","empty"=>"All"));?>
					</td>
					<td>Client Location Country: &nbsp;</td>
					<td>
					<?php 
					$cl = array();
					foreach($clientlocation as $key=>$value) {
						$cl_country[$key] = $key; 
						foreach($value as $k=>$v){
							$com = $k.",".$v; 
							$cl_city[$com] = $com; 
						}
					}
					$country = array_keys($cl_country);
					foreach($country as $k=>$v) {
						$country_only[$v] = $v; 
					}
					echo $this->Form->select("ClientCountry",$country_only,array("class"=>"searchbox","empty"=>"---Select---","style"=>"width:250px"));
					?>
					</td>
					
					<td>Client Location City: &nbsp;</td>
					<td><?php 
					echo $this->Form->select("ClientCity","",array("style"=>"width:250px","empty"=>"---Select---","class"=>"searchbox"));
					echo $this->Form->input("cityval", array("type" => "hidden","id"=>"cityval"));
					echo $this->Form->input("fromclientfrm", array("type" => "hidden","id"=>"fromclientfrm")); ?>
					
					</td>
					</tr>
					<tr>
					<td>Project Code,Name : &nbsp;</td>
					<td><?php echo $this->Form->select("ProjectName",$projectName,array("empty"=>"--Select--","style"=>"width:220px;","class"=>"searchbox"));?>
					</td>
					
					<!--<td>Project Code : &nbsp;</td>
					<td><?php //echo $this->Form->select("ProjectCode",$projectCode,array("empty"=>"--Select--","style"=>"width:220px;","class"=>"searchbox"));?>
					</td>-->
					<td><?php echo $this->Form->submit("Search");?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="displayResults">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
						<th>Client Name</th>
						<th>ProjectCode</th>
						<th>ProjectName</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Client Project Owner</th>
						<th>Client Project Manager</th>
						<th>Billing Type</th>
						<th>Status</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					
					if(count($projectList)>0){
								$i=1;
								foreach($projectList as $ckey=>$cval){
						?>
					<tr>
						<td><?php echo $clientList[$cval['Project']['ClientID']]?></td>
						<td class="project_details" data-val="<?php echo $cval['Project']['ID']?>"><a href="javascript:" ><?php echo $cval['Project']['Code']?></a></td>
						<td><?php echo $cval['Project']['Name']?></td>
						<td><?php echo $this->Time->format(Configure::Read("Date.Format"),$cval['Project']['StartDate'])?></td>
						<td><?php if(!empty($cval['Project']['EndDate'])){ echo $this->Time->format(Configure::Read("Date.Format"),$cval['Project']['EndDate']); }?></td>
						<td><?php if(!empty($clientContactList[$cval['Project']['ClientContactID']])){ echo  $clientContactList[$cval['Project']['ClientContactID']]; } ?></td>
<!-- 						<td><?php //echo $cval['Project']['ScreeningManager']?></td> -->
						<td><?php if(!empty($clientContactList[$cval['Project']['ProjectManagerID']])){ echo  $clientContactList[$cval['Project']['ProjectManagerID']]; } ?>
						</td>
						<td><?php echo $cval['Project']['BillingType']?></td>
						<td><?php echo $cval['Project']['SalesStatus']?></td>
						<td class="headerRight">
						<form id="frm<?php echo $cval['Project']['ID']?>" action="<?php echo $this->Html->url("/Position");?>" method="post">
									<input type="hidden" name="data[PositionFrm][ProjectName]" value="<?php echo $cval['Project']['ID']?>">
									<input type="hidden" name="data[PositionFrm][ClientId]" value="<?php echo $cval['Project']['ClientID']?>">
									<!-- <input type="hidden" name="data[Position][ClientID]" value="<?php //echo $cval['Project']['ClientID']?>"> -->	
									<input type="hidden" name="data[PositionFrm][StartDate]" value="<?php echo $cval['Project']['StartDate'];?>">								
									<input type="hidden" name="data[PositionFrm][WorkLocation_Country]" value="<?php echo $cval['ClientContact']['Country'];?>">
									<input type="hidden" name="data[PositionFrm][WorkLocation_City]" value="<?php echo $cval['ClientContact']['City'].','.$cval['ClientContact']['State'];?>">
									<input type="hidden" name="data[PositionFrm][posfromcity]" id="posfromcity" value="<?php echo $cval['ClientContact']['City'].','.$cval['ClientContact']['State'];?>">																	
						</form>
						
						<?php if($editAction){ ?>
							<?php echo $this->Html->link("edit",array('controller' => 'Project', 'action' => 'index', (int)$cval['Project']['ID']));?>
							| <a href="javascript:" class="" data-val="<?php echo $cval['Project']['ID']?>" onclick="$('#frm<?php echo $cval['Project']['ID']?>').submit();">Positions</a>
						<?php }else {?>
						<a href="javascript:" class="project_details" data-val="<?php echo $cval['Project']['ID']?>">View</a>
						| <a href="javascript:" class="" data-val="<?php echo $cval['Project']['ID']?>" onclick="$('#frm<?php echo $cval['Project']['ID']?>').submit();">Positions</a>
						<?php }?>
						</td>
					</tr>
					<?php
					$i++;
								}
						 }else{
						?>
				</tbody>
				<tr>
					<td colspan="12" class="headerRight">No Records found</td>
				</tr>
				<?php }
				/*if($this->Paginator->numbers()){
				 ?>
						<tr>
							<td colspan="12" style="text-align:right" class="headerRight">
							&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="12" style="text-align:right" class="headerRight">
								<?php
									echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
								 	echo "&nbsp;";
									echo $this->Paginator->numbers();
								 	echo "&nbsp;";
									echo $this->Paginator->next(' Next »', null, null, array('class' => 'disabled'));
								?>
							</td>
						</tr>
						<?php
						} */
						?>
			</table>
		</div>
		<div id="dialog-modal" title="Project Details">
		<h1 style="font-size: 100%;margin-left: 6px;margin-bottom: 1%;margin-top: auto;color: orange;"><label id="projectname" style="font-size: 130%;"></label> Details</h1>
			<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
				<tr>
					<td style="font-weight: bold;">Client Name</td>
					<td>:</td>
					<td><label id="clientname"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Start Date</td>
					<td>:</td>
					<td><label id="startdate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">End Date</td>
					<td>:</td>
					<td><label id="enddate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Client Project Owner</td>
					<td>:</td>
					<td><label id="clientcontact"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Client Project Manager</td>
					<td>:</td>
					<td><label id="pm"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Billing Type</td>
					<td>:</td>
					<td><label id="billing"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Status</td>
					<td>:</td>
					<td><label id="status"></label></td>
				</tr>
				<tr>
					<td colspan="3"><?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?></td>
				</tr>
			</table>

		</div>
		<script>
		$('#dialog-modal').hide();	
$(document).ready(function(){
	$('table').tablesorter({ headers: { 9: { sorter: false  } }});
	if($("#ProjectFrmClientCountry").val()!=""){
	var fromcl = $("#fromclientfrm").val();	
	var Country = $("#ProjectFrmClientCountry").val();
		$.ajax({
			 type: "POST",
			 url: "<?php echo $this->Html->url("/Client/loadCityclient");?>",
			 data: {Country:Country }
			 }).done(function( msg ) {
				 //alert(msg);
			     $("#ProjectFrmClientCity").html(msg);
			     if(fromcl!=""){
	//		     alert(fromcl);
			     	$("#ProjectFrmClientCity").val(fromcl);
			     }
			     else{
			     	if($("#cityval").val()!="")
			     		$("#ProjectFrmClientCity").val($("#cityval").val());
			     }
			     $(".searchbox").chosen();	
		 });
	 }
	 else {
	 	$(".searchbox").chosen();
	 }
});

$('.project_details').click( function() {
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Project/ProjectDetailsView?id="+id ,  function ( data ) {
		var data = jQuery.parseJSON(data);
		$('#clientname').text(data.Project.ClientName);
		$('#startdate').text(data.Project.StartDate);
		$('#enddate').text(data.Project.EndDate);
		$('#clientcontact').text(data.ClientContact.ContactName);
		$('#pm').text(data.ProjectManager.ContactName);
		$('#billing').text(data.Project.BillingType);
		$('#status').text(data.Project.SalesStatus);
		$('#projectname').text(data.Project.Name+"("+data.Project.Code+")");
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			 width:450,
			 modal: true
			 });
			 });
	});
});

$("#ProjectFrmClientId").change(function(){
	 $("#ProjectFrmProjectName").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { PositionId:$("#ProjectFrmClientId").val() }
		 }).done(function( msg ) {
			 $("#ProjectFrmProjectName").html(msg);
			 $("#ProjectFrmProjectName").trigger("liszt:updated");
	 });
});

$('#ProjectFrmClientCountry').change(function(){
	$("#ProjectFrmClientCity").html('');
	$("#fromclientfrm").val("");
	var Country = $("#ProjectFrmClientCountry").val();
	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Project/loadCityclient");?>",
		 data: {Country:Country }
		 }).done(function( msg ) {
			 //alert(msg);
		     $("#ProjectFrmClientCity").html(msg);
			$("#ProjectFrmClientCity").trigger("liszt:updated");	
			 
	 });
});
 
 $('#ProjectFrmClientCity').change(function(){
 	$("#cityval").val($("#ProjectFrmClientCity").val());
 	$("#fromclientfrm").val("");
 });
function closePopup(){
	$('.ui-front').remove();
	return false;
}
</script>
	</div>
</div>
