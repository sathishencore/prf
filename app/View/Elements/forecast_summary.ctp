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
<?php echo $this->Form->button("Export To Excel",array("class"=>"btn-custom","id"=>"excelDownload"));?><br></br>
<table id="forecastDetails" width=100% cellpadding="0" cellspacing="0" border=1>

<thead>
<tr>
<?php 
	$count = 0;
	if($months){
		$count = count($months);
	}?>
	<td colspan="<?php echo (count($months)+6)?>"><h2 style="text-align:center;">Resource Forecast Summary Report <?php if($from && $to){?> ( <?php print $from ?> to <?php print $to ?>)<?php }?></h2></td>
</tr>
<tr>
<td  colspan="2"></td><td colspan="<?php echo (count($months)+1)?>">Data</td>
</tr>
<tr>	
	<th>Skill</th>
	<th>Level</th>

	<?php $sum ="Sum";
	if($months) {
		foreach ($months as $month){ ?><th> <?php
			$headerMonth = $sum .'-'.$month;
			print $headerMonth;?> </th><?php 
		}
	}?>
	<th>Sum-Total</th>
</tr>
</thead>

<?php 
$sumArray = array(); $totalSum = array();
if (!empty($forecast_summary)) {
	foreach ($forecast_summary as $position_value) {	
				print '<tr>';				
				print '<td>' . $position_value['coreSkill'] . '</td>';			
				print '<td>' . $position_value['level'] . '</td>';
				foreach ($months as $month){
					$value ='';$count = 0;
					 if(isset ($position_value['date'] )){
						$data =  $position_value['date'] ;
						foreach($data as $key => $dateValue){
							$count = $count + $dateValue;
							if($key == $month){
								if(!array_key_exists($key, $sumArray)) $sumArray[$key] = 0;
								$sumArray[$key]+= $dateValue;
								$value = $dateValue;	
							}
						}
					} 
						print '<td>' .$value. '</td>';
				 }
				$totalSum[] +=$count;
			    print '<td>' . $count . '</td>';
				print '</td>';
				print '</tr>';				
		}
		print '<tr>';
		print '<td>' .'<b>' ."Total Result".'</b>' .'</td>';
		print '</td>';
		print '<td>';
		print '</td>';
		foreach ($months as $month){
			$value = 0;
			foreach ($sumArray as $key => $sumArrayValue) {
				if($month == $key){
					$value = $sumArrayValue;
				}				
			}
				print '<td>' .'<b>' . $value.'</b>' .'</td>'; 
		}
	    print '<td>'.'<b>' . array_sum($totalSum) . '</b>'.'</td>';
		print '</tr>';	
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
			filename: "forecastSummary"  
		}); 
	});
});
</script>