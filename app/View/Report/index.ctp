<div class="titlebg">
	<div class="titletxt">Position Tracker</div>	
</div>
<div class="bodyconrarea">
	<div id="searchPosition" class="content" style="min-height: 200px;">
	<!-- search form -->
	<div id="basicSearch" class="content-mid">
	
	<?php echo $this->Form->create("ReportFrm",array("url"=>array("controller"=>"Report", "action"=>"index")));?>
	<table cellpadding="0" cellspacing="2" border="0"  align="left">
					<tr>
                       <!-- <td >Client Name:&nbsp; &nbsp;</td>
                        <td>&nbsp; &nbsp;
                            <?php echo $this->Form->select("ClientID",$activeClientList,array("class"=>"searchbox","style"=>"width:250px;","class"=>"select-small","empty"=>"All",'multiple'=>'true'));?>
                        </td>-->
                        <td>Account Manager: &nbsp;</td>
                        <td>&nbsp; &nbsp;
                             <?php echo $this->Form->select("AccountManager",$managerList,array("empty"=>"All",'id'=>'manager',"style"=>"width:250px;","class"=>"searchbox"));?>
                        </td>
						<td>Status:&nbsp;</td>
						<td>&nbsp; &nbsp;
							<?php $configStatus   = Configure::read("Position.Status");
							echo $this->Form->select("Status",$configStatus,array("empty"=>"All",'id'=>'status',"style"=>"width:250px;","class"=>"searchbox",'id'=>'status'));?>
						</td>
						<td>Report Period : &nbsp;</td>
						<td>
							<?php
								echo $this->Form->input('ReportPeriod', array(
										'separator' => '&nbsp',
										'options' => array('1 week' => 'Week', '2 week' => 'Fortnight', '1 month' => 'Month', '3 month' => 'Quarter'),
										'type' => 'radio',
										'default' => isset($reportPeriod) ? ($reportPeriod) : '1 week',
										'legend' => false,	
								));
							?>
						</td>
					
					 </tr>
					 <tr>
					    <td>Criteria:&nbsp;</td>
                     <td>&nbsp; &nbsp;
						<?php echo $this->Form->select("criteria", array('Positions overdue' => 'Positions overdue','Positions overdue - upto 30 days' =>'Positions overdue - upto 30 days','Positions overdue - >30 days' => 'Positions overdue - >30 days'),array("empty"=>"All",'id'=>'criteria',"style"=>"width:250px;","class"=>"searchbox"));?>
                     </td>
						<td></td><td></td><td></td><td></td><td><?php echo $this->Form->submit("Search");?></td>
					</tr>
					 
				
	</table>
	<?php echo $this->Form->end();?>				
	</div>
	<div class="clear">&nbsp;</div>
		
	<!-- search results -->	
	<!--<div class="displayResults" style="text-align: right;"><?php echo $this->Form->button("Export To Excel",array("class"=>"btn-custom","id"=>"excelDownload"));?></div>-->
	 <div class="displayResults" style="text-align: right;"><strong><?php echo $this->Html->link('Export as Excel', array('controller'=>'Report', 'action'=>'export_xls?rpt=position')); ?></strong></div> 
	<div class="clear">&nbsp;</div>
	<div class="displayResults">
		<?php echo $this->element("positionReport"); ?>						
	</div>
	<div class="clear">&nbsp;</div>
	
	</div>
</div>
<!--<script>
var selectedcriteria ; var selectedManagerId; var  selectedStatus ;
$(document).ready(function(){
	selectedcriteria = 'all';selectedManagerId='all';selectedStatus='all';
    $("#manager").change(function(){
         selectedManagerId = $(this).children("option:selected").val();
		  sessionStorage.setItem("manager1", selectedManagerId);
    });
	 $("#status").change(function(){
         selectedStatus = $(this).children("option:selected").val();
		   sessionStorage.setItem("status1", selectedStatus);
    });
	 $("#criteria").change(function(){
         selectedcriteria = $(this).children("option:selected").val();
		   sessionStorage.setItem("criteria1", selectedcriteria);
    });
	var manager =   sessionStorage.getItem("manager1");
	alert(manager);
	var status =   sessionStorage.getItem("status1");
	var criteria =   sessionStorage.getItem("criteria1");
	if(manager == ""){
		manager ='All';
	}
	if(status == "" ){
		status ='All';
	}
	if(criteria =="" ){
		criteria ='All';
	}
	
	var dataString = 'manager='+ manager + '&status='+ status + '&criteria='+ criteria;
	$("#excelDownload").click(function(){
		$.ajax({
		type: "POST",
		data: dataString,
		url: "<?php echo $this->Html->url("/Report/export_xls");?>",
	/* 	success: function(result){
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
	}); */
});
});
}); 
</script>-->