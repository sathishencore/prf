<?php //echo "<pre>";
		//			print_r($positionList);die; ?>
		<style>


.tabs-nav li {
   float: left;
   list-style-type: none;
}

.tabs-nav li a {
  display: block;
  color: white;
  text-align: center;
  padding:8px 10px;
  text-decoration: none;
   list-style-type: none;
}
.tabs-nav li a:hover {
  background-color: #111;
}
.tabs-nav .tab-active a {
	background-color:lavender;
    border-bottom-color: hsla(0, 0%, 0%, 0);
    color: hsl(85, 54%, 51%);
    cursor: default;
	list-style-type: none;
}
.tabs-nav a {
    background-color:lavender !important;
    color:black !important;
    border: 1px solid hsl(210, 6%, 79%);
    color: hsl(215, 6%, 57%);
    display: block;
	list-style: none;
    font-size: 12px;
    font-weight: bold;
    height: 30px;
    line-height: 34px;
    text-align: center;
    text-transform: uppercase;
    width: 120px;
	 list-style-type: none;
}
.tabs-nav li {
    float: left;
}
#tab-1{
	margin-left:12px;
}
#detailsTable {
	padding:30px 100px 10px 100px;
	font-size:15px;
	font-family:times;
	
}
#skillTable{
	padding:30px 100px 10px 100px;
	font-size:12px;
	font-family:times;
	
}
table #detailsTable td ,table #skillTable td{
		margin-bottom: 10px;
		display: block;
		font-family :times;
		font-size:15px;
		width:150px;  
		padding:2px 
}

label ,{
    margin-bottom: 20px;
	display: block;
}
#excelReport{
	padding:0px 32px ;
}
</style>
<div class="titlebg">
    <div class="titletxt">Search</div>
    <div class="hide" id="toggleshow">&nbsp;</div>
</div>
<div class="bodyconrarea">
    <div class="content" id="searchPosition" style="min-height: 200px;">
        <div class="content-mid" id="basicSearch">
            <?php echo $this->Form->create("PositionFrm",array("url"=>array("controller"=>"Position","action"=>"index")));?>
                <table>
                    <tr>
                        <td>&nbsp;&nbsp;Client Name:&nbsp;</td>
                        <td>
                            <?php echo $this->Form->select("ClientId",$allClientList,array("class"=>"searchbox","style"=>"width:250px;","empty"=>"All"));?>
                        </td>
                        <td>&nbsp;&nbsp;Project Name: &nbsp;</td>
                        <td>
                            <?php echo $this->Form->select("ProjectName",$projectName,array("empty"=>"All","style"=>"width:250px;","class"=>"searchbox"));?>
                        </td>
                        <td>&nbsp;&nbsp;Account Manager:&nbsp;</td>
                        <td>
                            <?php echo $this->Form->select("AccountManager",$managerList,array("empty"=>"All","style"=>"width:250px;","class"=>"searchbox"));?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;Work Location:&nbsp;</td>
                        <td>
                            <?php echo $this->Form->select("WorkLocation",$worklocationList,array("empty"=>"All","style"=>"width:250px;","class"=>"searchbox"));?>
                        </td>
                        <td>&nbsp;&nbsp;Status :&nbsp;</td>
                        <td>
                            <?php 
					$configStatus   = Configure::read("Position.Status");
					echo $this->Form->select("Status",$configStatus,array("empty"=>"All","style"=>"width:250px;","class"=>"searchbox",'id'=>'status'));?>
                        </td>
                        <td>&nbsp;&nbsp;Criteria:&nbsp;</td>
                        <td>
                            <?php echo $this->Form->select("criteria", array('All' => 'All', 'Positions overdue' => 'Positions overdue','Positions overdue - upto 30 days' =>'Positions overdue - upto 30 days','Positions overdue - >30 days' => 'Positions overdue - >30 days'),array("style"=>"width:250px;","class"=>"searchbox"));?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <?php echo $this->Form->submit("Search");?>
                        </td>

                </table>
                <?php echo $this->Form->end();?>
                    <div class="clear">&nbsp;</div>
        </div>
        <div style="text-align:center;" id="excelReport"><?php echo $this->Form->button("Export To Excel",array("class"=>"btn-custom","id"=>"excelDownload"));?></div>
		<br></br>
        <div class="displayResults">
		
            <table class="tablesorter" width="100%" border="0" id="positionDetailsTable">
			
                <thead>
                    <tr>
                        <th>Requisition #</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th>Required Date</th>
                        <th># Days Overdue</th>
                        <th># Days Open</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
					//print_r(count($positionList));
					if(count($positionList)>0){
					foreach($positionList as $ckey=>$cval){ ?>
                        <tr>
                            <td class="req_details" data-val="<?php echo $cval['Position']['ProjectID']." &reqno=".urlencode($cval['Position']['RequisitionNumber'])?>" id="<?php echo (int)$cval['Position']['ID'] ?>">
                                <a href="javascript:">
                                    <?php echo substr_replace($cval['Position']['RequisitionNumber'], "-", -3,0)?>
                                </a>
                            </td>
                            <td>
                                <?php echo $clientList[$cval['Position']['ClientID']]?>
                            </td>
                            <td>
                                <?php echo $projectList[$cval['Position']['ProjectID']]?>
                            </td>
                            <td>
							   
                                <?php
								$role  = $cval['ProjectRole']['role'] ? $cval['ProjectRole']['role'] :'';
								$core_skill = '';
								if($cval['Skill']){
									foreach ($cval['Skill'] as $skill){
										if($skill['PositionSkill'] && $skill['PositionSkill']['type'] == "core_skill"){
											$core_skill = $skill['Name'];
										
										}
									}
								}
								
								$user_role = $core_skill ." ".$role ;
							
								echo $user_role?>
                            </td>
                            <td>
                                <?php
						$date = date("Y-m-d", strtotime($cval['Position']['created']));						
						echo $date ;?>
                            </td>
                            <td>  <?php
							$reqDate = date("Y-m-d", strtotime($cval['Position']['StartDate']));						
							echo $reqDate ;?></td>
							
                            <td> <?php
							$systemDate  = date("Y/m/d");
							$requiredDate = date("Y/m/d", strtotime($cval['Position']['StartDate']));
							$datediff = strtotime($systemDate)- strtotime($requiredDate);
						/* 	if($requiredDate > $systemDate){
									$datediff = strtotime($requiredDate)- strtotime($systemDate);
							} */
							
							$days = round($datediff / (60 * 60 * 24));
							if($days == 0 || $days < 0){
								$days = '';
							}
							echo $days;?>	
							</td>
							<td> <?php
							$systemDate  = date("Y/m/d");
							$createdDate = date("Y/m/d", strtotime($cval['Position']['created']));
							$datediff = strtotime($systemDate)- strtotime($createdDate);
							echo round($datediff / (60 * 60 * 24));		?>					
							</td>
                            <input type="hidden" id="positionId" value="<?php echo $cval[ 'Position'][ 'ProjectID'] ;?>"> 
                            <input type="hidden" id="posIds" value="<?php echo (int)$cval['Position']['ID'] ?>">

                        </tr>
                        <?php
								}
						 }
						?>
                </tbody>

                <?php 
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
            <input type="hidden" name="positionDetailsValue" value="">
            <h1 style="font-size: 100%; margin-left: 15px; margin-bottom: 1%; margin-top: auto; color: orange;"><label id="reqno" style="font-size: 130%;"></label> Details</h1>
            <ul class="tabs-nav" style="font-size: 100%; margin-left: 15px; margin-bottom: 1%; margin-top: auto; color: orange;">
                <li class=""><a href="#tab-1" >Details</a></li>
                <li class="tab-active"><a href="#tab-2" >Skills</a></li>
            </ul>
            <div class="tabs-stage">
                <div id="tab-1">
                    <table class="table-table striped" id="detailsTable" style="font-family:Palatino;" >
                        <tr>
                            <td style="font-weight: bold;">Client Name</td>
                            <td>:</td>
                            <td>
                                <label id="clientname"></label>
                            </td><td></td>
                            <td style="font-weight: bold;">Relocation Required?</td>
                            <td>:</td>
                            <td>
                                <label id="relocation"></label>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Project Name</td>
                            <td>:</td>
                            <td>
                                <label id="projectname"></label>
                            </td><td></td>

                            <td style="font-weight: bold;">Travel Required?</td>
                            <td>:</td>
                            <td>
                                <label id="travel"></label>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight: bold;">Role</td>
                            <td>:</td>
                            <td>
                                <label id="role"></label>
                            </td><td></td>

                            <td style="font-weight: bold;">Travel Billable?</td>
                            <td>:</td>
                            <td>
                                <label id="billable"></label>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Work Location</td>
                            <td>:</td>
                            <td>
                                <label id="worklocation"></label>
                            </td><td></td>

                            <td style="font-weight: bold;">Currency</td>
                            <td>:</td>
                            <td>
                                <label id="currency"></label>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Salary Annual FT</td>
                            <td>:</td>
                            <td>
                                <label id="salary_annual_ft"></label>
                            </td><td></td>

                            <td style="font-weight: bold;">Encore Screening Manager</td>
                            <td>:</td>
                            <td>
                                <label id="encorescreeningmanager"></label>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Salary Hourly</td>
                            <td>:</td>
                            <td>
                                <label id="salary_hourly"></label>
                            </td><td></td>
							
                            <td style="font-weight: bold;">Track</td>
                            <td>:</td>
                            <td>
                                <label id="track"></label>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-weight: bold;">No. Of Position</td>
                            <td>:</td>
                            <td>
                                <label id="noofposition"></label>
                            </td><td></td>
                            <td style="font-weight: bold;">Corp-to-Corp Hourly</td>
                            <td>:</td>
                            <td>
                                <label id="corp_to_corp_hourly"></label>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Status</td>
                            <td>:</td>
                            <td>
                                <label id="status"></label>
                            </td><td></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Recruiter</td>
                            <td>:</td>
                            <td>
                                <label id="recruiter"></label>
                            </td><td></td>
                            <td style="font-weight: bold;">Priority</td>
                            <td>:</td>
                            <td>
                                <label id="priority"></label>
                            </td>
                        </tr>

                    </table>
                </div>
                <div id="tab-2">
                    <table id="skillTable">
                        <tr>
                            <td style="font-weight: bold;">Core Skills &nbsp;</td>
                            <td>:</td>
                            <td>
                                <textarea id="coreskills" rows="5"  readonly="readonly"   cols="70"></textarea>
                            </td>
                        </tr>
                        <br></br>
                        <tr>
                            <td style="font-weight: bold;">Essential Skills &nbsp;</td>
                            <td>:</td>
                            <td>
                                <textarea id="essentialsecskills"   readonly="readonly"  rows="5" cols="70"></textarea>
                            </td>

                        </tr>
						<tr>
                            <td style="font-weight: bold;">Desirable Skills &nbsp;</td>
                            <td>:</td>
                            <td>
                                <textarea id="desirablesecskills"   readonly="readonly"  rows="5" cols="70"></textarea>
                            </td>

                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Job Description &nbsp;</td>
                            <td>:</td>

                            <td>
                                <a href="javascript:" id="jobDes"><img src="http://dailyblogging.org/wp-content/uploads/2010/07/microsoftword_thumb.png" width="42" height="42"></img>
                                </a>
                            </td>
                            <input type="hidden" id="jobdesc" name="des" />
                        </tr>
                    </table>
                </div>
            </div>
            <!-- <div class="tab-content">
				<div id="Details" class="tab-pane fade in active">
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
					<td style="font-weight: bold;">Currency</td>
					<td>:</td>
					<td><label id="currency"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Track</td>
					<td>:</td>
					<td><label id="track"></label></td>
					<td style="font-weight: bold;">Salary Annual FT</td>
					<td>:</td>
					<td><label id="salary_annual_ft"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Encore Screening Manager</td>
					<td>:</td>
					<td><label id="encorescreeningmanager"></label></td>
					<td style="font-weight: bold;">Salary Hourly</td>
					<td>:</td>
					<td><label id="salary_hourly"></label></td>

				</tr>
				<tr>
					<td style="font-weight: bold;">No. Of Position</td>
					<td>:</td>
					<td><label id="noofposition"></label></td>
					<td style="font-weight: bold;">Corp-to-Corp Hourly</td>
					<td>:</td>
					<td><label id="corp_to_corp_hourly"></label></td>

				</tr>
				<tr>
					<td style="font-weight: bold;">Status</td>
					<td>:</td>
					<td><label id="status"></label></td>
					<td style="font-weight: bold;">Primary Skills</td>
					<td>:</td>
					<td><label id="skills"></label></td>

				</tr>
				<tr>
					<td style="font-weight: bold;">Recruiter</td>
					<td>:</td>
					<td><label id="recruiter"></label></td>
					<td style="font-weight: bold;">Secondary Skills</td>
					<td>:</td>
					<td><label id="secskills"></label></td>
				</tr>
				<tr>
					<td style="font-weight: bold;">Priority</td>
					<td>:</td>
					<td><label id="priority"></label></td>
					<td style="font-weight: bold;">Job Description</td>
					<td>:</td>
					<td><label id="jobdesc"></label></td>
				</tr>
			</table>

				</div>
				<div id="skill" class="tab-pane fade">

				</div>
			</div>	 -->
            <td colspan="6">
                <?php echo $this->Form->button("Close",array("class"=>"btn-custom","onclick"=>"closePopup()"));?>
            </td>
            <td colspan="6">
                <?php echo $this->Form->button("edit",array("class"=>"btn-custom","id"=>"editPositionForm"));?>
            </td>

        </div>


<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>	

<div  id="dialog-jobDes-create" >
  <table id="jobDescriptionTable">
		<tr>
			<td>
				<text id="jobDescriptionValue"   name="jobDescriptionValue" readonly="readonly" ></textarea>
			</td>
		</tr>
	</table>
	 <div id="noExl"><td colspan="6" >
                <?php echo $this->Form->button("Download",array("class"=>"btn-custom","id"=>"downloadJobDes"));?>
				<input type="hidden" id="hiddenJobDes" value="">
				 <input type="hidden" id="jobId" value= "">
     </td></div>
</div>

<script>
$('#dialog-modal').hide();
				
$(document).ready(function(){
	
	$("#dialog-jobDes-create").hide();
	//document.getElementById("jobdesc").style.display = 'none';
$('.tabs-nav a').on('click', function (event) {
    event.preventDefault();
    
    $('.tab-active').removeClass('tab-active');
    $(this).parent().addClass('tab-active');
    $('.tabs-stage div').hide();
    $($(this).attr('href')).show();
});

$('.tabs-nav a:first').trigger('click'); 

	$('table').tablesorter({ headers: {12: { sorter: false  } }});
	<?php if(isset($openFlag)) { ?>
	$('#PositionFrmOpen').prop("checked", true);
	<?php } ?>	
	if(($("#PositionFrmProjectName").val()!="") && ($("#PositionFrmClientId").val()!="")){
	populateHiringManager();
	}
	if($("#PositionFrmWorkLocationCountry").val()!=""){
	//alert($("#cityval").val());
	var Country = $("#PositionFrmWorkLocationCountry").val();
		$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Position/loadCity");?>",
		 data: {Country:Country }
		 }).done(function( msg ) {
			 //alert(msg);
			 var ci = $("#cityval").val();
			 $("#PositionFrmWorkLocationCity").html("");
		     $("#PositionFrmWorkLocationCity").html(msg);
		     if($("#cityval").val()!="")
			 	$("#PositionFrmWorkLocationCity").val(ci);
			 $(".searchbox").chosen();
		 });
	 }	
	 else {
	 	$(".searchbox").chosen();
	 }
});

$('.req_details').click( function() {
	var id =$(this).attr("data-val");
	var PoId = $(this).attr("id");
	$('input[name=positionDetailsValue]').val(PoId);
	var userRole  = "";
	$.get( "<?php echo $this->Html->url("/")?>Position/ProjectDetailsView?id="+id ,  function ( datas ) {
		var data = jQuery.parseJSON(datas);
		console.log(data);
		$('#skills1').text(data.Position.EssentialSkills);
		$('#secskills1').text(data.Position.OtherSkills);
		$('#reqno').text(data.Project.RequisitionNumber);
		$('#clientname').text(data.Client.Name);
		$('#projectname').text(data.Project.Name);
		$('#worklocation').text(data.Position.WorkLocation);
		$('#track').text(data.Position.Track);
		$('#noofposition').text(data.Position.NoOfPosition);
		$('#status').text(data.Position.Status);
		$('#recruiter').text(data.User.FirstName+" "+data.User.LastName);
		$('#priority').text(data.Position.Priority);
		$('#skills').text(data.Position.EssentialSkills);
		$('#secskills').text(data.Position.OtherSkills);
		$('#encorescreeningmanager').text(data.Position.ScreeningManager);
		
		$('#currency').text(data.Position.Currency);
		$('#salary_annual_ft').text(Math.round(data.Position.SalaryFt).format());
		$('#salary_hourly').text(parseFloat(data.Position.SalaryHourly).format());
		$('#corp_to_corp_hourly').text(parseFloat(data.Position.CorpToCorp).format());
		
		$('#travel').text(data.Position.TravelRequired);
		$('#relocation').text(data.Position.RelocationRequired);
		$('#billable').text(data.Position.Billable);
		$('#jobdesc').val(data.Position.JobDescription);
		$('#reqno').text(data.Position.RequisitionNumber);
		$('#coreskills').text(data.Position.CoreSkills);
		var dataRole = data.Position.CoreSkills + ' ' + data.Position.Role;
		$('#role').text(dataRole);
		$('#desirablesecskills').text(data.Position.DesirableSkills);
		$('#essentialsecskills').text(data.Position.EssentialSkills);
		
		var projectName  = data.Project.Name + '-'+ data.Position.RequisitionNumber;
		$('#jobId').val(projectName);
		 $(function() {
			 $( "#dialog-modal" ).dialog({
			minWidth:850,
			 modal: true
			}).css("font-size", "15px","font-family" ,"Times New Roman", "Times", "serif","margin-left","5px","margin-right","5px");
			 });
	});
})
;
$('#excelDownload').click(function (e) {    
	var html_table = '';
	var data = [];
	$('#positionDetailsTable tr').each(function(rowIndex, r) {
		var cols = [];
		$(this).find('th,td').each(function (colIndex, c) {
			cols.push(c.textContent);
		});
		data.push(cols);
	});	

	$("#positionDetailsTable").table2excel({   
		name: "Worksheet Name",  
		filename: "PositionReport.xls"  
	});  
});	

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
	 $.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Project/getHiringManager");?>",
		 data: { ProjectId:$("#PositionFrmProjectName").val() }
		 }).done(function( msg ) {
			 //alert(msg);
			 var obj = jQuery.parseJSON(msg);
			 $("#ClientContactName").text(obj.name);
			 $("#PositionHiringManagerID").val(obj.id);
			 $("#PositionStartDate1").val(obj.startdate);
			 $("#PositionEndDate1").val(obj.enddate);
	 });
});
function populateHiringManager(){
	$.ajax({
		 type: "POST",
		 url: "<?php echo $this->Html->url("/Project/getHiringManager");?>",
		 data: { ProjectId:$("#PositionFrmProjectName").val() }
		 }).done(function( msg ) {
			 //alert(msg);
			 var obj = jQuery.parseJSON(msg);
			 $("#ClientContactName").text(obj.name);
			 $("#PositionHiringManagerID").val(obj.id);
			 $("#PositionStartDate1").val(obj.startdate);
			 $("#PositionEndDate1").val(obj.enddate);
	 });
}
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
	location.reload();
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
 
$('#PositionFrmWorkLocationCountry').change(function(){
	var Country = $("#PositionFrmWorkLocationCountry").val();
	$.ajax({
		type: "POST",
		url: "<?php echo $this->Html->url("/Position/loadCity");?>",
		data: {Country:Country }
	}).done(function( msg ) {
		$("#PositionFrmWorkLocationCity").html('');
		$("#PositionFrmWorkLocationCity").html(msg);
		$("#PositionFrmWorkLocationCity").trigger("liszt:updated");
	});
});
$('#editPositionForm').click(function () {    
	var positionViewId  = $('input[name=positionDetailsValue]').val();
	var url = "<?php echo $this->Html->url("/")?>Position/index/"+positionViewId;
	window.open(url);
	//window.location.href = url;			
}); 
$('#jobDes').click(function (e) {    
	var job  = $('input[name=des]').val();
	$('#hiddenJobDes').val(job);
	$('#jobDescriptionValue').text(job);
	if(job){
	     $(function() {
			 $( "#dialog-jobDes-create" ).dialog({
				 title: 'Job Description',
				 width:500,
				 height:250,
			 	 modal: true
			 }).css("font-size", "15px","font-family" ,"Times New Roman", "Times", "serif","margin-left","5px","margin-right","5px");
		});
	}else{
		alert("Job Description Is Empty");
	}
});   


$('#downloadJobDes').click(function (e) { 
	var job  = $('#hiddenJobDes').val();
	var jobNo =  $('#jobId').val();
	var fileName = 'job-description for'+" "+ $('#jobId').val();
	 if(job){
		 Export2Doc('jobDescriptionTable', fileName);
	}
});   
$('#PositionFrmWorkLocationCity').change(function(){
	$("#cityval").val($("#PositionFrmWorkLocationCity").val());
});
function Export2Doc(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).innerHTML+postHtml;
    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    }); 
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    // Specify file name
    filename = filename?filename+'.doc':'document.doc';
    // Create download link element
    var downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        downloadLink.download = filename;       
        //triggering the function
        downloadLink.click();
    }  
    document.body.removeChild(downloadLink);
}
</script>
	</div>
</div>
