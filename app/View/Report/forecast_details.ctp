<style>
table {
    display: table;
    border-collapse: separate;
    white-space: normal;
    line-height: normal;
    font-weight: normal;
    font-size: 12px;
    font-style: normal;
    color: -internal-quirk-inherit;
    text-align: start;
    border-spacing: 2px;
    border-color: grey;
    font-variant: normal;
}
</style>
<?php echo $this->Form->button("Export To Excel",array("class"=>"btn-custom","id"=>"excelDownload"));?>
<table id="forecastDetails" width=100% cellpadding="1" cellspacing="1" border=1>

<thead>
<h2 style="text-align:center;">Resource Forecast Details (<?php print $from ?> to <?php print $to ?>)</h2>
<tr>	
	<th>Skill</th>
	<th>Level</th>
	<th>Client</th>
	<th>Project</th>
	<?php $sum ="sum";
	if($months) {
	foreach ($months as $month){ ?><th> <?php
		$headerMonth = $sum .'-' .$month;
		print $month;?> </th><?php }}?>
	<th>Total</th>
	<th>BDE</th>
</tr>
</thead>
<?php if (!empty($forecast_details)) {
	//echo "<pre>" ;print_r($forecastResultArray);die;
	foreach ($forecast_details as $position_value) {	
				print '<tr>';				
				print '<td>' . $position_value['coreSkill'] . '</td>';			
				print '<td>' . $position_value['level'] . '</td>';
				print '<td>' . $position_value['clientname'] . '</td>';
				print '<td>' . $position_value['projectname'] . '</td>';
				foreach ($months as $month){
					$data ='';
					if(isset ($position_value[$month] )){
						$data =  $position_value[$month] ;
					}
						print '<td>' .$data. '</td>';
				 }
			    print '<td>' . $position_value['total'] . '</td>';
				print '<td>' . $position_value['bde'] . '</td>';
				print '</td>';
				print '</tr>';				
		}
		}

 else {
	print '<tr><td class="headerRight" colspan=18>No Records found!!!</td></tr>';
}?>
</tbody>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>	
<script>
$(document).ready(function(){
	$('#excelDownload').click(function (e) { 
	$("#forecastDetails").table2excel({   
			name: "Worksheet Name",  
			filename: "PositionReport.xls"  
		}); 
	});
});
</script>