<div class="titlebg">
	<div class="titletxt">Candidate Assignment</div>
	<div class="hide" id="toggleshows">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="CandidateAssignment" style="min-height: 150px;">
		<div class="content-mid" id="basicSearch">
			<div class="clear">&nbsp;</div>
		</div>
		<div class="displayResults" style="max-height: 200px;overflow: auto;"> 
			<table class="tablesorter" id="CandidateAssignmentTable" cellspacing="0">
				<thead>
					<tr>
						<th>Candidate Name</th>
						<th>Role</th>
						<th width="20%">Primary Skills</th>
						<th>Year of Experience</th>
						<th>Currency</th>
						<th>Amount</th>
						<th>Compensation Type</th>
						<th>Interview Date</th>
						<th>Assignment Status</th>
						<th class="headerRight">Action</th>
						
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($candidateAssignmentList)>0){
								$i=1;
								foreach($candidateAssignmentList as $ckey=>$cval){
						?>
					<tr>
					<?php if($this->Session->read("roleId") != 1){?>
					<td class="can_assignment"
							data-val="<?php echo $cval['Candidate']['ID']?>"><a
							href="javascript:"><?php echo $cval['Candidate']['FirstName']." ".$cval['Candidate']['LastName']?> </a></td>
							<?php }else{?>
						<td> <?php echo $cval['Candidate']['FirstName']." ".$cval['Candidate']['LastName']; }?></td>				
						<td><?php echo $cval['Candidate']['Role']?></td>
						<td><?php echo $cval['Candidate']['PrimarySkills']?></td>
						<td><?php echo $cval['Candidate']['YearsOfExperience']?></td>						
						<td><?php echo $cval['Candidate']['Currency']?></td>
						<td><?php if(!empty($cval['Candidate']['Amount'])) { echo number_format($cval['Candidate']['Amount'], 2, '.', ','); } else { echo "";}?></td>
						<td><?php echo $cval['Candidate']['CompensationPeriod']?></td>
						<?php
						if(!empty($cval['CandidateAssignment']['InterviewDate'])){
						$dateformat = explode(" ", $cval['CandidateAssignment']['InterviewDate']);
						$timesession = DateTime::createFromFormat( 'H:i:s', $dateformat[1]);
						$formatted = $timesession->format( 'h:i A');
						$timeformat = explode(" ", $formatted);
						}else{
							$dateformat[0]='';
							$timeformat[0]='';
							$timeformat[1]='';
						}
						?>
						<td><?php if(!empty($dateformat[0])) { echo $this->Time->format(Configure::Read("Date.Format"),$dateformat[0])." ".$timeformat[0]." ".$timeformat[1];}?></td>
						<td><?php echo $cval['CandidateAssignment']['AssignmentStatus']?></td>
						<td class="headerRight"><?php if(!empty($cval['Candidate']['ResumeName'])){
									if(file_exists(WWW_ROOT . 'files' . DS . $cval['Candidate']['ResumeName'])){
										echo "<a href='javascript:' class='resumes' data-val=".$cval['Position']['ID'].">".$this->Html->image("word-text.png",array("onclick"=>"return resumes(this)","id"=>$this->Html->url("/files/").$cval['Candidate']['ResumeName'],"name"=>$cval['Candidate']['ResumeName']))."</a>";
									}}
							?></td>
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
		</div></div></div>
<?php echo $this->element("viewCandidateAssignment");?>

<div id="optionmodal" title="Candidate Resume">
	<?php echo $this->Form->radio("resume",array("download"=>"Download resume","send"=>"Attach resume to a new email with a template"),array("label"=>true,"legend"=>false,"div"=>false));?>
	<?php echo $this->Form->button("submit",array("class"=>"onSubmit","style"=>"margin-left:42%;margin-top:3%;"));?>
</div>
<div id="mailtemplate" title="Compose new mail">
<?php echo $this->Form->create("MailTemplate",array("url"=>"/CandidateAssignment/candidateResumeMail")); ?>
	<table>
		<tr>
			<td>To address</td>
			<td>:</td>
			<td colspan="2"><?php echo $this->Form->input("ToAddress",array("label"=>false,"style"=>"width:500px "));?></td>
		</tr>
		<tr>
			<td>Subject</td>
			<td>:</td>
			<td colspan="2"><?php echo $this->Form->input("Subject",array("label"=>false,"style"=>"width:500px "));?></td>
		</tr>
		<tr>
			<td>Attachment</td>
			<td>:</td>
			<td style="width: 2%;"><?php echo $this->Html->image("word-text.png",array());?></td>
			<td><label id="AttachmentName"></label><?php echo $this->Form->hidden("resName",array("label"=>false));?>
			<?php echo $this->Form->hidden("PositionID",array("label"=>false));?></td>
		</tr>
		<tr>
			<td>Body</td>
		</tr>
		<tr>
			<td></td><td></td>
			<td colspan="2"><?php echo $this->Form->textarea("Body",array("label"=>false,"style"=>"width:500px;height:250px"));?></td>
		</tr>
		<tr>
			<td colspan="4"><?php echo $this->Form->button("Cancel",array("style"=>"float:right;","onclick"=>"return closePopup()"));?>
			<?php echo $this->Form->button("Send",array("style"=>"float:right; margin-right: 1%;")); ?></td>
		</tr>
	</table>
	<?php echo $this->Form->end();?>
</div>

<script>
$('#dialog-modal').hide();
$('#optionmodal').hide();
$('#mailtemplate').hide();
$(document).ready(function(){
	$("#searchbox").chosen();
$('table').tablesorter({ headers: { 9: { sorter: false  } }});		
});


function resumes(data){

	var id = data.id;
	 $(function() {
		 $("#ResumeDownload").attr('checked',true);
		 $( "#optionmodal" ).dialog({
		 height: 'auto',
		 width: 550,
		 modal: true
		 });
		});

$(".resumes").click( function(){
	var positionId = $(this).attr("data-val");
	
		$(".onSubmit").click( function(){
			if(id !=''){
			if($("input[name='data[resume]']:checked").val() == 'download'){
				window.location.href = id;
				$('.ui-front').remove();
			}else{
				$('.ui-front').remove();
				//ajax call for template data
				$.get( "<?php echo $this->Html->url("/")?>CandidateAssignment/mailTemplate?resumeName="+data.name+"&positionId="+positionId ,  function ( data ) {
					var str="Client Name: <<client_name>>\r\nProject Name: <<project_name>> \r\nRole: <<role>>\r\n"+
					"Candidate Name: <<candidate_name>>\r\nCurrent location: <<candidate_location>>\r\n"+
					"Cost to company: <<cost>>\r\n"+
					"Rate: <<currency>> <<amount>> \r\nType: <<compensation>>\r\n"+
					"Availability for interview: <<interview>>\r\n"+
					"Availability to start if found suitable: <<leadtime>> \r\nContact: <<phone>>, <<email>>\r\n";
					
					var mailData= jQuery.parseJSON(data);
					$("#MailTemplateToAddress").val(mailData.Candidate.Candidate.encoremail);
					$("#MailTemplateSubject").val(mailData.Position.Project.Name + ' / ' + mailData.Position.Position.Role);
					$("#AttachmentName").text(mailData.Candidate.Candidate.ResumeName);
					$("#MailTemplateResName").val(mailData.Candidate.Candidate.ResumeName);
					$("#MailTemplatePositionID").val(positionId);
					str=str.replace("<<client_name>>",mailData.Position.Client.Name);
					str=str.replace("<<project_name>>",mailData.Position.Project.Name);
					str=str.replace("<<role>>",mailData.Position.Position.Role);
					str=str.replace("<<candidate_name>>",mailData.Candidate.Candidate.FirstName+" "+mailData.Candidate.Candidate.LastName);
					str=str.replace("<<candidate_location>>",mailData.Candidate.Candidate.City+", "+mailData.Candidate.Candidate.State);
					str=str.replace("<<currency>>",mailData.Candidate.Candidate.Currency);
					str=str.replace("<<amount>>",mailData.Candidate.Candidate.Amount);
					str=str.replace("<<compensation>>",mailData.Candidate.Candidate.CompensationPeriod);
					str=str.replace("<<leadtime>>",mailData.Candidate.Candidate.LeadTime);
					str=str.replace("<<interview>>",mailData.Candidate.Candidate.LeadTimeForInterview);
					str=str.replace("<<cost>>",mailData.Candidate.Candidate.Cost);
					str=str.replace("<<email>>",mailData.Candidate.Candidate.Email);
					str=str.replace("<<phone>>",mailData.Candidate.Candidate.ContactPhone);
					$("#MailTemplateBody").val(str);
					
						 $(function() {
							 $( "#mailtemplate" ).dialog({
							 height: 'auto',
							 width: 650,
							 modal: true
							 });
							});
					});
				}
			}
			id="";
		});
	});
	return false;
}

function closePopup(){
	$('.ui-front').remove();
	return false;
}

$("#MailTemplateIndexForm").validate({
	 rules: {
		"data[MailTemplate][ToAddress]":{
			required:true,
			email:true,
		},
	 }
});
		
	

</script>
