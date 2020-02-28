<div class="titlebg"><?php if(!empty($positionId)) { $id="?positionid=".$positionId; }else{ $id='';}?>
	<div class="titletxt">Search</div>
	<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchCandidateAssignment"
		style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("CandidateAssignmentFrm",array("url"=>array("controller"=>"CandidateAssignment","action"=>"index".$id)));?>
			<table>
				<tr>
					<td>Role:</td>
					<td><?php echo $this->Form->select("Role",$roleList,array("empty"=>"All","class"=>"select-small"));?>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Range of Experience(years):</td>
					<td><?php echo $this->Form->select("YOE",Configure::read("Candidate.YearsOfExperience"),array("id"=>"searchbox","style"=>"width:250px;","empty"=>"All"));?>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td>Resource Type:</td>
					<td><?php echo $this->Form->select("ResourceType",Configure::read("Candidate.Compensation"),array("id"=>"searchbox","class"=>"select-small","empty"=>"All"));?>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Skills:</td>
					<td><?php echo $this->Form->input("Skills",array("label"=>false,"class"=>"textfield-cmn textfield-cmn-small"));?>
					</td>
					<td><?php echo $this->Form->submit("Search");?>
					</td>
				</tr>
			</table>
			<?php echo $this->Form->end();?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="displayResults">
			<table class="tablesorter" id="tests" cellspacing="0">
				<thead>
					<tr>
						<th>Candidate Name</th>
						<th>Primary Skills</th>
						<th>Secondary Skills</th>
						<th>YearsOfExperience</th>
						<th>Role</th>
						<th>Currency</th>
						<th>Amount</th>
						<th>Compensation Type</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($candidateList)>0){
								$i=1;
								foreach($candidateList as $ckey=>$cval){
						?>
					<tr>

						<td><?php echo $cval['Candidate']['FirstName']." ".$cval['Candidate']['LastName']?></td>
						<td><?php echo $cval['Candidate']['PrimarySkills']?></td>
						<td><?php echo $cval['Candidate']['SecondarySkills']?></td>
						<td><?php echo $cval['Candidate']['YearsOfExperience']?></td>
						<td><?php echo $cval['Candidate']['Role']?></td>
						<td><?php echo $cval['Candidate']['Currency']?></td>
						<td><?php if(!empty($cval['Candidate']['Amount'])) { echo number_format($cval['Candidate']['Amount'], 2, '.', ','); } else { echo "";}?></td>
						<td><?php echo $cval['Candidate']['CompensationPeriod']?></td>
						<td class="headerRight"><a href="javascript:"
							class="candidate_assign"
							data-val="<?php echo $cval['Candidate']['ID']?>" >Assign</a>
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
				<?php }?>
			</table>
		</div>
</div></div>
<script>
$('#dialog-modal').hide();	
$(document).ready(function(){
	$("#CandidateAssignmentFrmRole").chosen();
	$('table').tablesorter({ headers: { 8: { sorter: false  } }});		
});

$(".candidate_assign").click(function(){
	var id = $(this).attr("data-val");
	var req = "<?php if(!empty($positionData['Position']['RequisitionNumber'])) { echo substr_replace($positionData['Position']['RequisitionNumber'], "-", -3,0); }?>";
	if(req == ''){
		alert('Please Select the Position');	
	}else{
	var x = confirm("Do you want to assign this candidate to the requistion number "+req+" ?");
	if(x){
		window.location.href = window.location.href+"&assignCandidateID="+id;
		} 
	}
		
});

</script>

