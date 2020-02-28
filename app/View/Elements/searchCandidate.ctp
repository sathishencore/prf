<div class="titlebg">
	<div class="titletxt">Search</div>
	<div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchCandidate" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("CandidateFrm",array("url"=>array("controller"=>"Candidate","action"=>"index")));?>
			<table>
				<tr>
					<td>Range Of Experience : &nbsp;</td>
					<td><?php echo $this->Form->select("YOE",Configure::read("Candidate.YearsOfExperience"),array("id"=>"searchbox","style"=>"width:250px;","empty"=>"All"));?>
					</td>
					<td>Resource Type: &nbsp;</td>
					<td><?php echo $this->Form->select("ResourceType",Configure::read("Candidate.Compensation"),array("id"=>"ResourceType","empty"=>"All","class"=>"select-small"));?>
					</td>
</tr>
<tr>
					<td>Primary Skills: &nbsp;</td>
					<td><?php echo $this->Form->input("PrimarySkills",array("label"=>false,"div"=>false));?>
					</td>
					<td>Role: &nbsp;</td>
					<td><?php echo $this->Form->input("Role",array("label"=>false,"div"=>false));?>
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
						<th>Candidate Name</th>
						<th width="24%">Primary Skills</th>
						<th>Secondary Skills</th>
						<th title="Experience">Exp..</th>
						<th>Role</th>					
						<th>Currency</th>
						<th>Amount</th>
						<th> Compensation Type</th>
						<th colspan="2" class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($candidateList)>0){
								$i=1;
								foreach($candidateList as $ckey=>$cval){
						?>
					<tr> 

						<td class="candidate_view"	data-val="<?php echo $cval['Candidate']['ID']?>">
						<a	href="javascript:"><?php echo $cval['Candidate']['FirstName']." ".$cval['Candidate']['LastName']?> </a></td>
						<td><?php echo $cval['Candidate']['PrimarySkills']?></td>
						<td><?php echo $cval['Candidate']['SecondarySkills']?></td>
						<td><?php echo $cval['Candidate']['YearsOfExperience']?></td>
						<td><?php echo $cval['Candidate']['Role']?></td>
						<td><?php echo $cval['Candidate']['Currency']?></td>
						<td><?php if(!empty($cval['Candidate']['Amount'])) { echo number_format($cval['Candidate']['Amount'], 2, '.', ','); } else { echo "";}?></td>
						<td><?php echo $cval['Candidate']['CompensationPeriod']?></td>
						<td>
						<?php if(!empty($cval['Candidate']['ResumeName'])){
									if(file_exists(WWW_ROOT . 'files' . DS . $cval['Candidate']['ResumeName'])){
										echo "<a href='".$this->Html->url("/files/").$cval['Candidate']['ResumeName']."'>".$this->Html->image("word-text.png")."</a>";
									}
							?>
						<?php }?>
						</td>
						<td class="headerRight"><?php 
							if($editAction){ 
								echo $this->Html->link("edit",array('controller' => 'Candidate', 'action' => 'index', (int)$cval['Candidate']['ID']));
							}else{
						?>
							<a	href="javascript:" class="candidate_view" data-val="<?php echo $cval['Candidate']['ID']?>">View </a>
						<?php }?></td>	
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
					<td style="font-weight: bold;">Primary Skills</td>
					<td>:</td>
					<td><label id="primaryskill"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Secondary Skills</td>
					<td>:</td>
					<td><label id="secondaryskill"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Experience</td>
					<td>:</td>
					<td><label id="exp"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Role</td>
					<td>:</td>
					<td><label id="role"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Currency</td>
					<td>:</td>
					<td><label id="salaryft"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Amount</td>
					<td>:</td>
					<td><label id="salaryhourly"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Compensation Type</td>
					<td>:</td>
					<td><label id="C2C"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Status</td>
					<td>:</td>
					<td><label id="status"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Email</td>
					<td>:</td>
					<td><label id="email"></label></td>
				</tr>
				<tr>
					<td colspan="3"><?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?></td>
				</tr>
			</table>

		</div>
		<script>
		$('#dialog-modal').hide();	
$(document).ready(function(){
	$("#searchbox,#searchbox1").chosen();
	$('table').tablesorter({ headers: { 8: { sorter: false  } }});		
});

$('.candidate_view').click( function() {
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Candidate/CandidateView?id="+id ,  function ( data ) {
		var candidate_data = jQuery.parseJSON(data);
		$('#candidatename').text(candidate_data.Candidate.FirstName+" "+candidate_data.Candidate.LastName);
		$('#primaryskill').text(candidate_data.Candidate.PrimarySkills);
		$('#secondaryskill').text(candidate_data.Candidate.SecondarySkills);
		$('#exp').text(candidate_data.Candidate.YearsOfExperience);
		$('#role').text(candidate_data.Candidate.Role);
		$('#salaryft').text(candidate_data.Candidate.Currency);
		$('#salaryhourly').text(candidate_data.Candidate.Amount);
		$('#C2C').text(candidate_data.Candidate.CompensationPeriod);
		$('#status').text(candidate_data.Candidate.Status);
		$('#email').text(candidate_data.Candidate.Email);
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			 width:800,
			 modal: true
			 });
			 });
	});
});

function closePopup(){
	$('.ui-front').remove();
	return false;
}
</script>
	</div>
</div>
