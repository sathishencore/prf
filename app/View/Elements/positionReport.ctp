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
<table id="positionreport" width=100% border=0>	
<thead>
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
<!--
	<th>Project Name</th>	
	<th>Role</th>
	<th>Core Skill</th>
	<th>Essential Skill</th>
	<th>Desirable Skill</th>
	<th>Location</th>
	<th>Position Start</th>
	<th>Primary Recruiter</th>
	<th>Secondary Recruiter</th>
	<th>Priority</th>
	<th>Created Date</th>
	<th>Status</th>
	<th>Job Description</th>
	<th>Relocation Required?</th>
	<th>Travel Required?</th>
	<th>Travel Billable?</th>
	<th>Work Location</th>
	<th>Currency</th>
	<th>Salary Annual FT</th>
	<th>Salary Hourly</th>
	<th>Corp-to-Corp Hourly</th>
	<th>Encore Screening Manager</th>
	<th>Track</th>
	<th># Days Overdue</th>
	<th># Days Open</th>
	
	<th>Total Positions</th>
	<th class="headerRight">Open Positions</th> -->
</tr>
</thead>
<tbody>
<?php if (!empty($positionAssignment)) {			
	foreach ($positionAssignment as $pos_client => $client_val) {					
		foreach ($client_val as $pos_project => $project_value) {
			foreach ($project_value as $key => $position_value) {
				
				//Position Details											
				print '<tr>';				
				print '<td>' . $position_value['clientname'] . '</td>';			
				//print '<td>' . $position_value['projectcode'] . '</td>';
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
				print '<td>' .$position_value['corekill'] . '</td>';
				print '<td>' . $position_value['essentialskill'] . '</td>';
				print '<td>' . $position_value['desirableskill'] . '</td>'; 
				print '<td>' . $position_value['JobDescription'] . '</td>';
				print '<td>' . $position_value['JobDescription'] . '</td>';
				print '<td>' . $position_value['#overdue'] . '</td>';
				print '<td>' . $position_value['#open'] . '</td>';
				
		/* 					
				print '<td>' . $position_value['primaryrecruiter'] . '</td>';
				print '<td>' . $position_value['secondaryrecruiter'] . '</td>';															
				print '<td>' . $position_value['relocation'] . '</td>';
				print '<td>' . $position_value['travel'] . '</td>';
				print '<td>' . $position_value['billable'] . '</td>';
				print '<td>' . $position_value['currency'] . '</td>';
				print '<td>' . $position_value['salary_annual_ft'] . '</td>';
				print '<td>' . $position_value['salary_hourly'] . '</td>';
				print '<td>' . $position_value['corp_to_corp_hourly'] . '</td>';
				print '<td>' . $position_value['encorescreeningmanager'] . '</td>';
				print '<td>' . $position_value['track'] . '</td>';
				print '<td class="headerRight">' . $position_value['openposition'] . '</td>'; */
				print '</tr>';
				
				//Candidate Details for the position
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
					print '</tr>';					
				}
			}
		}
	}	
} else {
	print '<tr><td class="headerRight" colspan=18>No Records found!!!</td></tr>';
}?>
</tbody>
</table>