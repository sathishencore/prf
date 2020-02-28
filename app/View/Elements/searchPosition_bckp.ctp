<div class="titlebg">
	<div class="titletxt">Search</div>
	<div class="show" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
	<div class="content" id="searchPosition" style="min-height: 200px;">
		<div class="content-mid" id="basicSearch">
			<?php echo $this->Form->create("PositionFrm",array("url"=>array("controller"=>"Position","action"=>"index")));?>
			<table>
				<tr>
					<td>Client Name : &nbsp;</td>
					<td><?php echo $this->Form->select("ClientId",$allClientList,array("class"=>"searchbox","style"=>"width:220px;","empty"=>"All"));?>
					</td>
					<td>Project Code,Name: &nbsp;</td>
					<td><?php echo $this->Form->select("ProjectName",$projectName,array("empty"=>"--Select--","style"=>"width:220px;","class"=>"searchbox"));?>
					</td>
					<td>Role : &nbsp;</td>
					<td><?php echo $this->Form->select("Role",$roleList,array("empty"=>"--Select--","style"=>"width:220px;","class"=>"searchbox"));?>
					</td>
				</tr>
				<tr>
				    <td>Status :</td>
				    <td><?php 
                    $configStatus   = Configure::read("Position.Status");
                        
                    foreach($configStatus as $val){
                        $attr=array('class' =>'checkbox1', "div"=>false,"name"=>"data[PositionFrm][Status][]","value"=>$val,"id"=>"PositionFrm".$val,"hiddenField"=>false);
                        if(isset($this->data['PositionFrm']['Status']))                        
                        foreach($this->data['PositionFrm']['Status'] as $optionval){
                            if($val == $optionval){
                                $attr['checked'] = "checked";
                            }
                        }
                        
                    echo $this->Form->checkbox('Status',$attr);
                    echo "<label for='PositionFrm".$val."'>".$val."</label>";    
                    }
                    $attr=array('class' =>'checkbox2', "div"=>false,"name"=>"data[PositionFrm][Status][]","value"=>"All","id"=>"PositionFrmAll");
                    if(isset($this->data['PositionFrm']['Status']))                        
                    foreach($this->data['PositionFrm']['Status'] as $optionval){
                        if($optionval == 'All'){
                            $attr['checked'] = "checked";
                        }
                    }
                    echo $this->Form->checkbox('Status', $attr);
                    echo "<label for='PositionFrmAll'>All</label>";
                    ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
				    <td><?php echo $this->Form->submit("Search");?>
                    </td></tr>
			</table>
			<?php echo $this->Form->end();?>
			<div class="clear">&nbsp;</div>
		</div>
		<div class="displayResults">
			<table class="tablesorter" cellspacing="0">
				<thead>
					<tr>
						<th>Client Name</th>
						<th>Project Name</th>
						<th>Requisition Number</th>
						<th>Role</th>
						<th>Track</th>
						<th>Work Location</th>
						<th>No. of Positions</th>
						<th width="20%">Essential Skills</th>
						<th width="10%">Primary Recruiter</th>
						<th class="headerRight">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if(count($positionList)>0){
								$i=1;
								foreach($positionList as $ckey=>$cval){
						?>
					<tr>
						<td><?php echo $clientList[$cval['Position']['ClientID']]?></td>
						<td><?php echo $projectList[$cval['Position']['ProjectID']]?></td>
						<td class="req_details"
							data-val="<?php echo $cval['Position']['ProjectID']."&reqno=".$cval['Position']['RequisitionNumber']?>"><a
							href="javascript:"><?php echo substr_replace($cval['Position']['RequisitionNumber'], "-", -3,0)?>
						</a></td>
						<td><?php echo $cval['Position']['Role']?></td>
						<td><?php echo $cval['Position']['Track']?></td>
						<td><?php echo $cval['Position']['WorkLocation']?></td>
						<td><?php echo $cval['Position']['NoOfPosition']?></td>
						<td><?php echo $cval['Position']['EssentialSkills']?></td>
						<td><?php echo $cval['User']['fullName']?></td>
						<td class="headerRight"><?php if($editAction){ ?> <?php echo $this->Html->link("edit",array('controller' => 'Position', 'action' => 'index', (int)$cval['Position']['ID']));?>
							|<?php echo $this->Html->link("Copy",array('controller' => 'Position', 'action' => 'Copy', (int)$cval['Position']['ID']));?>
							| <a href="<?php $this->Html->url("/")?>CandidateAssignment/index?positionid=<?php echo $cval['Position']['ID']?>" class=""
							data-val="<?php echo $cval['Position']['ID']?>">Candidates</a> <?php } else {?>
							<a href="javascript:" class="req_details"
							data-val="<?php echo $cval['Position']['ProjectID']."&reqno=".$cval['Position']['RequisitionNumber']?>">View</a>
							| <a href="<?php $this->Html->url("/")?>CandidateAssignment/index?positionid=<?php echo $cval['Position']['ID']?>" class=""
							data-val="<?php echo $cval['Position']['ID']?>">Candidates</a>
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
		<div id="dialog-modal" title="Position Details">
			<h1
				style="font-size: 100%; margin-left: 6px; margin-bottom: 1%; margin-top: auto; color: orange;">
				<label id="reqno" style="font-size: 130%;"></label> Details
			</h1>
			<table cellspacing="5" cellpadding="5" style="margin-left: 7%">
				<tr>
					<td style="font-weight: bold;">Client Name</td>
					<td>:</td>
					<td><label id="clientname"></label></td>
					<td style="font-weight: bold;">Relocation Required?</td>
					<td>:</td>
					<td><label id="relocation"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Project Name</td>
					<td>:</td>
					<td><label id="projectname"></label></td>
					<td style="font-weight: bold;">Travel Required?</td>
					<td>:</td>
					<td><label id="travel"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Role</td>
					<td>:</td>
					<td><label id="role"></label></td>
					<td style="font-weight: bold;">Travel Billable?</td>
					<td>:</td>
					<td><label id="billable"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Work Location</td>
					<td>:</td>
					<td><label id="worklocation"></label></td>
					<td style="font-weight: bold;">Rate</td>
					<td>:</td>
					<td><label id="rate"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Track</td>
					<td>:</td>
					<td><label id="track"></label></td>
					<td style="font-weight: bold;">Unit of Measure</td>
					<td>:</td>
					<td><label id="unit"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Encore Screening Manager</td>
					<td>:</td>
					<td><label id="encorescreeningmanager"></label></td>
					<td style="font-weight: bold;">Primary Skills</td>
					<td>:</td>
					<td><label id="skills"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">No. Of Position</td>
					<td>:</td>
					<td><label id="noofposition"></label></td>
					<td style="font-weight: bold;">Secondary Skills</td>
					<td>:</td>
					<td><label id="secskills"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Status</td>
					<td>:</td>
					<td><label id="status"></label></td>
					<td style="font-weight: bold;">Job Description</td>
					<td>:</td>
					<td><label id="jobdesc"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Recruiter</td>
					<td>:</td>
					<td><label id="recruiter"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Priority</td>
					<td>:</td>
					<td><label id="priority"></label></td>
				</tr>
				<tr>
					<td colspan="6"><?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?></td>
				</tr>
			</table>
		</div>
		<script>
$('#dialog-modal').hide();
						
$(document).ready(function(){
	$(".searchbox").chosen();
	$('table').tablesorter({ headers: { 9: { sorter: false  } }});
	<?php if(isset($openFlag)) { ?>
	$('#PositionFrmOpen').prop("checked", true);
	<?php } ?>	
});

$('.req_details').click( function() {
	var id=$(this).attr("data-val");
	$.get( "<?php echo $this->Html->url("/")?>Position/ProjectDetailsView?id="+id ,  function ( datas ) {
		var data = jQuery.parseJSON(datas);
		$('#reqno').text(data.Project.RequisitionNumber);
		$('#clientname').text(data.Client.Name);
		$('#projectname').text(data.Project.Name);
		$('#role').text(data.Position.Role);
		$('#worklocation').text(data.Position.WorkLocation);
		$('#track').text(data.Position.Track);
		$('#noofposition').text(data.Position.NoOfPosition);
		$('#status').text(data.Position.Status);
		$('#recruiter').text(data.User.FirstName+" "+data.User.LastName);
		$('#priority').text(data.Position.Priority);
		$('#skills').text(data.Position.EssentialSkills);
		$('#secskills').text(data.Position.OtherSkills);
		$('#encorescreeningmanager').text(data.Position.ScreeningManager);
		$('#rate').text(data.Position.BillingRate);
		$('#unit').text(data.Position.UnitOfMeasure);
		$('#travel').text(data.Position.TravelRequired);
		$('#relocation').text(data.Position.RelocationRequired);
		$('#billable').text(data.Position.Billable);
		$('#jobdesc').text(data.Position.JobDescription);
		$('#reqno').text(data.Position.RequisitionNumber);
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			minWidth:850,
			 modal: true
			 });
			 });
	});
});

/*$(document).ready(function() {
    var header = $('table.tablesorter thead');
    header.css({'position':'absolute', 'margin-top':'-26px'});
    header.each(function(){
        var tbody = $(this).closest('table').find('tbody');
        var firstRow = tbody.find('tr').first();
        var th = $(this).find('th');
        th.each(function(i){
            var borderWidth = 2;
            var td = $(firstRow.find('td')[i]);
            var w = td.css('width').replace('px', '');
            w = parseInt(w)- borderWidth;
            $(this).css({'width': w+'px'});
        });
    })
});*/

$("#PositionFrmClientId").change(function(){
	 $("#PositionFrmProjectName").html('');	 
	 populateProject();
});
$("#PositionFrmProjectName").change(function(){
	 $("#PositionFrmRole").html('');
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { getRoleId:$("#PositionFrmProjectName").val(), ClientId:$("#PositionFrmClientId").val() }
		 }).done(function( msg ) {
			 $("#PositionFrmRole").html(msg);
			 $("#PositionFrmRole").trigger("liszt:updated");
	 });
});

function populateProject(){
	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Client/getProject");?>",
		 data: { PositionId:$("#PositionFrmClientId").val() }
		 }).done(function( msg ) {
			 $("#PositionFrmProjectName").html(msg);
			 $("#PositionFrmProjectName").trigger("liszt:updated");
	 });
}


function closePopup(){
	$('.ui-front').remove();
	return false;
}

$("#PositionFrmAll").click(function () {    
     var checkedVal=$(this).prop("checked");  
     $( ".checkbox1" ).each(function() {         
        $(this).prop("checked", checkedVal);
     });
});

    
 $('.checkbox1').change(function () {
     var cntFlag=0;
     $( ".checkbox1" ).each(function() {
        if($(this).prop("checked")){
            if($(this).attr("id")!='PositionFrmAll')
                cntFlag++;         
          }         
     }); 
     cntFlag=parseInt(cntFlag);
     if(cntFlag == <?php echo count(Configure::read("Position.Status")); ?>)
           $("#PositionFrmAll").prop("checked",true); 
      else
            $("#PositionFrmAll").prop("checked",false);
 });
</script>
	</div>
</div>
