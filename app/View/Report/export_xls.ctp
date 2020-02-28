<?php
$rptElement = ($this->request->query['rpt'] == 'candidate') ? 'unassignedCandidate' : 'positionReport' ;
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=" . strtolower($rptElement) . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

if($rptElement == 'positionReport')
{ ?>
<table id="positionreport" width=100% border=0>	
<thead>
<tr>
					<td><h4 style="text-align:center;margin-left:50px;">List Of All Positions </h4>	<td></tr>
					<tr>
				 	<td><b> Account Manager : </b> <?php print $accountManager;?></td></tr>
					<tr><td><b> Status :  </b><?php print $status ; ?></td></tr>
					<tr><td><b> Criteria :  </b><?php print  $criteria ;?></td></tr>

<tr>	
	<th>Client Name</th>
	<th>Project Name</th>
	<th>Requisition Number</th>
	<th>Created date</th>
	<th>Start date</th>
	<th>End date</th>
	<th>Role</th>
	<th>Work Location</th>
	<th># positions </th>
	<th>Priority </th>
	<th>Status </th>
	<th>Prefered Source </th>
	<th>Core Skill </th>
	<th>Essential Skill</th>
	<th>Desirables Skill</th>
	<th>Job Description</th>
	<th>Account Manager</th>
	<th># Days Overdue</th>
	<th># Days Open</th>
</tr>
</thead>
<tbody>
<?php if (!empty($positionAssignment)) {			
	foreach ($positionAssignment as $pos_client => $client_val) {					
		foreach ($client_val as $pos_project => $project_value) {
			foreach ($project_value as $key => $position_value) {
				print '<tr>';			 	
				print '<td>' . $position_value['clientname'] . '</td>';			
				print '<td>' . $position_value['projectname'] . '</td>';
				print '<td>' . $position_value['requisition'] . '</td>';
				print '<td>' . $position_value['createddate'] . '</td>';
				print '<td>' . $position_value['startdate'] . '</td>';
				print '<td>' . $position_value['endDate'] . '</td>';
				print '<td>' . $position_value['role'] . '</td>';
				print '<td>' . $position_value['location'] . '</td>';
				print '<td>' . $position_value['totalposition'] . '</td>';
				print '<td>' . $position_value['priority'] . '</td>';
				print '<td>' . $position_value['status'] . '</td>';
				print '<td>' . $position_value['status'] . '</td>';
				print '<td>' . $position_value['corekill'] . '</td>';
				print '<td>' . $position_value['essentialskill'] . '</td>';
				print '<td>' . $position_value['desirableskill'] . '</td>';
				print '<td>' . $position_value['JobDescription'] . '</td>';
				print '<td>' . $position_value['JobDescription'] . '</td>';
				print '<td>' . $position_value['#overdue'] . '</td>';
				print '<td>' . $position_value['#open'] . '</td>';
				print '</tr>';
				if(!empty($position_value['candidate'])) {					
					print '<tr><td colspan=2>&nbsp;</td>';										
					print '<td colspan=13>';
					print '<table width=100% cellspacing=0 cellpadding=0 border=0>';
					print '<tr><th>Candidate Name</th>';
					print '<th>Assignment Status</th>';
					print '<th>Interview Level</th>';
					print '<th class="headerRight">Interview Date</th></tr>';					
					
					foreach ( $position_value['candidate'] as $candidate){						
						print '<tr>';						
						print '<td>' . $candidate['candidatename'] . '</td>';
						print '<td>' . $candidate['assignmentstatus'] . '</td>';															
						print '<td>' . $candidate['interviewlevel'] . '</td>';
						print '<td class="headerRight">' . $candidate['interviewdate'] . '</td>';
						print '</tr>';
					}
					print '</table>';
					print '</td>';
					print '</tr>';	?></p>	<?php			
				}
			}
		}
	}	
} else {
	print '<tr><td class="headerRight" colspan=18>No Records found!!!</td></tr>';
}?>
</tbody>
</table>
<?php
}
 else{
	echo $this->element($rptElement);
} 
?>
