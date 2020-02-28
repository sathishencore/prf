<div id="candidatestatus" title="Candidates List">
	<h1
		style="font-size: 100%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
		<label id="assignmentStatus" style="font-size: 130%;"></label>
		Candidates List:
	</h1>
	<p></p>
	<div class="displayResults" style="margin-left: 15%;width: 75%;">
		<table cellspacing="0" callpadding="5" id="candidateTable">
		</table>
		<div class="buttonalign" style="margin-left: 22%">
		<?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"return closePopup()","style"=>"float:right;margin-top:6%"));?>
	</div>
	</div>
	<p></p>
	<p></p>
</div>

<script type="text/javascript">
$("#candidatestatus").hide();
$('.assignment_status').click( function() {
	var status = $(this).attr("data-val");
	<?php if(!empty($positionData)){?>
	var id= <?php echo $positionData['Position']['ID'];?>;
	<?php }?>
	 $.get( "<?php echo $this->Html->url("/")?>CandidateAssignment/assignmentStatus?assignmentStatus="+status+"&positionid="+id ,  function ( data ) {
		 	$("#assignmentStatus").text(status);
			var obj = jQuery.parseJSON(data);
			if(obj != ''){
				var optionstr="<tr><th>S.No</th><th class='headerRight'>Candidate Name</th></tr>";
				var no = 0;
				for(i=0;i<obj.length;i++){
					optionstr+="<tr>";
					optionstr+="<td>";
					optionstr+=++no;
					optionstr+="</td>";
					optionstr+="<td class='headerRight'>";
					optionstr+=obj[i].Candidate.FirstName+" "+obj[i].Candidate.LastName;
					optionstr+="</td>";
					optionstr+="</tr>";
				}
				$("#candidateTable").html(optionstr);	
	 
	 $(function() {
		 $( "#candidatestatus" ).dialog({
		 width:'auto',
		 height:'auto',
		 modal: true
		 });
		 });
			}else{
				alert('No Candidates found for the status '+status);
			}
	 });
});

function closePopup(){
	$('.ui-front').remove();
	return false;
}


</script>
