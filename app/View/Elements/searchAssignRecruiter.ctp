<?php
//Sort the details based on the candidateassignment information
$tempList = $unassigned = $assigned = array();
foreach ($assignRecruiterList as $key => $candidInfo) {
	if (empty($assignRecruiterList[$key]['CandidateAssignment'])) {
		array_push($unassigned, $assignRecruiterList[$key]);
	}
	else {
		array_push($assigned, $assignRecruiterList[$key]);
	}
}

//unassigned first
foreach ($unassigned as $key => $value) {
	$tempList[] = $unassigned[$key];
}

//assigned next
foreach ($assigned as $key => $value) {
	$tempList[] = $assigned[$key];
}

$assignRecruiterList = $tempList;

?>

<div class="titlebg">
	<div class="titletxt">Search</div>
	<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchAssignRecruiter" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("AssignRecruiterFrm",array("url"=>array("controller"=>"AssignRecruiter","action"=>"index")));?>
			<table>
				<tr>
					<td>Client Name:</td>
					<td><?php echo $this->Form->select("Client",$activeClientList,array("empty"=>"--Select--","class"=>"select-small searchbox"));?>
					</td>
					<td>&nbsp;Project Name:</td>
					<td><?php echo $this->Form->select("Project",$projectList,array("empty"=>"--Select--","class"=>"select-small searchbox"));?>
					</td>
					<td>&nbsp;Role:</td>
					<td><?php echo $this->Form->select("Role",$roleList,array("empty"=>"--Select--","class"=>"select-small searchbox"));?>
					</td>
					<td>&nbsp;Recruiter:</td>
					<td><?php echo $this->Form->select("Recruiter",$recruiterList,array("empty"=>"All","class"=>"select-small searchbox"));?>
					</td>
					
				</tr>
				<tr>
				<!-- <td>Work Location:</td>
					<td><?php echo $this->Form->select("WorkLocation",$worklocationdistinctList,array("empty"=>"---Select---","class"=>"select-small searchbox"));?>
					</td>-->
					<td>Work Location Country: 
		   		<?php //echo "<pre>";
					//print_r($worklocationdistinctList);
					$country=array();
					$country_city = array();
					$country_only = array();
					foreach($worklocationdistinctList as $id=>$val){
						$split = explode(',',$val);
						if(!isset($split[2]))
							continue;
						//print_r($split);
						if(isset($aMemb['Name']))     
						    $aMemberships[] = $aMemb['Name'];
						//echo $split[0].'/'.$split[1].'/'.$split[2]."<br>";
						if(($split[2]=="")&&($split[1]!="")) {
							$ss = $split[1];
							$cc = $split[0];
						}
						else if(($split[2]=="")&&($split[1]=="")) {
							$ss = $split[0];
							
						}
						else {
							$ss = $split[2];
							$cc = $split[0].','.$split[1];
						}
						//$country[]=$ss;
						$country_city[$ss][$cc] = $cc;
					}
					$country = array_keys($country_city);
					foreach($country as $k=>$v) {
						$country_only[$v] = $v; 
					}?></td>
					
					<td><?php 
					if($this->Session->read("assignedcountry")){
					$s = $this->Session->read("assignedcountry");
						echo $this->Form->select("WorkLocation_Country",$country_only,array("empty"=>"---Select---","class"=>"select-small searchbox","value"=>$s));
					}
					else {
						echo $this->Form->select("WorkLocation_Country",$country_only,array("empty"=>"---Select---","class"=>"select-small searchbox"));
					}
					?>
					</td>
					<td>&nbsp;Work Location City: &nbsp;</td>
					<td><?php echo $this->Form->select("WorkLocation_City","",array("empty"=>"---Select---","class"=>"select-small searchbox"));
					echo $this->Form->input("cityval", array("type" => "hidden","id"=>"cityval"));?>
					</td>
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
						<th>Project Code,Name</th>
						<th>Requisition Number</th>
						<th>Role</th>
						<th>Track</th>					
						<th>Essential Skills</th>
						<th>No Of Positions</th>
						<th>Primary Recruiter</th>
						<th>Secondary Recruiter</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($assignRecruiterList)>0){
								$i=1;
								foreach($assignRecruiterList as $ckey=>$cval){
						?>
					<tr>
						<td><?php echo $clientList[$cval['Position']['ClientID']]?></td>
						<td><?php echo $projectList[$cval['Position']['ProjectID']]?></td>
						<td><?php echo substr_replace($cval['Position']['RequisitionNumber'], "-", -3,0)?></td>
						<td><?php echo $cval['Position']['Role']?></td>
						<td><?php echo $cval['Position']['Track']?></td>
						<td><?php echo $cval['Position']['EssentialSkills']?></td>
						<td><?php echo $cval['Position']['NoOfPosition']?></td>
						<td><?php if(!empty($recruiterList[$cval['Position']['RecruiterId']])) { echo $recruiterList[$cval['Position']['RecruiterId']]; } ?></td>		
						<td><?php if(!empty($recruiterList[$cval['Position']['SecondaryRecruiterId']])) { echo $recruiterList[$cval['Position']['SecondaryRecruiterId']]; } ?></td>			
						<td class="headerRight">
							<a	href="<?php echo $this->Html->url("/")?>AssignRecruiter/index?positionid=<?php echo $cval['Position']['ID']?>" >Assign </a>
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
							<td colspan="13" style="text-align:right" class="headerRight">
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

		<div id="dialog-modal" title="Candidate Details">
			<h1
				style="font-size: 100%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
				<label id="candidatename" style="font-size: 130%;"></label> Details
			</h1>
			<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
				<tr>
					<td style="font-weight: bold;">Date Of Birth</td>
					<td>:</td>
					<td><label id="dob"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Skill Set</td>
					<td>:</td>
					<td><label id="skill"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Non Skill Set</td>
					<td>:</td>
					<td><label id="nonskill"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Experience</td>
					<td>:</td>
					<td><label id="exp"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Domain</td>
					<td>:</td>
					<td><label id="domain"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Salary</td>
					<td>:</td>
					<td><label id="salary"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Interview Date</td>
					<td>:</td>
					<td><label id="interviewdate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Client</td>
					<td>:</td>
					<td><label id="client"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Project</td>
					<td>:</td>
					<td><label id="project"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Email</td>
					<td>:</td>
					<td><label id="email"></label></td>
				</tr>
			</table>

		</div>
		<script>
		$('#dialog-modal').hide();	
$(document).ready(function(){
	//$("#AssignRecruiterFrmClient,#AssignRecruiterFrmProject,#AssignRecruiterFrmRole").chosen();
	$('table').tablesorter({ headers: { 9: { sorter: false  } }});	
	//alert($("#AssignRecruiterFrmWorkLocationCountry").val());
	if($("#AssignRecruiterFrmWorkLocationCountry").val()!=""){
	var Country = $("#AssignRecruiterFrmWorkLocationCountry").val();
		$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/AssignRecruiter/loadCity");?>",
		 data: {Country:Country }
		 }).done(function( msg ) {
			 //alert(msg);
		     $("#AssignRecruiterFrmWorkLocationCity").html('');
			 $("#AssignRecruiterFrmWorkLocationCity").html(msg);
			 $("#AssignRecruiterFrmWorkLocationCity").val($("#cityval").val());
			 $(".searchbox").chosen();
	 	});
	 }	
	 else{
	 	$(".searchbox").chosen();
	 }
});

$('.candidate_view').click( function() {
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Candidate/CandidateView?id="+id ,  function ( data ) {
		var candidate_data = jQuery.parseJSON(data);
		$('#candidatename').text(candidate_data.Candidate.Name);
		$('#dob').text(candidate_data.Candidate.DateOfBirth);
		$('#skill').text(candidate_data.Candidate.SkillSet);
		$('#nonskill').text(candidate_data.Candidate.NonSkillSet);
		$('#exp').text(candidate_data.Candidate.YearsOfExperience);
		$('#domain').text(candidate_data.Candidate.Domain);
		$('#salary').text(candidate_data.Candidate.Salary);
		$('#interviewdate').text(candidate_data.Candidate.InterviewDate);
		$('#client').text(candidate_data.Client.Name);
		$('#email').text(candidate_data.Candidate.Email);
		$('#project').text(candidate_data.Project.Name);
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			 width:400,
			 modal: true
			 });
			 });
	});
});

$("#AssignRecruiterFrmClient").change(function(){
	 $("#AssignRecruiterFrmProject").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { PositionId:$("#AssignRecruiterFrmClient").val() }
		 }).done(function( msg ) {
			 $("#AssignRecruiterFrmProject").html(msg);
			 $("#AssignRecruiterFrmProject").trigger("liszt:updated");
	 });
});
$("#AssignRecruiterFrmProject").change(function(){
	 $("#AssignRecruiterFrmRole").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { getRoleId:$("#AssignRecruiterFrmProject").val(), ClientId:$("#AssignRecruiterFrmClient").val() }
		 }).done(function( msg ) {
			 $("#AssignRecruiterFrmRole").html(msg);
			 $("#AssignRecruiterFrmRole").trigger("liszt:updated");
	 });
});
$('#AssignRecruiterFrmWorkLocationCountry').change(function(){
	 var Country = $("#AssignRecruiterFrmWorkLocationCountry").val();
	 //alert(Country);
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/AssignRecruiter/loadCity");?>",
		 data: {Country:Country }
		 }).done(function( msg ) {
			// alert(msg);
		     $("#AssignRecruiterFrmWorkLocationCity").html('');
			 $("#AssignRecruiterFrmWorkLocationCity").html(msg);
			 $("#AssignRecruiterFrmWorkLocationCity").trigger("liszt:updated");
	 });
});

$('#AssignRecruiterFrmWorkLocationCity').change(function(){
 	$("#cityval").val($("#AssignRecruiterFrmWorkLocationCity").val());
 });
</script>
	</div>
</div>
	
