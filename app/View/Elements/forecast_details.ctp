<style>
table {
    display: table;
    border-collapse: separate;
    white-space: normal;
    line-height: normal;
    font-weight: normal;
    font-size: 12px;
    font-style: normal;
    text-align: start;
    border-spacing:1px;
    border-color: grey;
    font-variant: normal;
}
</style>
<?php echo $this->Form->button("Export To Excel",array("class"=>"btn-custom","id"=>"excelDownload"));?><br></br>
<table id="forecastDetails" width=100% cellpadding="0" cellspacing="0" border=1>

<thead>
<tr>
<?php 
	$count = 0;
	if($months){
		$count = count($months);
	}?>
	<td rowspan= "1" colspan="<?php echo (count($months)+6)?>"><h2 style="text-align:center;">Resource Forecast Details <?php if($from && $to){?> ( <?php print $from ?> to <?php print $to ?>)<?php }?></h2>
	<input type="hidden" id="from" value ="<?php echo $from;?>">
	<input type="hidden" id="to" value ="<?php echo $to;?>">
	</td>
</tr>
<tr>	
	<th>Skill</th>
	<th>Level</th>
	<th>Client</th>
	<th>Project</th>
	<?php $sum ="sum";
	if($months) {
		foreach ($months as $month){ ?><th> <?php
			print $month;?> </th><?php 
		}
	}?>
	<th>Total</th>
	<th>BDE</th>
</tr>
</thead>
<?php if (!empty($forecast_details)) {
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>	
<script>
$(document).ready(function(){
	$('#excelDownload').click(function (e) { 
	$("#forecastDetails").table2excel({   
			name: "Worksheet Name",  
			filename: "Resource Forecast Details"+" "+ "from "+ $("#from").val()+" " + "to" +" " + $("#to").val()
		}); 
	});
});
</script>